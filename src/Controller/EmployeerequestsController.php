<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;

/**
 * Employeerequests Controller
 *
 * @property \App\Model\Table\EmployeerequestsTable $Employeerequests
 *
 * @method \App\Model\Entity\Employeerequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeerequestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $employeerequests = $this->paginate($this->Employeerequests);

        $this->set(compact('employeerequests'));
    }


    /**add request */
    public function request()
    {
        $this->loadModel('Employeerequests');

    }

    public function addrequest()
    {
        $user_id = $this->Auth->user('id');
        $newrequest = $this->Employeerequests->newEntity();
        $newrequest->user_id = $user_id;
        $newrequest->title = $this->request->getData('name');
        $newrequest->request_type = $this->request->getData('requesttype');
        $newrequest->worktype = $this->request->getData('worktype');


        $newrequest->description = $this->request->getData('description');
        $fromdate = $this->request->getData('fromdate');

        $fromdate = Time::createFromFormat(
            'd/m/Y',
            $fromdate,
            'Europe/Paris'
        );
        $newrequest->fromdate =$fromdate;
        $todate =  $this->request->getData('todate');
        //debug($todate);exit;

        $todate = Time::createFromFormat(
            'd/m/Y',
            $todate,
            'Europe/Paris'
        );
       // debug($todate);exit;
        $newrequest->todate =$todate;


       //debug($newrequest);exit;

        $this->Employeerequests->save($newrequest);
        return $this->redirect(['action' => 'requests']);
    }

    /**update request */
    public function updaterequest(){
        $rid = $this->request->getData('rid');
       $updaterequest =  $this->Employeerequests->find('all',[
            'conditions' => [
                'id' => $rid
            ]
        ])->first();
        $updaterequest->title = $this->request->getData('title');
        $updaterequest->request_type = $this->request->getData('request_type');
        $updaterequest->worktype = $this->request->getData('work_type');
        $updaterequest->description = $this->request->getData('description');
        $fromdate = $this->request->getData('fromdate');

        $fromdate= Time::createFromFormat(
            'd/m/Y',
            $fromdate,
            'Europe/Rome'
        );
        $updaterequest->fromdate =$fromdate;
        $todate = $this->request->getData('todate');
        $todate= Time::createFromFormat(
            'd/m/Y',
            $todate,
            'Europe/Rome'
        );


        $updaterequest->todate = $todate;
        $updaterequest->status = $this->request->getData('status');
        $this->Employeerequests->save($updaterequest);
        return $this->redirect(['action' => 'requests']);


    }

    /**
     * View method
     *
     * @param string|null $id Employeerequest id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeerequest = $this->Employeerequests->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('employeerequest', $employeerequest);
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        debug('hiii');exit;
        $employeerequest = $this->Employeerequests->newEntity();
        if ($this->request->is('post')) {
            $employeerequest = $this->Employeerequests->patchEntity($employeerequest, $this->request->getData());
            if ($this->Employeerequests->save($employeerequest)) {
                $this->Flash->success(__('The employeerequest has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employeerequest could not be saved. Please, try again.'));
        }
        $users = $this->Employeerequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('employeerequest', 'users'));
    }

    public function requests(){
        $this->loadModel('User');
        $allusers = $this->User->find('all',[
            'isDeleted' => false
        ])->toArray();
        $this->loadModel('Employeerequests');
        $allrequest = $this->Employeerequests->find('all')->toArray();
        $this->set(compact('allrequest','allusers'));



    }

    /**
     * Edit method
     *
     * @param string|null $id Employeerequest id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeerequest = $this->Employeerequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeerequest = $this->Employeerequests->patchEntity($employeerequest, $this->request->getData());
            if ($this->Employeerequests->save($employeerequest)) {
                $this->Flash->success(__('The employeerequest has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employeerequest could not be saved. Please, try again.'));
        }
        $users = $this->Employeerequests->Users->find('list', ['limit' => 200]);
        $this->set(compact('employeerequest', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employeerequest id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeerequest = $this->Employeerequests->get($id);
        if ($this->Employeerequests->delete($employeerequest)) {
            $this->Flash->success(__('The employeerequest has been deleted.'));
        } else {
            $this->Flash->error(__('The employeerequest could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
