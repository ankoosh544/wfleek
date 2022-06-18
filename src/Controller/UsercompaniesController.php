<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Cake\Dompdf\DomPdf;
use Cake\Core\Configure;
/* use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
 */

/**
 * Usercompanies Controller
 *
 * @property \App\Model\Table\UsercompaniesTable $Usercompanies
 *
 * @method \App\Model\Entity\Usercompany[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsercompaniesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

       $user_id =  $this->Auth->user('id');
      $usercompanies = $this->Usercompanies->find('all',[
           'conditions' => [
               'user_id' =>  $user_id
           ]
       ])->toArray();

        $this->set(compact('usercompanies'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Usercompany id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $company_id = $this->request->getQuery('company_id');
        $this->loadModel('User');
         //change to respective Company dashboard
         $user_id = $this->Auth->user('id');
         $user = $this->User->find('all',[
             'conditions' => [
                 'id in' => $user_id
             ]
         ])->first();
         $user->choosen_companyId = $company_id;
         $this->User->save($user);
         //


        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $user_id
            ]
        ])->toArray();

        if (!empty($authuserprojects)) {
            $all_projectids = array();
            foreach ($authuserprojects as $project) {
                array_push($all_projectids, $project->projectId);
            }
            $unique_projectids = array_unique($all_projectids);
        }

        $this->loadModel('Projecttypes');
        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $cities = array();
        //Cities Information
      /*   $this->loadModel('Cities');
        $fromDbCities = $this->Cities->find('all')->select(['name', 'province'])->order(['province' => 'ASC', 'name' => 'ASC'])->toArray();
        $cities = array();
        foreach ($fromDbCities as $city) {
            if (!array_key_exists($city->province, $cities)) {
                $cities[$city->province] = $city;
            }
        } */


        $this->loadModel('Groups');
        $this->loadModel('Groupmembers');
        $allmembers = $this->Groupmembers->find('all')->toArray();
        $authusergroups = $this->Groupmembers->find('all',[
            'conditions' => [
                'user_id' =>   $user_id
            ]
        ])->toArray();
        $authusergroupIds = array();
        foreach($authusergroups as $group){
            array_push($authusergroupIds, $group->group_id);
        }
        if (!empty($authusergroupIds)) {
            $allcompanygroups = $this->Groups->find('all', [
                'conditions' => [
                    'id in' => $authusergroupIds,
                    'company_id ' => $company_id,
                    'isDeleted' => false
                ]
            ])->contain([
                'Groupmembers' => function ($q) {
                    return $q->where([
                        'Groupmembers.isDeleted' => false
                    ]);
                },
                'Groupmembers.Users'
            ])->toArray();
        } else {
            $allcompanygroups = null;
        }


        $this->loadModel('CompaniesUser');
        $authuser = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id in ' => $user_id
            ]
        ])->contain(['Usercompanies', 'User'])->first();

        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $company_id
            ]
        ])->contain(['User', 'Usercompanies','Designations'])->toArray();



        if (!empty($unique_projectids)) {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $unique_projectids,
                    'isDeleted' => false,
                    'isFuturedProject' => false,
                    'company_id' =>  $company_id
                ]
            ])->contain([
                'Projecttypes',
                'Projectfiles',
                'Projecttasks' => function ($q) {
                    return $q->where([
                        'isDeleted' => false
                    ]);
                },
                'Projectmembers.User',
                'Projectmembers.Designations'
            ])->toArray();


        }else{
            $projectObjects = array();
            $managers = array();
            $allmanagers = array();
            $projecttasks = array();
            $projectMembers = array();
        }


        $this->set(compact('type','allmembers','allcompanygroups','companymembers','company_id','cities','projecttypes','authuser','projectObjects'));

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {


        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $name = $this->request->getData('company_name');
        $description = $this->request->getData('company_description');
        $businessname = $this->request->getData('businessname');
        $fiscal_code = $this->request->getData('fiscal_code');
        $vatcode = $this->request->getData('vatcode');
        $address = $this->request->getData('company_address');
        $country = $this->request->getData('country');
        $city = $this->request->getData('city');


        $province = $this->request->getData('province');
        $postalcode = $this->request->getData('postalcode');

        //check email exit in DB
        $email =  $this->request->getData('email');

        $users = $this->User->find('all')->toArray();
        $emails = array();
        foreach($users as $user){
            array_push($emails, $user->email);

        }
        if(in_array($email, $emails)){
            $this->Flash->error('Email Already Exist!');
            return $this->redirect(['controller' => 'user','action' => 'userprofile', $user_id]);

        }


        $phonenumber = $this->request->getData('phonenumber');
        $mobilenumber = $this->request->getData('mobilenumber');
        $bankname = $this->request->getData('bank_name');
        $iban = $this->request->getData('iban');
        $country = $this->request->getData('country');
        $bankprovince = $this->request->getData('bankprovince');
        $city_bankbranch = $this->request->getData('city_bankbranch');
        $weblink = $this->request->getData('weblink');
        $file = $this->request->getData()['file'];

        //creating company as User in User Table
        $companyasuser = $this->User->newEntity();
        $companyasuser->email = $email;
        $companyasuser->langId = 'it';
        $companyasuser->firstname =  $name;
        $companyasuser->username =  $name;
        $companyasuser->password =  'sk8143399890';
        $companyasuser->passwordExpirationDate = (Time::now())->modify("+10 years");
        $companyasuser->registrationDate = Time::now();
        $companyasuser->nickname =  $name;


        $companyasuser->address =  $address;


        $companyasuser->country = $country;


        $companyasuser->province = $province;

        $companyasuser->cap = $postalcode;
        $companyasuser->tel =$mobilenumber;
        $companyasuser->businessname = $businessname;
        $companyasuser->tax_code = $fiscal_code;
        $companyasuser->vat_code = $vatcode;


        $this->User->save($companyasuser);
        //$companyasuser->iban = $this->request->getData('iban');
        //$companyasuser->website = $this->request->getData('weblink');
        $companyasuser->profileFilename = $file['name'];
        $companyasuser->profileFilepath = "/assets/img/profiles/" .  $companyasuser->id;
        $destinationFolder = WWW_ROOT . "assets/img/profiles/" .  $companyasuser->id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        $this->User->save($companyasuser);
        $usercompany = $this->Usercompanies->newEntity();
        $usercompany->user_id = $user_id;
        $usercompany->company_user = $companyasuser->id;
        $usercompany->name =  $name;
        $usercompany->description =  $description;
        $usercompany->businessname = $businessname;
        $usercompany->address = $address;
        $usercompany->country = $country;
        $this->loadModel('Cities');
        $usercompany->city =  $city;
        $usercompany->province = $province;

        $citydata = $this->Cities->find('all',[
            'conditions' => [
                'province' => $province,
                'name' => $city
            ]
        ])->first();


            if ($citydata->postcodes == $postalcode) {
                $usercompany->postal_code = $postalcode;
            } else {
                $this->Flash->error('Postal Code is Invalid.');
                return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $user_id]);
            }


        $usercompany->email =$email;
        $usercompany->phone_number =  $phonenumber;
        $usercompany->mobile_number =$mobilenumber;

        $usercompany->bank_name = $bankname;
        $usercompany->state_bankbranch = $country;
        $usercompany->province_bankbranch =$bankprovince;
        $usercompany->city_bankbranch = $city_bankbranch;
        $usercompany->iban = $iban;
        $usercompany->website = $weblink;
        $usercompany->businessname = $businessname;
        $usercompany->fiscal_code = $fiscal_code;
        $usercompany->vat_code = $vatcode;
        $this->Usercompanies->save($usercompany);
        $usercompany->company_logoFilename = $file['name'];
        $usercompany->company_logoFilepath = "/assets/img/profiles/" .  $usercompany->id;
        $destinationFolder = WWW_ROOT . "assets/img/profiles/" .  $usercompany->id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        $this->Usercompanies->save($usercompany);


        $this->loadModel('CompaniesUser');
        $companymember = $this->CompaniesUser->newEntity();
        $companymember->company_id = $usercompany->id;
        $companymember->user_id =  $usercompany->user_id;
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


        $companymember->department_id = $department->id;
        $companymember->member_role = $designation->id;
        $this->CompaniesUser->save($companymember);
        $this->Flash->success('Azienda creata con successo.');
        return $this->redirect(['controller' => 'user','action' => 'userprofile', $user_id]);
    }



    public function updatecompanyinfo(){

        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $companyId = $this->request->getData('companyId');
        $companyprofile = null;
        $companyprofile = $this->request->getData('companyprofile');
        $updatecompanydata =  $this->Usercompanies->find('all', [
            'conditions' => [
                'id in' => $companyId
            ]
        ])->first();
        $name = $this->request->getData('company_name');
        $description = $this->request->getData('company_description');
        $address = $this->request->getData('company_address');
        $country = $this->request->getData('country');
        $city = $this->request->getData('city');
        $province = $this->request->getData('province');
        $postalcode = $this->request->getData('postalcode');
        $email =  $this->request->getData('email');
        $phonenumber = $this->request->getData('phonenumber');

        $mobilenumber = $this->request->getData('mobilenumber');
        $bankname = $this->request->getData('bank_name');
        $state_bankbranch = $this->request->getData('state_bankbranch');
        $bankprovince = $this->request->getData('bankprovince');
        $city_bankbranch = $this->request->getData('city_bankbranch');

        $iban = $this->request->getData('iban');
        $weblink = $this->request->getData('weblink');
        $fiscal_code = $this->request->getData('fiscal_code');
        $vat_code = $this->request->getData('vat_code');

        $businessname = $this->request->getData('businessname');
        $sdi_code = $this->request->getData('sdi_code');
        $pec_mail = $this->request->getData('pec_mail');
        $file = $this->request->getData('profilepic');

        $updatecompanydata->user_id = $user_id;
        $updatecompanydata->name =  $name;
        $updatecompanydata->description =  $description;
        $updatecompanydata->address = $address;
        $updatecompanydata->country = $country;
        $updatecompanydata->city =  $city;
        $updatecompanydata->province = $province;
        $updatecompanydata->postal_code = $postalcode;
        $updatecompanydata->email =$email;
        $updatecompanydata->phone_number =  $phonenumber;
        $updatecompanydata->mobile_number =$mobilenumber;
        $updatecompanydata->bank_name =$bankname;
        $updatecompanydata->state_bankbranch =$state_bankbranch;
        $updatecompanydata->province_bankbranch = $bankprovince;
        $updatecompanydata->city_bankbranch =$city_bankbranch;
        $updatecompanydata->iban = $iban;
        $updatecompanydata->website = $weblink;
        $updatecompanydata->fiscal_code = $fiscal_code;
        $updatecompanydata->vat_code = $vat_code;
        $updatecompanydata->businessname = $businessname;
        $updatecompanydata->sdi_code = $sdi_code;
        $updatecompanydata->pec_mail = $pec_mail;

        if (!empty($file)) {
            $updatecompanydata->company_logoFilename = $file['name'];
            $updatecompanydata->company_logoFilepath = "/assets/img/profiles/" .  $updatecompanydata->id;
            $destinationFolder = WWW_ROOT . "assets/img/profiles/" .  $updatecompanydata->id;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        }
        $this->Usercompanies->save($updatecompanydata);
        if ($companyprofile != null) {
            return $this->redirect(['controller' => 'usercompanies', 'action' => 'view', $companyId]);
        } else {
            return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $user_id]);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Usercompany id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usercompany = $this->Usercompanies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usercompany = $this->Usercompanies->patchEntity($usercompany, $this->request->getData());
            if ($this->Usercompanies->save($usercompany)) {
                $this->Flash->success(__('The usercompany has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usercompany could not be saved. Please, try again.'));
        }
        $users = $this->Usercompanies->Users->find('list', ['limit' => 200]);
        $this->set(compact('usercompany', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Usercompany id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usercompany = $this->Usercompanies->get($id);
        if ($this->Usercompanies->delete($usercompany)) {
            $this->Flash->success(__('The usercompany has been deleted.'));
        } else {
            $this->Flash->error(__('The usercompany could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function generateqrcode()
    {
        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');

        $user_id = $this->Auth->User('id');
        $rand_code = rand(10, 100000);
        $company = $this->Usercompanies->find('all', [
            'conditions' => [
                'id in' => $companyId
            ]
        ])->first();
          if($type =='Entrance'){
            $company->entrance_qr_code = $rand_code;
          }elseif($type == 'Exit'){
            $company->exit_qr_code = $rand_code;

          }

        $this->Usercompanies->save($company);

        $protocol = Configure::read('Protocol');
        $domain = Configure::read('Domain');
        $port = Configure::read('Port');
        if($port == 80){
            $port = "";
        } else {
            $port = ":" . $port;
        }

        if($type =='Entrance'){
        $result =  $protocol.'://'. $domain .  $port. '/companies-user/employeepunchin?Type='.$type.'&emp_id='.$user_id.'&company_id='.$companyId.'&code='.$company->entrance_qr_code;
    }elseif($type == 'Exit'){
        $result =  $protocol.'://'. $domain .  $port. '/companies-user/employeepunchout?Type='.$type.'&emp_id='.$user_id.'&company_id='.$companyId.'&code='.$company->exit_qr_code;
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
        $CakePdf->template('qrcode', 'default');
        $CakePdf->viewVars(['result' => $result, 'type' => $type]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $destinationFolder = WWW_ROOT . "assets" . DS . "qrcodes_company" . DS . "companyId_" .  $companyId;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder);
        }

        $file = "qrcode_" . $companyId . ".pdf";
        $filename = $destinationFolder . DS . "qrcode_" . $companyId . ".pdf";
        file_put_contents($filename, $pdf);
        if ($type == 'Entrance') {
            $company->entrance_qr_code_filename = $file;
            $company->entrance_qr_code_filepath = $destinationFolder;
            $this->Usercompanies->save($company);
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
            $this->Usercompanies->save($company);
            //Download File
            $file = $company->exit_qr_code_filepath . DS . $company->exit_qr_code_filename;
            $response =  $this->response->withFile($file, [
                'download' => true,
                'name' => $company->exit_qr_code_filename,
            ]);

            return $response;
        }

    }
}
