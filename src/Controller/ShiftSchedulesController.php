<?php
namespace App\Controller;
use Cake\I18n\Time;
use Cake\Mailer\Email;

use App\Controller\AppController;

/**
 * ShiftSchedules Controller
 *
 * @property \App\Model\Table\ShiftSchedulesTable $ShiftSchedules
 *
 * @method \App\Model\Entity\ShiftSchedule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShiftSchedulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Departments', 'Users', 'Shifts']
        ];
        $shiftSchedules = $this->paginate($this->ShiftSchedules);

        $this->set(compact('shiftSchedules'));
    }
    public function isAuthorized() {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Shift Schedule id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shiftSchedule = $this->ShiftSchedules->get($id, [
            'contain' => ['Departments', 'Users', 'Shifts']
        ]);

        $this->set('shiftSchedule', $shiftSchedule);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shiftSchedule = $this->ShiftSchedules->newEntity();
        if ($this->request->is('post')) {
            $shiftSchedule = $this->ShiftSchedules->patchEntity($shiftSchedule, $this->request->getData());
            if ($this->ShiftSchedules->save($shiftSchedule)) {
                $this->Flash->success(__('The shift schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shift schedule could not be saved. Please, try again.'));
        }
        $departments = $this->ShiftSchedules->Departments->find('list', ['limit' => 200]);
        $users = $this->ShiftSchedules->Users->find('list', ['limit' => 200]);
        $shifts = $this->ShiftSchedules->Shifts->find('list', ['limit' => 200]);
        $this->set(compact('shiftSchedule', 'departments', 'users', 'shifts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shift Schedule id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shiftSchedule = $this->ShiftSchedules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shiftSchedule = $this->ShiftSchedules->patchEntity($shiftSchedule, $this->request->getData());
            if ($this->ShiftSchedules->save($shiftSchedule)) {
                $this->Flash->success(__('The shift schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shift schedule could not be saved. Please, try again.'));
        }
        $departments = $this->ShiftSchedules->Departments->find('list', ['limit' => 200]);
        $users = $this->ShiftSchedules->Users->find('list', ['limit' => 200]);
        $shifts = $this->ShiftSchedules->Shifts->find('list', ['limit' => 200]);
        $this->set(compact('shiftSchedule', 'departments', 'users', 'shifts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shift Schedule id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shiftSchedule = $this->ShiftSchedules->get($id);
        if ($this->ShiftSchedules->delete($shiftSchedule)) {
            $this->Flash->success(__('The shift schedule has been deleted.'));
        } else {
            $this->Flash->error(__('The shift schedule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function shiftSchedule($companyId = null)
    {
        $this->loadModel('EmployeeShifts');
        $this->loadModel('Departments');
        $shifts = $this->EmployeeShifts->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain('RepeateShifts')->toArray();

        $departments = $this->Departments->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain([
            'Companiesuser.Designations',
            'Companiesuser.User'
        ])->toArray();

        $companyshiftschedules = $this->ShiftSchedules->find('all',[
            'conditions' => [
                'ShiftSchedules.company_id' => $companyId
            ]
        ])->contain([
            'User',
            'Departments.Designations'
        ])->toArray();
        $this->loadModel('CompaniesUser');
      $companymembers =  $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Shiftschedules.EmployeeShifts.RepeateShifts',
        'Shiftschedules.User',
        'Designations',
        'User'])->toArray();
        //debug($companymembers);exit;
        $this->set(compact('companyId', 'companyshiftschedules', 'companymembers','shifts', 'departments'));
    }

    public function addSchedule(){
        $shifts = $this->request->getData('shifts');
        $departmentId = $this->request->getData('departmentId');
        $employeeId = $this->request->getData('employeeId');
        $shifId = $this->request->getData('shiftId');
        $startschedule = $this->request->getData('startschedule');

        $startschedule = Time::createFromFormat(
            'd/m/Y',
            $startschedule,
            'Europe/Paris'
        );
        $endschedule = $this->request->getData('endschedule');
        $endschedule = Time::createFromFormat(
            'd/m/Y',
            $endschedule,
            'Europe/Paris'
        );
        $companyId = $this->request->getData('companyId');
       /*  $extrahrs = $this->request->getData('extrahrs');
        $publish = $this->request->getData('publish'); */

        $shiftSchedule = $this->ShiftSchedules->newEntity();
        $shiftSchedule->company_id = $companyId;
        $shiftSchedule->department_id = $departmentId;
        $shiftSchedule->user_id = $employeeId;
        $shiftSchedule->shift_id = intval($shifId);
        $shiftSchedule->scheduledshift_startdate = $startschedule;
        $shiftSchedule->scheduledshift_enddate = $endschedule;
        $this->ShiftSchedules->save($shiftSchedule);
        $this->Flash->success(__('Shift Schedule is Created.'));

        $this->createShiftSchedules($employeeId, $shiftSchedule->id);

        if(!empty($shifts)){
            return $this->redirect(['controller' => 'employeeShifts','action' => 'shifts', $companyId]);
        }else{
            return $this->redirect(['controller' => 'shiftSchedules','action' => 'shiftSchedule', $companyId]);

        }
    }
    public function editshift(){
        $editdepartmentId = $this->request->getData('editdepartmentId');
        $editemployeeId = $this->request->getData('editemployeeId');
        $editshift = $this->request->getData('editshift');
        $editstartdate = $this->request->getData('editstartdate');
        $editenddate = $this->request->getData('editenddate');
        $isRepeated = $this->request->getData('isRepeated');
        $daystorepeate = $this->request->getData('daystorepeate');
        $endofshift = $this->request->getData('endofshift');
        $isIndefinite = $this->request->getData('isIndefinite');

        debug($editdepartmentId);
        debug($editemployeeId);
        debug($editshift);
        debug($editstartdate);
        debug($editenddate);
        debug($isRepeated);
        debug($daystorepeate);
        debug($endofshift);
        debug($isIndefinite);exit;

    }

    public function serachshiftschedules(){
        $this->loadModel('EmployeeShifts');
        $this->loadModel('Departments');
        $this->loadModel('CompaniesUser');

        $companyId =  $this->request->getQuery('companyId');
        $employeename = $this->request->getQuery('employeename');
        $departmentId = $this->request->getQuery('departmentId');
        $fromdate = $this->request->getQuery('fromdate');
        $todate = $this->request->getQuery('todate');
        if (!empty($fromdate) && empty($todate) || empty($fromdate) && !empty($todate)) {
            $this->Flash->error(__('From Date or ToDate is Missing!'));
            return $this->redirect(['action' => 'shift-schedule', $companyId]);
        }elseif(!empty($fromdate) && !empty($todate)){
            $fromdate = Time::createFromFormat(
                'd/m/Y',
                $fromdate,
                'Europe/Paris'
            );
            $todate = Time::createFromFormat(
                'd/m/Y',
                $todate,
                'Europe/Paris'
            );

        }



        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Shiftschedules',
        'Shiftschedules.EmployeeShifts.RepeateShifts',
        'Shiftschedules.User',
        'Designations',
        'User'])->toArray();

        if (!empty($employeename) && !empty($departmentId) && !empty($fromdate) && !empty($todate)) {
            $resultarray = array();
            foreach ($companymembers as $companymember) {
                if ((preg_match("/{$employeename}/i", $companymember->user->firstname) || preg_match("/{$employeename}/i", $companymember->user->lastname)) && ($companymember->department_id == $departmentId)) {
                    array_push($resultarray, $companymember->user_id);
                }
            }
        } elseif (empty($employeename) && empty($departmentId) && !empty($fromdate) && !empty($todate)) {
            $resultarray = array();
            foreach($companymembers as $companymember){
                foreach($companymember->shiftschedules as $shiftschedule){
                    if(strtotime($shiftschedule->scheduledshift_startdate) == strtotime($fromdate) && strtotime($shiftschedule->scheduledshift_enddate) == strtotime($todate)){
                        array_push($resultarray, $companymember->user_id);
                    }
                }

            }

        } elseif (!empty($employeename) && empty($departmentId) && empty($fromdate) && empty($todate)) {
            $resultarray = array();
            foreach ($companymembers as $companymember) {
                if ((preg_match("/{$employeename}/i", $companymember->user->firstname) || preg_match("/{$employeename}/i", $companymember->user->lastname))) {
                    array_push($resultarray, $companymember->id);
                }
            }
        } elseif (empty($employeename) && !empty($departmentId) && empty($fromdate) && empty($todate)) {
            $resultarray = array();
            foreach ($companymembers as $companymember) {
                if ($companymember->department_id == $departmentId) {
                    array_push($resultarray, $companymember->id);
                }
            }
        }
        $shifts = $this->EmployeeShifts->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain('RepeateShifts')->toArray();

        $departments = $this->Departments->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain([
            'Companiesuser.Designations',
            'Companiesuser.User'
        ])->toArray();

        if (!empty($resultarray)) {
            $companyshiftschedules = $this->ShiftSchedules->find('all', [
                'conditions' => [
                    'ShiftSchedules.company_id' => $companyId,
                    'user_id in' =>  $resultarray
                ]
            ])->contain([
                'User',
                'Departments.Designations'
            ])->toArray();
        }else{
            $companyshiftschedules =array();
        }




        $this->set(compact('companyId', 'companyshiftschedules', 'shifts', 'departments','employeename', 'departmentId', 'fromdate','todate'));

    }

    private function createShiftSchedules($employeeId= null, $shiftScheduleId= null){



        $shiftSchedule = $this->ShiftSchedules->find('all',[
            'conditions' =>[
                'ShiftSchedules.id in' => $shiftScheduleId
            ]
        ])->contain(['EmployeeShifts'])->first();
        $this->loadModel('CompanyModules');

        $user_id = $this->Auth->user('id');

        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $touser = $this->User->find('all',[
            'conditions' => [
                'id in' => $employeeId
            ]
        ])->first();

        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->toArray();


        foreach ($companymodules as $module) {
            if ($module->name == 'ShiftSchedules' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id =$authuser->choosen_companyId;
                $notification->module_id = $module->id;
                $notification->module_action = 'Created';
                $notification->module_action_id = $shiftSchedule->id;
                $notification->module_action_title = $shiftSchedule->employee_shift->name;
                $notification->module_action_description = $shiftSchedule->start_date;
                $notification->creation_date = Time::now();
                $notification->fromuser_id = $user_id;
                $notification->touser_id = $employeeId;
                $this->Notifications->save($notification);

                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($touser->email)
                    ->setemailFormat('html')
                    ->setSubject('Notification')
                    ->setViewVars([
                    ])
                    ->setTemplate('notification')
                    ->send();
                if ($emailSent) {
                    $this->Flash->success(__('E-mail sent.'));
                } else {
                    $this->Flash->error(__('Error message'));
                }
            }
        }



    }

}
