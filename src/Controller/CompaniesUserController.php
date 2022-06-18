<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Mailer\Email;

/**
 * CompaniesUser Controller
 *
 * @property \App\Model\Table\CompaniesUserTable $CompaniesUser
 *
 * @method \App\Model\Entity\CompaniesUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompaniesUserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies', 'Users']
        ];
        $companiesUser = $this->paginate($this->CompaniesUser);

        $this->set(compact('companiesUser'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    //employees of company

    public function employees($companyId = null){
        $user_id = $this->Auth->user('id');
        $allemployees = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User', 'Designations'])->toArray();



        $this->loadModel('User');

        $alltags = $this->User->find('all')->toArray();
        $tagData = array();
        foreach ($alltags as $tag) {
            $str_arr = preg_split("/;/", $tag->tags);
            array_push($tagData,  $str_arr);
        }
        $result = array();
        foreach ($tagData as $v) {
            $result = array_merge($result, $v);
        }
        $result = array_unique($result);

        $this->set(compact('allemployees','result','companyId','user_id'));
    }

    public function updaterole(){

        $userid = $this->request->getData('userid');
        $role = $this->request->getData('role');
        $updaterole = $this->CompaniesUser->find('all',[
            'conditions' => [
                'user_id' => $userid
            ]
        ])->first();
        $updaterole->member_role = $role;

        $this->CompaniesUser->save($updaterole);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($updaterole));


    }


    public function addemployees($companyId = null)
    {
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->toArray();
        $allemployees = $this->CompaniesUser->find('all',[
            'conditions' => [
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User.Additionaldatausers', 'Designations'])->toArray();

        if(!empty($companymembers)){
            $memberIds = array();
            foreach($companymembers as $member){
                array_push($memberIds, $member->user_id);
            }
        }
        $alltags = $this->User->find('all')->toArray();
        $tagData = array();
        foreach ($alltags as $tag) {
            $str_arr = preg_split("/;/", $tag->tags);
            array_push($tagData,  $str_arr);
        }
        $result = array();
        foreach ($tagData as $v) {
            $result = array_merge($result, $v);
        }
        $result = array_unique($result);
      $allusers =  $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false,
                'id not in' => $memberIds
            ]
        ])->toArray();
        $this->set(compact('allusers','result', 'allemployees'));

    }

    public function filteremployees()
    {

        $this->loadModel('Departments');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['Designations'])->toArray();
        $companydepartments = $this->Departments->find('all', [
            'conditions' => [
                'company_id' =>  $authuser->choosen_companyId
            ]
        ])->contain(['Designations'])->toArray();
        $tagvalue =  $this->request->getQuery('employee');
        if (!empty($companymembers)) {
            $memberIds = array();
            foreach ($companymembers as $member) {
                array_push($memberIds, $member->user_id);
            }
            $allusers = $this->User->find('all', [
                'conditions' => [
                    'id not in' => $memberIds,
                    'tags like' => '%;' . $tagvalue . ';%'
                ]
            ])->toArray();
        } else {
            $allusers = $this->User->find('all', [
                'conditions' => [
                    'tags like' => '%;' . $tagvalue . ';%'
                ]
            ])->toArray();
        }
        $this->set(compact('allusers', 'tagvalue', 'authuser', 'companydepartments'));
    }

    public function saveemployee(){
        $this->loadModel('Designations');
        $this->loadModel('User');
        $companyId = $this->request->getData('companyId');
        $empId = $this->request->getData('empId');
        $designationId = $this->request->getData('designation');
        $tagvalue = $this->request->getData('tagvalue');
        $designation = $this->Designations->find('all',[
            'conditions' => [
                'id ' => $designationId
            ]
        ])->first();


        $companymember = $this->CompaniesUser->newEntity();
        $companymember->company_id = $companyId;
        $companymember->user_id = $empId;
        if (!empty($designationId)) {
            $companymember->department_id = $designation->department_id;
            $companymember->member_role = $designation->id;
            $this->CompaniesUser->save($companymember);
            $this->Flash->success(__('Employee Added Sucessfully.'));
            return $this->redirect([
                'controller' => 'companiesuser',
                'action' => 'filteremployees',
                'employee' => $tagvalue
            ]);
        } else {
            $this->Flash->error(__('Designation not Defined.'));
            return $this->redirect([
                'controller' => 'companiesuser',
                'action' => 'filteremployees',
                'employee' => $tagvalue
            ]);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Companies User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companiesUser = $this->CompaniesUser->get($id, [
            'contain' => ['Companies', 'Users']
        ]);

        $this->set('companiesUser', $companiesUser);
    }


  /*   public function suggestedData()
    {

        if ($this->request->is('ajax')) {
            $this->loadModel('User');
            $id = $this->request->getData('id');
            $data = $this->CompaniesUser->find('all', [
                'conditions' => [
                    'member_role' => 'C'
                ]

            ])->toArray();
            $userids = array();
            foreach ($data as $item) {
                array_push($userids, $item['user_id']);
            }

            // SELECT * FROM user WHERE id in (1, 2, 34)
            $users = $this->User->find('all', [
                'conditions' => [
                    'id in' => $userids
                ],
                'fields' => [
                    'email', 'firstname', 'lastname', 'id'
                ]
            ])->toArray();

            foreach ($users as $item) {
                $item['email'] =  $item['email'] . "*****"  . $item['id'];
            };
            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($users));
        }
    } */

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companiesUser = $this->CompaniesUser->newEntity();
        if ($this->request->is('post')) {
            $companiesUser = $this->CompaniesUser->patchEntity($companiesUser, $this->request->getData());
            if ($this->CompaniesUser->save($companiesUser)) {
                $this->Flash->success(__('The companies user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The companies user could not be saved. Please, try again.'));
        }
        $companies = $this->CompaniesUser->Companies->find('list', ['limit' => 200]);
        $users = $this->CompaniesUser->Users->find('list', ['limit' => 200]);
        $this->set(compact('companiesUser', 'companies', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Companies User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companiesUser = $this->CompaniesUser->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companiesUser = $this->CompaniesUser->patchEntity($companiesUser, $this->request->getData());
            if ($this->CompaniesUser->save($companiesUser)) {
                $this->Flash->success(__('The companies user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The companies user could not be saved. Please, try again.'));
        }
        $companies = $this->CompaniesUser->Companies->find('list', ['limit' => 200]);
        $users = $this->CompaniesUser->Users->find('list', ['limit' => 200]);
        $this->set(compact('companiesUser', 'companies', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Companies User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
       $user_id = $this->request->getQuery('emp_id');
       $companyId = $this->request->getQuery('company_id');


       $deleteuser = $this->CompaniesUser->find('all',[
           'conditions' => [
               'company_id' => $companyId,
                'user_id' => $user_id
            ]
        ])->first();
        $this->CompaniesUser->delete($deleteuser);
        return $this->redirect(['action' => 'employees', $companyId]);
    }

    public function employeesdata(){
        $this->loadModel('Designations');
        $this->loadModel('Departments');
        $user_id = $this->request->getQuery('emp_id');
        $companyId = $this->request->getQuery('company_id');


        $designations = $this->Designations->find('all')->toArray();
        //debug($designations);exit;

        $employee = $this->CompaniesUser->find('all',[
            'conditions' => [
                'CompaniesUser.user_id' => $user_id,
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['User','User.Additionaldatausers.Designations', 'Usercompanies'])->first();

       // debug($employee);exit;




        $this->set(compact('employee', 'designations'));

    }
    public function updateemployee(){
        $user_id = $this->request->getData('user_id');
        $companyId = $this->request->getData('company_id');

        $this->loadModel('User');

        $this->User->find('all',[
            'condition' => [
                'id in' => $user_id
            ]
        ])->first();
       // debug('PENDING');exit;
    }

    public function viewemployeedata()
    {

        $user_id = $this->request->getQuery('emp_id');
        $companyId = $this->request->getQuery('company_id');
        $employee = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id' => $user_id,
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Usercompanies'])->first();

        $this->set(compact('employee'));
    }
    public function employeepunchin(){
        $user_id = $this->request->getQuery('emp_id');
        $companyId = $this->request->getQuery('company_id');
        $userprofile = $this->request->getQuery('userprofile');
        $attendencedashboard = $this->request->getQuery('attendencedashboard');
        $this->loadModel('Workinghours');
        $checkpunchoutemp = null;
        $checkpunchoutemp = $this->Workinghours->find('all',[
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $companyId,
                'end_time is' => null
            ]
        ])->toArray();



        if ($checkpunchoutemp != null) {
            $this->Flash->error('Please Push-out First,Before Punch In Again! ');
            if (!empty($userprofile)) {
                $this->Flash->success('Sucessfully PunchedOut Working Time Ends Now! ');
                return $this->redirect([
                    'controller' => 'projectmember',
                    'action' => 'userprofile',
                    $userprofile
                ]);
            } elseif (!empty($attendencedashboard)) {
                $this->Flash->success('Sucessfully PunchedOut Working Time Ends Now! ');
                return $this->redirect([
                    'controller' => 'workinghours',
                    'action' => 'attendance',
                    'emp_id' => $user_id,
                    'company_id' => $companyId
                ]);
            } else {
                return $this->redirect([
                    'controller' => 'companiesUser',
                    'action' => 'employees',
                    $companyId
                ]);
            }

         }
         else {

            $employeepushIn = $this->Workinghours->newEntity();
            $employeepushIn->id = time() . $user_id;
            $employeepushIn->user_id = $user_id;
            $employeepushIn->company_id = $companyId;
            $employeepushIn->date_of_work = Time::now();
            $employeepushIn->start_time = Time::now();
            $this->Workinghours->save($employeepushIn);

            if (!empty($userprofile)) {
                $this->Flash->success('Sucessfully PunchIn, Working Time Starts Now! ');
                return $this->redirect([
                    'controller' => 'projectmember',
                    'action' => 'userprofile',
                    $userprofile
                ]);
            } elseif (!empty($attendencedashboard)) {
                $this->Flash->success('Sucessfully PunchIn, Working Time Starts Now! ');
                return $this->redirect([
                    'controller' => 'workinghours',
                    'action' => 'attendance',
                    'emp_id' => $user_id,
                    'company_id' => $companyId
                ]);
            } else {
                return $this->redirect([
                    'controller' => 'companiesUser',
                    'action' => 'employees',
                    $companyId
                ]);
            }
        }
    }
    public function employeepunchout()
    {
        $user_id = $this->request->getQuery('emp_id');
        $companyId = $this->request->getQuery('company_id');
        $attendancepage = $this->request->getQuery('attendancepage');
        $attendencedashboard = $this->request->getQuery('attendencedashboard');
        $userprofile = $this->request->getQuery('userprofile');
        $description = $this->request->getQuery('description');




        $this->loadModel('Workinghours');

        $punchoutemp = $this->Workinghours->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $companyId,
                'start_time is not' => null,
                'end_time is' => null
            ]
        ])->first();


        if ($punchoutemp != null) {
            $punchoutemp->date_of_work = Time::now();
            $punchoutemp->end_time = Time::now();
            $punchoutemp->description = $description;
            $this->Workinghours->save($punchoutemp);

            if (!empty($attendancepage)) {

                return $this->redirect([
                    'controller' => 'companiesUser',
                    'action' => 'employees',
                    $companyId
                ]);
            }elseif(!empty($attendencedashboard)){
                return $this->redirect([
                    'controller' => 'workinghours',
                    'action' => 'attendance',
                    'emp_id' => $user_id,
                    'company_id' => $companyId
                ]);
            }

            elseif(!empty($userprofile)) {
                $this->Flash->success('Sucessfully PunchedOut Working Time Ends Now! ');
                return $this->redirect([
                    'controller' => 'projectmember',
                    'action' => 'userprofile',
                    $userprofile
                ]);
            }

            else {
                return $this->redirect([
                    'controller' => 'workinghours',
                    'action' => 'attendance',
                    'emp_id' => $user_id,
                    'company_id' => $companyId
                ]);
            }
        } else {
            $this->Flash->error('No Push In Time Found');
            if (!empty($attendancepage)) {
                return $this->redirect([
                    'controller' => 'companiesUser',
                    'action' => 'employees',
                    $companyId
                ]);
            }elseif(!empty($userprofile)) {
                $this->Flash->success('Sucessfully PunchIn, Working Time Starts Now! ');
                return $this->redirect([
                    'controller' => 'projectmember',
                    'action' => 'userprofile',
                    $userprofile
                ]);
            }elseif(!empty($attendencedashboard)){
                $this->Flash->success('Sucessfully PunchIn, Working Time Starts Now! ');
                return $this->redirect([
                    'controller' => 'workinghours',
                    'action' => 'attendance',
                    'emp_id' => $user_id,
                    'company_id' => $companyId
                ]);

            } else {
                return $this->redirect([
                    'controller' => 'workinghours',
                    'action' => 'attendance',
                    'emp_id' => $user_id,
                    'company_id' => $companyId
                ]);
            }
        }
    }


    public function salary($companyId = null)
    {
        $this->loadModel('Salaries');
        $salaries =  $this->Salaries->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Usercompanies'])->toArray();


        $employees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['User', 'Usercompanies'])->toArray();

        $this->set(compact('employees', 'companyId', 'salaries'));
    }





    public function invitemembers()
    {
        $this->loadModel("CompaniesUser");
        $this->loadModel("User");
        $this->loadModel("ProjectObject");

        $user_id = $this->Auth->user('id');
        $authuser =  $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $tagvalues = json_decode($_POST['tagvalues']);
        $designation = $this->request->getData('tag');
        $cid = $this->request->getData('cid');
        foreach ($tagvalues as $userId) {
            $user = $this->User->find('all', array(
                'conditions' => array('User.id' => $userId),
            ))->first();
            $companymember = $this->CompaniesUser->newEntity();
            $companymember->company_id = $authuser->choosen_companyId;
            $companymember->user_id = $userId;
            if ($designation == 'DEVELOPER;') {
                $designation = 'X';
            } elseif ($designation == 'PROJECTMANAGER;') {
                $designation = 'Z';
            } elseif ($designation == 'ADMINISTRATOR;') {
                $designation = 'Y';
            } elseif ($designation == 'COORDINATOR;') {
                $designation = 'W';
            } elseif ($designation == 'HR;') {
                $designation = 'H';
            }
            $companymember->member_role = $designation;

            if ($designation == 'X') {
                $designation = 'DEVELOPER;';
                if (preg_match('/' . $designation . '/', $user->tags)) {
                    $user->tags = $user->tags;
                } else {
                    $user->tags = $user->tags . $designation;
                }
            } elseif ($designation == 'Z') {

                $designation = 'PROJECTMANAGER;';
                if (preg_match('/' . $designation . '/', $user->tags)) {
                    $user->tags = $user->tags;
                } else {
                    $user->tags = $user->tags . $designation;
                }
            } elseif ($designation == 'Y') {

                $designation = 'ADMINISTRATOR;';
                if (preg_match('/' . $designation . '/', $user->tags)) {
                    $user->tags = $user->tags;
                } else {
                    $user->tags = $user->tags . $designation;
                }
            } elseif ($designation === 'W') {
                $designation = 'COORDINATOR;';
                if (preg_match('/' . $designation . '/', $user->tags)) {
                    $user->tags = $user->tags;
                } else {
                    $user->tags = $user->tags . $designation;
                }
            } elseif ($designation == 'H') {
                $designation = 'HR;';
                if (preg_match('/' . $designation . '/', $user->tags)) {
                    $user->tags = $user->tags;
                } else {
                    $user->tags = $user->tags . $designation;
                }
            }
            $this->CompaniesUser->save($companymember);
            $this->User->save($user);
        }
        if ($this->request->is('ajax')) {

            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($user));
        }

    }


    public function searchdata(){
        $name = null;
        $companyname = null;
        $designation = null;
        $companyId  = $this->request->getData('companyId');
        $name =$this->request->getData('name');
        $companyname = $this->request->getData('companyname');
        $designation = $this->request->getData('role');


      $companydata =  $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id in' => $companyId
            ]
        ])->contain(['User','Usercompanies'])->toArray();

        $matched_data = array();

        foreach ($companydata as $companyuser) {

            if ($name != null) {
                if ((preg_match("/{$name}/i", $companyuser->user->firstname))) {
                    array_push(
                        $matched_data,
                        $companyuser
                    );
                } elseif (preg_match("/{$name}/i", $companyuser->user->lastname)) {
                    array_push(
                        $matched_data,
                        $companyuser
                    );
                }
            }
            if ($designation != null) {
                if ((preg_match("/{$designation}/i", $companyuser->member_role))) {
                    array_push(
                        $matched_data,
                        $companyuser
                    );
                }
            }

        }

        //debug($matched_data);exit;
        $this->set(compact('matched_data','companyId'));
    }

    public function addclient(){
        $this->loadModel('Registrations');
        $random = rand(100000, 999999);
        $invoicecompanyId = $this->request->getData('invoicecompanyId');

        $companyId = $this->request->getData('companyId');
        $firstname = $this->request->getData('firstname');
        $lastname = $this->request->getData('lastname');
        $username = $this->request->getData('username');
        $email = $this->request->getData('emailId');
        $password = $this->request->getData('password');
        $confirmpassword = $this->request->getData('confirmpassword');
        $tel = $this->request->getData('tel');
        $dob = $this->request->getData('dob');
        $registrationuser = $this->Registrations->newEntity();
        $registrationuser->firstname =  $firstname;
        $registrationuser->lastname =  $lastname;
        $allusers =  $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        if(!empty($allusers)){
            $allemailds = array();
            foreach ($allusers as $singleuser) {
                array_push($allemailds, $singleuser->email);
            }
        }
        if ($email != null) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            if (preg_match($test_patt, $email)) {

                if (!empty($allemailds) && in_array($email, $allemailds)) {
                    $this->Flash->error(__('Email Already Exit'));
                    if(!empty($invoicecompanyId)){
                        return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
                    }else{
                        return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
                    }

                } else {
                    $registrationuser->email_id =  $email;
                }
            } else {
                $this->Flash->error(__('Invalid Email !'));
                if(!empty($invoicecompanyId)){
                    return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
                }else{
                    return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
                }
            }
        }
        $regex = "/^(?=.*[a-z])(?=.*\d).*$/";

        if (preg_match($regex, $password, $matches)) {
            if (strlen($password) < 6) {
                $this->Flash->error(__('Password non corrispondente e password ripetuta !'));
                if(!empty($invoicecompanyId)){
                    return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
                }else{
                    return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
                }
            } else {

                if ($password === $confirmpassword) {
                    $registrationuser->password = $password;
                } else {
                    $this->Flash->error(__('Password non corrispondente e password ripetuta !'));
                    if(!empty($invoicecompanyId)){
                        return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
                    }else{
                        return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
                    }
                }
            }
        } else {
            $this->Flash->error(__('Password Requirements not followed !'));
            if(!empty($invoicecompanyId)){
                return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
            }else{
                return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
            }
        }

        $registrationuser->validation_code =  $random;
        $registrationuser->validation_expirydate = (Time::now())->modify("+2 days");
        $dob = Time::createFromFormat(
            'd/m/Y',
            $dob,
            'Europe/Paris'
        );
        $diff = abs(strtotime(Time::now()->i18nFormat('yyyy-MM-dd')) - strtotime($dob->i18nFormat('yyyy-MM-dd')));

        $years = floor($diff / (365 * 60 * 60 * 24));
        if ($years < 16) {
            $this->Flash->error(__('Data di nascita non valida! Deve avere più di 16 anni !'));
            if(!empty($invoicecompanyId)){
                return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
            }else{
                return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
            }
        } else {
            $registrationuser->date_of_birth = $dob;
        }

        $this->Registrations->save($registrationuser);
       // $this->Flash->success(__('Posta di verifica della registrazione inviata !'));
        $protocol = Configure::read('Protocol');
        $domain = Configure::read('Domain');
        $port = Configure::read('Port');
        if($port == 80){
            $port = "";
        } else {
            $port = ":" . $port;
        }
        if(!empty($invoicecompanyId)){
       $link = ' <a class="btn btn-info" href="' . $protocol . '://' . $domain .  $port . '/registrations/validate?email=' . $registrationuser->email_id . '&key=' . $random . '&invoicecompanyId='.$invoicecompanyId.'"';
    }else{
       $link = '<a class="btn btn-info" href="' . $protocol . '://' . $domain .  $port . '/registrations/validate?email=' . $registrationuser->email_id . '&key=' . $random . '&role='.$companyId.'"';
    }
        $email = new Email();
        $emailSent = $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($registrationuser->email_id)
            ->setemailFormat('html')
            ->setSubject('Posta di verifica della registrazione inviata')
            ->send('Dear ' . $registrationuser->firstname . $registrationuser->lastname . ', <h3> Please click the below link to complete the registration proces</h3> ' . $link. '> Click here </a>  Thank You');
            if($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
            if(!empty($invoicecompanyId)){
                return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
            }else{
                return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
            }
        } else {
            $this->Flash->error(__('Error message'));
            if(!empty($invoicecompanyId)){
                return $this->redirect(['controller' => 'invoices', 'action' => 'create-invoice', 'companyId' => $invoicecompanyId]);
            }else{
                return $this->redirect(['controller' => 'companiesUser', 'action' => 'clients', $invoicecompanyId]);
            }
        }

    }

    public function clients($companyId = null)
    {
        $user_id = $this->Auth->user('id');
        $authuser = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User',
        'Usercompanies',
        'Designations' => function ($q) {
            return $q->where([
                'Designations.name is' => 'Administrator'
            ]);
        },
        ])->first();


        $this->loadModel('CompanyModules');
        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->toArray();




        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain([
            'User',
            'Usercompanies',
            'Designations' => function ($q) {
                return $q->where([
                    'Designations.name is' => 'Customer'
                ]);
            },
        ])->toArray();



        $this->set(compact('companymembers', 'companymodules','authuser', 'companyId'));
    }

    public function qrcodes(){
        $user_id = $this->Auth->user('id');

        $admincompanies = $this->CompaniesUser->find('all',[
            'conditions' => [
            'CompaniesUser.user_id' => $user_id
            ]
        ])->contain(['Usercompanies','Designations'])->toArray();

       // debug($admincompanies);exit;
       $this->set(compact('admincompanies'));


    }

    public function downloadqrcodes(){
        $user_id = $this->Auth->user('id');

        $type = $this->request->getQuery('type');

        $admincompanies = $this->CompaniesUser->find('all',[
            'conditions' => [
            'CompaniesUser.user_id' => $user_id,
            ]
        ])->contain(['Usercompanies', 'Designations'])->toArray();

        foreach ($admincompanies as $company) {
            if ($company->designation->name == 'Administrator') {
                $rand_code = rand(10, 100000);
                if ($type == 'Entrance') {
                    $company->usercompany->entrance_qr_code = $rand_code;
                } elseif ($type == 'Exit') {
                    $company->usercompany->exit_qr_code = $rand_code;
                }
                //debug($company->usercompany);exit;
                $company->usercompany->isDirty();
                $this->CompaniesUser->save($company);


                $protocol = Configure::read('Protocol');
                $domain = Configure::read('Domain');
                $port = Configure::read('Port');
                if ($port == 80) {
                    $port = "";
                } else {
                    $port = ":" . $port;
                }

                if ($type == 'Entrance') {
                    $result =  $protocol . '://' . $domain .  $port . '/companies-user/employeepunchin?Type=' . $type . '&emp_id=' . $user_id . '&company_id=' . $company->usercompany->id . '&code=' . $company->usercompany->entrance_qr_code;
                } elseif ($type == 'Exit') {
                    $result =  $protocol . '://' . $domain .  $port . '/companies-user/employeepunchout?Type=' . $type . '&emp_id=' . $user_id . '&company_id=' . $company->usercompany->id . '&code=' . $company->usercompany->exit_qr_code;
                }
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
                $CakePdf->template('admincompaniesqrcodes', 'default');
                $CakePdf->viewVars(['admincompanies' => $admincompanies, 'type' => $type, 'protocol' => $protocol, 'domain' => $domain, 'port' => $port, 'user_id' =>  $user_id]);
                // Get the PDF string returned
                $pdf = $CakePdf->output();
                $destinationFolder = WWW_ROOT . "assets" . DS . "qrcodes_company" . DS . "companyId_" .  $company->usercompany->id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder);
                }

                $file = "qrcode_" . $company->usercompany->id . ".pdf";
                $filename = $destinationFolder . DS . "qrcode_" . $company->usercompany->id . ".pdf";
                file_put_contents($filename, $pdf);
            }
        }



        if ($type == 'Entrance') {
            $company->entrance_qr_code_filename = $file;
            $company->entrance_qr_code_filepath = $destinationFolder;
            $company->usercompany->isDirty();
            $this->CompaniesUser->save($company);
            //Download File
            $file = $company->entrance_qr_code_filepath . DS . $company->entrance_qr_code_filename;
            $response =  $this->response->withFile($file, [
                'download' => true,
                'name' => $company->entrance_qr_code_filename,
            ]);

            return $response;
        } else {
            $company->exit_qr_code_filename = $file;
            $company->exit_qr_code_filepath = $destinationFolder;
            $company->usercompany->isDirty();
            $this->CompaniesUser->save($company);
            //Download File
            $file = $company->exit_qr_code_filepath . DS . $company->exit_qr_code_filename;
            $response =  $this->response->withFile($file, [
                'download' => true,
                'name' => $company->exit_qr_code_filename,
            ]);

            return $response;
        }
    }
    public function downloadexitqrcodes(){
        $user_id = $this->Auth->user('id');
        $admincompanies = $this->CompaniesUser->find('all',[
            'conditions' => [
            'CompaniesUser.user_id' => $user_id
            ]
        ])->contain(['Usercompanies'])->toArray();

    }


    public function companydashboard($companyId = null)
    {

        $this->loadModel('Usercompanies');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');
        $this->loadModel('Leaves');
        $this->loadModel('Projectfiles');
        $this->loadModel('CompaniesUser');
        $this->loadModel('Invoices');

        $user_id = $this->Auth->user('id');
        $authuser =  $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['Usercompanies',
        'Invoices.Clients',
        'Invoices.Projectobject.Taskgroups',
        'Invoices.invoiceitems'
        ])->first();
        $projectfiles = $this->Projectfiles->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $todayleaves = $this->Leaves->find('all', [
            'conditions' => [
                'status' => 'A',
                'DATE(fromdate) <=' => date('Y-m-d'),
                'DATE(todate) >=' => date('Y-m-d'),
                'isDeleted' => false,
                'company_id' => $companyId
            ]
        ])->toArray();
        $todaypendingleaves = $this->Leaves->find('all', [
            'conditions' => [
                'status' => 'P',
                'DATE(fromdate) <=' => date('Y-m-d'),
                'DATE(todate) >=' => date('Y-m-d'),
                'company_id' => $companyId
            ]
        ])->toArray();
        $todaynewleaves = $this->Leaves->find('all', [
            'conditions' => [
                'status' => 'N',
                'DATE(fromdate) <=' => date('Y-m-d'),
                'DATE(todate) >=' => date('Y-m-d'),
                'company_id' => $companyId
            ]
        ])->toArray();
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id ' => $companyId

            ]
        ])->contain('Designations')->toArray();
        $empids = array();
        foreach ($companymembers as $emp) {
            if($emp->designation->name != 'Customer'){
                array_push($empids, $emp->user_id);
            }

        }
        $totalemployees =  array_unique($empids);
        $todayleaveempIds = array();
        foreach ($todayleaves as $leave) {
            array_push($todayleaveempIds, $leave->user_id);
        }
        $workingemps = array();

        foreach ($companymembers as $emp) {
            if (!in_array($emp->memberId, $todayleaveempIds)) {
                array_push($workingemps, $emp->memberId);
            }
        }
        $resultworkingemps = array_unique($workingemps);

        $projectObjects = $this->ProjectObject->find(
            'all',
            [
                'conditions' => [
                    'isDeleted' => false,
                    'company_id' => $companyId
                ]
            ]

        )->order(['createDate' => 'DESC'])->toArray();

        $projectMembers = $this->ProjectMember->find('all')->contain(['User'])->toArray();
        $clients = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id ' => $companyId

            ]
        ])->contain([
            'User',
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();

        if (!empty($projectObjects)) {
            $allcompanyprojectIds  = array();
            foreach ($projectObjects as $projectObject) {
                array_push($allcompanyprojectIds, $projectObject->id);

            }
                $projecttasks = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'isDeleted' => false,
                        'type' => 'TS'
                    ]
                ])->toArray();

                $todotasks = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'isDeleted' => false,
                        'type' => 'TS',
                        'status' => 'T'
                    ]
                ])->toArray();

                $completedtasks = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'isDeleted' => false,
                        'type' => 'TS',
                        'status' => 'D'
                    ]
                ])->toArray();

                $inProgresstasks = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'isDeleted' => false,
                        'type' => 'TS',
                        'status' => 'I'
                    ]
                ])->toArray();

                $opentickets = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'type' => 'TC',
                        'status' => 'T',
                        'isDeleted' => false
                    ]
                ])->toArray();

        }else{
            $projecttasks = null;
            $todotasks = null;
            $completedtasks = null;
            $inProgresstasks = null;
            $opentickets = null;


        }

        $allusers = $this->User->find('all')->toArray();

        $this->set(compact('projectMembers','companyId', 'opentickets', 'projectfiles', 'todaynewleaves', 'todaypendingleaves', 'todotasks', 'inProgresstasks', 'completedtasks', 'projectObjects', 'clients', 'projecttasks', 'totalemployees', 'authuser', 'todayleaves', 'resultworkingemps', 'allusers', 'companymembers'));
    }

      /**Leads method */
    //This method show all Leads of Project
    public function leads()
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $leads = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.company_id' =>  $authuser->choosen_companyId
            ]
        ])->contain([
            'Designations',
            'ProjectMember',
            'ProjectMember.User',
            'ProjectMember.Projectobject',
            'ProjectMember.Projectobject.Projectmembers.User'
        ])->toArray();
       // debug($leads);exit;

        $this->set(compact('leads'));
    }

    public function employeeReports($companyId = null){
      $companymembers = $this->CompaniesUser->find('all',[
            'conditions'  => [
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['Usercompanies','User','Designations.Departments'])->toArray();


        $this->set(compact('companymembers', 'companyId'));

    }
    public function generatepdf(){
        $companyId = $this->request->getQuery('companyId');
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions'  => [
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['Usercompanies','User','Designations.Departments'])->toArray();

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
        $CakePdf->template('employeesreports', 'default');
        $CakePdf->viewVars(['companymembers' => $companymembers]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $response = $this->response;
        // Inject string content into response body
        $response = $response->withStringBody($pdf);
        $response = $response->withType('pdf');
        // Optionally force file download
        $response = $response->withDownload('employeesreports.pdf');
        return $response;

    }

    public function docready(){
        $user_id = $this->Auth->user('id');
        $this->loadModel('User');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id' => $user_id
            ]
        ])->first();

        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,

            ]
        ])->contain('Designations')->toArray();

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($companymembers));

    }

    public function updateuserstatus(){
        $companyId = $this->request->getData('companyId');
        $userId = $this->request->getData('userId');
        $status = $this->request->getData('status');
        $companymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId,
                'user_id' => $userId
            ]
        ])->first();
        $companymember->status = $status;
        $this->CompaniesUser->save($companymember);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($companymember));
    }
}
