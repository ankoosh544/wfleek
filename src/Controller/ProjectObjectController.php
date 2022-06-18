<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Core\Configure;


/**
 * ProjectObject Controller
 *
 * @property \App\Model\Table\ProjectObjectTable $ProjectObject
 *
 * @method \App\Model\Entity\ProjectObject[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectObjectController extends AppController
{
 //   const imageDirectoryName = "C:\xampp\htdocs\GitHubU\epebook_Creazione-Agora-AI-\webroot\projectfiles";
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /* Creating  and download a File */
    public $components = array('Paginator', 'RequestHandler');

    public function startfutureproject($id = null)
    {
        $this->loadModel('Projecttasks');
        $this->loadModel('Taskgroups');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $projecttasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $id
            ]
        ])->toArray();
        foreach ($projecttasks as $projecttask) {
            $projecttask->isFuturedTask = false;
        }
        $projectObject->isFuturedProject = false;
        return $this->redirect(['controller' => 'ProjectObject', 'action' => 'index']);
    }

    /*FutureProject*/
    public function futureprojects()
    {
        $this->loadModel('CompaniesUser');
        $companyId = $this->request->getQuery('companyId');
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();
        $type = $this->request->getQuery('type');
        $projectId = $this->request->getQuery('projectId');
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttypes');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in ' => $user_id
            ]
        ])->first();
        if(!empty($companyId)){
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'company_id' => $companyId,
                    'visibility' => $type,
                    'isFuturedProject' => true,
                    'isDeleted' => false
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

        }else{
            $authuserprojects = $this->ProjectMember->find('all',[
                'conditions' => [
                    'memberId in' => $user_id
                ]
            ])->toArray();
            $projectids =array();
            foreach($authuserprojects as $project){
                array_push($projectids, $project->projectId);

            }

            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $projectids,
                    'visibility' => $type,
                    'isFuturedProject' => true,
                    'isDeleted' => false
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

        }


        if ($projectId == null) {
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                   'isFuturedProject' => true,
                    'isDeleted' => false
                ]
            ])->order(['createDate' => 'DESC'])->contain([
                'Projecttypes',
                'Projectfiles',
                'Projecttasks' => function ($q) {
                    return $q->where([
                        'isDeleted' => false
                    ]);
                },
                'Projectmembers.User'
            ])->first();
            $projecttypes = $this->Projecttypes->find('all')->toarray();
        } else {
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $projectId,
                    'isDeleted' => false
                ]
            ])->order(['createDate' => 'DESC'])->contain([
                'Projecttypes',
                'Projectfiles',
                'Taskgroups',

                'Projecttasks' => function ($q) {
                    return $q->where([
                        'isDeleted' => false
                    ]);
                },
                'Projectmembers.User'
            ])->first();

            $projecttypes = $this->Projecttypes->find('all')->toarray();
        }


        $this->set(compact('projectObjects', 'projecttypes', 'projectObject', 'authuser','type'));
    }



    //futureprojectsview
    public function futureprojectsview($id = null)
    {
        $this->loadModel('Projectfiles');
        $projectfiles = $this->Projectfiles->find('all', [
            'conditions' => [
                'project_id' => $id
            ]
        ])->toArray();
        $this->loadModel('Projectfiles');
        $projectfiles = $this->Projectfiles->find('all', [
            'conditions' => [
                'project_id' => $id
            ]
        ])->toArray();
        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');
        $user_id = $this->Auth->user('id');
        $this->loadModel('TaskgroupsProjecttasks');
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
        $this->set(compact('manyObject'));
        $this->loadModel('Taskgroups');
        $taskgroups = $this->Taskgroups->find('all', [
            'conditions' => [
                'isFuturedGroup' => 1
            ]
        ])->toArray();
        $projecttask = $this->Projecttasks->find('all')->toArray();
        $this->set(compact('taskgroups', 'projecttask'));
        $this->set(compact('user_id'));
        $this->loadModel('Contracts');
        $contract = $this->Contracts->find('all')->toArray();
        //debug($contract);exit;
        $this->loadModel('VersionsContract');
        $version = $this->VersionsContract->find('all')->toArray();
        $this->loadModel('Taskusers');
        $taskusers = $this->Taskusers->find('all')->toArray();
        $this->set(compact('contract', 'version', 'taskusers'));
        // add task
        $tasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $id,
                'isDeleted' => false,
                'type' => 'TS',

            ]
        ])->toArray();
        $alltags = $this->User->find('all', [
            'conditions' => [
                'tags !=' => 'NULL',
            ]
        ])->toArray();
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
        $todoTasks =  $this->Projecttasks->find('all', [
            'conditions' => [
                'status' => 'T'
            ]
        ])->toArray();
        $inProTasks =  $this->Projecttasks->find('all', [
            'conditions' => [
                'status' => 'I'
            ]
        ])->toArray();
        $doneTasks =  $this->Projecttasks->find('all', [
            'conditions' => [
                'status' => 'D'
            ]
        ])->toArray();
        $this->set(compact('todoTasks', 'inProTasks', 'doneTasks', 'tasks', 'result', 'projectfiles'));
        $this->loadModel('ProjectMember');
        $allUsers = $this->User->find('all')->toArray();
        $projectMembers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id,
                'type !=' => 'C'
            ]
        ])->toArray();
        $clients = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();
        $data = $this->ProjectMember->find('all')->toArray();
        $projectmanagers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id
            ]
        ])->contain([
            'Designations'=> function ($q) {
                return $q->where([
                   'name is' => 'Project Manager'
                ]);
            },
        ])->toArray();
        $admin = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id
            ]
        ])->contain([
            'Designations'=> function ($q) {
                return $q->where([
                   'name is' => 'Administrator'
                ]);
            },
        ])->first();
        $data2 = $this->ProjectMember->find(
            'all',
            [
                'conditions' => [
                    'memberId' => $user_id
                ]
            ]
        )->first();
        $userData = $this->User->find('all', [
            'conditions' => [
                'id' => $user_id
            ]
        ])->first();
        $this->set(compact('data2', 'userData'));
        $userid = array();
        foreach ($data as $item) {
            array_push($userid, $item['memberId']);
        }
        $data = $this->User->find(
            'all',
            [
                'conditions' => [
                    'id' => $user_id
                ]
            ]
        )->first();
        $managerids = array();
        foreach ($projectmanagers as $item) {
            array_push($managerids, $item['memberId']);
        }
        $userid = array();
        foreach ($projectMembers as $item) {
            array_push($userid, $item['memberId']);
        }
        $totalprojectmemberids = array_merge($userid, $managerids);
        $this->set(compact('data2', 'data', 'clients', 'projectfiles', 'allUsers', 'userid', 'admin', 'projectmanagers', 'projectMembers', 'totalprojectmemberids', 'result'));
        $projectObjects = $this->paginate($this->ProjectObject);

        $this->set(compact('projectObjects'));
        $file = $this->request->getData('projectIMG');
        $go = $this->ProjectObject->find('all', [
            'conditions' => ['id' => $id]
        ])->count();
        $member = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id,
                'memberId' => $this->Auth->user('id'),
                'isMembershipRequest' => false,
                'isInvitation' => false,
                'isBanned' => false
            ]
        ])->count();
        $memberRequest = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id,
                'memberId' => $this->Auth->user('id'),
                'isMembershipRequest' => true,
                'isInvitation' => false,
                'isBanned' => false
            ]
        ])->count();
        $level012 = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id,
                'memberId' => $this->Auth->user('id'),
                'isMembershipRequest' => false,
                'isInvitation' => false,
                'isBanned' => false,
                'accessLevel = 1 OR accessLevel = 2 OR accessLevel = 1'
            ]
        ])->count();
        if ($go == 0) {
            $this->Flash->error('Il progetto non esiste.');
            return $this->redirect(['controller' => 'ProjectObject', 'action' => 'index']);
        }
        $projectObject = $this->ProjectObject->get($id, [
            'contain' => []
        ]);
        $userId = $this->Auth->user('id');
        $this->set('projectObject', $projectObject);
        $this->set('userId', $userId);
        $this->set('member', $member);
        $this->set('memberRequest', $memberRequest);
        $this->set('level012', $level012);
    }

    /**Edit and Update ProjectDetails */
    public function updateproject()
    {
        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');

        $this->loadModel('User');
        $user_id = $this->Auth->User('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $pid = $this->request->getData('pid');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $pid
            ]
        ])->first();
        $url = $this->request->getData('url');
        $archieveprojects = $this->request->getData('archieveprojects');
        $projectlists = $this->request->getData('projectlists');
        $rendercompanyId = $this->request->getData('rendercompanyId');
        $userprofile = $this->request->getData('userprofile');
        $projectreports = $this->request->getData('projectreports');
        $projectcategoryview = $this->request->getData('projectcategoryview');
       // debug($projectreports);exit;

        $admin = $this->request->getData('admin');
        $userprofile = $this->request->getData('userprofile');
        $projectObject->creatorId = $this->Auth->User('id');
        $projectObject->type = $this->request->getData('projecttype');
        $projectObject->name = $this->request->getData('name');
        $projectObject->description = $this->request->getData('description');
        $startdate = $this->request->getData('startdate');
        $startdate = Time::createFromFormat(
            'd/m/Y',
            $startdate,
            'Europe/Paris'
        );
        $expirydate = $this->request->getData('expirydate');
        $expirydate = Time::createFromFormat(
            'd/m/Y',
            $expirydate,
            'Europe/Paris'
        );
        $projectObject->startdate = $startdate;
        $projectObject->expirydate = $expirydate;
        $projectObject->totalgroups = $this->request->getData('group_slots');
        $projectObject->description2 = null;
        $projectObject->visibility = $this->request->getData('visibility');
        $projectObject->price = $this->request->getData('price');
        $projectObject->tax = $this->request->getData('tax');
        $typeproject = $this->request->getData('typeproject');
        if ($typeproject == 'P') {
            $projectObject->isPersonal = 1;
            $projectObject->company_id = null;
        } else {
            $projectObject->isPersonal = 0;
            $projectObject->company_id = $authuser->choosen_companyId;
        }
        $projectObject->isRestricted = 0;
        $projectObject->isMembershipRequestAllowed = $this->request->getData('membership_request') === null ? false : true;
        $projectObject->isBanAllowed = $this->request->getData('ban_span') === null ? false : true;
        $projectObject->isInvitationAllowed = $this->request->getData('invitation_span') === null ? false : true;
        $projectObject->isArchieveAllowed = $this->request->getData('archive_project') === null ? false : true;
        $projectObject->note = null;
        if ($this->ProjectObject->save($projectObject)) {
            $projectId = $projectObject->get('id');
            // ------------- IMage Save Starts Here --------------------------
            $files = $this->request->getData()['images'];
            $this->loadModel('Projectfiles');
            foreach ($files as $file) {
                if ($file['size'] != 0) {
                    $projectfiles = $this->Projectfiles->newEntity();
                    $projectfiles->project_id = $projectId;
                    $projectfiles->user_id = $this->Auth->user('id');
                    $projectfiles->type = $file['type'];
                    $projectfiles->size = $file['size'];
                    $projectfiles->filename = $file['name'];
                    $projectfiles->filepath = "assets/projectfiles/" .  $projectId;
                    $destinationFolder = WWW_ROOT . "assets/projectfiles/" .  $projectId;
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                    $result = $this->Projectfiles->save($projectfiles);
                }
            }
            // ------------------------ Images save ends here ------------------

            $this->loadModel('Departments');
            $companydepartments = $this->Departments->find('all',[
                 'conditions' => [
                     'company_id' => $companyId
                 ]
             ])->contain(['Designations'])->toArray();
             $customerdesignationId =null;
             $projectmanagerId =null;
             $developerId = null;
             $administratorId = null;

             foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Customer') {
                        $customerdesignationId = $customerdesignationId + $designation->id;
                        break;
                    }
                }
            }
            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Project Manager') {
                        $projectmanagerId = $projectmanagerId + $designation->id;
                        break;
                    }
                }
            }
            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Developer') {
                        $developerId = $developerId + $designation->id;
                        break;
                    }
                }
            }
            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Administrator') {
                        $administratorId = $administratorId + $designation->id;
                        break;
                    }
                }
            }

            //new fields
            $client = intval($this->request->getData('editclient'));
            $existingclient = $this->ProjectMember->find('all', [
                'conditions' => [
                    'projectId' => $projectId,
                ]
            ])->contain([
                'Designations' => function ($q) {
                    return $q->where([
                        'name is' => 'Customer'
                    ]);
                },
            ])->first();

            if (!empty($client) && $client == $existingclient->memberId) {
                $this->ProjectMember->delete($existingclient);
                $clientmember = $this->ProjectMember->newEntity();
                $clientmember->projectId = $projectId;
                $clientmember->accessLevel = 1;
                $clientmember->isInvitation = 0;
                $clientmember->designation_id = $customerdesignationId;
                $clientmember->memberId = $client;
                $clientmember->joinDate = $projectObject->createDate;
                $this->ProjectMember->save($clientmember);
                $this->projectUpdatedNotification($clientmember->memberId, $projectId);
            } elseif (!empty($client) && $client != $existingclient->memberId) {
                $this->ProjectMember->delete($existingclient);
                $clientmember = $this->ProjectMember->newEntity();
                $clientmember->projectId = $projectId;
                $clientmember->accessLevel = 1;
                $clientmember->isInvitation = 0;
                $clientmember->designation_id = $customerdesignationId;
                $clientmember->memberId = $client;
                $clientmember->joinDate = $projectObject->createDate;
                $this->ProjectMember->save($clientmember);
                $this->projectAssignedNotification($clientmember->memberId, $projectId);
            }


            $projectleader = intval($this->request->getData('editprojectleader'));

            $existingleader = $this->ProjectMember->find('all', [
                'conditions' => [
                    'projectId' => $projectId,
                ]
            ])->contain([
                'Designations' => function ($q) {
                    return $q->where([
                        'name is' => 'Project Manager'
                    ]);
                },
            ])->first();

            if(!empty($projectleader) && !empty(existingleader) && $projectleader == $existingleader->memberId){
                $this->ProjectMember->delete($existingleader);
                $projectleadermember = $this->ProjectMember->newEntity();
                $projectleadermember->projectId = $projectId;
                $projectleadermember->accessLevel = 1;
                $projectleadermember->isInvitation = 0;
                $projectleadermember->designation_id = $projectmanagerId;
                $projectleadermember->memberId = $projectleader;
                $projectleadermember->joinDate = $projectObject->createDate;
                $this->ProjectMember->save($projectleadermember);
                $this->projectUpdatedNotification($clientmember->memberId, $projectId);

            }

            elseif(!empty($projectleader) && !empty(existingleader) && $projectleader != $existingleader->memberId) {
                $this->ProjectMember->delete($existingleader);
                $projectleadermember = $this->ProjectMember->newEntity();
                $projectleadermember->projectId = $projectId;
                $projectleadermember->accessLevel = 1;
                $projectleadermember->isInvitation = 0;
                $projectleadermember->designation_id = $projectmanagerId;
                $projectleadermember->memberId = $projectleader;
                $projectleadermember->joinDate = $projectObject->createDate;
                $this->ProjectMember->save($projectleadermember);
                $this->projectAssignedNotification($clientmember->memberId, $projectId);
            }

            $projectteam =  $this->request->getData('editprojectmembers');

            $existinteam = $this->ProjectMember->find('all',[
                'conditions' => [
                    'projectId' => $projectId,
                ]
            ])->toArray();
            $memberids = array();
            foreach($existinteam as $team){
                array_push($memberids, $team->memberId);
            }


            if (!empty($projectteam)) {

                foreach ($projectteam as $member) {
                    if (!in_array($memberids, $member)) {
                        $member = $this->ProjectMember->newEntity();
                        $member->projectId = $projectId;
                        $member->accessLevel = 1;
                        $member->isInvitation = 0;
                        $member->designation_id = $developerId;
                        $member->memberId = intval($member);
                        $member->joinDate = $projectObject->createDate;
                        $this->ProjectMember->save($member);
                        $this->projectUpdatedNotification($clientmember->memberId, $projectId);
                    }
                }
            }

            $this->ProjectObject->save($projectObject);
            if ($this->ProjectObject->save($projectObject)) {
                $projectId = $projectObject->get('id');

                if ($projectObject->fatherId != 0) {                                                                                     //setto superCode e level
                    $father = $this->ProjectObject->get($projectObject->fatherId);
                    $projectObject->superCode = $father->superCode . "/" . $projectId;
                    $projectObject->level = $father->level + 1;
                } else {
                    $projectObject->superCode = "/" . $projectId;
                    $projectObject->level = 0;
                }
                $secondSave = $this->ProjectObject->save($projectObject);
            }


            if ($url) {
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'view',
                    $pid
                ]);
            }elseif(!empty($archieveprojects)){
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'archieve_projects',
                     $authuser->choosen_companyId
                ]);

            }

            elseif ($admin != null) {
                return $this->redirect([
                    'controller' => 'companiesUser',
                    'action' => 'companydashboard',
                ]);
            } elseif ($userprofile != null) {
                return $this->redirect([
                    'controller' => 'user',
                    'action' => 'userprofile',
                    $user_id
                ]);
            } elseif($projectlists){
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'projectlists',
                    'companyId' => $authuser->choosen_companyId,
                    'type' => $projectObject->visibility
                ]);
              }  elseif($projectreports){
                    return $this->redirect([
                        'controller' => 'projectObject',
                        'action' => 'projectReports',
                        $authuser->choosen_companyId
                    ]);

            }   elseif($projectcategoryview){
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'projectcategoryview',
                    'companyId' => $authuser->choosen_companyId,
                    'status' => $projectObject->status
                ]);

        }
            elseif($rendercompanyId){
                return $this->redirect([
                    'controller' => 'Usercompanies',
                    'action' => 'view',
                    $rendercompanyId

                ]);

            }

            else {

                return $this->redirect($this->referer());

            }
        }
    }

    /*taskgroupDetails*/
    public function taskgroupDetails()
    {
        $tgroupId = $this->request->getData('tsgrouptype');
        $this->loadModel('Taskgroups');
        $taskgroup = $this->Taskgroups->find('all', [
            'conditions' => [
                'id' => $tgroupId
            ]
        ])->first();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($taskgroup));
    }


    /**Archieved Tickets */
    public function archievedTickets($pid = null)
    {
        $this->loadModel('Projecttasks');
        $archieved = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $pid,
                'status' => 'A'
            ]
        ])->toArray();
        $this->set(compact('archieved'));
    }





    //ProjectObject Comment Section
    public function comments()
    {
        $pid = $this->request->getQuery('projectId');
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');
        $this->loadModel('Comments');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $user_id = $this->Auth->user('id');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $pid
            ]
        ])->first();
        $totaltasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $pid,
                'type' => 'TS',
                'isDeleted' => false
            ]
        ])->toArray();
        $total = count($totaltasks);
        $allcomments = $this->Comments->find('all', [
            'conditions' => [
                'comment_id is' => null,
            ]
        ])->order(['creation_date' => 'ASC'])->contain([
            'Replies',
            'Replies.Taskfiles',
            'Replies.User',
            'User',
            'Taskfiles'
        ])->toArray();
        foreach ($allcomments as $comment) {
            $comment->creation_date = $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            if ($comment->last_update != null) {
                $comment->last_update = $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            }
        }
        $userData = $this->User->find('all')->toArray();
        $this->set(compact('allcomments', 'total', 'totaltasks', 'projectObject', 'user_id', 'userData'));
    }


    //method for document.reday for all projects
    public function docallprojects()
    {
        $this->loadModel('ProjectObject');
        $projectObjects = $this->ProjectObject->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->order(['createDate' => 'ASC'])->toArray();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($projectObjects));
    }



    /**Taskboard */
    public function taskboard($id = null)
    {
        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('Departments');
        $this->loadModel('CompaniesUsers');
        $this->loadmodel('Projecttasks');
        $user_id = $this->Auth->user('id');
        $userData = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $userData->choosen_companyId,
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['User','Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();

        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.id in' => $id
            ]
        ])->contain([
            'Projecttypes',
            'Projectfiles',
            'Projecttasks' => function ($q) {
                return $q->where([
                    'isDeleted' => false
                ])->contain(['EpictasksProjecttasks',
                'EpictasksProjecttasks.Projecttask',
                'Subtasks',
                'Subtasks.Epictasks'
                ])->order(['Projecttasks.index_number' => 'ASC']);
            },
            'Projecttasks.Taskusers.User',
            'Projectmembers.User',
            'Projectmembers.Designations',
            'Taskgroups'
        ])->first();

        $epictasks = $this->Projecttasks->find('all',[
            'conditions' => [
                'Projecttasks.isDeleted' => false,
                'Projecttasks.isEpic' => true
            ]
        ])->toArray();

        $data2 = $this->ProjectMember->find(
            'all',
            [
                'conditions' => [
                    'memberId' => $user_id
                ]
            ]
        )->contain('Designations')->first();


        $departments = $this->Departments->find('all',[
            'conditions' => [
                'company_id' => $userData->choosen_companyId
            ]
        ])->toArray();
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $userData->choosen_companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();
        $alltickets = null;
        $this->set(compact('companymembers','epictasks', 'user_id', 'projectObject', 'data2','alltickets', 'departments', 'userData','authcompanymember'));
    }



    /**Projectlist method */
    public function projectlists()
    {
        $this->loadModel('User');
        $this->loadModel('Projecttypes');
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectMember');

        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');

        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $user_id = $this->Auth->user('id');
        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId,
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['User','Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();

        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User','Designations'])->toArray();

        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $user_id
            ]
        ])->toArray();
        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }
        $unique_projectids = null;
        $unique_projectids = array_unique($all_projectids);
        if (!empty($unique_projectids)) {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $unique_projectids,
                    'isDeleted' => false,
                     'company_id' => $companyId
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
        }else{
            $projectObjects = null;
        }


        $this->set(compact('projectObjects', 'projecttypes','companymembers', 'type', 'companyId', 'authcompanymember'));
    }


    /**Send Summary to Customer */

    public function sendsummary($pid = null)
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('Taskgroups');
        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $this->loadModel('Contracts');
        $this->loadModel('Notifications');
        $content = $this->request->getData('content');
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
        $groupoftask = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' => $pid
            ]
        ])->toArray();
        $projecttask = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $pid
            ]
        ])->toArray();
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $pid
            ]
        ])->first();
        $projectMember = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $projectObject->id
            ]
        ])->contain([
            'Designations'=> function ($q) {
                return $q->where([
                   'name !=' => 'Customer'
                ]);
            },
        ])->toArray();
        $userid = array();
        foreach ($projectMember as $item) {
            array_push($userid, $item['memberId']);
        }
        $res = $this->User->find('all', [
            'conditions' => [
                'id in' => $userid
            ]
        ])->toArray();

        $customers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $projectObject->id
            ]
        ])->contain([
            'Designations'=> function ($q) {
                return $q->where([
                   'name is' => 'Customer'
                ]);
            },
        ])->toArray();
        $customerid = array();
        foreach ($customers as $customer) {
            array_push($customerid, $customer['memberId']);
        }
        $unique_customerid = array_unique($customerid);

        if (!empty($unique_customerid)) {
            $users = $this->User->find('all', [
                'conditions' => [
                    'id in' => $unique_customerid
                ]
            ])->toArray();
        } else {
            $users = null;
        }
        $contract = $this->Contracts->newEntity();
        $names = '';
        foreach ($res as $item) {
            $names .=   $item->firstname . ' ';
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
        $CakePdf->template('summary', 'default');
        $CakePdf->viewVars(['res' => $res, 'projectMember' => $projectMember, 'projectObject' => $projectObject, 'manyObject' => $manyObject, 'groupoftask' => $groupoftask, 'projecttask' => $projecttask, 'user' => $users, 'content' => $content, 'contract' => $contract]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $destinationFolder = WWW_ROOT . "assets" . DS . "summarycontracts" . DS . "project_" .  $pid;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder);
        }
        $file = "contract_user_" . $user_id . "_project_" . $pid . ".pdf";
        $filename = $destinationFolder . DS . "contract_user_" . $user_id . "_project_" . $pid . ".pdf";
        file_put_contents($filename, $pdf);

        $contract->project_object_id = $pid;
        $contract->title = $projectObject->summary_title;
        $contract->description = $projectObject->summary_description;
        $contract->listof_members = $names;
        $contract->content = $content;
        $contract->creation_date = Time::now();
        $contract->acceptance_date = null;
        $contract->contract_filename = $file;
        $contract->contract_filepath = $destinationFolder;
        $contract->price = $projectObject->price;
        $contract->tax = $projectObject->tax;
        $contract->total_workinghrs = $projectObject->total_workinghrs;

        $this->Contracts->save($contract);
        if ($users != null) {
            foreach ($users as $user) {
                //Notifications
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = null;
                $notification->action_status = 'sending'; // $leave->status;//New
                $notification->action_description = 'Project Summary';
                $notification->action_id = $pid;
                $notification->creation_date = Time::now();
                $notification->touser_id = $user->id;
                $notification->type = 'mail';
                $this->Notifications->save($notification);

                //External Mail
                $email = new Email();

                $protocol = Configure::read('Protocol');
                $domain = Configure::read('Domain');
                $port = Configure::read('Port');
                if ($user)
                    $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                      //  ->setTo('ankoosh.sk@gmail.com')
                        -> setTo($user->email)
                        ->setEmailFormat('html')
                        ->setSubject('Summary of the the Project')
                        ->setTemplate('summary', 'default')
                        ->setAttachments([
                            'contractsummary.pdf' => [
                                'file' =>   $filename,
                                'mimetype' => 'pdf'
                            ]
                        ])

                        ->setViewVars(['projectObject' => $projectObject, 'user' => $user, 'content' => $content, 'contract' => $contract, 'protocol' => $protocol, 'domain' =>  $domain, 'port' => $port]);
                $email->send();
            }

            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'summaryPrices',
                'projectId' => $pid
            ]);
        } else {
            $this->Flash->error(__('No Customer Data'));
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'summaryPrices',
                'projectId' => $pid
            ]);
        }
    }


    /**Summary Title and Description Update */
    public function summaryUpdates()
    {
        $pid = $this->request->getData('pid');
        $title = $this->request->getData('title');
        $description = $this->request->getData('description');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $pid
            ]
        ])->first();
        $projectObject->summary_title = $title;
        $projectObject->summary_description = $description;
        $this->ProjectObject->save($projectObject);
        return $this->redirect([
            'controller' => 'ProjectObject',
            'action' => 'summaryPrices',
            'projectId' => $pid
        ]);
    }

    //download summaryof project

    public function downloadFile($id = null)
    {
        $fileinfo = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $file = $fileinfo->summaryfilepath . DS . $fileinfo->summaryfilename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

        return $response;
    }


    /* Contractsummary */
    public function contractsummary()
    {

        $pid = $this->request->getQuery('projectId');
        $contractId = $this->request->getQuery('contractId');




        $this->loadModel('User');

        $this->loadModel('ProjectObject');
        $this->loadModel('Contracts');
        $this->loadModel('VersionsContract');
        $user_id = $this->Auth->User('id');

        $projectObject =  $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.id in' => $pid
            ]
        ])->contain([
            'Contracts' => function ($q) {
                return $q->where([
                    'acceptance_date is not' => null
                ])->order([
                    'creation_date' => 'DESC'
                ]);
            },
            'Contracts.Versions'=> function ($q) {
                return $q->where([
                    'acceptance_date is not' => null
                ])->order([
                    'creation_date' => 'DESC'
                ]);
            },
            'Projecttypes',
            'Projectfiles',
            'Projecttasks' => function ($q) {
                return $q->where([
                    'Projecttasks.isDeleted' => false
                ]);
            },
            'Projectmembers.User',
            'Taskgroups.Projecttasks' => function ($q) {
                return $q->where([
                    'Projecttasks.isDeleted' => false
                ]);
            },
        ])->first();

        $this->set(compact('projectObject', 'contractId'));
    }



    /*   Summary Prices*/
    public function summaryPrices()
    {
        $pid = $this->request->getQuery('projectId');
        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $user_id = $this->Auth->user('id');

        //Thi is for pid from Summaryupdate method


           $this->loadModel('ProjectMember');
            $data2 = $this->ProjectMember->find(
                'all',
                [
                    'conditions' => [
                        'memberId' => $user_id
                    ]
                ]
            )->first();
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id' => $pid,
                    'isDeleted' => false
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
                'Taskgroups.Projecttasks' => function ($q) {
                    return $q->where([
                        'Projecttasks.isDeleted' => false
                    ]);
                },
            ])->first();

        //make summary as summarypdf

        $customers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $pid
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
            ])->toArray();
            $customerid = array();
            foreach ($customers as $customer) {
                array_push($customerid, $customer['memberId']);
            }
            $unique_customerid = array_unique($customerid);
            if (!empty($unique_customerid)) {
                $users = $this->User->find('all', [
                    'conditions' => [
                        'id in' => $unique_customerid
                    ]
                ])->toArray();
            } else {
                $users = null;
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
            $CakePdf->template('projectsummary', 'default');
            $CakePdf->viewVars(['projectObject' => $projectObject, 'user' => $users]);
            // Get the PDF string returned
            $pdf = $CakePdf->output();
            $destinationFolder = WWW_ROOT . "assets" . DS . "summaryofproject";
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder);
            }
            $filename = "project_" . $pid . ".pdf";
            $file = $destinationFolder . DS . $filename;
            file_put_contents($file, $pdf);
            $projectObject->summaryfilepath = $destinationFolder;
            $projectObject->summaryfilename = $filename;
            $this->ProjectObject->save($projectObject);
            $this->set(compact('projectObject', 'data2', 'users'));

    }






    //searchfilter method

    public function projectsearchfilter()
    {

        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttypes');
        $this->loadModel('CompaniesUser');
        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $companyId = $this->request->getQuery('companyId');
        $visibility = $this->request->getQuery('visibility');
        $projectname =  $this->request->getQuery('projectname');
        $employeename = $this->request->getQuery('employeename');
        $projecttype = $this->request->getQuery('projecttype');

        $user_id = $this->Auth->user('id');

        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId,
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['User','Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();





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

        if ($companyId != null) {
            if (!empty($unique_projectids)) {
                if(!empty($visibility)){
                    $allprojects = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $unique_projectids,
                            'isDeleted' => false,
                            'visibility' => $visibility,
                            'isFuturedProject' => false,
                            'company_id' => $companyId
                        ]
                    ])->contain(['Projecttypes', 'Projectmembers.User'])->toArray();

                }else{
                    $allprojects = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $unique_projectids,
                            'isDeleted' => false,
                            'isFuturedProject' => false,
                            'company_id' => $companyId
                        ]
                    ])->contain(['Projecttypes', 'Projectmembers.User'])->toArray();

                }



                if (!empty($projectname) && !empty($employeename) && !empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ((preg_match("/{$projectname}/i", $singleproject->name)) && $singleproject->type == $projecttype) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        }
                    }
                } elseif (!empty($projectname) && !empty($employeename) && empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ((preg_match("/{$projectname}/i", $singleproject->name))) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        }
                    }
                } elseif (!empty($projectname) && empty($employeename) && !empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ((preg_match("/{$projectname}/i", $singleproject->name)) && $singleproject->type == $projecttype) {
                            array_push(
                                $matchedprojectids,
                                $singleproject->id
                            );
                        }
                    }
                } elseif (empty($projectname) && !empty($employeename) && !empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ($singleproject->type == $projecttype) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        }
                    }
                } elseif (!empty($projectname) || !empty($employeename) || !empty($projecttype)) {
                    $matchedprojectids = array();

                    foreach ($allprojects as $singleproject) {

                        if (!empty($projectname) && preg_match("/{$projectname}/i", $singleproject->name)) {
                            array_push(
                                $matchedprojectids,
                                $singleproject->id
                            );
                        } elseif (!empty($employeename)) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        } elseif (!empty($projecttype) && $singleproject->type == $projecttype) {
                            array_push(
                                $matchedprojectids,
                                $singleproject->id
                            );
                        }
                    }
                }

                if(!empty($matchedprojectids)){
                    $projectObjects = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $matchedprojectids
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


                    $total = count($projectObjects);

                }else{
                    $projectObjects = null;
                    $total = 0;

                }
            }
            $companymembers = $this->CompaniesUser->find('all',[
                'conditions' => [
                    'company_id' => $companyId
                ]
            ])->contain(['Designations','User'])->toArray();



            $this->set(compact('projectname','employeename','projecttype','companyId', 'projectObjects', 'total', 'companymembers', 'visibility', 'projecttypes', 'authcompanymember'));


        } else {
            $companymembers = null;
            $authcompanymember = null;

            if (!empty($unique_projectids)) {
                if(!empty($visibility)){
                    $allprojects = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $unique_projectids,
                            'isDeleted' => false,
                            'visibility' => $visibility,
                            'isFuturedProject' => false,
                        ]
                    ])->contain(['Projecttypes', 'Projectmembers.User'])->toArray();

                }else{
                    $allprojects = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $unique_projectids,
                            'isDeleted' => false,
                            'isFuturedProject' => false,
                        ]
                    ])->contain(['Projecttypes', 'Projectmembers.User'])->toArray();

                }



                if (!empty($projectname) && !empty($employeename) && !empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ((preg_match("/{$projectname}/i", $singleproject->name)) && $singleproject->type == $projecttype) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        }
                    }
                } elseif (!empty($projectname) && !empty($employeename) && empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ((preg_match("/{$projectname}/i", $singleproject->name))) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        }
                    }
                } elseif (!empty($projectname) && empty($employeename) && !empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ((preg_match("/{$projectname}/i", $singleproject->name)) && $singleproject->type == $projecttype) {
                            array_push(
                                $matchedprojectids,
                                $singleproject->id
                            );
                        }
                    }
                } elseif (empty($projectname) && !empty($employeename) && !empty($projecttype)) {
                    $matchedprojectids = array();
                    foreach ($allprojects as $singleproject) {
                        if ($singleproject->type == $projecttype) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        }
                    }
                } elseif (!empty($projectname) || !empty($employeename) || !empty($projecttype)) {
                    $matchedprojectids = array();

                    foreach ($allprojects as $singleproject) {

                        if (!empty($projectname) && preg_match("/{$projectname}/i", $singleproject->name)) {
                            array_push(
                                $matchedprojectids,
                                $singleproject->id
                            );
                        } elseif (!empty($employeename)) {
                            foreach ($singleproject->projectmembers as $projectmember) {
                                if ((preg_match("/{$employeename}/i", $projectmember->user->firstname)) || (preg_match("/{$employeename}/i", $projectmember->user->lastname))) {
                                    array_push(
                                        $matchedprojectids,
                                        $singleproject->id
                                    );
                                }
                            }
                        } elseif (!empty($projecttype) && $singleproject->type == $projecttype) {
                            array_push(
                                $matchedprojectids,
                                $singleproject->id
                            );
                        }
                    }
                }

                if(!empty($matchedprojectids)){
                    $projectObjects = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $matchedprojectids
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


                    $total = count($projectObjects);

                }else{
                    $projectObjects = null;
                    $total = 0;

                }

            }
            $this->set(compact('projectname','employeename','projecttype','companyId', 'authcompanymember', 'projectObjects', 'total', 'companymembers', 'visibility', 'projecttypes'));
        }
    }







    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');
        $this->loadModel('Projecttypes');
        $this->loadModel('ProjectObject');
        $this->loadModel('User');
        $this->loadModel('Projecttasks');
        $this->loadModel('Projectfiles');
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectMember');
        $user_id = $this->Auth->user('id');
        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.company_id' => $companyId,
                'CompaniesUser.user_id' => $user_id
            ]
        ])->contain(['User','Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();

        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $user_id
            ]
        ])->toArray();
        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }
        $unique_projectids = null;
        $unique_projectids = array_unique($all_projectids);

        if ($companyId != null) {
            $this->loadModel('CompaniesUser');
            $companymembers = $this->CompaniesUser->find('all',[
                'conditions' => [
                    'company_id' => $companyId
                ]
            ])->contain(['User', 'Designations'])->toArray();
            if ($unique_projectids != null) {
                $projectObjects = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'ProjectObject.id in' => $unique_projectids,
                        'isDeleted' => false,
                        'visibility' => $type,
                        'isFuturedProject' => false,
                        'isArchieveAllowed' => false,
                        'company_id' => $companyId
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
                $total = count($projectObjects);
            } else {
                $projectObjects = null;
                $total = null;
            }
        } else {
            if ($unique_projectids != null) {
                $projectObjects = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'ProjectObject.id in' => $unique_projectids,
                        'isDeleted' => false,
                        'visibility' => $type,
                        'isPersonal' => true
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

                $total = count($projectObjects);
                $companymembers = null;
            } else {
                $projectObjects = null;
                $total = null;
                $companymembers = null;

            }
        }
        $this->set(compact('companymembers','projecttypes','projectObjects', 'total', 'authcompanymember', 'type', 'companyId'));

    }







    /**
     * View method
     *
     * @param string|null $id Project Object id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    /**filter */
    public function filtertags()
    {
        $tagvalue = $this->request->getData('tagvalue');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $choosencompanyusers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->toArray();

        $companyusers = array();
        foreach ($choosencompanyusers as $user) {
            array_push($companyusers, $user->user_id);
        }

        $allUser = $this->User->find('all', [
            'conditions' => [
                'id in' => $companyusers,
                'tags like' => '%;' . $tagvalue . ';%'
            ]
        ])->toArray();

        $total = count($allUser);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($allUser));
    }
    public function alluserfiltertags()
    {
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
        ])->toArray();
        $tagvalue = $this->request->getData('tagvalue');


        if(!empty($companymembers)){
            $memberIds = array();
            foreach($companymembers as $member){
                array_push($memberIds, $member->user_id);
            }
            $allUser = $this->User->find('all', [
                'conditions' => [
                    'id not in' => $memberIds,
                    'tags like' => '%;' . $tagvalue . ';%'
                ]
            ])->toArray();
        }else{
            $allUser = $this->User->find('all', [
                'conditions' => [

                    'tags like' => '%;' . $tagvalue . ';%'
                ]
            ])->toArray();

        }

        $this->loadModel('User');
        $total = count($allUser);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($allUser));
    }





    //projectreports
    public function projectReports($companyId = null)
    {
        $this->loadModel('Projecttypes');
        $projecttypes = $this->Projecttypes->find('all')->toArray();

        $projectObjects = $this->ProjectObject->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'isDeleted' => false
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
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();
        $type = null;
        $total = count($projectObjects);


        $this->set(compact('projectObjects', 'companyId','projecttypes', 'type','total','companymembers'));
    }


    //Projectcategorized view in ProjectReports Page
    public function projectcategoryview(){
        $this->loadModel('Projecttypes');
        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $companyId = $this->request->getQuery('companyId');
        $status = $this->request->getQuery('status');
        $projectObjects = $this->ProjectObject->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'isDeleted' => false,
                'status' => $status
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
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();
        $type = null;


        $this->set(compact('projectObjects', 'companyId', 'projecttypes', 'companymembers', 'type'));



    }


    public function search()
    {
        $userId = $this->Auth->user('id');

        $this->loadModel('ProjectObject');
        $this->loadModel('User');
        $this->loadModel('Usercompanies');
        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttypes');

        $searchkeyword = $this->request->getQuery('searchelement');

        $input_keyword = $this->request->getQuery('input_keyword');


        if (!empty($input_keyword) &&  $searchkeyword == null) {
            $searchkeyword = $input_keyword;
        }

        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $userId
            ]
        ])->first();
        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $userId
            ]
        ])->toArray();

        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }
        $unique_projectids = null;
        $unique_projectids = array_unique($all_projectids);
        $allprojectmembers = $this->ProjectMember->find('all')->contain(['User'])->toArray();

            if ($authuser->choosen_companyId != null) {
                $allprojects = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'ProjectObject.id in' => $unique_projectids,
                        'isDeleted' => false,
                        'company_id' => $authuser->choosen_companyId
                    ]
                ])->contain([
                    'Projecttypes',
                    'Projectfiles',
                    'Projectmembers.User',
                    'Projecttasks' => function ($q) {
                        return $q->where([
                            'isDeleted' => false
                        ]);
                    }

                ])->toArray();

                $matchedprojects = array();
                foreach ($allprojects as $singleproject) {
                    if (preg_match("/{$searchkeyword}/i", $singleproject->name)) {
                        array_push(
                            $matchedprojects,
                            $singleproject->id
                        );
                    }
                }

                foreach ($allprojectmembers as $member) {
                    if (preg_match("/{$searchkeyword}/i", $member->user->firstname)) {
                        array_push(
                            $matchedprojects,
                            $member->projectId
                        );
                    } elseif (preg_match("/{$searchkeyword}/i", $member->user->lastname)) {
                        array_push(
                            $matchedprojects,
                            $member->projectId
                        );
                    }
                }

                if (!empty($matchedprojects)) {
                    $uniqueprojectids = array_unique($matchedprojects);
                    $allmatchedproject = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $uniqueprojectids,
                            'isDeleted' => false,
                            'company_id' => $authuser->choosen_companyId
                        ]
                    ])->contain([
                        'Projecttypes',
                        'Projectfiles',
                        'Projectmembers.User',
                        'Projecttasks' => function ($q) {
                            return $q->where([
                                'isDeleted' => false
                            ]);
                        }

                    ])->toArray();
                } else {
                    $allmatchedproject = null;
                }

                $this->loadModel('CompaniesUser');
                $allcompanyusers = $this->CompaniesUser->find('all', [
                    'conditions' => [
                        'company_id ' => $authuser->choosen_companyId
                    ]
                ])->contain(['User', 'Usercompanies'])->toArray();
                $matchedusers = array();
                foreach ($allcompanyusers as $companyuser) {
                    if ((preg_match("/{$searchkeyword}/i", $companyuser->user->firstname)) || (preg_match("/{$searchkeyword}/i", $companyuser->user->lastname))) {
                        array_push(
                            $matchedusers,
                            $companyuser
                        );
                    }
                }
            } else {
                debug('private');exit;

                $allusers = $this->User->find('all')->toArray();
                $allprojects = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'id in' => $unique_projectids,
                        'isDeleted' => false,
                    ]
                ])->toArray();
                $matchedprojects = array();
                foreach ($allprojects as $singleproject) {
                    if (preg_match("/{$searchkeyword}/i", $singleproject->name)) {
                        array_push(
                            $matchedprojects,
                            $singleproject->id
                        );
                    }
                }

                foreach ($allprojectmembers as $member) {
                    if (preg_match("/{$searchkeyword}/i", $member->user->firstname)) {
                        array_push(
                            $matchedprojects,
                            $member->projectId
                        );
                    } elseif (preg_match("/{$searchkeyword}/i", $member->user->lastname)) {
                        array_push(
                            $matchedprojects,
                            $member->projectId
                        );
                    }
                }


                if (!empty($matchedprojects)) {
                    $uniqueprojectids = array_unique($matchedprojects);
                    $allmatchedproject = $this->ProjectObject->find('all', [
                        'conditions' => [
                            'ProjectObject.id in' => $uniqueprojectids,
                            'isDeleted' => false,
                            'company_id is' => null
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
                    $allmatchedproject = null;
                }

                $this->loadModel('CompaniesUser');
                $allcompanyusers = null;
                $matchedusers = array();
                foreach ($allusers as $user) {
                    if ((preg_match("/{$searchkeyword}/i", $user->firstname)) || (preg_match("/{$searchkeyword}/i", $user->lastname))) {
                        array_push(
                            $matchedusers,
                            $user
                        );
                    }
                }
            }
         //  debug($allmatchedproject);
          //  debug($matchedusers);exit;

        $this->set(compact('searchkeyword', 'allmatchedproject', 'userId',  'input_keyword', 'matchedusers', 'allcompanyusers'));
    }


    //deletefile
    public function deletefile()
    {
        if ($this->request->is('ajax')) {
            $this->loadModel('Projectfiles');
            $fid = $this->request->getData('fid');
            $pid = $this->request->getData('pid');
            $fileinfo = $this->Projectfiles->find('all', [
                'conditions' => [
                    'id' => $fid,
                    'isDeleted' => false
                ]
            ])->first();
            $fileinfo->isDeleted = true;
            $this->Projectfiles->save($fileinfo);
            $file = WWW_ROOT . str_replace('/', '\\', $fileinfo->filepath . DS . $fileinfo->filename);
            $result = unlink($file);
            $allprojectfiles = $this->Projectfiles->find('all', [
                'conditions' => [
                    'project_id' => $pid,
                    'isDeleted' => false
                ]
            ])->toArray();
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($allprojectfiles));
        }
        $this->loadModel('Projectfiles');
        $fid = $this->request->getQuery('fileId');
        $pid = $this->request->getQuery('pid');

        $fileinfo = $this->Projectfiles->find('all', [
            'conditions' => [
                'id' => $fid,
                'isDeleted' => false
            ]
        ])->first();
        $fileinfo->isDeleted = true;
        $this->Projectfiles->save($fileinfo);
        //  $file = WWW_ROOT . str_replace('/', '\\', $fileinfo->filepath . DS . $fileinfo->filename);
        $file = WWW_ROOT . $fileinfo->filepath . DS . $fileinfo->filename;
        $result = unlink($file);
        return $this->redirect(['controller' => 'projectObject', 'action' => 'view', $pid]);
    }



    //projectobject view
    public function view($id = null)
    {
        $this->loadModel('User');
        $this->loadModel('Projecttypes');
        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('Taskgroups');
        $this->loadModel('VersionsContract');
        $this->loadModel('Departments');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectMember');
        $user_id = $this->Auth->user('id');

        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $userData = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $userData->choosen_companyId,
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['User','Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();
        $departments = $this->Departments->find('all',[
            'conditions' => [
                'company_id' => $userData->choosen_companyId
            ]
        ])->contain(['Designations'])->toArray();

        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $userData->choosen_companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();

        $companyusers = array();
        foreach ($companymembers as $user) {
            array_push($companyusers, $user->user_id);
        }

        $member_role = $this->ProjectMember->find(
            'all',
            [
                'conditions' => [
                    'memberId' => $user_id
                ]
            ]
        )->contain('Designations')->first();

        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.id in' => $id
            ]
        ])->contain([
            'User',
            'Projecttypes',
            'Projectfiles',
            'Projecttasks' => function ($q) {
                return $q->where([
                    'isDeleted' => false
                ]);
            },
            'Projecttasks.Taskusers.User',
            'Projectmembers.User',
            'Projectmembers.Designations',
            'Contracts' => function ($q) {
                return $q->where([
                    'acceptance_date is not' => null
                ])->order([
                    'creation_date' => 'DESC'
                ]);
            },
            'Contracts.Versions' => function ($q) {
                return $q->where([
                    'acceptance_date is not' => null
                ])->order([
                    'creation_date' => 'DESC'
                ]);
            },

        ])->first();
        $type = $projectObject->visibility;

        $this->set(compact('projectObject', 'member_role', 'userData', 'companymembers', 'projecttypes', 'departments', 'type', 'authcompanymember'));
    }





    public function updatepriority()
    {
        $this->loadModel('ProjectObject');
        $pid = $this->request->getData('pid');
        $priority = $this->request->getData('priority');
        $project = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $pid
            ]
        ])->first();
        $project->priority = $priority;
        $this->ProjectObject->save($project);
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($project));
    }

    public function updatestatus()
    {
        $this->loadModel('ProjectObject');
        $pid = $this->request->getData('pid');
        $status = $this->request->getData('status');

        $project = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $pid
            ]
        ])->first();
        $project->status = $status;
        $this->ProjectObject->save($project);

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($project));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectObject = $this->ProjectObject->newEntity();
        if ($this->request->is('post')) {
            $projectObject = $this->ProjectObject->patchEntity($projectObject, $this->request->getData());
            if ($this->ProjectObject->save($projectObject)) {
                $this->Flash->success(__('The project object has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project object could not be saved. Please, try again.'));
        }
        $this->set(compact('projectObject'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Object id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */


    public function edit($id = null)
    {
        $projectObject = $this->ProjectObject->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectObject = $this->ProjectObject->patchEntity($projectObject, $this->request->getData());
            if ($this->ProjectObject->save($projectObject)) {
                $this->Flash->success(__('The project object has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project object could not be saved. Please, try again.'));
        }
        //$this->set(compact('projectObject'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Project Object id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteproject()
    {
        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');


        $pid = $this->request->getData('pid');
        $tag = $this->request->getData('tag');
        $rendercompanyId = $this->request->getData('rendercompanyId');
        $userprofile = $this->request->getData('userprofile');
        $projectreports = $this->request->getData('projectreports');
        $projectcategoryview = $this->request->getData('projectcategoryview');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $this->loadModel('ProjectObject');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' =>  $pid
            ]
        ])->contain(['ProjectMembers'])->first();

        foreach ($projectObject->projectmembers as $projectmember) {
            $this->projectDeletedNotification($projectmember->memberId, $pid);
        }
        $projectObject->isDeleted = true;
        $this->ProjectObject->save($projectObject);

       if($rendercompanyId){
            return $this->redirect([
                'controller' => 'Usercompanies',
                'action' => 'view',
                $rendercompanyId
            ]);

        }elseif($projectcategoryview){
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'projectcategoryview',
                'status' => $projectObject->status
            ]);

        }

        elseif($projectreports){
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'project-reports',
                $authuser->choosen_companyId
            ]);

        }
        elseif($userprofile){
            return $this->redirect([
                'controller' => 'ProjectMember',
                'action' => 'userprofile',
                $authuser->id
            ]);

        }
         else {
            return $this->redirect($this->referer());
        }
    }


    public function isAuthorized($user)
    {
        return true;
    }



    /*Delete ProjectMember*/
    public function deleteProjectusers()
    {
        $this->loadModel('ProjectMember');
        $memberId = $this->request->getQuery('memberId');
        $pid = $this->request->getQuery('pid');

        //delete user for task
        $this->loadModel('Taskusers');
        $taskusers = $this->Taskusers->find('all', [
            'assignee_id' => $memberId
        ])->toArray();

        //debug($taskusers);exit;
        foreach ($taskusers as $taskuser) {
            $this->Taskusers->delete($taskuser);
        }

        //delete user for project
        $projectMember = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $pid,
                'memberId' => $memberId,
            ]
        ])->first();
        $this->ProjectMember->delete($projectMember);
        return $this->redirect(['controller' => 'projectObject', 'action' => 'view', $pid]);
    }


    public function getProjectsOwnedByUser()
    {

        if ($this->request->is('post')) {
            $this->autoRender = false;
            $page = $this->request->getData('page');
            $limit = $this->request->getData('limit');

            if ($page != null || $limit != null) {

                $queryProject = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'creatorId = ' . $this->Auth->user('id'),
                        'isDeleted' => false
                    ],
                ])->order('name')->limit(6)->page($page)->toArray();
                $nextPage = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'creatorId = ' . $this->Auth->user('id'),
                        'isDeleted' => false
                    ],
                ])->order('name')->limit(6)->page(++$page)->toArray();

                $next = count($nextPage);
                $gr = [];
                $gr['projects'] = $queryProject;
                $gr['nextPage'] = $next;
            } else {
                $queryProject = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'creatorId = ' . $this->Auth->user('id'),
                        'isDeleted' => false
                    ],
                ])->order('name')->toArray();

                $gr = [];
                $gr['projects'] = $queryProject;
            }
            echo json_encode($gr);
        } else {
            $queryProject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'creatorId = ' . $this->Auth->user('id'),
                    'isDeleted' => false
                ],
            ])->order('name')->toArray();

            $result = $queryProject;
            return $result;
        }
    }

    public function getProjectsMemberedByUser($school = 0)
    {
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $page = $this->request->getData('page');
            $limit = $this->request->getData('limit');
            $school = $this->request->getData('study');
            $gr = [];

            if ($school) {
                // proposta di corso
                $gr['projects-mine'] = $this->ProjectObject->find('all', array(
                    'conditions' => array(
                        'isSchool = "1" AND ' .
                            'creatorId = ' . $this->Auth->user('id')
                    )
                ));
                $gr['projects-other'] = $this->ProjectObject->find('all', array(
                    'conditions' => array(
                        'isSchool = "1" AND ' .
                            'creatorId != ' . $this->Auth->user('id')
                    )
                ));
            } else {
                if ($page != null || $limit != null) {
                    $userInProject = $this->ProjectObject->find('all', array(
                        'join' => array(
                            'table' => 'project_member',
                            'alias' => 'gm',
                            'type' => 'inner',
                            'conditions' => array('gm.projectId = ProjectObject.id
                                                AND gm.memberType ="U"
                                                AND memberId=' . $this->Auth->user('id') . '
                                                AND creatorId <> ' . $this->Auth->user('id') . '
                                                AND gm.isBanned = false
                                                AND isSchool = ' . $school)
                        )
                    ))->limit(6)->page($page)->toArray();
                    $nextPage = $this->ProjectObject->find('all', array(
                        'join' => array(
                            'table' => 'project_member',
                            'alias' => 'gm',
                            'type' => 'inner',
                            'conditions' => array('gm.projectId = ProjectObject.id
                                                AND gm.memberType ="U"
                                                AND memberId=' . $this->Auth->user('id') . '
                                                AND creatorId <> ' . $this->Auth->user('id') . '
                                                AND gm.isBanned = false
                                                AND isSchool = ' . $school)
                        )
                    ))->limit(6)->page(++$page)->toArray();

                    $next = count($nextPage);

                    $gr = [];
                    $gr['projects'] = $userInProject;
                    $gr['nextPage'] = $next;
                } else {
                    $userInProject = $this->ProjectObject->find('all', array(
                        'join' => array(
                            'table' => 'project_member',
                            'alias' => 'gm',
                            'type' => 'inner',
                            'conditions' => array('gm.projectId = ProjectObject.id
                                                AND gm.memberType ="U"
                                                AND memberId=' . $this->Auth->user('id') . '
                                                AND creatorId <> ' . $this->Auth->user('id') . '
                                                AND gm.isBanned = false
                                                AND isSchool = ' . $school)
                        )
                    ))->toArray();

                    $gr = [];
                    $gr['projects'] = $userInProject;
                }
            }

            echo json_encode($gr);
        } else {
            //$result;
            if ($school) {
                // prendi progetti pubblici senza controllare iscrizioni
                $result = $this->ProjectObject->find('all', array(
                    'conditions' => array(
                        'isSchool = "1"'
                    )
                ))->toArray();
            } else {
                $userInProject = $this->ProjectObject->find('all', array(
                    'join' => array(
                        'table' => 'project_member',
                        'alias' => 'gm',
                        'type' => 'inner',
                        'conditions' => array('gm.projectId = ProjectObject.id

                                            AND memberId=' . $this->Auth->user('id') . '
                                            AND creatorId <> ' . $this->Auth->user('id') . '
                                            AND gm.isBanned = false
                                            AND isSchool = ' . $school)
                    )
                ))->toArray();
                $result = $userInProject;
            }
            return $result;
        }
    }




    public function addProject()
    {
        $this->loadModel('ProjectObject');
        $this->loadModel('Projectfiles');
        $this->loadModel('ProjectMember');


        $projectshek_type = $this->request->getQuery('type');
        $companyId = $this->request->getQuery('companyId');
         $projectlists = $this->request->getData('projectlists');
        $keyforrender = $this->request->getData('keyforrender');
        $futureprojects = $this->request->getData('futureprojects');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $companyId = $authuser->choosen_companyId;
        $projectObject = $this->ProjectObject->newEntity();
        $projectObject->creatorId =  $user_id;
        $projectObject->type = $this->request->getData('projecttype');
        $projectObject->name = $this->request->getData('name');
        $projectObject->description = $this->request->getData('description');
        $startdate = $this->request->getData('startdate');
        $startdate = Time::createFromFormat(
            'd/m/Y',
            $startdate,
            'Europe/Paris'
        );
        if ($startdate->i18nFormat('yyyy-MM-dd') < Time::now()->i18nFormat('yyyy-MM-dd')) {
            $this->Flash->error(__('Start Date Must be Greater or equeal to Today Date !'));
            if (!empty($futureprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'futureprojects', 'companyId' => $companyId, 'type' => $projectshek_type]);
            } elseif (!empty($projectlists)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'projectlists', $companyId]);
            }elseif(!empty($keyforrender)){
                return $this->redirect(['controller' => 'usercompanies','action' => 'view', $companyId]);
            } else {
                return $this->redirect($this->referer());
            }
        }
        $expirydate = $this->request->getData('expirydate');
        $expirydate = Time::createFromFormat(
            'd/m/Y',
            $expirydate,
            'Europe/Paris'
        );
        if ($expirydate->i18nFormat('yyyy-MM-dd') < $startdate->i18nFormat('yyyy-MM-dd')) {
            $this->Flash->error(__('Expiry Date Must be Greater than Start Date !'));
            if (!empty($futureprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'futureprojects', 'companyId' => $companyId, 'type' => $projectshek_type]);
            } elseif (!empty($projectlists)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'projectlists', $companyId]);
            }elseif(!empty($keyforrender)){
                return $this->redirect(['controller' => 'usercompanies','action' => 'view', $companyId]);
            } else {
                return $this->redirect($this->referer());
            }
        }
        $projectObject->startdate = $startdate;
        $projectObject->expirydate = $expirydate;
        $projectObject->description2 = null;
        $projectObject->isDeleted = 0;
        $projectObject->createDate = Time::now();
        $projectObject->visibility = $this->request->getData('visibility');
        $type = $this->request->getData('typeproject');
        if ($type == 'P') {
            $projectObject->isPersonal = 1;
            $projectObject->company_id = null;
        } else {
            $projectObject->isPersonal = 0;
            if ($companyId != null) {
                $projectObject->company_id = $companyId;
            }else{
                $projectObject->company_id = null;
            }
            $projectObject->price = $this->request->getData('price');
            $projectObject->tax = $this->request->getData('tax');
            $projectObject->totalgroups = $this->request->getData('group_slots');
        }
        $projectObject->isRestricted = 0;
        $projectObject->isMembershipRequestAllowed = $this->request->getData('membership_request') === null ? false : true;
        $projectObject->isBanAllowed = $this->request->getData('ban_span') === null ? false : true;
        $projectObject->isInvitationAllowed = $this->request->getData('invitation_span') === null ? false : true;
        $projectObject->isArchieveallowed = $this->request->getData('archieve_projects') === null ? false : true;
        $projectObject->note = null;
        //new fields added
        $projectObject->priority = $this->request->getData('priority');
        if (!empty($futureprojects)) {
            $projectObject->isFuturedProject = true;
        }
        $connection = ConnectionManager::get('default');
        if (empty($connection)) {
            $this->Flash->error(__('A causa di problemi tecnici non è stato possibile creare il progetto. Ti preghiamo di riprovare.'));
            if (!empty($futureprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'futureprojects', 'companyId' => $companyId, 'type' => $projectshek_type]);
            } elseif (!empty($projectlists)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'projectlists', $companyId]);
            }elseif(!empty($keyforrender)){
                return $this->redirect(['controller' => 'usercompanies','action' => 'view', $companyId]);
            } else {
                return $this->redirect($this->referer());
            }
        }
        $connection->begin();
        if ($firstSave = $this->ProjectObject->save($projectObject)) {
            $projectId = $projectObject->get('id');
            //-----------------------------Files-------------------------------->
            $files = $this->request->getData()['images'];
            foreach ($files as $file) {
                if (!empty($file['tmp_name'])) {
                    $projectfiles = $this->Projectfiles->newEntity();
                    $projectfiles->project_id = $projectId;
                    $projectfiles->user_id = $this->Auth->user('id');
                    $projectfiles->type = $file['type'];
                    $projectfiles->size = $file['size'];
                    $projectfiles->filename = $file['name'];
                    $projectfiles->filepath = "assets/projectfiles/" .  $projectId;
                    $destinationFolder = WWW_ROOT . "assets/projectfiles/" .  $projectId;
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                    $this->Projectfiles->save($projectfiles);
                }
            }
            // ------------------------ Images save ends here ------------------
            $team =array();
            $this->loadModel('Departments');
           $companydepartments = $this->Departments->find('all',[
                'conditions' => [
                    'company_id' => $companyId
                ]
            ])->contain(['Designations'])->toArray();
            $customerdesignationId =null;
            $projectmanagerId =null;
            $developerId = null;
            $administratorId = null;

            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Customer') {
                        $customerdesignationId = $customerdesignationId + $designation->id;
                        break;
                    }
                }
            }
            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Project Manager') {
                        $projectmanagerId = $projectmanagerId + $designation->id;
                        break;
                    }
                }
            }
            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Developer') {
                        $developerId = $developerId + $designation->id;
                        break;
                    }
                }
            }
            foreach ($companydepartments as $department) {
                foreach ($department->designations as $designation) {
                    if ($designation->name == 'Administrator') {
                        $administratorId = $administratorId + $designation->id;
                        break;
                    }
                }
            }

            $client = intval($this->request->getData('client'));
            if (!empty($client)) {
                array_push($team, $client);
                $clientmember = $this->ProjectMember->newEntity();
                $clientmember->projectId = $projectId;
                $clientmember->accessLevel = 1;
                $clientmember->isInvitation = 0;
                $clientmember->designation_id = $customerdesignationId;
                $clientmember->memberId = $client;
                $clientmember->joinDate = $projectObject->createDate;
                $this->ProjectMember->save($clientmember);
                //Notify to Customer by Notifications
                $this->projectCreationNotification($clientmember->memberId, $projectId);
                $this->projectAssignedNotification($clientmember->memberId, $projectId);

            }
            $projectleader = intval($this->request->getData('projectleader'));
            if (!empty($projectleader)) {
                array_push($team, $projectleader);
                $projectleadermember = $this->ProjectMember->newEntity();
                $projectleadermember->projectId = $projectId;
                $projectleadermember->accessLevel = 1;
                $projectleadermember->isInvitation = 0;
                $projectleadermember->designation_id = $projectmanagerId;
                $projectleadermember->memberId = $projectleader;
                $projectleadermember->joinDate = $projectObject->createDate;
                $this->ProjectMember->save($projectleadermember);

                //notify to user for project creation
               $this->projectCreationNotification($projectleadermember->memberId, $projectId);
               $this->projectAssignedNotification($projectleadermember->memberId, $projectId);
            }
            $projectteam =  $this->request->getData('projectmembers');
            if (!empty($projectteams)) {
                foreach ($projectteam as $member) {
                    array_push($team, $member);
                    $member = $this->ProjectMember->newEntity();
                    $member->projectId = $projectId;
                    $member->accessLevel = 1;
                    $member->isInvitation = 0;
                    $member->designation_id = $developerId;
                    $member->memberId = intval($member);
                    $member->joinDate = $projectObject->createDate;
                    $projectMemberSave = $this->ProjectMember->save($member);
                    //Notify
                    $this->projectCreationNotification($member->memberId, $projectId);
                    $this->projectAssignedNotification($member->memberId, $projectId);
                }
            }
            //notify to all team


            if ($projectObject->fatherId != 0) {                                                                                     //setto superCode e level
                $father = $this->ProjectObject->get($projectObject->fatherId);
                $projectObject->superCode = $father->superCode . "/" . $projectId;
                $projectObject->level = $father->level + 1;
            } else {
                $projectObject->superCode = "/" . $projectId;
                $projectObject->level = 0;
            }
            $secondSave = $this->ProjectObject->save($projectObject);
        }
        $secondSave = $this->ProjectObject->save($projectObject);
        $projectMember = $this->ProjectMember->newEntity();
        $projectMember->projectId = $projectObject->id;
        $projectMember->accessLevel = 1;
        $projectMember->isInvitation = 0;
        $projectMember->designation_id = $administratorId;
        $projectMember->memberId = $this->Auth->user('id');
        $projectMember->joinDate = $projectObject->createDate;
        $projectMemberSave = $this->ProjectMember->save($projectMember);





        if ($firstSave && $secondSave && $projectMemberSave) {
            $connection->commit();
            $this->Flash->success(__('Il progetto è stato creato.'));
            if (!empty($futureprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'futureprojects', 'companyId' => $companyId, 'type' => $projectshek_type]);
            } elseif (!empty($allprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'allprojects', $companyId]);
            }elseif(!empty($keyforrender)){
                return $this->redirect(['controller' => 'usercompanies','action' => 'view', $companyId]);
            } else {
                return $this->redirect($this->referer());
            }
        } else {
            $connection->rollback();
            if (!empty($futureprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'futureprojects', 'companyId' => $companyId, 'type' => $projectshek_type]);
            } elseif (!empty($allprojects)) {
                return $this->redirect(['controller' => 'projectObject','action' => 'allprojects', $companyId]);
            }elseif(!empty($keyforrender)){
                return $this->redirect(['controller' => 'usercompanies','action' => 'view', $companyId]);
            } else {
                return $this->redirect($this->referer());
            }
        }
    }

    function searchProject()
    {

        if ($this->request->is('ajax')) {

            $this->loadModel('ProjectMember');
            $this->autoRender = false;
            $input = $this->request->getData('term');
            /*$this->response->type('json');
            $this->response->body(json_encode($input));

            return $this->response;*/


            $userId = $this->Auth->user('id');

            $projects = $this->ProjectObject->find('all', [
                /*'join' => [
                    'table' => 'project_member',
                    'alias' => 'gm',
                    'type' => 'left',
                    'conditions' => [
                        'gm.memberId' => $userId,
                        'gm.memberType' => "U",
                        'gm.projectId' => 'ProjectObject.id'
                    ]
                ],*/
                'conditions' => [
                    'name like ' => '%' . $input . '%',
                    'isDeleted = 0',
                    'OR' => [
                        'visibility = "P"',
                        'visibility = "V"',
                    ],
                    'AND' => [
                        /*'isMembershipRequestAllowed' => true,
                        'isInvitationAllowed' => true*/]
                ],
            ])->order(['name' => 'ASC'])
                ->select($this->ProjectObject)
                ->toArray();



            $projectpese = [];

            foreach ($projects as $project) {

                $projectTMP = [
                    'value' => $project->name,
                    'id' => $project->id
                ];

                array_push($projectpese, $projectTMP);
            }



            echo json_encode($projectpese);
            //echo json_encode($projects);

        }
    }


    public function getProjectTabList()
    {

        if ($this->request->is('ajax')) {
            $this->loadModel('ProjectMember');
            $this->autoRender = false;

            $page = $this->request->getData('page');
            $projectId = $this->request->getData('projectId');
            $invito = $this->request->getData('invito');
            $richiesta = $this->request->getData('richiesta');
            //echo json_encode($invito . '-' . $richiesta);


            $order = '';
            if ($invito && !$richiesta) {
                $order = 'invitationDate';
            } else if (!$invito && $richiesta) {
                $order = 'membershipRequestDate';
            }

            if ($page == 'view') {
                $mr = $this->ProjectMember->find('all', [
                    'join' => [
                        'table' => 'user',
                        'alias' => 'u',
                        'type' => 'inner',
                        'conditions' => [
                            'ProjectMember.memberId = u.id'
                        ]
                    ],
                    'conditions' => [
                        'projectId' => $projectId,
                        'isInvitation' => $invito,
                        'isMembershipRequest' => $richiesta,
                        'memberType' => 'U'
                    ]
                ])
                    ->select($this->ProjectMember)
                    ->select(['u.id', 'u.firstname', 'u.lastname'])
                    ->order([$order])
                    ->toArray();
            } else if ($page == 'index') {
                $projectsOwned = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'creatorId = ' . $this->Auth->user('id'),
                        'isDeleted' => false,
                        'visibility' =>'I',
                        'isFutured' => false
                    ],
                ])->select('id');
                //debug($projectsOwned);exit;

                $go = ['none'];
                foreach ($projectsOwned as $project) {
                    array_push($go, $project['id']);
                }

                $mr = $this->ProjectMember->find('all', [
                    'join' => [
                        [
                            'table' => 'user',
                            'alias' => 'u',
                            'type' => 'inner',
                            'conditions' => [
                                'ProjectMember.memberId = u.id'
                            ]
                        ],
                        'join' => [
                            'table' => 'project_object',
                            'alias' => 'go',
                            'type' => 'inner',
                            'conditions' => [
                                'ProjectMember.projectId = go.id'
                            ]
                        ]
                    ],
                    'conditions' => [
                        'ProjectMember.isInvitation = ' . $invito . ' AND ProjectMember.isMembershipRequest = ' . $richiesta . ' AND ProjectMember.memberType = "U" AND ProjectMember.projectId NOT IN' . str_replace(']', ')', str_replace('[', '(', json_encode($go))) . ' AND ProjectMember.memberId = ' . $this->Auth->user('id')
                    ]
                ])
                    ->select($this->ProjectMember)
                    ->select(['u.id', 'u.firstname', 'u.lastname', 'go.name'])
                    ->order([$order])
                    ->toArray();
            }



            echo json_encode($mr);
            //$this->response->withType('json');
            //$this->response->body($resultJ);

            //return $this->response;
        }
    }


    public function acceptRequest()
    {

        if ($this->request->is('ajax')) {

            $this->autoRender = false;
            $this->loadModel('ProjectMember');

            $projectId = $this->request->getData('projectId');
            $memberId = $this->request->getData('memberId');
            $memberType = $this->request->getData('memberType');

            $mr = $this->ProjectMember->get([$projectId, $memberType, $memberId]);
            $mr->joinDate = Time::now();
            $mr->isMembershipRequest = 0;

            if ($this->ProjectMember->save($mr)) {
                $this->Flash->success(__('Request accepted succesfully!'));
                echo json_encode('OK');
            } else {
                $this->Flash->error(__('Error accepting the request'));
                echo json_encode('KO');
            }
        }
    }


    public function acceptInvitation()
    {

        if ($this->request->is('ajax')) {

            $this->autoRender = false;
            $this->loadModel('ProjectMember');

            $projectId = $this->request->getData('projectId');
            $memberId = $this->request->getData('memberId');
            $memberType = $this->request->getData('memberType');

            $mr = $this->ProjectMember->get([$projectId, $memberType, $memberId]);
            $mr->joinDate = Time::now();
            $mr->isInvitation = 0;

            if ($this->ProjectMember->save($mr)) {
                $this->Flash->success(__('Invite accepted succesfully!'));
                echo json_encode('OK');
            } else {
                $this->Flash->error(__('Error accepting the invite'));
                echo json_encode('KO');
            }
        }
    }




    public function manageUsersModal($projectId = null)
    {
        if ($this->request->is('get') && $projectId != null) {
            $this->loadModel('ProjectMember');
            $project_members = $this->ProjectMember->find('all', [
                'join' => [
                    'table' => 'user',
                    'alias' => 'u',
                    'type' => 'inner',
                    'conditions' => [
                        'ProjectMember.memberId = u.id'
                    ]
                ],
                'conditions' => [
                    'projectId' => $projectId,
                    'isInvitation' => 0,
                    'isMembershipRequest' => 0,
                    'memberType' => 'U'
                ]
            ])
                ->select($this->ProjectMember)
                ->select(['u.id', 'u.firstname', 'u.lastname'])
                ->toArray();

            $accessLevelNamesArray = [
                __('System Admin'),
                __('Owner'),
                __('Administrator'),
                null,
                null,
                null,
                __('User')
            ];

            foreach ($project_members as $gm) {
                $gm['accessLevelName'] = $accessLevelNamesArray[$gm['accessLevel']];
            }



            $this->set(compact('project_members'));
            $this->set(compact('projectId'));
        } else {
            $this->Flash->error(__('Error. Request isn\'t in the right format'));
            return $this->redirect(['controller' => 'ProjectObject', 'action' => 'index']);
        }
    }

    public function getFriendshipForInvite()
    {
        return true;
    }

    public function isMyProject()
    {
        if ($this->request->is('ajax')) {
            // get auth user
            $user = (string)$this->Auth->user('id');
            // get data from request
            $projectId = $this->request->getData('projectId');
            // get project creator
            $creatorId = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id' => $projectId
                ]
            ])->select('creatorId')->extract('creatorId')->first();
            // avoid cake redirect
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($creatorId == $user));
        }
    }

    public function getCourseProposals($projectId = null)
    {
        if ($this->request->is('ajax')) {
            // get data from request
            $projectId = $this->request->getData('projectId');
            // pick proposals from the database
            $courseProposals = $this->ProjectObject->find('all', [
                'join' => [
                    [
                        'table' => 'course_proposal', // join proposal
                        'alias' => 'cp',
                        'type' => 'inner',
                        'conditions' => [
                            'ProjectObject.id = cp.projectId'
                        ]
                    ],
                    [
                        'table' => 'organization', // join organitation
                        'alias' => 'o',
                        'type' => 'inner',
                        'conditions' => [
                            'o.id = cp.organizationId'
                        ]
                    ],
                    [
                        'table' => 'anagraphic', // join anagraphic
                        'alias' => 'a',
                        'type' => 'inner',
                        'conditions' => [
                            'o.anagId = a.id'
                        ]
                    ]
                ],
                'conditions' => [
                    'cp.projectId' => $projectId    // filter by project
                ]
            ])->select(['cp.priceMin', 'cp.priceMax', 'a.name1', 'o.imageFileServer', 'o.imageFilePath'])->toArray();
            // avoid cake redirect
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($courseProposals));
        }
    }


    public function ganttdata($projectId = null)
    {
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $projectId
            ]
        ])->first();
        $allprojecttasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id in' => $projectId
            ]
        ])->order(['creation_date' => 'DESC'])->toArray();

        foreach($allprojecttasks as $task){

            $task->startdate = $task->startdate->i18nFormat('yyyy-M-d','Europe/Rome');
            $task->expiration_date = $task->expiration_date->i18nFormat('yyyy-M-d','Europe/Rome');
        }




        if ($this->request->is('ajax')) {


            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($allprojecttasks));
        }
        $this->set(compact('projectObject'));
    }
    public function archieveProjects()
    {
        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');
        $this->loadModel('Projecttypes');
        $this->loadModel('ProjectObject');
        $this->loadModel('User');
        $this->loadModel('Projecttasks');
        $this->loadModel('Projectfiles');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $projecttypes = $this->Projecttypes->find('all')->toArray();
        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $user_id
            ]
        ])->toArray();
        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }
        $unique_projectids = null;
        $unique_projectids = array_unique($all_projectids);
        if ($companyId != null) {
            $this->loadModel('CompaniesUser');
            $companymembers = $this->CompaniesUser->find('all',[
                'conditions' => [
                    'company_id' => $authuser->choosen_companyId
                ]
            ])->contain(['User'])->toArray();
            if ($unique_projectids != null) {
                $projectObjects = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'ProjectObject.id in' => $unique_projectids,
                        'isDeleted' => false,
                        'visibility' => $type,
                        'isFuturedProject' => false,
                        'isArchieveAllowed' => false,
                        'company_id' => $companyId,
                        'isArchieveAllowed' => true
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
                $total = count($projectObjects);
            } else {
                $projectObjects = null;
                $total = null;
            }
        } else {
            if ($unique_projectids != null) {
                $projectObjects = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'ProjectObject.id in' => $unique_projectids,
                        'isDeleted' => false,
                        'visibility' => $type,
                        'isPersonal' => true,
                        'isArchieveAllowed' => true
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
                    'Projectmember.Designations'
                ])->toArray();

                $total = count($projectObjects);
                $companymembers = null;
            } else {
                $projectObjects = null;
                $total = null;
                $companymembers = null;

            }
        }
        $this->set(compact('companymembers','projecttypes','projectObjects', 'total', 'authuser', 'type', 'companyId'));

    }




    public function projectsgrantt()
    {

        $user_id = $this->Auth->user('id');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $authuserprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $user_id
            ]
        ])->toArray();
        $all_projectids = array();
        foreach ($authuserprojects as $project) {
            array_push($all_projectids, $project->projectId);
        }
        $unique_projectids = null;
        $unique_projectids = array_unique($all_projectids);
        if ($authuser->choosen_companyId != null) {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $unique_projectids,
                    'isDeleted' => false,
                    'visibility' =>'I',
                    'isFuturedProject' => false,
                    'company_id' => $authuser->choosen_companyId,

                ]
            ])->contain(['Projecttypes'])->toArray();


        } else {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'ProjectObject.id in' => $unique_projectids,
                    'isDeleted' => false,
                    'visibility' =>'I',
                    'isFuturedProject' => false,
                    'isPersobnal' => true
                ]
            ])->contain(['Projecttypes'])->toArray();
        }

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($projectObjects));


    }

    public function contractversions($projectId = null){
        //debug($projectId);exit;

        $this->loadModel('User');
        $this->loadModel('VersionsContract');
        $this->loadModel('ProjectMember');
        $user_id = $this->Auth->user('id');

            $currentversion = $this->VersionsContract->find('all', [
                'conditions' => [
                    'project_object_id' => $projectId,
                    'acceptance_date is not' => null
                ]
            ])->order([
                'creation_date' => 'DESC'
            ])->first();
        if (!empty($currentversion)) {
            $previousversions =  $this->VersionsContract->find('all', [
                'conditions' => [
                    'project_object_id' => $projectId,
                    'id is not' => $currentversion->id,
                    'creation_date <' => $currentversion->creation_date
                ]
            ])->toArray();
            $unsignedfutureversions =  $this->VersionsContract->find('all', [
                'conditions' => [
                    'project_object_id' => $projectId,
                    'id is not' => $currentversion->id,
                    'creation_date >' => $currentversion->creation_date
                ]
            ])->toArray();
        } else {
            $previousversions = null;
            $unsignedfutureversions = null;
        }
        $projectmembers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $projectId,
            ]
        ])->contain([
            'User',
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();

        $this->set(compact('previousversions','currentversion','projectmembers','unsignedfutureversions'));
    }




    public function addedmembers()
    {

        $values = json_decode($_POST['values']);

        $this->loadModel('User');
        $members = $this->User->find('all', [
            'conditions' => [
                'id in' => $values
            ]
        ])->toArray();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($members));
    }

    private function projectCreationNotification($touserId, $projectId)
    {

        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompanyModules');
        $user_id = $this->Auth->user('id');

       $projectmember = $this->ProjectMember->find('all',[
            'conditions' => [
                'ProjectMember.memberId ' => $touserId
            ]
        ])->contain(['User',
        'ProjectObject.User'
        ])->first();

        $project = $this->ProjectObject->find('all',[
            'conditions' => [
                'ProjectObject.id in' => $projectmember->projectId
            ]
        ])->contain(['User'])->first();

        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $project->company_id
            ]
        ])->toArray();

        foreach ($companymodules as $module) {
            if ($module->name == 'Projects' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id = $project->company_id;
                $notification->module_id = $module->id;
                $notification->module_action = 'Created';
                $notification->module_action_id = $project->id;
                $notification->module_action_title = $project->name;
                $notification->module_action_description = $project->description;
                $notification->creation_date = Time::now();
                $notification->fromuser_id = $user_id;
                $notification->touser_id = $touserId;
                $this->Notifications->save($notification);

                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($projectmember->user->email)
                    ->setemailFormat('html')
                    ->setSubject('Notification')
                    ->setViewVars([
                        'projectmember' => $projectmember,
                        'project' => $project

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


    private function projectAssignedNotification($touserId, $projectId)
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompanyModules');
        $user_id = $this->Auth->user('id');

       $projectmember = $this->ProjectMember->find('all',[
            'conditions' => [
                'ProjectMember.memberId ' => $touserId
            ]
        ])->contain(['User',
        'ProjectObject.User'
        ])->first();
        $project = $this->ProjectObject->find('all',[
            'conditions' => [
                'ProjectObject.id in' => $projectmember->projectId
            ]
        ])->contain(['User'])->first();
        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $project->company_id
            ]
        ])->toArray();


        foreach ($companymodules as $module) {
            if ($module->name == 'Projects' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id = $project->company_id;
                $notification->module_id = $module->id;
                $notification->module_action = 'Assigned';
                $notification->module_action_id = $project->id;
                $notification->module_action_title = $project->name;
                $notification->module_action_description = $project->description;
                $notification->creation_date = Time::now();
                $notification->fromuser_id = $user_id;
                $notification->touser_id = $touserId;
                $this->Notifications->save($notification);

                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($projectmember->user->email)
                    ->setemailFormat('html')
                    ->setSubject('Notification')
                    ->setViewVars([
                        'projectmember' => $projectmember,
                        'project' => $project

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
    private function projectUpdatedNotification($touserId, $projectId)
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompanyModules');
        $user_id = $this->Auth->user('id');

       $projectmember = $this->ProjectMember->find('all',[
            'conditions' => [
                'ProjectMember.memberId ' => $touserId
            ]
        ])->contain(['User',
        'ProjectObject.User'
        ])->first();
        $project = $this->ProjectObject->find('all',[
            'conditions' => [
                'ProjectObject.id in' => $projectmember->projectId
            ]
        ])->contain(['User'])->first();
        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $project->company_id
            ]
        ])->toArray();


        foreach ($companymodules as $module) {
            if ($module->name == 'Projects' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id = $project->company_id;
                $notification->module_id = $module->id;
                $notification->module_action = 'Updated';
                $notification->module_action_id = $project->id;
                $notification->module_action_title = $project->name;
                $notification->module_action_description = $project->description;
                $notification->creation_date = Time::now();
                $notification->fromuser_id = $user_id;
                $notification->touser_id = $touserId;
                $this->Notifications->save($notification);

                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($projectmember->user->email)
                    ->setemailFormat('html')
                    ->setSubject('Notification')
                    ->setViewVars([
                        'projectmember' => $projectmember,
                        'project' => $project

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

    private function projectDeletedNotification($touserId, $projectId)
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('CompanyModules');
        $user_id = $this->Auth->user('id');

       $projectmember = $this->ProjectMember->find('all',[
            'conditions' => [
                'ProjectMember.memberId ' => $touserId
            ]
        ])->contain(['User',
        'ProjectObject.User'
        ])->first();
        $project = $this->ProjectObject->find('all',[
            'conditions' => [
                'ProjectObject.id in' => $projectmember->projectId
            ]
        ])->contain(['User'])->first();
        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $project->company_id
            ]
        ])->toArray();


        foreach ($companymodules as $module) {
            if ($module->name == 'Projects' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id = $project->company_id;
                $notification->module_id = $module->id;
                $notification->module_action = 'Deleted';
                $notification->module_action_id = $project->id;
                $notification->module_action_title = $project->name;
                $notification->module_action_description = $project->description;
                $notification->creation_date = Time::now();
                $notification->fromuser_id = $user_id;
                $notification->touser_id = $touserId;
                $this->Notifications->save($notification);

                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($projectmember->user->email)
                    ->setemailFormat('html')
                    ->setSubject('Notification')
                    ->setViewVars([
                        'projectmember' => $projectmember,
                        'project' => $project

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


    public function addclient(){
        $this->loadModel('CompaniesUser');
        $this->loadModel('ProjectMember');
        $projectId = $this->request->getQuery('projectId');

        $projectObject = $this->ProjectObject->find('all',[
            'conditions' => [
                'id in' => $projectId
            ]
        ])->first();
        $clientId = $this->request->getQuery('clientId');

        $clientData = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' =>  $projectObject->company_id,
                'user_id' => $clientId
            ]
        ])->first();

        $projectclient = $this->ProjectMember->find('all',[
            'conditions' => [
                'ProjectMember.projectId' => $projectId
            ]
        ])->contain(['Designations' => function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },
        ])->toArray();
        if (empty($projectclient)) {
            $client = $this->ProjectMember->newEntity();
            $client->projectId = $projectId;
            $client->accessLevel = 1;
            $client->isInvitation = 0;
            $client->designation_id = $clientData->member_role;
            $client->memberId = $clientData->user_id;
            $client->joinDate = $projectObject->createDate;
            $projectMemberSave = $this->ProjectMember->save($client);
        }
       // debug($projectclient);exit;
       return $this->redirect([
        'controller' => 'projectObject',
        'action' => 'view',
        $projectId
    ]);

    }




}
