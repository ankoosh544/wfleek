<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Core\Configure;

/**
 * Registrations Controller
 *
 * @property \App\Model\Table\RegistrationsTable $Registrations
 *
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RegistrationsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['register','validate','resendverification','resendemail','sendverificationlink','saveregistrationuser','registerCompany','verifymail']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $registrations = $this->paginate($this->Registrations);

        $this->set(compact('registrations'));
    }

    /**
     * View method
     *
     * @param string|null $id Registration id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => []
        ]);

        $this->set('registration', $registration);
    }

    //setup register user form template
    public function register()
    {
        $this->loadModel('User');
    }

    //setup register user as company form template
    public function registerCompany(){

    }

    // setup to send a link to verify mail template
    public function verifymail(){
    }

    public function validate()
    {
        $invoicecompanyId = $this->request->getQuery('invoicecompanyId');
        $role = $this->request->getQuery('role');
        $code =  $this->request->getQuery('key');
        $email =  $this->request->getQuery('email');
        $this->loadModel('Registrations');
        $verifyuser = $this->Registrations->find('all', [
            'conditions' => [
                'email_id' => $email
            ]
        ])->first();
        if ($verifyuser != null) {
            if (($verifyuser->validation_expirydate->i18nFormat('yyyy-MM-dd')) < (Time::now()->i18nFormat('yyyy-MM-dd'))) {
                $this->Flash->success(__('Validation code is expired !'));
                return $this->redirect([
                    'controller' => 'registrations',
                    'action' => 'resendverification',
                    $email
                ]);
            } else {

                $this->loadModel('User');
                $registrationuser = $this->User->newEntity();
                $registrationuser->firstname =  $verifyuser->firstname;
                $registrationuser->lastname =  $verifyuser->lastname;
                $registrationuser->username =   $verifyuser->email_id;
                $registrationuser->email =  $verifyuser->email_id;
                $registrationuser->password = $verifyuser->password;
                $registrationuser->gender = $verifyuser->gender;
                $registrationuser->businessname = $verifyuser->businessname;
                if($verifyuser->isCompany == true){
                $registrationuser->isCompany = true;
                }
                if ($verifyuser->tax_code != null) {
                    $registrationuser->tax_code = $verifyuser->tax_code;
                }
                if ($verifyuser->vat_code != null) {
                    $registrationuser->vat_code = $verifyuser->vat_code;
                }
                if ($verifyuser->address != null) {
                    $registrationuser->address = $verifyuser->address;
                }
                if ($verifyuser->city != null) {
                    $registrationuser->city = $verifyuser->city;
                }
                if ($verifyuser->country != null) {
                    $registrationuser->city = $verifyuser->country;
                }
                $registrationuser->langId = 'it';
                $registrationuser->nickname =  $verifyuser->email_id;
                $registrationuser->passwordExpirationDate = (Time::now())->modify("+10 years");
                $registrationuser->registrationDate = Time::now();
                $registrationuser->birthday =  $verifyuser->date_of_birth;
                $registrationuser = $this->User->save($registrationuser);

                //add Bank Record
                $this->loadModel('Userbanks');
                $userbank = $this->Userbanks->newEntity();
                $userbank->user_id = $registrationuser->id;
                $this->Userbanks->save($userbank);

                if(!empty($role)){
                    $this->loadModel('CompaniesUser');
                    $this->loadModel('Departments');
                    $companydepartments = $this->Departments->find('all',[
                        'conditions' => [
                            'company_id is' => $role
                        ]
                    ])->contain(['Designations'])->toArray();

                    $designationId = 0;
                    $departmentId = 0;
                    foreach ($companydepartments as $department) {
                        foreach ($department->designations as $designation) {
                            if ($designation->name == 'Customer') {
                                $designationId = $designationId + $designation->id;
                                $departmentId = $departmentId + $designation->department_id;
                                break;
                            }
                        }
                    }

                    $newcustomer = $this->CompaniesUser->newEntity();
                    $newcustomer->company_id = $role;
                    $newcustomer->user_id = $registrationuser->id;
                    $newcustomer->department_id = $departmentId;
                    $newcustomer->member_role = $designationId;
                    $this->CompaniesUser->save($newcustomer);
                    return $this->redirect([
                        'controller' => 'companiesUser',
                        'action' => 'clients',
                        $role
                    ]);
                }elseif(!empty($invoicecompanyId)){
                    $this->loadModel('CompaniesUser');
                    $this->loadModel('Departments');
                    $companydepartments = $this->Departments->find('all',[
                        'conditions' => [
                            'company_id is' => $invoicecompanyId
                        ]
                    ])->contain(['Designations'])->toArray();
                    $departmentId =0;
                   $designationId =0;
                    foreach($companydepartments as $department){
                            foreach($department->designations as $designation){
                                if($designation->name == 'Customer'){
                                    $designationId = $designationId +$designation->id;
                                    $departmentId = $departmentId +$designation->department_id;
                                    break;
                                }

                            }
                    }

                    $newcustomer = $this->CompaniesUser->newEntity();
                    $newcustomer->company_id = $invoicecompanyId;
                    $newcustomer->user_id = $registrationuser->id;
                    $newcustomer->department_id = $departmentId;
                    $newcustomer->member_role = $designationId;
                    $this->CompaniesUser->save($newcustomer);
                    return $this->redirect([
                        'controller' => 'invoices',
                        'action' => 'create-invoice',
                        'companyId' => $invoicecompanyId
                    ]);

                }




                $this->loadModel('Usercompanies');
                if($verifyuser->isCompany == true){
                    $usercompany = $this->Usercompanies->newEntity();
                    $usercompany->user_id = null;
                    $usercompany->company_user = $registrationuser->id;
                    $usercompany->name =  $registrationuser->firstname;
                    //$usercompany->description =  $description;
                    $usercompany->address = $registrationuser->address;
                    $usercompany->country = $registrationuser->country;
                    $usercompany->city =  $registrationuser->city;
                    $usercompany->email =$registrationuser->email;
                    $usercompany->businessname = $registrationuser->businessname;
                    //$usercompany->phone_number =  $phonenumber;
                    //$usercompany->mobile_number =$mobilenumber;
                    //$usercompany->iban = $iban;
                   // $usercompany->website = $weblink;
                    $this->Usercompanies->save($usercompany);

                    //add Department
                    $this->loadModel('Departments');
                    $department = $this->Departments->newEntity();
                    $department->company_id = $usercompany->id;
                    $department->name = 'Web Developer';
                    $this->Departments->save($department);

                    // add Designation
                    $this->loadModel('Designations');
                    $designation = $this->Designations->newEntity();
                    $designation->department_id = $department->id;
                    $designation->name = 'Administrator';
                    $this->Designations->save($designation);

                    //add member role in CompaniesUser
                    $this->loadModel('CompaniesUser');
                    $companymember = $this->CompaniesUser->newEntity();
                    $companymember->company_id = $usercompany->id;
                    $companymember->user_id = $registrationuser->id;
                    $companymember->department_id = $department->id;
                    $companymember->member_role = $designation->id;

                    $this->CompaniesUser->save($companymember);
                }







                $this->Registrations->delete($verifyuser);

                $this->Flash->success(__('Il tuo account è stato verificato correttamente. Ora puoi effettuare il login!'));

                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'login'
                ]);
            }
        }


    }
    public function resendverification($email = null)
    {

        $this->loadModel('Registrations');
        $verifyuser = $this->Registrations->find('all', [
            'conditions' => [
                'email_id' => $email
            ]
        ])->first();
        $this->set(compact('verifyuser'));
    }



    public function resendemail($email = null)
    {

        $this->loadModel('Registrations');
        $random = rand(100000, 999999);
        $verifyuser = $this->Registrations->find('all', [
            'conditions' => [
                'email_id' => $email
            ]
        ])->first();

        $verifyuser->validation_code = $random;
        $verifyuser->validation_expirydate = (Time::now())->modify("+2 days");


        $this->Registrations->save($verifyuser);

        // $msg = 'Registration Verification mail';
        $protocol = Configure::read('Protocol');
        $domain = Configure::read('Domain');
        $port = Configure::read('Port');
        if($port == 80){
            $port = "";
        } else {
            $port = ":" . $port;
        }
        $email = new Email();
        $emailSent =   $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
        ->setTo($verifyuser->email_id)
            ->setemailFormat('html')
            ->setSubject('Registration Verification mail')
        ->send('Dear ' . $verifyuser->firstname . $verifyuser->lastname . '<h3> Please click the below link to complete the registration proces</h3> ' . '<a href="' . $protocol . '://' . $domain .  $port . '/registrations/validate?email=' . $verifyuser->email_id . '&key=' . $random . ' "> Click here </a>  Thank You');

        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Failed to Send Email'));
        }
        return $this->redirect(['controller' => 'user', 'action' => 'login', $random]);
    }

    public function saveregistrationuser()
    {

        $random = rand(100000, 999999);
        $this->loadModel('Registrations');
        $companyinfo = null;
        $companyinfo = $this->request->getData('companyinfo');
        $registrationuser = $this->Registrations->newEntity();
        if ($companyinfo != null) {
            $registrationuser->address = $this->request->getData('address');
            $registrationuser->city = $this->request->getData('city');
            $registrationuser->country = $this->request->getData('country');
            $registrationuser->isCompany = true;
            $registrationuser->businessname =  $this->request->getData('businessname');
            $registrationuser->tax_code =  $this->request->getData('taxcode');
            $registrationuser->vat_code =  $this->request->getData('vatcode');
        }
        $firstname = $this->request->getData('firstname');
        $lastname = $this->request->getData('lastname');
        $gender = $this->request->getData('gender');
        $email = $this->request->getData('email');
        $password = $this->request->getData('password');
        $repeatpassword = $this->request->getData('repeatpassword');
        $dob = $this->request->getData('dob');

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
                    return $this->redirect(['controller' => 'registrations', 'action' => 'register']);
                } else {
                    $registrationuser->email_id =  $email;
                }
            } else {
                $this->Flash->error(__('Invalid Email !'));
            return $this->redirect(['controller' => 'registrations', 'action' => 'register']);
            }
        }
        $regex = "/^(?=.*[a-z])(?=.*\d).*$/";

        if (preg_match($regex, $password, $matches)) {

            if (strlen($password) < 6) {
                $this->Flash->error(__('Password non corrispondente e password ripetuta !'));
                return $this->redirect(['controller' => 'registrations', 'action' => 'register']);
            } else {

                if ($password === $repeatpassword) {
                    $registrationuser->password = $password;
                } else {
                    $this->Flash->error(__('Password non corrispondente e password ripetuta !'));
                    return $this->redirect(['controller' => 'registrations', 'action' => 'register']);
                }
            }
        } else {
            $this->Flash->error(__('Password Requirements not followed !'));
            return $this->redirect(['controller' => 'registrations', 'action' => 'register']);
        }

        $registrationuser->gender = $gender;
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
            return $this->redirect(['controller' => 'registrations', 'action' => 'register']);
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
        $email = new Email();
        $emailSent = $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($registrationuser->email_id)
            ->setemailFormat('html')
            ->setSubject('Posta di verifica della registrazione inviata')
            ->send('Dear ' . $registrationuser->firstname . $registrationuser->lastname . ', <h3> Please click the below link to complete the registration proces</h3> ' . '<a class="btn btn-info" href="' . $protocol . '://' . $domain .  $port . '/registrations/validate?email=' . $registrationuser->email_id . '&key=' . $random . ' "> Click here </a>  Thank You');
        if($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
            return $this->redirect(['controller' => 'user', 'action' => 'login']);
        } else {
            $this->Flash->error(__('Error message'));
        }

        return $this->redirect(['controller' => 'registrations', 'action' => 'register']);

    }


    public function sendverificationlink(){
        $random = rand(100000, 999999);
        $email = $this->request->getData('email');
        $this->loadModel('Registrations');
        $this->loadModel('User');
       $registered =  $this->Registrations->find('all',[
            'conditions' => [
                'email_id' => $email
            ]
        ])->first();
        if (!empty($registered)) {
            $protocol = Configure::read('Protocol');
            $domain = Configure::read('Domain');
            $port = Configure::read('Port');
            if ($port == 80) {
                $port = "";
            } else {
                $port = ":" . $port;
            }
            $email = new Email();
            $emailSent = $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($registered->email_id)
                ->setemailFormat('html')
                ->setSubject('Registration Verification mail')
                ->send('Dear ' . $registered->firstname . $registered->lastname . ', <h3> Please click the below link to complete the registration proces</h3> ' . '<a class="btn btn-info" href="' . $protocol . '://' . $domain .  $port . '/registrations/validate?email=' . $registered->email_id . '&key=' . $random . ' "> Click here </a>  Thank You');
            if ($emailSent) {
                $this->Flash->success(__('E-mail sent.'));
                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'login'
                ]);
            } else {
                $this->Flash->error(__('Error message'));
                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'login'
                ]);
            }
        }else{
            $user = $this->User->find('all',[
                'conditions' => [
                    'email' => $email
                ]
            ])->first();
            if(!empty($user)){
                $this->Flash->error(__('Your Email already Verified Please Login !!'));
                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'login'
                ]);

            }else{
            $this->Flash->error(__('No Account is found !!'));
            return $this->redirect([
                'controller' => 'user',
                'action' => 'login'
            ]);
        }

        }

    }




    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registration = $this->Registrations->newEntity();
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());
            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('The registration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registration could not be saved. Please, try again.'));
        }
        $this->set(compact('registration'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Registration id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());
            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('The registration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registration could not be saved. Please, try again.'));
        }
        $this->set(compact('registration'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Registration id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registration = $this->Registrations->get($id);
        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('The registration has been deleted.'));
        } else {
            $this->Flash->error(__('The registration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
