<?php
namespace App\Controller;
use Cake\I18n\Time;
use Cake\Mailer\Email;

use App\Controller\AppController;

/**
 * Appointments Controller
 *
 * @property \App\Model\Table\AppointmentsTable $Appointments
 *
 * @method \App\Model\Entity\Appointment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppointmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Companymembers']
        ];
        $appointments = $this->paginate($this->Appointments);

        $this->set(compact('appointments'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appointment = $this->Appointments->get($id, [
            'contain' => ['Clients', 'Companymembers']
        ]);

        $this->set('appointment', $appointment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appointment = $this->Appointments->newEntity();
        if ($this->request->is('post')) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->getData());
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
        }
        $clients = $this->Appointments->Clients->find('list', ['limit' => 200]);
        $companymembers = $this->Appointments->Companymembers->find('list', ['limit' => 200]);
        $this->set(compact('appointment', 'clients', 'companymembers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appointment = $this->Appointments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->getData());
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
        }
        $clients = $this->Appointments->Clients->find('list', ['limit' => 200]);
        $companymembers = $this->Appointments->Companymembers->find('list', ['limit' => 200]);
        $this->set(compact('appointment', 'clients', 'companymembers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appointment = $this->Appointments->get($id);
        if ($this->Appointments->delete($appointment)) {
            $this->Flash->success(__('The appointment has been deleted.'));
        } else {
            $this->Flash->error(__('The appointment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function appointmentspage($companyId){
        $this->loadModel('CompaniesUser');
        $user_id = $this->Auth->user('id');

        $company_memberrole = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'user_id' => $user_id
            ]
        ])->contain('Designations')->first();


        if($company_memberrole->designation->name == 'Customer') {
            $appointments = $this->Appointments->find('all',[
                'conditions' => [
                    'company_id' => $companyId,
                    'candidate_id' =>  $user_id
                ]
            ])->contain(['Candidates'])->toArray();



        }else{
            $appointments = $this->Appointments->find('all',[
                'conditions' => [
                    'company_id' => $companyId,
                    'companymember_id ' =>  $user_id
                ]
            ])->contain(['Candidates'])->toArray();
        }



      //  debug($appointments);exit;

        $this->set(compact('companyId', 'appointments'));
    }
    public function bookingpage(){
        $this->loadModel('CompaniesUser');
        $companyId = $this->request->getQuery('companyId');

        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User', 'Designations'])->toArray();

        $this->set(compact('companymembers'));
    }
    public function newappointment(){
        $this->loadModel('CompaniesUser');
        $user_id = $this->Auth->user('id');
        $companymemberId = $this->request->getQuery('companymemberId');

        $companyId = $this->request->getQuery('companyId');

        $touserData = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id in' => $companyId,
                'user_id' => $user_id
            ]
        ])->contain(['User', 'Designations'])->first();
        $appointmentdate = $this->request->getData('appointmentdate');
        $appointmentdate = Time::createFromFormat(
            'd/m/Y H:i:s',
            $appointmentdate,
            'Europe/Paris'
        );

        $title = $this->request->getData('title');

        $subject = $this->request->getData('subject');

        $appointment = $this->Appointments->newEntity();
        $appointment->company_id = $companyId;
        $appointment->candidate_id = $user_id;
        $appointment->companymember_id = $companymemberId;
        $appointment->datetime = $appointmentdate;
        $appointment->title = $title;
        $appointment->subject = $subject;
        $this->Appointments->save($appointment);

        $appointment =  $this->Appointments->find('all', [
            'conditions' => [
                'Appointments.id' => $appointment->id
            ]
        ])->contain(['Companymembers','Candidates'])->first();



        //Notify by notification and email
        $this->loadModel('Notifications');
        $notification = $this->Notifications->newEntity();
        $notification->fromuser_id = $user_id = $this->Auth->user('id');
        $notification->action_title = $appointment->title;
        $notification->action_description = $subject;
        $notification->action_id = $appointment->id;
        $notification->action_status = 'request';
        $notification->creation_date = Time::now();
        $notification->touser_id = $companymemberId;
        $notification->type = 'appointment';
        $this->Notifications->save($notification);
        //email notification
        $email = new Email();
        $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($touserData->user->email)
            ->setemailFormat('html')
            ->setSubject('Notification')
            ->setViewVars([
                'appointment' =>$appointment,
                'notification' => $notification

            ])
            ->setTemplate('appointment_notification')
            ->send();

        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
        return $this->redirect(['action' => 'appointmentspage',$companyId]);


    }
    public function updateappointmentstatus(){
        $id = $this->request->getData('id');
        $status = $this->request->getData('status');
        $appointment =  $this->Appointments->find('all', [
            'conditions' => [
                'Appointments.id' => $id
            ]
        ])->contain(['Companymembers','Candidates'])->first();
        if($status == '1'){
            $appointment->status = true;
        }else{
            $appointment->status = false;

        }

        $this->Appointments->save($appointment);
          //Notify by notification and email
          $this->loadModel('Notifications');
          $notification = $this->Notifications->newEntity();
          $notification->fromuser_id = $this->Auth->user('id');
          $notification->action_title = $appointment->title;
          $notification->action_description = $appointment->subject;
          $notification->action_id = $appointment->id;
          $notification->action_status = 'update';
          $notification->creation_date = Time::now();
          $notification->touser_id = $appointment->candidate_id;
          $notification->type = 'appointment';
          $this->Notifications->save($notification);

          //email notification
          $email = new Email();
          $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
              ->setTo($appointment->candidate->user->email)
              ->setemailFormat('html')
              ->setSubject('Notification')
              ->setViewVars([
                  'appointment' => $appointment,
                  'notification' => $notification

              ])
              ->setTemplate('appointment_notification')
              ->send();

          if ($emailSent) {
              $this->Flash->success(__('E-mail sent.'));
          } else {
              $this->Flash->error(__('Error message'));
          }
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($appointment));
    }
}
