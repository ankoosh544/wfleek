<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;

use Cake\Mailer\Mailer;
use Cake\Mailer\Email;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * Leaves Controller
 *
 * @property \App\Model\Table\LeavesTable $Leaves
 *
 * @method \App\Model\Entity\Leave[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeavesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['User']
        ];
        $leaves = $this->paginate($this->Leaves);

        $this->set(compact('leaves'));
    }
    public function isAuthorized($user)
    {
        return true;
    }


    /**
     * View method
     *
     * @param string|null $id Leave id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');

        //debug($pid);exit;
        $this->loadModel('ProjectMember');
        $projectObject = $this->ProjectObject->find('all', [
            'condition' => [
                'id' => $id
            ]
        ])->first();

        $this->set(compact('projectObject'));

        $leave = $this->Leaves->find('all')->toArray();
        $leaveApproved = $this->Leaves->find('all',[
            'conditions' => [
                'status' => 'A'
            ]
        ]
        )->toArray();
        $leavePending = $this->Leaves->find('all',[
            'conditions' => [
                'status' => 'P'
            ]
        ]
        )->toArray();
        $leaveRejected = $this->Leaves->find('all',[
            'conditions' => [
                'status' => 'R'
            ]
        ]
        )->toArray();
        $leaveNew = $this->Leaves->find('all',[
            'conditions' => [
                'status' => 'N'
            ]
        ]
        )->toArray();
        $this->set(compact('leave','leaveApproved','leavePending','leaveRejected','leaveNew'));
        $data = $this->ProjectMember->find('all')->toArray();
        $userid = array();
        foreach ($data as $item) {
            array_push($userid, $item['memberId']);
        }
        $res = $this->User->find('all', [
            'conditions' => [
                'id in' => $userid
            ]
        ])->toArray();
        $this->set(compact('res'));
    }



    /**Total employees on leave */
    public function onleaveemployees(){
        $this->loadModel('Leaves');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $date = Time::now()->i18nFormat('dd/MM/yyyy', 'Europe/Rome');
        $date = Time::createFromFormat(
            'd/m/Y',
            $date,
            'Europe/Rome'
        );
        $leaves = $this->Leaves->find('all',[
            'conditions' => [
                'fromdate <= ' => $date,
                'todate >='  => $date,
                'status' => 'A'
            ]
        ])->toArray();
        $admin = $this->ProjectMember->find('all',[
            'conditions' =>[
                'type' => 'Y'
            ]
        ])->first();
        $user = $this->User->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $this->set(compact('leaves','user','admin' ));
    }


    // Today Working Employees

    public function presentworkingemp(){
        $this->loadModel('Leaves');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $leaves = $this->Leaves->find('all',[
            'conditions'=>[
                'DATE(fromdate) <=' => date('Y-m-d'),
                'DATE(todate) >='  => date('Y-m-d'),
                'status' => 'A'
            ]
        ])->toArray();
        $empIds = array();
        foreach($leaves as $leave){
            array_push($empIds, $leave->user_id);
        }
        $projectmembers = $this->ProjectMember->find('all',[
            'conditions' =>[
                'type !=' => 'C'
            ]
        ])->toArray();
        $workingemps = array();
        foreach ($projectmembers as $emp) {
            if (!in_array($emp->memberId, $empIds)) {
                array_push($workingemps, $emp->memberId);
            }
        }
        $totalprojectmemberIds =  array_unique($workingemps);
        $allUsers = $this->User->find('all', [
            'conditions' => [
                'id in ' => $totalprojectmemberIds
            ]
        ])->toArray();
        $this->set(compact('allUsers'));

    }


    /**updateLeavestatus method */

    public function updateLeavestatus(){

        $this->loadModel('Leaves');
        $this->loadModel('User');
        $lid = $this->request->getData('lid');
        $status = $this->request->getData('leavestatus');
        $emprecord = $this->Leaves->find('all', [
            'conditions' => [
                'id' => $lid
            ]
        ])->first();
        $emprecord->status = $status;
        $this->Leaves->save($emprecord);
        $user =$this->User->find('all',[
            'conditions'=> [
                'id in' => $emprecord->user_id
            ]
        ])->first();

    //Notification for Update LeaveStatus
        $this->loadModel('Notifications');
        $userid = $this->Auth->user('id');
        $notEmp = $this->Notifications->newEntity();
       /*  $notEmp->company_id =  */
        $notEmp->fromuser_id = $userid;
        $notEmp->touser_id = $emprecord->user_id;
        $notEmp->action_title = $emprecord->leavetype;
        $notEmp->action_status = $emprecord->status;
        $notEmp->action_description =null;
        $notEmp->action_id = $emprecord->id;
        $notEmp->creation_date = Time:: now();
        $notEmp->type ='leave';
        $this->Notifications->save($notEmp);
        if($emprecord->status == 'P'){
            $emprecord->status = 'Pending';
        }elseif($emprecord->status == 'A'){
            $emprecord->status = 'Approved';
        }elseif($emprecord->status == 'R'){
            $emprecord->status = 'Rejected';
        }
        $email = new Email();
        $emailSent =    $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
       ->setTo($user->email)
        ->setemailFormat('html')
        ->setSubject('Leave Request Updated' )
        ->send('Hello  '.$user->firstname .' '.$user->lastname.'  Administrator '.$emprecord->status. '  Your Leave Request');
       if($emailSent)
        $this->Flash->success(__('Email is Sent to Administrator!'));
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode('sucess'));
    }

    /**-------------Update------------------------ */


    public function updateleave()
    {
        $kid = null;
        $kid = $this->request->getData('kid');
        //debug($kid);exit;
        $lid = $this->request->getData('lid');
        //debug($lid);exit;
        $this->loadModel('Leaves');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');

        $leavetype = $this->request->getData('leavetype');
        //debug($leavetype);exit;
        $medicalno = null;
        if ($leavetype == 'M') {
            $medicalno = $this->request->getData('medicalno');
        }
        //debug($leavetype);exit;
        $fromdate = $this->request->getData('fromdate');
        $todate = $this->request->getData('todate');
        // $ndays = $this->request->getData('ndays');
        $reason = $this->request->getData('leavereason');

        $updateleave = $this->Leaves->find('all', [
            'conditions' => [
                'id' => $lid
            ]
        ])->first();

       $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        //debug($updateleave);exit;
        //$updateleave->user_id = $user_id;
        $updateleave->leavetype = $leavetype;
        $updateleave->company_id =$authuser->choosen_companyId;
        //debug($fromdate);exit;
        $fromdate = Time::createFromFormat(
            'd/m/Y',
            $fromdate,
            'Europe/Rome'
        );
        //debug($fromdate);exit;

        $updateleave->fromdate = $fromdate;
        $todate = Time::createFromFormat(
            'd/m/Y',
            $todate,
            'Europe/Rome'
        );

        $updateleave->todate = $todate;
        $updateleave->leavereason = $reason;
        $updateleave->medical_number = $medicalno;
        //$leave->creation_date = Time::now();
       // debug($updateleave);exit;
        $this->Leaves->save($updateleave);
        if($kid !=null){
            return $this->redirect([
                'controller' => 'Leaves',
                'action' => 'adminleaves'
            ]);

        }

    }
    /**Employee Leaves */

    public function employeeleaves(){
    $this->loadModel('User');
    $userId = $this->Auth->user('id');
    //debug($userId);exit;
    $empleave = $this->Leaves->find('all',[
        'conditions' => [
            'user_id' => $userId
        ]
    ])->toArray();
    //debug($leave);exit;
    $this->set(compact('empleave'));




    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leave = $this->Leaves->newEntity();
        if ($this->request->is('post')) {
            $leave = $this->Leaves->patchEntity($leave, $this->request->getData());
            if ($this->Leaves->save($leave)) {
                $this->Flash->success(__('The leave has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave could not be saved. Please, try again.'));
        }
        $user = $this->Leaves->User->find('list', ['limit' => 200]);
        $this->set(compact('leave', 'user'));
    }






        /**Adminbashboard method */
    public function adminleaves($companyId = null)
    {

        $this->loadModel('User');
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectObject');
        $user_id = $this->Auth->user('id');

        $leavesData = $this->Leaves->find('all',[
            'conditions' =>[
                'Leaves.isDeleted' =>false,
                'Leaves.company_id' => $companyId
            ]
        ])->order(['creation_date' => 'DESC'])->contain(['User'])->toArray();

       // debug($leavesData);exit;

        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Designations'])->toArray();

        $leaves = $this->Leaves->find('all', [
            'conditions' => [
                'status' => 'A',
                'isDeleted' => false
            ]
        ])->toArray();
         $pending = $this->Leaves->find('all', [
             'conditions' => [
                 'status' => 'P',
                 'isDeleted' => false
             ]
         ])->toArray();
         $totalpendings = count($pending);

         $empIds = array();
         foreach($leaves as $leave){
             array_push($empIds, $leave->user_id);
         }
         $companymembers = $this->CompaniesUser->find('all')->contain([
             'Designations'=> function ($q) {
                return $q->where([
                   'name !=' => 'Customer'
                ]);
            },
         ])->toArray();
        $workingemps = array();
        foreach ($companymembers as $emp) {
            if (!in_array($emp->user_id, $empIds)) {
                array_push($workingemps, $emp->user_id);
            }
        }
        $totalprojectmemberIds =  array_unique($workingemps);
         $totalemps = count($totalprojectmemberIds);
         $totalleave = count($empIds);
         $this->set(compact('leaves', 'totalemps','totalleave','totalpendings','leavesData', 'companyId','companymembers'));
    }


    public function searchleave(){
        $this->loadModel('CompaniesUser');
        $employeename = $this->request->getQuery('employeename');
        $leavetype = $this->request->getQuery('leavetype');
        $leavestatus = $this->request->getQuery('leavestatus');
        $fromdate = $this->request->getQuery('fromdate');
        $todate = $this->request->getQuery('todate');
        $companyId = $this->request->getQuery('companyId');

        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Designations'])->toArray();



        $leaves = $this->Leaves->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User'])->toArray();


            if(!empty($employeename) && !empty($leavetype) && !empty($leavestatus) && !empty($fromdate) && !empty($todate)){
                $leavesData = array();
                foreach($leaves as $leave){
                    if ((preg_match("/{$employeename}/i", $leave->user->firstname)) || (preg_match("/{$employeename}/i", $leave->user->lastname)) && $leavetype== $leave->type && $leavestatus == $leave->status && (strtotime($fromdate) == strtotime($leave->fromdate)) && (strtotime($todate) == strtotime($leave->todate))) {
                        array_push($leavesData, $leave);
                    }
                }
            }elseif(!empty($employeename) && !empty($leavetype) && !empty($leavestatus)){

                $leavesData = array();
                foreach($leaves as $leave){
                    if ((preg_match("/{$employeename}/i", $leave->user->firstname)) || (preg_match("/{$employeename}/i", $leave->user->lastname)) && $leavetype== $leave->type && $leavestatus == $leave->status) {
                        array_push($leavesData, $leave);
                    }
                }
            }elseif(empty($employeename) && empty($leavetype) && empty($leavestatus) && !empty($fromdate) && !empty($todate)){
                $leavesData = array();
                foreach($leaves as $leave){
                    if ((strtotime($fromdate) == strtotime($leave->fromdate)) && (strtotime($todate) == strtotime($leave->todate))){
                        array_push($leavesData, $leave);
                    }
                }
            }elseif(!empty($employeename) && !empty($leavetype) && empty($leavestatus)){


                $leavesData = array();
                foreach($leaves as $leave){
                    if (((preg_match("/{$employeename}/i", $leave->user->firstname)) || (preg_match("/{$employeename}/i", $leave->user->lastname))) && $leavetype == $leave->type) {
                        array_push($leavesData, $leave);
                    }
                }
            }elseif(!empty($employeename) && empty($leavetype) && !empty($leavestatus)){
                $leavesData = array();
                foreach($leaves as $leave){
                    if ((preg_match("/{$employeename}/i", $leave->user->firstname)) || (preg_match("/{$employeename}/i", $leave->user->lastname)) && $leavestatus == $leave->status) {
                        array_push($leavesData, $leave);
                    }
                }
            }elseif(empty($employeename) && !empty($leavetype) && !empty($leavestatus)){
                $leavesData = array();
                foreach($leaves as $leave){
                    if ($leavetype== $leave->type && $leavestatus == $leave->status) {
                        array_push($leavesData, $leave);
                    }
                }
            }else{

                $leavesData = array();
                foreach($leaves as $leave){
                    if(!empty($employeename) && empty($leavetype) && empty($leavestatus) && empty($fromdate) && empty($todate)){
                        if ((preg_match("/{$employeename}/i", $leave->user->firstname)) || (preg_match("/{$employeename}/i", $leave->user->lastname))) {
                            array_push($leavesData, $leave);
                        }
                    }elseif(empty($employeename) && !empty($leavetype) && empty($leavestatus) && empty($fromdate) && empty($todate)){
                        if($leavetype== $leave->type){
                            array_push($leavesData, $leave);
                        }

                    }elseif(empty($employeename) && empty($leavetype) && !empty($leavestatus) && empty($fromdate) && empty($todate)){
                        if($leavestatus == $leave->status){
                            array_push($leavesData, $leave);
                        }

                    }elseif(empty($employeename) && empty($leavetype) && empty($leavestatus) && !empty($fromdate) && empty($todate)){
                        if ((strtotime($fromdate) == strtotime($leave->fromdate))){
                            array_push($leavesData, $leave);

                        }
                    }elseif(empty($employeename) && empty($leavetype) && empty($leavestatus) && empty($fromdate) && !empty($todate)){
                        if ((strtotime($todate) == strtotime($leave->todate))){
                            array_push($leavesData, $leave);
                        }
                    }
                }
            }



            $this->set(compact('leavesData', 'companyId','companymembers'));
    }





    /**Leave Reports */
    public function leaveReports($companyId = null){
        $this->loadModel('CompaniesUser');
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();

        $leaves = $this->Leaves->find('all',[
            'conditions' => [
                'Leaves.company_id' => $companyId,
                'Leaves.status' => 'A'
            ]
        ])->contain(['User'])->toArray();

        $this->set(compact('leaves', 'companymembers', 'companyId'));

    }

    public function generatepdf(){
      $companyId =  $this->request->getQuery('companyId');

      $companymembers = $this->CompaniesUser->find('all',[
        'conditions' => [
            'company_id' => $companyId
        ]
    ])->contain(['User', 'Designations'])->toArray();

    $leaves = $this->Leaves->find('all',[
        'conditions' => [
            'Leaves.company_id' => $companyId,
            'Leaves.status' => 'A'
        ]
    ])->contain(['User'])->toArray();

          //This is Engine for pdf
          Configure::write('CakePdf', [
            'engine' => [
                'className' => 'CakePdf.DomPdf',
                'options' => [
                    'isRemoteEnabled' => true
                ]
            ],
            'margin' => [
                'bottom' => 15,
                'left' => 50,
                'right' => 30,
                'top' => 45
            ],
            'orientation' => 'landscape',
            'download' => true
        ]);
        //This is cakepdf code for pdf
        $CakePdf = new \CakePdf\Pdf\CakePdf();
        $CakePdf->template('leaves', 'default');
        $CakePdf->viewVars(['companymembers' => $companymembers, 'leaves' => $leaves]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $response = $this->response;
        // Inject string content into response body
        $response = $response->withStringBody($pdf);
        $response = $response->withType('pdf');
        // Optionally force file download
        $response = $response->withDownload('leaves.pdf');
        return $response;


    }

    //update lastsEeen
    public function lastseenLeaves(){
        $this->loadModel('Leaves');
        if ($this->request->is('ajax')) {
            $dummy = $this->request->getData('dummy');
            $leaves =  $this->Leaves->find('all', [
                'conditions' => [
                    'isSeen' => false
                ]
            ])->toArray();
           // debug($leaves);exit;
            foreach ($leaves as $leave) {
                $leave->isSeen = true;
                $this->Leaves->save($leave);
            }


            $unseenleaves =  $this->Leaves->find('all', [
                'conditions' => [
                    'isSeen' => false,
                    'isDeleted' => false
                ]
            ])->toArray();
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($unseenleaves));
        }
    }




    public function addleave()
    {
        $this->loadModel('Leaves');
        $this->loadModel('User');
        $this->loadModel('CompaniesUser');
        $companyId = $this->request->getData('companyId');

        $leavetype = $this->request->getData('leavetype');
        $medicalno = null;
        if ($leavetype == 'M') {
            $medicalno = $this->request->getData('medicalno');
        }
        $fromdate = $this->request->getData('fromdate');
        $fromdate = Time::createFromFormat(
            'd/m/Y',
            $fromdate,
            'Europe/Paris'
        );

        $todate = $this->request->getData('todate');
        $todate = Time::createFromFormat(
            'd/m/Y',
            $todate,
            'Europe/Paris'
        );
        $reason = $this->request->getData('leavereason');

        $type = $this->request->getData('type');
        $user_id = $this->Auth->user('id');
        $authuser =  $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $leave = $this->Leaves->newEntity();
        $leave->user_id = $user_id;
        $leave->company_id = $authuser->choosen_companyId;
        $leave->leavetype = $leavetype;
        $leave->fromdate = $fromdate;
        $leave->todate = $todate;
        $leave->leavereason = $reason;
        $leave->medical_number = $medicalno;
        $leave->creation_date = Time::now();
        $this->Leaves->save($leave);

        $companymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['Designations','User'])->first();

        if ($companymember->designation->name != 'Administrator') {
            $this->loadModel('Notifications');
            $notification = $this->Notifications->newEntity();
            $notification->company_id = $authuser->choosen_companyId;
            $notification->fromuser_id = $user_id;
            $notification->action_title = $leave->leavetype;
            $notification->action_status = 'New';
            $notification->action_description = null;
            $notification->action_id = $leave->id;
            $notification->creation_date = Time::now();
            $notification->touser_id = $companymember->user_id;
            $notification->type = 'leave';
            $this->Notifications->save($notification);
            $email = new Email();
            $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($companymember->user->email)
            ->setEmailFormat('html')
            ->setSubject('Leave Request by Employee' . $authuser->firstname . ' ' . $authuser->lastname)
                ->setTemplate('leaverequest', 'default')
                ->setViewVars(['leave' => $leave, 'leaveuseremail' => $authuser]);
            $email->send();

            if ($type != null) {
                return $this->redirect([
                    'controller' => 'projectmember',
                    'action' => 'employeedashboard',
                    $companyId
                ]);
            } else {
                return $this->redirect([
                    'controller' => 'Leaves',
                    'action' => 'employeeleaves',
                    $companyId
                ]);
            }
        } else {
            return $this->redirect([
                'controller' => 'Leaves',
                'action' => 'adminleaves',
                $companyId
            ]);
        }
    }



    /**
     * Edit method
     *
     * @param string|null $id Leave id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leave = $this->Leaves->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leave = $this->Leaves->patchEntity($leave, $this->request->getData());
            if ($this->Leaves->save($leave)) {
                $this->Flash->success(__('The leave has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave could not be saved. Please, try again.'));
        }
        $user = $this->Leaves->User->find('list', ['limit' => 200]);
        $this->set(compact('leave', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leave id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('ProjectMember');

        $userid = $this->Auth->user('id');
        $data2 = $this->ProjectMember->find('all',[
            'conditions'=> [
                'memberId'=>  $userid
            ]
        ])->first();
        $this->request->allowMethod(['post', 'get', 'delete']);
        $leave = $this->Leaves->get($id);
        $companyId = $leave->company_id;
        if ($this->Leaves->delete($leave)) {
            $this->Flash->success(__('The leave has been deleted.'));
        } else {
            $this->Flash->error(__('The leave could not be deleted. Please, try again.'));
        }
        if($data2->type != 'Y')
        {
            return $this->redirect([
                'controller' => 'Leaves',
                    'action' => 'employeeleaves',
                    $companyId
            ]);
        }else{
            return $this->redirect([
                'controller' => 'Leaves',
                    'action' => 'adminleaves',
                    $companyId
            ]);
        }
    }
}
