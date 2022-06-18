<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Core\Configure;
/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController
{
    public function isAuthorized($user)
    {
        return true;
    }
    public function beforeFilter(Event $event)
    {

        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'appLogin', 'appresetpassword', 'forgotPassword', 'logout', 'recoverPassword', 'resetpassword', 'setnewpassword', 'resendpasswordresetlink', 'resendforpassword', 'saveresetpassword', 'checkmailid', 'logincontinue', 'verification', 'verifysecuritycode', 'resendemail', 'invalidsecuritycode', 'generateresend', 'sendsecuritycode', 'dashboard', 'acceptancecontract', 'versionAcceptancy']);
    }




    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user = $this->paginate($this->User);
        $this->set(compact('user'));
    }

    /** user Profile */
    public function userprofile($id)
    {
        $this->viewBuilder()->setLayout('new_default');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompaniesUser');
        $this->loadModel('Usercompanies');
        $this->loadModel('Cities');
        $this->loadModel('Projecttypes');
        $this->loadModel('ProjectMember');
        $this->loadModel('Workinghours');


        $projecttypes = $this->Projecttypes->find('all')->toArray();

        $fromDbCities = $this->Cities->find('all')->select(['name', 'province'])->order(['province' => 'ASC', 'name' => 'ASC'])->toArray();

        $cities = array();
        foreach ($fromDbCities as $city) {
            if (!array_key_exists($city->province, $cities)) {
                $cities[$city->province] = $city;
            }
        }

        $defalutcities = $this->Cities->find('all', [
            'conditions' => [
                'province' => 'Agrigento'
            ]
        ])->toArray();


        $user_id = $this->Auth->User('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'User.id in' => $user_id
            ]
        ])->contain(['Userbanks'])->first();

        $authuser->choosen_companyId = null;
        $this->User->save($authuser);


        $authusercompanies =  $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['Usercompanies.Companyuser', 'Usercompanies.Users', 'User'])->toArray();
        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $user_id
            ]
        ])->toArray();
        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }
        $unique_projectids = array_unique($all_projectids);
        if (!empty($unique_projectids)) {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $unique_projectids,
                    'isDeleted' => false,
                    'visibility' => 'I',
                    'isPersonal' => true,
                ]
            ])->contain([
                'Projecttypes',
                'Projectfiles',
                'Projecttasks' => function ($q) {
                    return $q->where([
                        'isDeleted' => false
                    ]);
                },
                'Projectmembers.User'
            ])->toArray();
        } else {
            $projectObjects = null;
        }
        $admin = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Administrator'
                ]);
            },
        ])->first();
        $this->set(compact('defalutcities', 'projecttypes', 'cities', 'authusercompanies', 'admin', 'projectObjects', 'authuser'));
    }


    //update profilepic
    //This is mothod is used to update only profile pic of user
    public function updateProfilepic()
    {
        $this->loadModel('User');
        $file = $this->request->getData('file');
        $id = $this->Auth->user('id');
        $updateUser = $this->User->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $file = WWW_ROOT . str_replace('/', '\\', $updateUser->profileFilepath . DS . $updateUser->profileFilename);
        $file = $this->request->getData('file');
        $updateUser->profileFilename = $file['name'];
        $updateUser->profileFilepath = "/assets/img/profiles/" .  $updateUser->id;
        $destinationFolder = WWW_ROOT . "assets/img/profiles/" .  $updateUser->id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        $updatedUser = $this->User->save($updateUser);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($updatedUser));
    }

    //updateprofile information
    //This method is used to update user data
    public function updateprofile()
    {
        $authuser = $this->request->getData('authuser');
        $firstname = $this->request->getData('firstname');
        $lastname = $this->request->getData('lastname');
        $dob = $this->request->getData('dob');
        $dob = Time::createFromFormat(
            'd/m/Y',
            $dob,
            'Europe/Paris'
        );
        $email = $this->request->getData('email');
        $number = $this->request->getData('tel');
        $taxcode = $this->request->getData('tax_code');
        $vat_code = $this->request->getData('vat_code');
        $tel = $this->request->getData('tel');
        $file = $this->request->getData('profilepic');
        $update = $this->User->find('all', [
            'conditions' => [
                'id in' => $authuser
            ]
        ])->first();
        $update->firstname = $firstname;
        $update->lastname = $lastname;
        $update->birthday = $dob;
        $update->email = $email;
        $update->tel = $number;
        if (!empty($file)) {
            $update->profileFilename = $file['name'];
            $update->profileFilepath = "/assets/img/profiles/" .  $update->id;
            $destinationFolder = WWW_ROOT . "assets/img/profiles/" .  $update->id;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        }

        $this->User->save($update);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($update));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    //User view template
    public function view($id = null)
    {
        $this->loadModel('User');
        $this->loadModel('Projecttasks');
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');

        $user_id = $this->Auth->User('id');

        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $userData = $this->User->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $projecttasks = $this->Projecttasks->find('all')->toArray();
        $userview =  $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id in' => $id
            ]
        ])->contain(['Usercompanies', 'User'])->first();

        $viewusercompanies =  $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id in' => $id
            ]
        ])->contain(['Usercompanies'])->toArray();


        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $id
            ]
        ])->toArray();

        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }

        $projectMembers = $this->ProjectMember->find('all')->contain(['User'])->toArray();
        $managers = $this->ProjectMember->find('all')->contain([
            'User',
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Project Manager'
                ]);
            },
        ])->toArray();


        $unique_projectids = array_unique($all_projectids);

        if (!empty($unique_projectids)) {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $unique_projectids,
                    'isDeleted' => false,
                    'isFuturedProject' => false,
                    'isPersonal' => true,
                ]
            ])->contain([
                'Projecttypes',
                'Projectfiles',
                'Projecttasks' => function ($q) {
                    return $q->where([
                        'isDeleted' => false
                    ]);
                },
                'Projectmembers.Designations',
                'Projectmembers.User'
            ])->toArray();
        } else {
            $projectObjects = null;
        }

        $this->set(compact('projectObjects', 'managers', 'userData', 'authuser', 'userview', 'viewusercompanies', 'projecttasks', 'projectMembers'));
    }



    //all users info
    //This method is used to show all user based on authuserchoosed company  filter
    public function users($companyId = null)
    {

        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompaniesUser');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $projectObjects = $this->ProjectObject->find('all');
        $users = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' =>  $authuser->choosen_companyId
            ]
        ])->contain(['User'])->toArray();


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
        $this->set(compact('users', 'companymembers', 'projectObjects', 'result', 'companyId'));
    }


    //updateuser info
    //This method is used to update employee data in user table
    public function updateuser()
    {
        $userid = $this->request->getData('userid');
        $employee = $this->request->getData('employee');
        $user = $this->User->find('all', [
            'conditions' => [
                'id in ' => $userid
            ]
        ])->first();
        $user->firstname = $this->request->getData('firstname');
        $user->lastname = $this->request->getData('lastname');
        $user->address = $this->request->getData('address');
        $user->gender = $this->request->getData('gender');
        $user->email = $this->request->getData('email');
        $user->password = $this->request->getData('password');
        $passwordexpirydate = $this->request->getData('passwordExpitydate');
        $passwordexpirydate = Time::createFromFormat(
            'd/m/Y',
            $passwordexpirydate,
            'Europe/Rome'
        );
        $user->passwordExpirationDate = $passwordexpirydate;
        $user->tel = $this->request->getData('tel');
        //$user->role = $this->request->getData('role');
        $this->User->save($user);
        if ($employee != null) {
            return $this->redirect(['action' => 'employees']);
        } else {
            return $this->redirect(['action' => 'users']);
        }
    }



    /**Knowledgebase */
    public function knowledgebase()
    {
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
    }


    //update userprofile info
    public function updateuserprofile()
    {
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $authuser->firstname = $this->request->getData('firstname');
        $authuser->lastname = $this->request->getData('lastname');
        $taxcode = $this->request->getData('tax_code');
        $vat_code = $this->request->getData('vat_code');
        $tel = $this->request->getData('tel');
        $file = $this->request->getData('profilepic');
        $dob = $this->request->getData('dob');
        $dob = Time::createFromFormat(
            'd/m/Y',
            $dob,
            'Europe/Rome'
        );
        $authuser->birthday = $dob;
        $authuser->gender = $this->request->getData('gender');
        $authuser->address = $this->request->getData('address');
        $authuser->state = $this->request->getData('state');
        $authuser->country = $this->request->getData('country');
        $authuser->cap = $this->request->getData('cap');
        $authuser->tel = $this->request->getData('tel');
        $authuser->tax_code = $taxcode;
        if (!empty($file)) {
            $authuser->profileFilename = $file['name'];
            $authuser->profileFilepath = "/assets/img/profiles/" .  $authuser->id;
            $destinationFolder = WWW_ROOT . "assets/img/profiles/" .  $authuser->id;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        }
        $this->User->save($authuser);
        return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $user_id]);
    }



    //employees method, Which is used to show all employees  based on company filter
    public function employees($companyId = null)
    {
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectMember');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $employees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name !=' => 'Customer'
                ]);
            },
        ])->toArray();
        $employeeIds = array();
        foreach ($employees as $item) {
            array_push($employeeIds, $item->user_id);
        }
        $emp_uniqueids = array_unique($employeeIds);
        $allUsers = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false,
                'id in' => $emp_uniqueids
            ]
        ])->toArray();
        $this->set(compact('employeeIds', 'allUsers', 'employees'));
    }




    /**saveresetpassword */
    public function saveresetpassword()
    {
        $this->loadModel('User');
        $resetcode = $this->request->getData('securitycode');
        $password = $this->request->getData('password');
        $confirmpassword = $this->request->getData('confirmpassword');


        $userData = $this->User->find('all', [
            'conditions' => [
                'resetpasswordcode' => intval($resetcode)
            ]
        ])->first();


        if (!empty($userData)) {
            if (strtotime($userData->resetpassword_expirydate) < strtotime(Time::now())) {
                $this->Flash->error(__('Security Code is  Expired!'));
                return $this->redirect(['action' => 'generateresend', $userData->id]);
            } else {
                if ($password != $confirmpassword) {
                    $this->Flash->error(__('Password and ConfirmPassword Incorrect!'));
                    return $this->redirect(['action' => 'login']);
                } else {
                    $userData->password = $password;
                    $result = $this->User->save($userData);
                    $this->Flash->success(__('Successfully Password is changed!'));
                    return $this->redirect(['action' => 'login']);
                }
            }
        } else {
            $this->Flash->error(__('Security Code is Wrong!'));
            return $this->redirect(['action' => 'login']);
        }
    }


    /** Link for Password Reset  */
    public function resendforpassword($user_id = null)
    {
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $random = rand(100000, 999999);
        $authuser->resetpasswordcode = $random;
        $authuser->resetpassword_expirydate = (Time::now())->modify("+2 days");
        $this->User->save($authuser);
        $firstname = $authuser->firstname;
        $lastname = $authuser->lastname;
        $protocol = Configure::read('Protocol');
        $domain = Configure::read('Domain');
        $port = Configure::read('Port');
        if ($port == 80) {
            $port = "";
        } else {
            $port = ":" . $port;
        }
        $link = $protocol . '://' . $domain .  $port . '/user/setnewpassword?userid=' . $authuser->id . '&securitycode=' . $random;
        $email = new Email();
        $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($authuser->email)
            ->setemailFormat('html')
            ->setSubject(' Link for Password Reset')
            ->setViewVars([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'link' => $link
            ])
            ->setTemplate('resetpassword')
            ->send();

        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
        return $this->redirect(['action' => 'login']);
    }


    // Generateresend password
    public function generateresend($user_id = null)
    {
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $this->set(compact('authuser'));
    }

    // forgotpassword
    public function forgotPassword()
    {
    }

    //appresetpassword

    public function appresetpassword()
    {
        $useremail = $this->request->getQuery('useremail');
        debug($useremail);
        exit;

        $response = $this->response;
        $response = $response->withType('application/json')->withStringBody(json_encode($useremail));
        return $response;
    }

    //resetpassword
    public function resetpassword()
    {
        $this->loadModel('User');
        $random = rand(100000, 999999);
        $useremail = $this->request->getData('email');

        if (empty($useremail)) {
            $this->Flash->error(__('Il campo e-mail è obbligatorio.'));
            return $this->redirect([
                'action' => 'forgotPassword'
            ]);
        }
        $authemailuser = null;
        $authemailuser =  $this->User->find('all', [
            'conditions' => [
                'email' => $useremail
            ]
        ])->first();
        if ($authemailuser == null) {
            $this->Flash->success(__('E-mail non valida.'));
        } else {
            $authemailuser->resetpasswordcode = $random;
            $authemailuser->resetpassword_expirydate = (Time::now())->modify("+2 days");
            $this->User->save($authemailuser);
            $firstname = $authemailuser->firstname;
            $lastname = $authemailuser->lastname;
            $protocol = Configure::read('Protocol');
            $domain = Configure::read('Domain');
            $port = Configure::read('Port');
            if ($port == 80) {
                $port = "";
            } else {
                $port = ":" . $port;
            }

            $link = $protocol . '://' . $domain .  $port . "/user/setnewpassword?userid=" . $authemailuser->id . "&securitycode=" . $random;
            $this->Flash->success(__('Request accepted succesfully!'));
            $email = new Email();
            $emailSent = $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($authemailuser->email)
                ->setEmailFormat('html')
                ->setSubject(__('Codice per il reset della password.'))
                ->setViewVars([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'link' => $link
                ])
                ->setTemplate('resetpassword')
                ->send();
        }
        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
        return $this->redirect(['action' => 'login']);
    }

    //setnewpassword
    public function setnewpassword()
    {
        $this->loadModel('User');
        $user_id = $this->request->getQuery('userid');
        $authemail = $this->User->find('all', [
            'conditions' => [
                'id in' => intval($user_id)
            ]
        ])->first();
        $securitycode = $this->request->getQuery('securitycode');
        $email = new Email();
        $firstname = $authemail->firstname;
        $lastname = $authemail->lastname;
        $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($authemail->email)
            ->setemailFormat('html')
            ->setSubject(__('OTP per il ripristino della password.'))
            ->setViewVars([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'otpcode' =>  $securitycode,
            ])
            ->setTemplate('otpcode')
            ->send();
        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
    }

    /**
     * Profile method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->User->newEntity();
        if ($this->request->is('post')) {
            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $eCourse = $this->User->ECourse->find('list', ['limit' => 200]);
        $organization = $this->User->Organization->find('list', ['limit' => 200]);
        $role = $this->User->Role->find('list', ['limit' => 200]);
        $subscription = $this->User->Subscription->find('list', ['limit' => 200]);
        $this->set(compact('user', 'eCourse', 'organization', 'role', 'subscription'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    /**Change profile Photo */
    public function changeProfilePhoto()
    {
        //Check if request is post
        if ($this->request->is('post')) {
            //Retrieve photo file from post
            $file = $this->request->getData('profile_photo');

            //Check if a file was really submitted
            if (empty($file)) {
                $message = 'required_photo_file';
                return $this->redirect(['action' => 'profile', 'update_status' => $message]);
            }
            //Check if the file is an image
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo !== false) {
                //Check if the image is jpg
                if ($imageInfo['mime'] !== "image/jpeg") {
                    $message = 'uploaded_photo_type_not_correct';
                    return $this->redirect(['action' => 'profile', 'update_status' => $message]);
                }
                //Check if the file size is below the max file size for profile photo
                $this->loadModel('Config');
                $profilePhotoMaxSize = $this->Config->find('all', ['conditions' => ['itemKey' => 'max_profile_photo_size']])->first();
                if ($file['size'] > $profilePhotoMaxSize->itemValue) {
                    $message = 'uploaded_photo_size_error';
                    return $this->redirect(['action' => 'profile', 'update_status' => $message]);
                }
                $this->loadComponent('FileUtility');
                $targetFilePath = WWW_ROOT . 'img' . DS . 'profilephotoimages' . DS . 'user-' . $this->Auth->user('id') . '.jpg';
                if ($this->FileUtility->uploadFile($targetFilePath, $file)) {
                    $message = 'tmp_profile_photo_uploaded_successfully';
                    $image = imagecreatefromjpeg($targetFilePath);
                    $w = getimagesize($targetFilePath)[0];
                    $h = getimagesize($targetFilePath)[1];
                    if ($w > $h) {
                        $file = imagecrop($image, ['y' => 0, 'x' => ($w / 2) - ($h / 2), 'width' => min($h, $w), 'height' => min($h, $w)]);
                    } else if ($h > $w) {
                        $file = imagecrop($image, ['y' => ($h / 2) - ($w / 2), 'x' => 0, 'width' => min($h, $w), 'height' => min($h, $w)]);
                    }

                    if (imagejpeg($file, $targetFilePath)) {
                        $message .= ' --- profile_photo_uploaded_successfully';
                    } else {
                        $message .= ' --- errors_when_uploading_profile_photo';
                    }
                } else {
                    $message = 'tmp_errors_when_uploading_profile_photo';
                }
                return $this->redirect(['action' => 'profile', 'update_status' => $message]);
            } else {
                $message = 'uploaded_photo_is_not_an_image';
                return $this->redirect(['action' => 'profile', 'update_status' => $message]);
            }
        } else {
            $message = 'forbidden';
            return $this->redirect(['action' => 'profile', 'update_status' => $message]);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->User->get($id);
        if ($this->User->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    // deleteuser, This method is used to delete user
    public function deleteuser()
    {
        $this->loadModel('User');
        $this->loadModel('CompaniesUser');
        $id = $this->request->getData('userid');
        $companyId = $this->request->getData('companyId');

        $user_companyId = $this->request->getData('user_companyId');
        debug($user_companyId);

        $user = $this->CompaniesUser->find('all', [
            'conditions' => [
                'user_id' => $id,
                'company_id' => $companyId
            ]
        ])->first();
        debug($user_companyId);
        exit;
        $user->isDeleted = true;
        $this->CompaniesUser->save($user);
        if (!empty($user_companyId)) {
            return $this->redirect(['controller' => 'usercompanies', 'action' => 'view', $user_companyId]);
        } else {
            return $this->redirect(['action' => 'users']);
        }
    }

    public function appLogin($id = null)
    {
        $useremail =  trim($this->request->getQuery('useremail'));
        $password = $this->request->getQuery('userpassword');
        $random = rand(100000, 999999);


        $authuser = $this->User->find('all', [
            'conditions' => [
                'email' => $useremail,
                'password' => $password,
            ]
        ])->first();


        if (!empty($authuser)) {
            $authuser->apptokenNumber = $random;
            $this->User->save($authuser);
            $this->loadModel('CompaniesUser');
            $companies = $this->CompaniesUser->find('all', [
                'conditions' => [
                    'CompaniesUser.user_id' => $authuser->id,
                ]
            ])->contain(['User', 'Usercompanies', 'Designations'])->toArray();
            $authuser->last_login = Time::now();
            $authuser->status = 'P';
            $this->User->save($authuser);

            $result = array();
            if ($authuser->isCompany != true) {
                if (!empty($companies)) {
                    $result = ['companies' => $companies];
                } else {
                    $result = ['user' => $authuser];
                }
            } else {
             /*  $this->loadModel('Usercompanies');
                $checkcompany = $this->Usercompanies->find('all', [
                    'conditions' => [
                        'company_user' => $authuser->id
                    ]
                ])->first();
                if (!empty($checkcompany)) {
                    $authuser->isCompany = false;
                    $this->User->save($authuser);
                    return $this->redirect(['action' => 'dashboard', $authuser->id, $checkcompany->id]);
                } else {
                    $this->Flash->error(__('Company Does not Exit !.'));
                }*/
            }

        } else {
            $result = array();
            $result = $result + array('message' => "ERROR");
        }

        $response = $this->response;
        $response = $response->withType('application/json')->withStringBody(json_encode($result));
        return $response;
    }

    public function appLogincontinue(){
        $companyId = $this->request->getQuery('company_id');
        $user_id = $this->Auth->user('id');
        $this->loadModel('CompaniesUser');
        $companymember = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'user_id' => $user_id
            ]
        ])->first();
        debug($companymember);exit;


    }


    //login method which is used to check credentionals of user and allow you to login!
    public function login()
    {
        if (!empty($this->Auth->user())) {
            return $this->redirect('/');
        }
        $redirectUrl = ((empty($this->request->getQuery('redirect'))) ? '/' : $this->request->getQuery('redirect'));
        if ($this->request->is('post')) {
            $email = trim($this->request->getData('email'));
            $password = $this->request->getData('password');
            $login_result = array();
            if (empty($email) || empty($password)) {
                $this->Flash->error(__('Inserisci e-mail e password.'));
                $this->viewBuilder()->setLayout('layout_for_pages');
                return;
            }

            // LOGIN
            $this->viewBuilder()->setLayout('new_default');
            $userEnabled = $this->User->find('all', ['conditions' =>
            [
                'email' => $email,
                'isDeleted' => false,
                'isBlocked' => false

            ]])->first();

            if (!empty($userEnabled)) {
                $this->loadModel('Settings');
                $notverifieduser = $this->User->find('all', [
                    'conditions' => [
                        'email' => $email
                    ]
                ])->first();
                $authusersettings = null;
                $authusersettings =  $this->Settings->find('all', [
                    'conditions' => [
                        'user_id in' => $notverifieduser->id
                    ]
                ])->first();
                if ($authusersettings == null) {
                    $settings = $this->Settings->newEntity();
                    $settings->user_id = $notverifieduser->id;
                    $settings->two_factor_authentication = false;
                    $this->Settings->save($settings);
                }
                $authuser = $this->User->find('all', [
                    'conditions' => [
                        'id in' => $notverifieduser->id
                    ]
                ])->first();
                $this->loadModel('CompaniesUser');
                $companies = $this->CompaniesUser->find('all', [
                    'conditions' => [
                        'user_id' => $authuser->id,
                    ]
                ])->toArray();
                if (empty($authusersettings) || ($authusersettings->two_factor_authentication == false)) {
                    $user = $this->Auth->identify();
                    if ($user) {
                        $this->Auth->setUser($user);
                        $authuser->last_login = Time::now();
                        $authuser->status = 'P';
                        $this->User->save($authuser);
                        if ($authuser->isCompany != true) {
                            if (!empty($companies)) {
                                return $this->redirect([
                                    'controller' => 'User',
                                    'action' => 'logincontinue',
                                    'email' => $email
                                ]);
                            } else {
                                return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $authuser->id]);
                            }
                        } else {
                            $this->loadModel('Usercompanies');
                            $checkcompany = $this->Usercompanies->find('all', [
                                'conditions' => [
                                    'company_user' => $authuser->id
                                ]
                            ])->first();
                            if (!empty($checkcompany)) {
                                $authuser->isCompany = false;
                                $this->User->save($authuser);
                                return $this->redirect(['action' => 'dashboard', $authuser->id, $checkcompany->id]);
                            } else {
                                $this->Flash->error(__('Company Does not Exit !.'));
                            }
                        }
                    } else {
                        $this->Flash->error(__('E-mail o password errate.'));
                    }
                } else {

                    return $this->redirect([
                        'controller' => 'User',
                        'action' => 'logincontinue',
                        'email' => $email
                    ]);
                }
            } else {
                $this->Flash->error(__('Questo account è stato cancellato o bloccato.'));
                return $this->redirect('/');
            }
        } else {
            $email = "";
        }
        // Set layout for login
        $this->viewBuilder()->setLayout('login_layout');
        $this->set(compact('email', 'redirectUrl'));
    }



    //logincontinue method, which is used to help which company company dashboars we are looking
    public function logincontinue()
    {
        $email = $this->request->getQuery('email');
        $this->loadModel('CompaniesUser');
        $authuser =  $this->User->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ])->first();
        $companies = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id' => $authuser->id
            ]
        ])->contain(['Usercompanies'])->toArray();


        $this->set(compact('companies', 'authuser'));
    }

    //companydashbord, which is prepare, render to dashboard and private dashboard based on member_role
    public function dashboard($user_id = null, $cid = null)
    {
        $this->loadModel('User');
        if ($user_id == null && $cid == null) {
            $user_id = $this->request->getData('userid');
            $cid = $this->request->getData('companyId');
        }
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();


        if (!empty($cid)) {

            $authuser->choosen_companyId = $cid;
            $this->User->save($authuser);
            $this->loadModel('CompaniesUser');
            $company =  $this->CompaniesUser->find('all', [
                'conditions' => [
                    'company_id in' => $cid
                ]
            ])->first();
            $this->loadModel('CompaniesUser');
            $authcompanymember = $this->CompaniesUser->find('all', [
                'conditions' => [
                    'CompaniesUser.user_id' => $authuser->id,
                    'company_id' =>  $authuser->choosen_companyId
                ]
            ])->contain(['Designations'])->first();
            $this->loadModel('Settings');

            $authusersettings =  $this->Settings->find('all', [
                'conditions' => [
                    'user_id in' => $user_id
                ]
            ])->first();
            if (empty($authusersettings)) {
                $this->loadModel('Settings');
                $authusersettings = $this->Settings->newEntity();
                $authusersettings->user_id = $user_id;
                $authusersettings->company_id = $cid;
                $authusersettings->two_factor_authentication = false;
                $this->Settings->save($authusersettings);
            } else {
                $authusersettings->user_id = $user_id;
                $authusersettings->company_id = $cid;
                $this->Settings->save($authusersettings);
            }


            if ($authusersettings->two_factor_authentication == false) {
                $userEnabled = $this->User->find('all', ['conditions' =>
                [
                    'email' => $authuser->email,
                    'isDeleted' => false,
                    'isBlocked' => false

                ]])->first();
                if ($userEnabled) {
                    $this->Auth->setUser($userEnabled);
                    if ($authcompanymember != null) {
                        if ($authcompanymember->designation->name == 'Administrator' || $authcompanymember->designation->name == 'Customer') {
                            return $this->redirect(['controller' => 'companiesUser', 'action' => 'companydashboard', $cid]);
                        } else {
                            return $this->redirect(['controller' => 'ProjectMember', 'action' => 'privatedashboard', $cid]);
                        }
                    } else {
                        return $this->redirect(['controller' => 'companiesUser', 'action' => 'companydashboard', $cid]);
                    }
                } else {
                    $this->Flash->error(__('Questo account è stato cancellato o bloccato.'));
                    return $this->redirect('/');
                }
            } else {
                $this->loadModel('User');
                $random = rand(100000, 999999);
                $authuser->two_factor_securitycode = $random;
                $authuser->two_factor_securitycode_expirydate = (Time::now())->modify("+2 days");
                $this->User->save($authuser);
                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                    ->setTo($authuser->email)
                    ->setemailFormat('html')
                    ->setSubject('Your Authentication Code')
                    ->setViewVars([
                        'firstname' => $authuser->firstname,
                        'lastname' => $authuser->lastname,
                        'otpcode' =>  $random,
                    ])
                    ->setTemplate('otpcode')
                    ->send();

                if ($emailSent) {
                    $this->Flash->success(__('E-mail sent.'));
                } else {
                    $this->Flash->error(__('Error message'));
                }
                return $this->redirect(['action' => 'verification', $authuser->email]);
            }
        } else {
            $this->Flash->success(__('Choose an Option to Login!!'));
            return $this->redirect([
                'controller' => 'User',
                'action' => 'logincontinue',
                'email' => $authuser->email
            ]);
        }
    }


    //verification method, which will prepared template for securitycode verification
    public function verification($email)
    {
        $notverifieduser = $this->User->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ])->first();
        $verifyuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $notverifieduser->id
            ]
        ])->first();
        $this->set(compact('verifyuser'));
    }

    //verifysecuritycode, this method verify the security code, and render to respective dashboard!!
    public function verifysecuritycode()
    {
        if ($this->request->is('POST')) {
            $securitycode =  $this->request->getData('securitycode');
            $user_id = $this->request->getData('userid');
        } else {
            $securitycode =  $this->request->getQuery('securitycode');
            $user_id = $this->request->getQuery('userid');
        }
        $verifyuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        if (($verifyuser->two_factor_securitycode == $securitycode)  && ($verifyuser->two_factor_securitycode_expirydate > Time::now())) {
            $userEnabled = $this->User->find('all', ['conditions' =>
            [
                'email' => $verifyuser->email,
                'isDeleted' => false,
                'isBlocked' => false

            ]])->first();
            if (!empty($userEnabled)) {
                if ($userEnabled) {
                    $this->Auth->setUser($userEnabled);
                    if ($userEnabled->choosen_companyId != null) {
                        $this->loadModel('CompaniesUser');
                        $authcompanymember = $this->CompaniesUser->find('all', [
                            'conditions' => [
                                'user_id' => $userEnabled->id,
                                'company_id' => $userEnabled->choosen_companyId
                            ]
                        ])->first();
                        if ($authcompanymember != null) {
                            if ($authcompanymember->designation->name == 'Administrator' || $authcompanymember->designation->name == 'Customer') {
                                return $this->redirect(['controller' => 'companiesUser', 'action' => 'companydashboard', $verifyuser->choosen_companyId]);
                            } else {
                                return $this->redirect(['controller' => 'ProjectMember', 'action' => 'employeedashboard', $verifyuser->choosen_companyId]);
                            }
                        } else {
                            return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $user_id]);
                        }
                    } else {
                        return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $user_id]);
                    }
                } else {
                    $this->Flash->error(__('Error!'));

                    return $this->redirect(['action' => 'login']);
                }
            }
        } else {
            return $this->redirect(['action' => 'invalidsecuritycode', $verifyuser->email]);
        }
    }


    //invalidsecuritycode, this method set a template if security code invalid !!

    public function invalidsecuritycode($email = null)
    {
        $notverifieduser = $this->User->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ])->first();
        $verifyuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $notverifieduser->id
            ]
        ])->first();
        $this->set(compact('verifyuser'));
    }

    //resendemail, this methid set a template for resend mail if link invalid !!

    public function resendemail($email = null)
    {
        $this->loadModel('User');
        $random = rand(100000, 999999);
        $verifyuser = $this->User->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ])->first();
        $verifyuser->two_factor_securitycode = $random;
        $verifyuser->two_factor_securitycode_expirydate = (Time::now())->modify("+2 days");
        $this->User->save($verifyuser);
        $firstname = $verifyuser->firstname;
        $lastname = $verifyuser->lastname;

        $protocol = Configure::read('Protocol');
        $domain = Configure::read('Domain');
        $port = Configure::read('Port');

        if ($port == 80) {
            $port = "";
        } else {
            $port = ":" . $port;
        }
        $link = $protocol . '://' . $domain . $port . '/user/sendsecuritycode/' . $verifyuser->email;
        $email = new Email();
        $emailSent = $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($verifyuser->email)
            ->setemailFormat('html')
            ->setSubject('Login Security Verification mail')
            ->setViewVars([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'link' => $link
            ])
            ->setTemplate('resendemail')
            ->send();
        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
        return $this->redirect(['action' => 'login']);
    }

    //sendsecuritycode method, this is send a security code for verified email id !
    public function sendsecuritycode($email = null)
    {
        $this->loadModel('User');
        $random = rand(100000, 999999);
        $verifyuser = $this->User->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ])->first();
        $verifyuser->two_factor_securitycode = $random;
        $verifyuser->two_factor_securitycode_expirydate = (Time::now())->modify("+2 days");
        $this->User->save($verifyuser);
        $firstname = $verifyuser->firstname;
        $lastname = $verifyuser->lastname;
        $email = new Email();
        $emailSent =   $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($verifyuser->email)
            ->setemailFormat('html')
            ->setSubject(__('OTP per il ripristino della password.'))
            ->setViewVars([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'otpcode' =>  $random,
            ])
            ->setTemplate('otpcode')
            ->send();
        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
        return $this->redirect(['action' => 'verification', $verifyuser->email]);
    }


    //logout method
    public function logout()
    {
        $user_id = $this->Auth->user('id');
        $logoutuser = $this->User->find('all', [
            'conditions' => [
                'id' => $user_id
            ]
        ])->first();
        // $logoutuser->status = 'A';
        // $this->User->save($logoutuser);
        $this->Flash->success(__('Logged out.'));
        return $this->redirect($this->Auth->logout());
    }



    //checkmailid method, checkmail for  registed mail or unregistered mail ?
    public function checkmailid()
    {
        $email =  $this->request->getData('email');
        $allusers =  $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $allemailds = array();
        foreach ($allusers as $singleuser) {
            array_push($allemailds, $singleuser->email);
        }
        if ($email != null) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            if (preg_match($test_patt, $email)) {
                if (in_array($email, $allemailds)) {
                    $msg = 'Email Id already exist';
                } else {
                    $msg = '';
                }
            } else {
                $msg = 'Invalid Email Address';
            }
        } else {
            $msg = "Please Enter Email Field";
        }
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($msg));
    }





    /** contract acceptance method from customer */

    public function acceptancecontract($contract_id = null, $user_id = null)
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $this->loadModel('Contracts');
        $custdata = $this->User->find('all', [
            'conditions' => [
                'id ' => $user_id
            ]
        ])->first();

        $contract = $this->Contracts->find('all', [
            'conditions' => [
                'id' => $contract_id
            ]
        ])->first();

        $contract->acceptance_date = Time::now();
        $this->Contracts->save($contract);
        $pmembers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $contract->project_object_id,
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();

        $userIds = array();
        foreach ($pmembers as $mem) {
            array_push($userIds, $mem['memberId']);
        }
        $projectmember = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $contract->project_object_id,
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Administrator'
                ]);
            },
        ])->toArray();
        $cheifIds = array();
        foreach ($projectmember as $member) {
            array_push($cheifIds, $member['memberId']);
        }
        $cheifs = $this->User->find('all', [
            'conditions' => [
                'id in' => $cheifIds
            ]
        ])->toArray();
        foreach ($cheifs as $cheif) {
            $email = new Email();
            $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($cheif->email)
                ->setemailFormat('html')
                ->setSubject('Customer Acceptance of the Contract')
                ->send('Hello ' . $cheif->firstname . ', the Customer contract accepted notice');
        }


        $email = new Email();
        $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($custdata->email)
            ->setemailFormat('html')
            ->setSubject('Acceptance Notice')
            ->send('Hello ' . $custdata->firstname . ', the contract accepted notice');

        $this->Flash->success(__('Accepted Sucessfully!'));
        return $this->redirect([
            'controller' => 'ProjectObject',
            'action' => 'view',
            $contract->project_object_id

        ]);
    }





    //modal template with credential form will be displayed
    public function verifycontractacceptancy()
    {
        $contract_id =  $this->request->getQuery('contract_id');
        $pid = $this->request->getQuery('pid');
        $userid = $this->request->getQuery('userid');
        $versionId = $this->request->getQuery('versionId');



        $this->set(compact('contract_id', 'pid', 'versionId'));
    }


    //verify Credentials
    public function verifycredentials()
    {

        $email = $this->request->getData('email');
        $password = $this->request->getData('password');
        $contract_id = $this->request->getData('contract_id');
        $pid = $this->request->getData('pid');
        $versionId = $this->request->getData('versionId');


        $this->loadModel('Contracts');
        $this->loadModel('VersionsContract');

        $contract = $this->Contracts->find('all', [
            'conditions' => [
                'id in' => $contract_id
            ]
        ])->first();

        $notverifieduser = $this->User->find('all', [
            'conditions' => [
                'email' => $email
            ]
        ])->first();
        $customers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $pid
            ]
        ])->contain([
            'User',
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();
        $user_id = $this->Auth->user('id');
        foreach ($customers as $customer) {

            if ($customer->user->email == $email /* && $customer->user->password == $password */) {
                if (!empty($versionId)) {
                    // debug($versionId);exit;
                    return $this->redirect([
                        'controller' => 'user',
                        'action' => 'versionAcceptancy',
                        $versionId,
                        $user_id
                    ]);
                } else {
                    return $this->redirect([
                        'controller' => 'user',
                        'action' => 'acceptancecontract',
                        $contract_id,
                        $user_id

                    ]);
                }
            } elseif (!empty($notverifieduser)) {
                $this->Flash->error(__('Invalid Email Or Password !'));
                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'verifycontractacceptancy',
                    'contract_id' => $contract_id,
                    'pid' => $pid,
                    'userid' => $notverifieduser->id

                ]);
            } else {
                $this->Flash->error(__('No Email found !'));
                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'login'
                ]);
            }
        }
    }

    public function profiledashboard($user_id = null)
    {

        $this->loadModel('Settings');
        $authusersettings = null;
        $authusersettings =  $this->Settings->find('all', [
            'conditions' => [
                'user_id in' => $user_id
            ]
        ])->first();

        if ($authusersettings == null) {
            $this->loadModel('Settings');
            $settings = $this->Settings->newEntity();
            $settings->user_id = $user_id;
            $settings->company_id = null;
            $settings->two_factor_authentication = false;
            $this->Settings->save($settings);
        } else {
            $authusersettings->company_id = $user_id;
            $authusersettings->company_id = null;
            $this->Settings->save($authusersettings);
        }

        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        if ($authusersettings->two_factor_authentication == false) {
            //updating last login time
            $loginuser =  $this->User->find('all', [
                'conditions' => [
                    'email' => $authuser->email
                ]
            ])->first();
            $user = $this->Auth->identify();
            $loginuser->last_login = Time::now();
            $loginuser->status = 'P';
            $loginuser->choosen_companyId = null;
            $this->User->save($loginuser);
            return $this->redirect(['controller' => 'user', 'action' => 'userprofile', $user_id]);
        } else {
            $this->loadModel('User');
            $random = rand(100000, 999999);
            $authuser->two_factor_securitycode = $random;
            $authuser->two_factor_securitycode_expirydate = (Time::now())->modify("+2 days");
            $this->User->save($authuser);
            $email = new Email();
            $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($authuser->email)
                ->setemailFormat('html')
                ->setSubject('Your Authentication Code')
                ->setViewVars([
                    'firstname' => $authuser->firstname,
                    'lastname' => $authuser->lastname,
                    'otpcode' =>  $random,
                ])
                ->setTemplate('otpcode')
                ->send();

            if ($emailSent) {
                $this->Flash->success(__('E-mail sent.'));
            } else {
                $this->Flash->error(__('Error message'));
            }
            return $this->redirect(['action' => 'verification', $authuser->email]);
        }
    }



    public function versionAcceptancy($versionId = null, $user_id = null)
    {

        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $this->loadModel('VersionsContract');
        $version = $this->VersionsContract->find('all', [
            'conditions' => [
                'id' => $versionId
            ]
        ])->first();
        $version->acceptance_date = Time::now();
        $this->VersionsContract->save($version);
        $pmembers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $version->project_object_id
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();
        $userIds = array();
        foreach ($pmembers as $mem) {
            array_push($userIds, $mem['memberId']);
        }
        $customers = $this->User->find('all', [
            'conditions' => [
                'id in' => $userIds
            ]

        ])->toArray();
        $projectmember = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $version->project_object_id
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Administrator'
                ]);
            },
        ])->toArray();
        $cheifIds = array();
        foreach ($projectmember as $member) {
            array_push($cheifIds, $member['memberId']);
        }
        $cheifs = $this->User->find('all', [
            'conditions' => [
                'id in' => $cheifIds

            ]

        ])->toArray();
        $cheifEmails = array();
        foreach ($cheifs as $cheif) {
            array_push($cheifEmails, $cheif->email);
        }

        $email = new Email();
        $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($cheifEmails)
            ->setemailFormat('html')
            ->setSubject('Customer Acceptance of the Contract')
            ->send('Hello ' . $cheif->firstname . ', the Customer contract accepted notice');
        $recipients = array();

        foreach ($customers as $user) {
            array_push($recipients, $user->email);
        }

        $email = new Email();
        $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($recipients)
            ->setemailFormat('html')
            ->setSubject('Contract Version Acceptance Notice')
            ->send('Hello, the contract accepted notice');
        $this->Flash->success(__('Accepted Sucessfully!'));
        return $this->redirect([
            'controller' => 'ProjectObject',
            'action' => 'view',
            $version->project_object_id

        ]);
    }
    public function userReports($companyId = null)
    {
        $this->loadModel('CompaniesUser');
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id in' => $companyId
            ]
        ])->contain(['Usercompanies', 'User', 'Designations'])->toArray();

        $this->set(compact('companymembers', 'companyId'));
    }
    public function updateuserbankinfo()
    {
        $this->loadModel('Userbanks');
        $userId = $this->request->getData('userId');
        $bankname = $this->request->getData('bankname');
        $iban = $this->request->getData('iban');
        $state_bankbranch = $this->request->getData('state_bankbranch');
        $bankprovince = $this->request->getData('bankprovince');
        $city_bankbranch = $this->request->getData('city_bankbranch');
        $updatebank = $this->Userbanks->find('all', [
            'conditions' => [
                'user_id' => $userId
            ]
        ])->first();
        $updatebank->bank_name = $bankname;
        $updatebank->iban = $iban;
        $updatebank->state_bankbranch = $state_bankbranch;
        $updatebank->province_bankbranch = $bankprovince;
        $updatebank->city_bankbranch = $city_bankbranch;
        $this->Userbanks->save($updatebank);

        return $this->redirect([
            'controller' => 'user',
            'action' => 'userprofile',
            $userId

        ]);
    }


    public function changepasswordSettings($companyId)
    {
        $this->set(compact('companyId'));
    }

    public function updatepassword()
    {

        $user_id = $this->Auth->User('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id' => $user_id
            ]
        ])->first();
        $old =  $this->request->getData('oldpassword');
        $new = $this->request->getData('newpassword');
        $confirm = $this->request->getData('confirmpassword');
        $verify = password_verify($old, $authuser->password);

        if ($verify == true) {
            if ($new == $confirm) {
                $authuser->password = password_hash($new, PASSWORD_DEFAULT);
                $this->Flash->success(__('Password Updated'));
                $this->User->save($authuser);
            } else {
                $this->Flash->error(__('Password Mismatch'));
            }
        } else {
            $this->Flash->error(__('Old Password Mismatch'));
        }

        return $this->redirect([
            'controller' => 'user',
            'action' => 'changepassword_settings',
            $authuser->choosen_companyId

        ]);
    }
}
