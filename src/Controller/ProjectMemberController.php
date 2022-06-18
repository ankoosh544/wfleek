<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use SebastianBergmann\Environment\Console;

/**
 * ProjectMember Controller
 *
 * @property \App\Model\Table\ProjectMemberTable $ProjectMember
 *
 * @method \App\Model\Entity\ProjectMember[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectMemberController extends AppController
{
    public function isAuthorized($user)
    {
        return true;
    }

    /*Suggested Members*/

    public function suggesteddata()
    {

        if ($this->request->is('ajax')) {
            $this->loadModel('User');
            $id = $this->request->getData('id');
            $data = $this->ProjectMember->find('all', [
                'conditions' => [
                    'type' => 'C'
                ]
            ])->toArray();
            if (!empty($data)) {
                $userids = array();
                foreach ($data as $item) {
                    array_push($userids, $item['memberId']);
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
            }else{
                //$this->Flash->error('No Clients Find');
            return $this->redirect(['controller' => 'Onsiteemployees', 'action' => 'index']);

            }
        }
    }







    public function deleteproject($id = null)
    {

        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttasks');
        $projecttasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $id
            ]
        ])->toArray();
        $projectMembers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id
            ]
        ])->toArray();
        //debug($projectMember);exit;


        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        //debug($projectObject);exit;
        foreach ($projecttasks as $projecttask) {
            $projecttask->isDeleted = true;
            $this->Projecttasks->save($projecttask);
        }

        foreach ($projectMembers as $projectMember) {
            $this->ProjectMember->delete($projectMember);
        }

        $projectObject->isDeleted = true;
        $this->ProjectObject->save($projectObject);

        return $this->redirect(['action' => 'companydashboard']);
    }







    /**employee dashboard */
    public function employeedashboard($companyId = null)
    {

        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttasks');
        $this->loadModel('Leaves');
        $this->loadModel('Holidays');

        $date = Time::now();

        $currentTimestamp = time(); // which returns an integer (time)
        $holidays = $this->Holidays->find('all', [
            'conditions' => [
                'DATE(holiday_date) >' => date('Y-m-d')
            ]
        ])->toArray();


        $user_id = $this->Auth->user('id');

       $authuser =  $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $approvedleaves = $this->Leaves->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'status' => 'A',
                'isDeleted' => false,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->toArray();
        $conditions = array(
            'and' => array(
                array(
                    'DATE(fromdate) <= ' => date('Y-m-d'),
                    'DATE(todate) >= ' => date('Y-m-d')
                ),
                'Leaves.status =' => 'A',
                'Leaves.isDeleted' => false,
                'company_id' => $authuser->choosen_companyId
            )
        );
        $onleavetoday = $this->Leaves->find('all', [
            'conditions' => $conditions,
        ])->contain(['User'])->toArray();




        $nextweekleaves = $this->Leaves->find('all', [
            'conditions' => [
                'DATE(fromdate) <= ' => date('Y-m-d'),
                'DATE(todate) <=' => date('Y-m-d', strtotime('+7 days')),
                'Leaves.status' => 'A',
                'Leaves.isDeleted' => false,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User'])->toArray();

        $allusers = $this->User->find('all')->toArray();
        $authUser = $this->User->find('all', [
            'conditions' => [
                'id in'  => $user_id
            ]
        ])->first();
        $projectObjects = $this->ProjectObject->find('all')->toArray();
        $projecttasks = $this->Projecttasks->find('all', ['conditions' => ['type' => 'TS']])->toArray();
        $pendingtasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'type' => 'TS',
                'Projecttasks.status' => 'I',
                'isDeleted' => false
            ]
        ])->toArray();
        $this->loadModel('Employeerequests');
        $requestconditions = array(
            'and' => array(
                array(
                    'DATE(fromdate) <= ' => date('Y-m-d'),
                    'DATE(todate) >= ' => date('Y-m-d')
                ),
                'Employeerequests.status =' => 'A',
                /* 'Employeerequests.isDeleted' => false */
            )
        );
        $myrequest = $this->Employeerequests->find('all', [
            'conditions' => $requestconditions, [
                'user_id' => $authUser->id
            ]

        ])->first();
        $this->set(compact('holidays', 'nextweekleaves', 'authUser', 'projectObjects', 'projecttasks', 'pendingtasks', 'approvedleaves', 'onleavetoday', 'allusers', 'myrequest'));
    }

    //privatedashboard

    public function privatedashboard($companyId = null)
    {

            $this->loadModel('User');
            $this->loadModel('ProjectMember');
            $this->loadModel('ProjectObject');
            $this->loadModel('ProjectMember');
            $this->loadModel('Projecttasks');
            $this->loadModel('Leaves');
            $this->loadModel('Holidays');
            $this->loadModel('Onsiteemployees');
            $this->loadModel('Employeerequests');

            $today = Time::now();

            $holidays = $this->Holidays->find('all', [
                'conditions' => [
                    'DATE(holiday_date) >' => date('Y-m-d')
                ]
            ])->toArray();
            $categorizedemps = $this->Onsiteemployees->find('all')->contain(['User', 'Worklocations'])->toArray();
            $user_id = $this->Auth->user('id');

            $authUser = $this->User->find('all', [
                'conditions' => [
                    'id in'  => $user_id
                ]
            ])->first();

            $projecttasks = $this->Projecttasks->find('all', [
                'conditions' => [
                    'type' => 'TS'
                    ]
                    ])->toArray();
            $pendingtasks = $this->Projecttasks->find('all', [
                'conditions' => [
                    'type' => 'TS',
                    'Projecttasks.status' => 'I',
                    'isDeleted' => false
                ]
            ])->toArray();

            $requestconditions = array(
                'and' => array(
                    array(
                        'DATE(fromdate) <= ' => date('Y-m-d'),
                        'DATE(todate) >= ' => date('Y-m-d')
                    ),
                    'Employeerequests.status =' => 'A',
                )
            );
            $myrequest = $this->Employeerequests->find('all', [
                    'conditions' => $requestconditions, [
                        'user_id' => $authUser->id
                    ]

                ])->first();
                $onleavetoday = null;
                $nextweekleaves = null;
                $approvedleaves = null;

        if ($companyId != null) {
            $this->loadModel('CompaniesUser');
            $admin = $this->CompaniesUser->find('all',[
                'conditions' => [
                    'company_id' => $companyId,
                    'member_role' => 5
                ]
            ])->first();

            $allapprovedleaves = $this->Leaves->find('all', [
                'conditions' => [
                    'Leaves.status' => 'A',
                    'Leaves.isDeleted' => false,
                    'company_id' => $companyId
                ]
            ])->contain(['User'])->toArray();

            $approvedleaves = $this->Leaves->find('all', [
                'conditions' => [
                    'user_id' => $user_id,
                    'status' => 'A',
                    'isDeleted' => false,
                    'company_id' => $companyId
                ]
            ])->toArray();


            // Making Expired Leaves as Delete Operation
            foreach($allapprovedleaves as $singleapprovedleave){
                if($singleapprovedleave->todate->i18nFormat('yyyy-MM-dd') < $today->i18nFormat('yyyy-MM-dd')){
                    $singleapprovedleave->isDeleted = true;
                    $this->Leaves->save($singleapprovedleave);
                }
            }


            $onleavetoday = array();
            foreach($allapprovedleaves as $singleapprovedleave){
                if($singleapprovedleave->fromdate->i18nFormat('yyyy-MM-dd') == $today->i18nFormat('yyyy-MM-dd')){
                    array_push($onleavetoday, $singleapprovedleave);
                }
            }

            $nextweekleaves =array();
            foreach($allapprovedleaves as $singleapprovedleave){
                if($singleapprovedleave->fromdate->i18nFormat('yyyy-MM-dd') > $today->i18nFormat('yyyy-MM-dd') &&  $singleapprovedleave->todate->i18nFormat('yyyy-MM-dd') <= $today->modify('+7 days')->i18nFormat('yyyy-MM-dd') ){
                    array_push($nextweekleaves, $singleapprovedleave);
                }
            }
            $projectObjects = $this->ProjectObject->find('all',[
                'conditions' => [
                    'company_id' => $companyId
                ]
            ])->toArray();
        } else {
            $projectObjects = $this->ProjectObject->find('all',[
                'conditions' => [
                    'isPersonal' => true,
                    'isDeleted' => false,
                    'creatorId' => $user_id
                ]
            ])->toArray();
            $admin = null;
        }
        $this->set(compact('admin','categorizedemps', 'holidays', 'authUser', 'projectObjects', 'projecttasks', 'pendingtasks','nextweekleaves','approvedleaves','onleavetoday', 'myrequest'));

    }






    public function updateclientinfo()
    {

        $userid = $this->request->getData('userid');
        $user = $this->User->find('all', [
            'conditions' => [
                'id in ' => $userid
            ]
        ])->first();

        $user->firstname = $this->request->getData('firstname');
        $user->lastname = $this->request->getData('lastname');
        $user->birthday = $this->request->getData('dob');
        $user->address = $this->request->getData('address');
        $user->gender = $this->request->getData('gender');
        $user->email = $this->request->getData('email');
        $user->password = $this->request->getData('password');
        $user->password = $this->request->getData('confirmpassword');
        $expirydate = $this->request->getData('passwordExpitydate');

        $expirydate = Time::createFromFormat(
            'd/m/Y',
            $expirydate,
            'Europe/Paris'
        );
        $user->passwordExpirationDate =  $expirydate;
        $user->tel = $this->request->getData('tel');
        //$user->role = $this->request->getData('role');

        $this->User->save($user);
        return $this->redirect(['action' => 'companydashboard']);
    }

    public function deleteclient($id = null)
    {
        //debug($id);exit;
        $user = $this->User->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $user->isDeleted = true;
        $this->User->save($user);
        return $this->redirect(['action' => 'companydashboard']);
    }



    /*delete member*/

    public function deleteMember()
    {

        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectMember');
        $memid = $this->request->getData('id');
        //debug($memid);exit;
        if (!empty($memid)) {
            $member = $this->ProjectMember->find('all', [
                'conditions' => [
                    'memberId' => $memid
                ]

            ])->first();

            $this->ProjectMember->delete($member);

            return $this->redirect([
                'controller' => 'Projecttasks',
                'action' => 'recyclebin',

            ]);
        }
    }


    public function inviteMembers()
    {
        if ($this->request->is('post')) {
            $projectId = $this->request->getData('projectId');
            $designationId = $this->request->getData('designationId');
            $departmentId = $this->request->getData('departmentId');
            $userId = $this->request->getData('userId');

            $checkuser = $this->ProjectMember->find('all',[
                'conditions' => [
                    'projectId' => $projectId,
                    'memberId' => $userId
                ]
            ])->first();
            if (empty($checkuser)) {
                $projectMember = $this->ProjectMember->newEntity();
                $projectMember->projectId = $projectId;
                $projectMember->memberId = $userId;
                $projectMember->department_id = $departmentId;
                $projectMember->designation_id = $designationId;
                $projectMember->joinDate = Time::now();
                $projectMember->sponsorId = 1;
                $projectMember->isInvitation = true;
                if ($projectMember->isInvitation == true) {
                    $projectMember->invitationDate =  Time::now();
                }
                $projectMember->isMembershipRequest = False;
                if ($projectMember->isMembershipRequest == true) {
                    $projectMember->membershipRequestDate = Time::now();
                }
                $projectMember->isBanned = false;
                if ($projectMember->isBanned == true) {
                    $projectMember->banDate = Time::now();
                    $projectMember->bannerId = 1;
                    $projectMember->banReason = null;
                }
                $this->ProjectMember->save($projectMember);
            }else{
                $this->Flash->error(__('Error. User Already Member of this Project'));
            }

            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'view',
                $projectId
            ]);
        } else {
            $this->Flash->error(__('Error. Request isn\' in the right format'));
        }
    }

}
