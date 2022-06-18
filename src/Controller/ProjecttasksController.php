<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Projecttask;
use App\Model\Entity\Taskgroup;
use Cake\I18n\Time;
use Cake\Mailer\Mailer;
use Cake\Mailer\Email;
use PhpParser\Node\Expr\Exit_;

Time::setDefaultLocale('es-ES');

/**
 * Projecttasks Controller
 *
 * @property \App\Model\Table\ProjecttasksTable $Projecttasks
 *
 * @method \App\Model\Entity\Projecttask[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjecttasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects']
        ];
        $projecttasks = $this->paginate($this->Projecttasks);

        $this->set(compact('projecttasks'));
    }
    public function isAuthorized($user)
    {
        return true;
    }
    /**task Reports */
    public function taskReports($companyId = null)
    {
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');
        $this->loadModel('Taskusers');
        $this->loadModel('User');

        $projectobjects = $this->ProjectObject->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'isDeleted' => false,
                'isFuturedProject' => false
            ]
        ])->contain([
            'Projecttasks'=> function ($q) {
                return $q->where([
                    'isDeleted' => false,
                    'type' => 'TS',
                    'isFuturedTask' => false
                ]);
            },
            'Projecttasks.Taskusers.User'
        ])->toArray();
        $alltickets = null;
        $this->set(compact('projectobjects', 'alltickets', 'companyId'));
    }

    public function taskcategized(){
        $this->loadModel('ProjectObject');
        $companyId = $this->request->getQuery('companyId');
        $status = $this->request->getQuery('status');
        $projectobjects = $this->ProjectObject->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'isDeleted' => false,
                'isFuturedProject' => false,

            ]
        ])->contain([
            'Projecttasks'=> function ($q) use ($status) {
                return $q->where([
                    'isDeleted' => false,
                    'type' => 'TS',
                    'isFuturedTask' => false,
                    'status' => $status
                ]);
            },
            'Projecttasks.Taskusers.User'
        ])->toArray();


        $alltickets = null;
        $this->set(compact('projectobjects', 'alltickets', 'companyId'));

    }




    /**Achive tickets */
    public function archiveTicket()
    {
        $this->loadModel('Projecttasks');
        $updatedtaskId = $this->request->getData('updatedtaskId');
        $id = $this->request->getData('updatedtaskpid');
        $archievedtask = $this->Projecttasks->find('all', [
            'conditions' => [
                'id in' => $updatedtaskId
            ]
        ])->first();
        $archievedtask->status = 'A';
        $this->Projecttasks->save($archievedtask);
        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $projectmember = $this->ProjectMember->find('all', [
            'conditions' => [
                'type' => 'Y'
            ]
        ])->toArray();
        $userid = array();
        foreach ($projectmember as $member) {
            array_push($userid, $member['memberId']);
        }
        $users = $this->User->find('all', [
            'conditions' => [
                'id in' => $userid
            ]
        ])->toArray();


        //Notifications
        $projectmember = $this->ProjectMember->find('all', [
            'conditions' => [
                'type' => 'Y'
            ]
        ])->toArray();
        $admins = array();
        foreach ($projectmember as $member) {
            array_push($admins, $member->memberId);
        }
        $uniqueadmin = array_unique($admins);
        $user_id =  $this->Auth->user('id');
        $admins = array_unique($admins);
        foreach ($uniqueadmin as $member) {
            $notification = $this->Notifications->newEntity();
            $notification->fromuser_id = $user_id;
            $notification->action_title = $archievedtask->title;
            $notification->action_status = 'customer Archieved';
            $notification->action_description = null;
            $notification->action_id = $archievedtask->id;
            $notification->creation_date = Time::now();
            $notification->touser_id = $member;
            $notification->type = 'ticket';
            $this->Notifications->save($notification);
        }
        $chiefemails = array();
        foreach ($users as $user) {
            array_push($chiefemails, $user['email']);
        }
        $email = new Email();
        $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($chiefemails)
            ->setemailFormat('html')
            ->setSubject('Customer Archieved the Ticket' . $archievedtask->title)
            ->send('Hello' . $archievedtask->title . 'and task id' . $archievedtask->id . 'is  Archieved by Customer');
        return $this->redirect([
            'controller' => 'ProjectObject',
            'action' => 'taskboard',
            $id
        ]);
    }




    /*Modify tasks */
    public function modify()
    {
        $this->loadModel('Projecttasks');
        $tid = null;
        $updatedtask = null;
        $tid = $this->request->getData('tid');
        $updatedtask = $this->request->getData('updatedtaskId');
        if ($tid != null) {
            $pid = $this->request->getData('pid');
            $task = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $tid
                ]
            ])->first();
            if ($task->type == 'TC') {
                $task->type = 'TS';
            } else {
                $task->type = 'TC';
            }
            $updated =  $this->Projecttasks->save($task);
            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'taskboard',
                $pid

            ]);
        }

        if ($updatedtask != null) {
            $this->loadModel('Taskgroups');
            $taskgroups = $this->Taskgroups->find('all')->toArray();
            $this->loadModel('TaskgroupsProjecttasks');
            $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
            $id = $this->request->getData('updatedtaskpid');
            $this->loadModel('ProjectObject');
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'id' => $id
                ]
            ])->first();
            $custid = $this->request->getData('custid');
            $accepted_task = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id in' => $updatedtask
                ]
            ])->first();
            if ($accepted_task->type == 'TC') {
                $accepted_task->type = 'TS';
            }
            $this->Projecttasks->save($accepted_task);
            $this->loadModel('ProjectMember');
            $this->loadModel('User');
            $projectmember = $this->ProjectMember->find('all', [
                'conditions' => [
                    'type' => 'Y'
                ]
            ])->toArray();
            $userid = array();
            foreach ($projectmember as $member) {
                array_push($userid, $member['memberId']);
            }
            $users = $this->User->find('all', [
                'conditions' => [
                    'id in' => $userid
                ]
            ])->toArray();
            $chiefemails = array();
            foreach ($users as $user) {
                array_push($chiefemails, $user['email']);
            }
            $custemail = $this->User->find('all', [
                'conditions' => [
                    'id' => $custid
                ]
            ])->first();
            $email = new Email();
            $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($custemail->email)
                ->setEmailFormat('html')
                ->setSubject('Ticket Accepted by Customer  ' . $custemail->firstname . '  ' . $custemail->lastname)
                ->setTemplate('ticket', 'default')
                ->setViewVars(['user' => $user, 'updatetask' => $accepted_task, 'projectObject' => $projectObject, 'manyObject' => $manyObject, 'taskgroups' => $taskgroups]);
            $email->send();
            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'taskboard',
                $id
            ]);
        }
    }
    public function merge()
    {
        $this->loadModel('User');
        $creatorId = $this->Auth->user('id');
        $projectId = $this->request->getData('pid');
        $mergeId = $this->request->getData('merge');
        $tid = $this->request->getData('id');
        $to_mergetask = $this->Projecttasks->find('all', [
            'conditions' => [
                'id' => $mergeId
            ]

        ])->first();
        $from_mergetask = $this->Projecttasks->find('all', [
            'conditions' => [
                'id' => $tid
            ]
        ])->first();
        $this->loadModel('Taskgroups');
        $title = $to_mergetask->title;
        $description = $from_mergetask->description . $to_mergetask->description;
        $price = $from_mergetask->price + $to_mergetask->price;
        $tax = $from_mergetask->tax_percentage + $to_mergetask->tax_percentage;
        /*create a group*/
        $taskgroups = $this->Taskgroups->newEntity();
        $taskgroups->title = 'group : ' . $title;
        $taskgroups->description = $description;
        $taskgroups->price = $price;
        $taskgroups->tax_percentage = $tax;
        $taskgroups->last_update = Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss');
        $taskgroups->creation_date = Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss');
        $this->Taskgroups->save($taskgroups);
        /** new task  */
        $task = $this->Projecttasks->newEntity();
        $task->project_id = $projectId;
        $task->creatorId = $creatorId;
        $task->title = $to_mergetask->title;
        $task->description = $from_mergetask->description . $to_mergetask->description;
        $task->price = $from_mergetask->price + $to_mergetask->price;
        $task->tax_percentage = $from_mergetask->tax_percentage + $to_mergetask->tax_percentage;
        $task->type = $to_mergetask->type;
        $task->startdate = $to_mergetask->startdate;
        $task->expiration_date = $to_mergetask->expiration_date;
        $this->Projecttasks->save($task);
        $to_mergetask->isDeleted = true;
        $from_mergetask->isDeleted = true;
        $this->Projecttasks->save($to_mergetask);
        $this->Projecttasks->save($from_mergetask);
        $this->loadModel('TaskgroupsProjecttasks');
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->newEntity();
        $taskgroupsProjecttask->taskgroup_id = $taskgroups->id;
        $taskgroupsProjecttask->projecttask_id = $task->id;
        $result = $this->TaskgroupsProjecttasks->save($taskgroupsProjecttask);
        return $this->redirect([
            'controller' => 'ProjectObject',
            'action' => 'taskboard',
            $projectId
        ]);
    }



    public function deletetask($id = null)
    {
        $tid = $this->request->getData('id');
        if (!empty($tid)) {
            $task = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $tid
                ]
            ])->first();
            $this->Projecttasks->delete($task);
        } else {
            $this->Projecttasks->deleteAll([
                'ProjecttasksisDeleted' => true
            ]);
        }

        if (!empty($id)) {
            $task = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $id
                ]
            ])->first();
            $this->Projecttasks->delete($task);
        }
        return $this->redirect([
            'controller' => 'Projecttasks',
            'action' => 'recyclebin',

        ]);
    }



    /*check startdate method*/
    public function checkstartdate()
    {
        $groupid = $this->request->getData('groupid');
        $this->loadModel('Taskgroups');
        $taskgroup = $this->Taskgroups->find('all', [
            'conditions' => [
                'id in' => $groupid
            ]
        ])->first();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($taskgroup));
    }

    public function checkexpirydate()
    {
        $groupid = $this->request->getData('groupid');
        $this->loadModel('Taskgroups');
        $taskgroup = $this->Taskgroups->find('all', [
            'conditions' => [
                'id in' => $groupid
            ]
        ])->first();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($taskgroup));
    }


    /**Update Ticket Status */
    public function updateticketStatus()
    {
        $user_id = $this->Auth->user('id');
        if ($this->request->is('ajax')) {
            $tid = $this->request->getData('tid');
            $status = $this->request->getData('status');
            $ticket = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id in' => $tid
                ]
            ])->first();
            $ticket->status = $status;

            $result = $this->Projecttasks->save($ticket);
            $msg = "Ticket Status Updated Sucessfully";
            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($result));
        }else{
            $ticketId = $this->request->getQuery('ticketId');
            $closeticket = $this->request->getQuery('closeticket');
            $ticket = $this->Projecttasks->find('all',[
                'conditions' => [
                    'id in' => $ticketId
                ]
            ])->first();
            $ticket->status = 'D';
            $this->Projecttasks->save($ticket);

            if(!empty($closeticket)){
                $this->Flash->success(__('Ticket Closed.'));
                return $this->redirect([
                    'controller' => 'Projecttasks',
                    'action' => 'tickets',
                    $user_id

                ]);
            }






        }
    }






    /*change status of task method*/
    public function changestatus()
    {
        $dummy = $this->request->getData('dummy');


        if (!empty($dummy)) {
            $user_id = $this->Auth->user('id');
            $tid = $this->request->getData('tid');
            $controlsEnabled = $this->request->getData('controlsEnabled');
            $currentstatus = $this->request->getData('status');
            $task = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id in' => $tid
                ]
            ])->first();
            if ($controlsEnabled == true) {
                $task->status = 'D';
                $task->status_updatedby = $user_id;
                $this->Flash->success(__('Task Status Updated.'));
                $this->Projecttasks->save($task);
            } else {
                $task->status_updatedby = $user_id;
                $task->status = $currentstatus;
                $this->Flash->success(__('Task Status Updated.'));
                $this->Projecttasks->save($task);
            }
            //notifications
            $this->loadModel('Notifications');
            $this->loadModel('ProjectMember');
            $projectmember = $this->ProjectMember->find('all')->contain(['Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Administrator'
                ]);
            },])->toArray();
            $admins = array();
            foreach ($projectmember as $member) {
                array_push($admins, $member->memberId);
            }
            $admins = array_unique($admins);
            foreach ($admins as $member) {
                $user_id = $this->Auth->user('id');
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = $task->title;
                $notification->action_status = $task->status;
                $notification->action_description = null;
                $notification->action_id = $task->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $member;
                $notification->type = 'task';
                $this->Notifications->save($notification);
                $updatedtask = $this->Projecttasks->find('all')->contain(['Statusupdatedby'])->toArray();
            }
            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($updatedtask));
        } else {

            $this->autoRender = false;
            $tid = $this->request->getData('taskId');
            $status = $this->request->getData('status');
            $user_id = $this->Auth->user('id');
            $task = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $tid
                ]
            ])->first();
            $task->status = $status;
            $task->status_updatedby = $user_id;
            $this->Projecttasks->save($task);
            $this->Flash->success(__('Task Status Updated.'));
            $msg = "Successfully Updated";
            $this->loadModel('Notifications');
            $this->loadModel('ProjectMember');
            $projectmember = $this->ProjectMember->find('all')->contain(['Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Administrator'
                ]);
            },])->toArray();
            $admins = array();
            foreach ($projectmember as $member) {
                array_push($admins, $member->memberId);
            }
            $admins = array_unique($admins);
            foreach ($admins as $member) {
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = $task->title;
                $notification->action_status = $task->status; // $leave->status;//New
                $notification->action_description = null;
                $notification->action_id = $task->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $member;
                $notification->type = 'task';
                $this->Notifications->save($notification);
            }
            $updatedtask = $this->Projecttasks->find('all')->contain(['Statusupdatedby'])->toArray();
            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($updatedtask));
        }
    }

    /*bintrecyclebin*/

    public function recyclebin($pid = null)
    {
        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $projectObject = $this->ProjectObject->find('all', [
            'condition' => [
                'id' => $pid
            ]
        ])->first();
        $this->set(compact('projectObject'));
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
        $binData = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.isDeleted' => true
            ]
        ])->toArray();
        $this->set(compact('binData'));
    }


    /* Create Ticket*/
    public function createTicket()
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $this->loadModel('Taskgroups');
        $this->loadModel('Notifications');

        $ticketsview = $this->request->getData('tickets');
        $projectview = $this->request->getData('projectview');
        $taskview = $this->request->getData('taskview');
        $taskboard = $this->request->getData('taskboard');



        if (!empty($taskview)) {
            $this->loadModel('Projecttasks');
            $task = $this->Projecttasks->find('all',[
                'conditions' => [
                    'id in' => $taskview
                ]
            ])->first();

            $pid =  $task->project_id;

        }elseif(!empty($projectview)){

            $pid = $this->request->getData('pid');
        }
        elseif(!empty($taskboard)){
            $pid = $taskboard;
        }else{
            $pid = null;
        }

        $task = $this->Projecttasks->newEntity();
        $user_id =  $this->Auth->user('id');

        $task->creatorId = $user_id;
        if (!empty($taskview)) {
            $task->referred_taskId = $taskview;
        }
        $task->type = 'TC';
        $taskgroupId = $this->request->getData('grouptype');
        $task->project_id = $pid;
        $task->title = $this->request->getData('ticketname');
        $task->description = $this->request->getData('ticketdescription');
        $task->category = $this->request->getData('category');
        $startdate = $this->request->getData('ticketstartdate');

        if (!empty($taskgroupId)) {
            $taskgroup = $this->Taskgroups->find('all', [
                'conditions' => [
                    'id in' => $taskgroupId
                ]
            ])->first();

            if (!empty($startdate)) {
                $startdate = Time::createFromFormat(
                    'd/m/Y',
                    $startdate,
                    'Europe/Paris'
                );

                if ($startdate->i18nFormat('yyyy-MM-dd') < Time::now()->i18nFormat('yyyy-MM-dd') && $startdate->i18nFormat('yyyy-MM-dd') >= $taskgroup->startdate->i18nFormat('yyyy-MM-dd') && $startdate->i18nFormat('yyyy-MM-dd') < $taskgroup->expirydate->i18nFormat('yyyy-MM-dd')) {
                    $this->Flash->error(__('Invalid Date !'));
                    if (!empty($taskview)) {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'taskview',
                            $taskview
                        ]);
                    } elseif (!empty($projectview)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'view',
                            $projectview
                        ]);
                    } else {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'tickets',
                        ]);
                    }
                }
                $task->startdate = $startdate;
            } else {
                $task->startdate = Time::now();
            }
            $expirydate = $this->request->getData('ticketexpirydate');
            if (!empty($expirydate)) {
                $expirydate = Time::createFromFormat(
                    'd/m/Y',
                    $expirydate,
                    'Europe/Paris'
                );
                if ($expirydate->i18nFormat('yyyy-MM-dd') <= $startdate->i18nFormat('yyyy-MM-dd') && $expirydate->i18nFormat('yyyy-MM-dd') >= $taskgroup->startdate->i18nFormat('yyyy-MM-dd') && $expirydate->i18nFormat('yyyy-MM-dd') < $taskgroup->expirydate->i18nFormat('yyyy-MM-dd')) {
                    $this->Flash->error(__('Invalid Date !'));
                    if (!empty($taskview)) {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'taskview',
                            $taskview
                        ]);
                    }elseif (!empty($taskboard)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'taskboard',
                            $taskboard
                        ]);
                    }
                    elseif (!empty($projectview)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'view',
                            $projectview
                        ]);
                    } else {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'tickets',
                        ]);
                    }
                }
                $task->expiration_date = $expirydate;
            } else {
                $task->expiration_date = null;
            }
        } else {
            if (!empty($startdate)) {
                $startdate = Time::createFromFormat(
                    'd/m/Y',
                    $startdate,
                    'Europe/Paris'
                );

                if ($startdate->i18nFormat('yyyy-MM-dd') < Time::now()->i18nFormat('yyyy-MM-dd')) {
                    $this->Flash->error(__('Invalid Date !'));
                    if (!empty($taskview)) {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'taskview',
                            $taskview
                        ]);
                    } elseif (!empty($taskboard)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'taskboard',
                            $taskboard
                        ]);
                    }  elseif (!empty($projectview)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'view',
                            $projectview
                        ]);
                    } else {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'tickets',
                        ]);
                    }
                }
                $task->startdate = $startdate;
            } else {
                $task->startdate = Time::now();
            }
            $expirydate = $this->request->getData('ticketexpirydate');
            if (!empty($expirydate)) {
                $expirydate = Time::createFromFormat(
                    'd/m/Y',
                    $expirydate,
                    'Europe/Paris'
                );
                if ($expirydate->i18nFormat('yyyy-MM-dd') <= $startdate->i18nFormat('yyyy-MM-dd')) {
                    $this->Flash->error(__('Invalid Date !'));
                    if (!empty($taskview)) {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'taskview',
                            $taskview
                        ]);
                    } elseif (!empty($taskboard)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'taskboard',
                            $taskboard
                        ]);
                    }  elseif (!empty($projectview)) {
                        return $this->redirect([
                            'controller' => 'projectObject',
                            'action' => 'view',
                            $projectview
                        ]);
                    } else {
                        return $this->redirect([
                            'controller' => 'projecttasks',
                            'action' => 'tickets',
                        ]);
                    }
                }
                $task->expiration_date = $expirydate;
            } else {
                $task->expiration_date = null;
            }
        }




        $task->creation_date = Time::now();
        $task->price = $this->request->getData('ticketprice');
        $task->tax_percentage = $this->request->getData('tickettax');
        $task->status_updatedby =  $user_id;
        $task->priority = $this->request->getData('task_prority');
        $task = $this->Projecttasks->save($task);

        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' =>  $user_id
            ]
        ])->first();

        $analysts = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'member_role ' => 'A'
            ]
        ])->toArray();
        $analystIds = array();
        foreach($analysts as $analyst){
            array_push($analystIds, $analyst->user_id);

        }

        //add ticket assignees
        $assignees = $this->request->getData('taskassignees');
        $this->loadModel('Taskusers');

        if (!empty($assignees)) {
            foreach ($assignees as $assignee) {
                foreach ($analystIds as $id) {
                    if ($assignee == $id) {
                        $task->ishaveAnalyst = true;
                        $this->Projecttasks->save($task);

                    }
                }
                $taskuser = $this->Taskusers->newEntity();
                $taskuser->taskId = $task->id;
                $taskuser->assignee_id = intval($assignee);
                $taskuser->assigned_date = Time::now();
                $this->Taskusers->save($taskuser);
            }
        }

        //add ticket followers
        $followers = $this->request->getData('followers');

        if (!empty($followers)) {
            foreach ($followers as $follower_id) {
                $this->loadModel('Followers');
                $follower = $this->Followers->newEntity();
                $follower->user_id = intval($follower_id);
                $follower->task_id = $task->id;
                $follower->project_id = $pid;
                $follower->creation_date = Time::now();
                $this->Followers->save($follower);
            }
        }

        //add ticket files
        $taskfiles = $this->request->getData()['ticketfiles'];

        foreach ($taskfiles as $file) {
            if (!empty($file['tmp_name'])) {
                $this->loadModel('Taskfiles');
                $taskfile = $this->Taskfiles->newEntity();
                $taskfile->user_id = $user_id;
                $taskfile->pid =  $pid;
                $taskfile->tid = $task->id;
                $taskfile->filename = $file['name'];
                $taskfile->type = $file['type'];
                $taskfile->size = $file['size'];
                $taskfile->creation_date = Time::now();
                $taskfile->filepath = "assets/taskfiles/" .  $task->id;
                $destinationFolder = WWW_ROOT . "assets/taskfiles/" . $task->id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Taskfiles->save($taskfile);
            }
        }

        if (!empty($taskgroupId)) {

            //Create a record in TaskgroupsProjecttasks table with $task-id and $taskId
            $this->loadModel('TaskgroupsProjecttasks');
            $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->newEntity();
            $taskgroupsProjecttask->project_id = $pid;
            $taskgroupsProjecttask->taskgroup_id = $taskgroupId;
            $taskgroupsProjecttask->projecttask_id = $task->id;
            $this->TaskgroupsProjecttasks->save($taskgroupsProjecttask);
        }


        $epic_task = $this->request->getData('epic_task');

        if (!empty($epic_task)) {
            $this->loadModel('EpictasksProjecttasks');
            $epictask = $this->EpictasksProjecttasks->newEntity();
            $epictask->epictask_id = $epic_task;
            $epictask->projecttask_id = $task->id;
            $epictask->projectId = $pid;
            $this->EpictasksProjecttasks->save($epictask);
        }


        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $authuser_company_role = $this->CompaniesUser->find('all',[
            'conditions' => [
                'user_id' => $authuser->id,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->first();

        if ($authuser_company_role->member_role == 'C') {
            $this->loadModel('Notifications');
            //----------Notifications................

            $projectmember = $this->CompaniesUser->find('all', [
                'conditions' => [
                    'company_id' => $authuser->choosen_companyId
                ]
            ])->toArray();

            $admins = array();
            foreach ($projectmember as $member) {
                if ($member->member_role == 'Y' || $member->member_role == 'A') {
                    array_push($admins, $member->user_id);
                }
            }
            $uniqueadmin = array_unique($admins);
            $admins = array_unique($admins);
            foreach ($uniqueadmin as $member) {
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = $task->title;
                $notification->action_status = 'T';
                $notification->action_description = null;
                $notification->action_id = $task->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $member;
                $notification->type = 'ticket';
                $this->Notifications->save($notification);
            }

            $emailofadmins = $this->User->find('all', [
                'conditions' => [
                    'id in' => $admins
                ]
            ])->toArray();

            //send email Notification

            foreach ($emailofadmins as $user)
            $email = new Email();
            $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($user->email)
                ->setEmailFormat('html')
                ->setSubject('Ticket Details')
                ->setTemplate('general_ticket', 'default')
                ->setViewVars(['user' => $user, 'task' => $task]);
            $email->send();
        }

        $this->Flash->set('The Ticket Created.', [
            'element' => 'success'
        ]);
        if (!empty($taskview)) {
            return $this->redirect([
                'controller' => 'projecttasks',
                'action' => 'taskview',
                $taskview

            ]);
        }elseif (!empty($taskboard)) {
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'taskboard',
                $taskboard
            ]);
        }   elseif (!empty($projectview)) {
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'view',
                $projectview

            ]);
        } else {
            return $this->redirect([
                'controller' => 'projecttasks',
                'action' => 'tickets',

            ]);
        }
    }




    /*addtask method*/
    public function addtask()
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $this->loadModel('Taskgroups');
        $this->autoRender = false;
        $futured = $this->request->getData('isFutured');
        $pid = $this->request->getData('pid');
        $user_id = $this->Auth->user('id');

        $task = $this->Projecttasks->newEntity();
        $task->creatorId = $this->Auth->user('id');                                          //in creator id metto l'id
        $taskgroupId = $this->request->getData('tsgrouptype');
        $taskgroup = $this->Taskgroups->find('all', [
            'conditions' => [
                'id in' => $taskgroupId
            ]
        ])->first();

        $task->project_id = $this->request->getData('pid');
        $task->title = $this->request->getData('name');
        $task->description = $this->request->getData('description');
        $startdate = $this->request->getData('startdate');
        $startdate = Time::createFromFormat(
            'd/m/Y',
            $startdate,
            'Europe/Paris'
        );
        if ($startdate->i18nFormat('yyyy-MM-dd') < Time::now()->i18nFormat('yyyy-MM-dd') && $startdate->i18nFormat('yyyy-MM-dd') >= $taskgroup->startdate->i18nFormat('yyyy-MM-dd') && $startdate->i18nFormat('yyyy-MM-dd') < $taskgroup->expirydate->i18nFormat('yyyy-MM-dd')) {
            $this->Flash->error(__('Invalid Date !'));
            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'taskboard',
                pid
            ]);
        }
        $expirydate = $this->request->getData('expirydate');
        $expirydate = Time::createFromFormat(
            'd/m/Y',
            $expirydate,
            'Europe/Paris'
        );
        if ($expirydate->i18nFormat('yyyy-MM-dd') <= $startdate->i18nFormat('yyyy-MM-dd') && $expirydate->i18nFormat('yyyy-MM-dd') >= $taskgroup->startdate->i18nFormat('yyyy-MM-dd') && $expirydate->i18nFormat('yyyy-MM-dd') < $taskgroup->expirydate->i18nFormat('yyyy-MM-dd')) {
            $this->Flash->error(__('Invalid Date !'));
            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'taskboard',
                pid
            ]);
        }
        $task->startdate = $startdate;
        $task->expiration_date = $expirydate;
        $task->creation_date = Time::now();
        $task->price = $this->request->getData('price');
        $task->tax_percentage = $this->request->getData('tax');
        $task->status_updatedby = $this->Auth->user('id');
        $task->priority = $this->request->getData('task_prority');
        if (!empty($futured)) {
            $task->isFuturedTask = true;
        }
        $task = $this->Projecttasks->save($task);

        //add task assignees
        $assignees = $this->request->getData('taskassignees');
        if (!empty($assignees)) {
            foreach ($assignees as $assignee) {
                $this->loadModel('Taskusers');
                $taskuser = $this->Taskusers->newEntity();
                $taskuser->taskId = $task->id;
                $taskuser->assignee_id = intval($assignee);
                $taskuser->assigned_date = Time::now();
                $this->Taskusers->save($taskuser);
            }
        }

        //add ticket followers
        $followers = $this->request->getData('followers');
        if (!empty($followers)) {
            foreach ($followers as $follower_id) {
                $this->loadModel('Followers');
                $follower = $this->Followers->newEntity();
                $follower->user_id = intval($follower_id);
                $follower->taskId = $task->id;
                $follower->project_id = $pid;
                $follower->creation_date = Time::now();
                $this->Followers->save($follower);
            }
        }

        //add ticket files
        $taskfiles = $this->request->getData()['taskfiles'];


        foreach ($taskfiles as $file) {
            if (!empty($file['tmp_name'])) {
                $this->loadModel('Taskfiles');
                $taskfile = $this->Taskfiles->newEntity();
                $taskfile->user_id = $user_id;
                $taskfile->pid =  $pid;
                $taskfile->tid = $task->id;
                $taskfile->filename = $file['name'];
                $taskfile->type = $file['type'];
                $taskfile->size = $file['size'];
                $taskfile->creation_date = Time::now();
                $taskfile->filepath = "assets/taskfiles/" .  $task->id;
                $destinationFolder = WWW_ROOT . "assets/taskfiles/" . $task->id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Taskfiles->save($taskfile);
            }
        }
        // debug($taskfile);exit;

        $epic_task = $this->request->getData('epic_task');
        if (!empty($epic_task)) {
            $this->loadModel('EpictasksProjecttasks');
            $epictask = $this->EpictasksProjecttasks->newEntity();
            $epictask->epictask_id = $epic_task;
            $epictask->projecttask_id = $task->id;
            $epictask->projectId = $pid;
            $this->EpictasksProjecttasks->save($epictask);
        }



        //Create a record in TaskgroupsProjecttasks table with $task-id and $taskId
        $this->loadModel('TaskgroupsProjecttasks');
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->newEntity();
        $taskgroupsProjecttask->taskgroup_id = $taskgroupId;
        $taskgroupsProjecttask->projecttask_id = $task->id;
        $taskgroupsProjecttask->project_id = $pid;
        $this->TaskgroupsProjecttasks->save($taskgroupsProjecttask);

        $this->updatetakprogress($pid);
        $data = $this->ProjectMember->find('all')->toArray();
        $userid = array();
        foreach ($data as $item) {
            array_push($userid, $item['memberId']);
        }
        $users = $this->User->find('all', [
            'conditions' => [
                'id in' => $userid
            ]
        ])->toArray();

        if(!empty($futured)){
            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'futureprojectsview',
                $pid
            ]);

        }else{
            return $this->redirect([
                'controller' => 'ProjectObject',
                'action' => 'taskboard',
                $task->project_id
            ]);

        }


    }



    public function createEpictask()
    {

        $pid = $this->request->getData('epic_pid');

        $subtasks = $this->request->getData('epic_tasks');
        $task = $this->Projecttasks->newEntity();
        $task->creatorId = $this->Auth->user('id');
        $taskgroupId = $this->request->getData('tsgrouptype');
        $task->project_id =  $pid;
        $task->title = $this->request->getData('epic_name');
        $task->description = $this->request->getData('epic_description');
        $startdate = $this->request->getData('epic_startdate');
        $startdate = Time::createFromFormat(
            'd/m/Y',
            $startdate,
            'Europe/Paris'
        );
        $expirydate = $this->request->getData('epic_expirydate');
        $expirydate = Time::createFromFormat(
            'd/m/Y',
            $expirydate,
            'Europe/Paris'
        );
        $task->startdate = $startdate;
        $task->expiration_date = $expirydate;
        $task->creation_date = Time::now();
        $task->price = $this->request->getData('epic_price');
        $task->tax_percentage = $this->request->getData('epic_tax');
        $task->status_updatedby = $this->Auth->user('id');

        $task->priority = $this->request->getData('epic_task_prority');
        $task->isEpic = true;
        $task = $this->Projecttasks->save($task);


        //Create a record in TaskgroupsProjecttasks table with $task-id and $taskId
        $this->loadModel('TaskgroupsProjecttasks');
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->newEntity();
        $taskgroupsProjecttask->taskgroup_id = $taskgroupId;
        $taskgroupsProjecttask->projecttask_id = $task->id;
        $taskgroupsProjecttask->project_id = $pid;
        $this->TaskgroupsProjecttasks->save($taskgroupsProjecttask);


        //Create Subtasks for Epictask
        if (!empty($subtasks)) {
            $this->loadModel('EpictasksProjecttasks');
            foreach ($subtasks as $childtask) {
                $epictask = $this->EpictasksProjecttasks->newEntity();
                $epictask->epictask_id = $task->id;
                $epictask->projecttask_id = $childtask;
                $epictask->projectId = $pid;
                $this->EpictasksProjecttasks->save($epictask);
            }
        }

        $this->updatetakprogress($pid);
        return $this->redirect([
            'controller' => 'ProjectObject',
            'action' => 'taskboard',
            $pid
        ]);
    }
    public function docalltasks()
    {
        $this->loadModel('Projecttasks');
        $alltasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.isDeleted' => false,
            ]
        ])->toArray();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($alltasks));
    }


    public function updateindex()
    {
        $this->loadModel('Projecttaks');
        $data =  $this->request->getData('data');
        $i = 0;
        foreach ($data as $task) {
            $projecttask = $this->Projecttasks->find('all', [
                'conditions' => [
                    'Projecttasks.id in' => $task
                ]
            ])->first();
            $projecttask->index_number = $i;
            $this->Projecttasks->save($projecttask);
            $i++;
        }
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($data));
    }



    /**Tickets page */
    public function tickets($user_id = null)
    {
        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectObject');
        $this->loadModel('Taskgroups');
        $this->loadModel('CompaniesUser');
        $this->loadModel('Followers');
        $this->loadModel('Taskusers');
        $user_id = $this->Auth->User('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $authcompanymember = $this->CompaniesUser->find('all',[
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['Designations.Usermodulepermissions.Modules'])->first();
        //debug($authcompanymember);exit;


        $companyrole = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'user_id' => $user_id
            ]
        ])->contain('Designations')->first();


        $projectobjects = $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.company_id ' => $authuser->choosen_companyId
            ]
        ])->toArray();

        if ($companyrole->designation->name == 'Administrator') {
            $alltickets = $this->Projecttasks->find('all', [
                'conditions' => [
                    'type' => 'TC',
                    'category' => 'General',
                    'isDeleted' => false
                ]
            ])->contain(['Taskusers', 'Followers'])->toArray();


        } elseif ($companyrole->designation->name == 'Functional Analyst') {

            $taskusers = $this->Taskusers->find('all',[
                'conditions' => [
                    'assignee_id' => $user_id
                ]
            ])->toArray();
            $analysttaskids = array();
            foreach($taskusers as $task){
                array_push($analysttaskids, $task->taskId);
            }

            if (!empty($analysttaskids)) {
                $analysttickets = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'id in' => $analysttaskids

                    ]
                ])->toArray();
                $sometickets = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'type' => 'TC',
                        'ishaveAnalyst' => false,
                        'category' => 'General',
                        'isDeleted' => false

                    ]
                ])->contain(['Taskusers', 'Followers'])->toArray();
                $alltickets = array_merge($analysttickets, $sometickets);

            } else {
                $alltickets = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'type' => 'TC',
                        'ishaveAnalyst' => false,
                        'category' => 'General',
                        'isDeleted' => false

                    ]
                ])->contain(['Taskusers', 'Followers'])->toArray();
            }


        } elseif ($companyrole->designation->name == 'Customer') {
            $alltickets = $this->Projecttasks->find('all', [
                'conditions' => [
                    'type' => 'TC',
                    'category' => 'General',
                    'creatorId' => $user_id,
                    'isDeleted' => false
                ]
            ])->contain(['Taskusers', 'Followers'])->toArray();
        } else {
            $alltickets  = null;
        }
        $epictasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.isDeleted' => false,
                'Projecttasks.isEpic' => true
            ]
        ])->toArray();

        $this->loadModel('CompaniesUsers');
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User','Designations'])->toArray();



        $this->set(compact('companymembers', 'alltickets', 'projectobjects', 'epictasks', 'companyrole', 'user_id', 'authcompanymember'));
    }

    /**
     * View method
     *
     * @param string|null $id Projecttask id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($tid = null)
    {
        $this->loadModel('ProjectObject');
        $this->loadModel('Projecttasks');
        $this->loadModel('Taskfiles');
        $this->loadModel('Taskusers');
        $this->loadModel('Followers');

        $projecttask = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.id' => $tid
            ]
        ])->contain(['Projectobject', 'Createduser'])->first();
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.id in' => $projecttask->project_id
            ]
        ])->first();

        $taskfiles = $this->Taskfiles->find('all', [
            'conditions' => [
                'tid' => $tid
            ]
        ])->contain(['User'])->toArray();

        $taskusers = $this->Taskusers->find('all', [
            'conditions' => [
                'taskId' => $tid
            ]
        ])->contain(['User'])->toArray();

        $followers = $this->Followers->find('all', [
            'conditions' => [
                'task_id' => $tid
            ]
        ])->contain(['Users'])->toArray();


        $this->set(compact('projecttask', 'taskfiles', 'taskusers', 'followers'));
    }


    /*Update Task*/
    public function updatetask()
    {
        if ($this->request->is('post')) {
            $this->loadModel('User');
            $this->loadModel('TaskgroupsProjecttasks');
            $this->loadModel('Taskgroups');
            $this->loadModel('ProjectObject');
            $this->loadModel('Projecttasks');
            $this->loadModel('Notifications');
            $tid = $this->request->getData('id');
            $pid = $this->request->getData('pid');
            $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
            $taskgroups = $this->Taskgroups->find('all')->toArray();
            $projecttask = $this->Projecttasks->find('all')->toArray();
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'id' => $pid
                ]
            ])->first();
            $grouptype = $this->request->getData('type');
            $name = $this->request->getData('name');
            $description = $this->request->getData('description');
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
            $price = $this->request->getData('price');
            $tax = $this->request->getData('tax');
            $priority = $this->request->getData('priority');
            $epic_task = $this->request->getData('epic_task');

            $subtasks = $this->request->getData('epic_tasks');
            $updatetask = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $tid
                ]
            ])->first();
            $updatetask->title = $name;
            $updatetask->description = $description;
            $updatetask->price = $price;
            $updatetask->tax_percentage = $tax;
            $updatetask->startdate = $startdate;
            $updatetask->expiration_date = $expirydate;
            $updatetask->priority =  $priority;
            $this->Projecttasks->save($updatetask);


            //update TaskgroupsProjecttasks associate tables
            $updatetaskgroupProjecttask = $this->TaskgroupsProjecttasks->find('all', [
                'conditions' => [
                    'projecttask_id' => $tid
                ]
            ])->first();
            $updatetaskgroupProjecttask->taskgroup_id = $grouptype;
            $updatetaskgroupProjecttask->projecttask_id = $updatetask->id;
            $result = $this->TaskgroupsProjecttasks->save($updatetaskgroupProjecttask);


            //update epic table
            if (!empty($subtasks)) {
                $this->loadModel('EpictasksProjecttasks');
                foreach ($subtasks as $childtask) {
                    $epictask = $this->EpictasksProjecttasks->newEntity();
                    $epictask->epictask_id = $updatetask->id;
                    $epictask->projecttask_id = $childtask;
                    $epictask->projectId = $pid;
                    $this->EpictasksProjecttasks->save($epictask);
                }
            }

            if (!empty($epic_task)) {
                $this->loadModel('EpictasksProjecttasks');
                $epictask = $this->EpictasksProjecttasks->newEntity();
                $epictask->epictask_id = $epic_task;
                $epictask->projecttask_id = $tid;
                $epictask->projectId = $pid;
                $this->EpictasksProjecttasks->save($epictask);
            }
            if ($updatetask->type == 'TC') {
                $res1 = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'id' => $tid
                    ]
                ])->first();
                $customers = $this->ProjectMember->find('all', [
                    'conditions' => [
                        'type' => 'C'
                    ]
                ])->toArray();
                $user_id = $this->Auth->user('id');
                $customerids = array();
                foreach ($customers as $customer) {
                    array_push($customerids, $customer->memberId);
                }
                $uniquecustomerid = array_unique($customerids);
                foreach ($uniquecustomerid as $customer) {
                    //----------------------Notifications------------------------------------------->
                    $notification = $this->Notifications->newEntity();
                    $notification->fromuser_id = $user_id;
                    $notification->action_title = $updatetask->title;
                    $notification->action_status = $updatetask->status; // $leave->status;//New
                    $notification->action_description = null;
                    $notification->action_id = $updatetask->id;
                    $notification->creation_date = Time::now();
                    $notification->touser_id = $customer;
                    $notification->type = 'ticket';
                    $this->Notifications->save($notification);
                }
                $users = $this->User->find('all', [
                    'conditions' => [
                        'id in' => $customerids

                    ]

                ])->toArray();
                foreach ($users as $user) {
                    $email = new Email();
                    $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                        ->setTo($user->email)
                        ->setEmailFormat('html')
                        ->setSubject('Ticket Details')
                        ->setTemplate('ticket', 'default')
                        ->setViewVars(['user' => $user, 'updatetask' => $updatetask, 'projectObject' => $projectObject, 'manyObject' => $manyObject, 'taskgroups' => $taskgroups, 'projecttask' => $projecttask, 'pid' => $pid]);
                    $email->send();
                }
            }

            return $this->redirect([
                'controller' => 'projecttasks',
                'action' => 'taskview',
                $tid

            ]);
        }
    }

    /**Update Ticket */

    public function updateticket($ticketId = null)
    {

        $user_id =  $this->Auth->user('id');
        $alltickets = $this->request->getData('alltickets');
        $projectview = $this->request->getData('pid');

        $updateticket = $this->Projecttasks->find('all', [
            'conditions' => [
                'id in' => $ticketId
            ]
        ])->first();
        $updateticket->title = $this->request->getData('editticketname');

        $status =  $this->request->getData('editticketstatus');
        if (!empty($status)) {

            $updateticket->status = $status;
        } else {
            $updateticket->status =  $updateticket->status;
        }
        $category = $this->request->getData('editcategory');
        if (!empty($category)) {
            $updateticket->category =  $category;
        } else {
            $updateticket->category =  $updateticket->category;
        }

        $clientid = $this->request->getData('clientid');



        $pid = $this->request->getData('projectname');
        if (!empty($pid)) {
            $updateticket->project_id =  $pid;
            $group = $this->request->getData('editgrouptype');
        } else {
            $updateticket->project_id = null;
            $group = $this->request->getData('editgrouptype');
        }
        $assignees = $this->request->getData('edittaskassignees');

        $followers = $this->request->getData('editfollowers');

        $editticketstartdate = $this->request->getData('editticketstartdate');
        if (!empty($editticketstartdate)) {
            $editticketstartdate = Time::createFromFormat(
                'd/m/Y',
                $editticketstartdate,
                'Europe/Paris'
            );
            $updateticket->startdate =  $editticketstartdate;
        }

        $editticketexpirydate = $this->request->getData('editticketexpirydate');
        if (!empty($editticketexpirydate)) {
            $editticketexpirydate = Time::createFromFormat(
                'd/m/Y',
                $editticketexpirydate,
                'Europe/Paris'
            );
            $updateticket->expiration_date = $editticketexpirydate;
        }


        $updateticket->price = $this->request->getData('editticketprice');

        $updateticket->tax_percentage = $this->request->getData('edittickettax');
        $updateticket->priority = $this->request->getData('edittask_prority');
        $updateticket->description = $this->request->getData('editticketdescription');

        $this->Projecttasks->save($updateticket);
        $editepic_task = $this->request->getData('editepic_task');
        $editticketfiles = $this->request->getData('editticketfiles');

        $user_id = $this->Auth->User('id');
        $this->loadModel('User');
        $this->loadModel('CompaniesUser');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $analysts = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'member_role ' => 'A'
            ]
        ])->toArray();
        $analystIds = array();
        foreach($analysts as $analyst){
            array_push($analystIds, $analyst->user_id);

        }
        if (!empty($assignees)) {
            $this->loadModel('Taskusers');
            $taskassignees = $this->Taskusers->find('all',[
                'conditions' => [
                    'taskId ' => $ticketId
                ]
            ])->toarray();
            $taskuser = array();
           foreach($taskassignees as $taskassignee){
               array_push($taskuser, $taskassignee->assignee_id);

           }
           $analystrender = null;
            foreach ($assignees as $assignee) {
                if (!empty($taskuser)){
                    if (in_array($assignee, $taskuser)) {
                        $this->Flash->error(__('User Already Assigned to this Task  !'));

                    } else {
                        foreach ($analystIds as $analystid) {
                            if ($assignee == $analystid) {
                                $updateticket->ishaveAnalyst = true;
                                $this->Projecttasks->save($updateticket);
                                $analystrender = $updateticket;
                            }
                        }
                        $taskuser = $this->Taskusers->newEntity();
                        $taskuser->taskId = $updateticket->id;
                        $taskuser->assignee_id = intval($assignee);
                        $taskuser->assigned_date = Time::now();
                        $this->Taskusers->save($taskuser);
                    }
                } else {
                    foreach ($analystIds as $analystid) {
                        if ($assignee == $analystid) {
                            $updateticket->ishaveAnalyst = true;
                            $this->Projecttasks->save($updateticket);
                            $analystrender = $updateticket;
                        }
                    }
                    $taskuser = $this->Taskusers->newEntity();
                    $taskuser->taskId = $updateticket->id;
                    $taskuser->assignee_id = intval($assignee);
                    $taskuser->assigned_date = Time::now();
                    $this->Taskusers->save($taskuser);
                }
            }
        }


        if (!empty($followers)) {
            foreach ($followers as $follower_id) {
                $this->loadModel('Followers');
                $follower = $this->Followers->newEntity();
                $follower->user_id = intval($follower_id);
                $follower->task_id = $updateticket->id;
                $follower->project_id = $pid;
                $follower->creation_date = Time::now();
                $this->Followers->save($follower);
            }
        }
        if (!empty($editticketfiles)) {
            foreach ($editticketfiles as $file) {
                if (!empty($file['tmp_name'])) {
                    $this->loadModel('Taskfiles');
                    $taskfile = $this->Taskfiles->newEntity();
                    $taskfile->user_id = $user_id;
                    $taskfile->pid =  $pid;
                    $taskfile->tid = $updateticket->id;
                    $taskfile->filename = $file['name'];
                    $taskfile->type = $file['type'];
                    $taskfile->size = $file['size'];
                    $taskfile->creation_date = Time::now();
                    $taskfile->filepath = "assets/taskfiles/" .  $updateticket->id;
                    $destinationFolder = WWW_ROOT . "assets/taskfiles/" . $updateticket->id;
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                    $this->Taskfiles->save($taskfile);
                }
            }
        }

        if (!empty($group)) {
            $this->loadModel('TaskgroupsProjecttasks');
            $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->newEntity();
            $taskgroupsProjecttask->taskgroup_id = $group;
            $taskgroupsProjecttask->projecttask_id = $updateticket->id;
            $taskgroupsProjecttask->project_id = $pid;
            $this->TaskgroupsProjecttasks->save($taskgroupsProjecttask);
        }

        if (!empty($alltickets)) {
            $this->Flash->success(__(' Ticket Updated !'));
            return $this->redirect([
                'controller' => 'projecttasks',
                'action' => 'chargetickets',
                'ticketid' => $updateticket->id,
                'alltickets' => $updateticket->id,
                'status' => $updateticket->status

            ]);
        } elseif (!empty($pid)) {
            $this->Flash->success(__(' Ticket Updated !'));
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'view',
                $pid

            ]);
        }
    }

    public function deletesubtask()
    {
        $taskId = $this->request->getData('taskId');
        $subtask_id = $this->request->getData('subtaskid');
        $this->loadModel('EpictasksProjecttasks');
        $epic = $this->EpictasksProjecttasks->find('all', [
            'conditions' => [
                'epictask_id' => $taskId,
                'projecttask_id' => $subtask_id
            ]
        ])->first();

        $this->EpictasksProjecttasks->delete($epic);

        $task = $this->Projecttasks->find('all', [
            'conditions' => [
                'id in' => $taskId,
                'Projecttasks.isDeleted' => false
            ]
        ])->contain([
            'EpictasksProjecttasks.Projecttask',
        ])->first();

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($task));
    }

    public function unlinktoepic()
    {
        $taskId = $this->request->getData('taskId');
        $epictaskid = $this->request->getData('epictaskid');
        $this->loadModel('EpictasksProjecttasks');

        $epic = $this->EpictasksProjecttasks->find('all', [
            'conditions' => [
                'epictask_id' => $epictaskid,
                'projecttask_id' => $taskId
            ]
        ])->first();
        $this->EpictasksProjecttasks->delete($epic);
        $task = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.id in' => $taskId,
                'Projecttasks.isDeleted' => false,
                'isEpic' => true
            ]
        ])->toArray();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($task));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projecttask = $this->Projecttasks->newEntity();
        if ($this->request->is('post')) {
            $projecttask = $this->Projecttasks->patchEntity($projecttask, $this->request->getData());
            if ($this->Projecttasks->save($projecttask)) {
                $this->Flash->success(__('The projecttask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projecttask could not be saved. Please, try again.'));
        }
        $projects = $this->Projecttasks->Projects->find('list', ['limit' => 200]);
        $this->set(compact('projecttask', 'projects'));
    }





    /**
     * Edit method
     *
     * @param string|null $id Projecttask id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projecttask = $this->Projecttasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projecttask = $this->Projecttasks->patchEntity($projecttask, $this->request->getData());
            if ($this->Projecttasks->save($projecttask)) {
                $this->Flash->success(__('The projecttask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projecttask could not be saved. Please, try again.'));
        }
        $projects = $this->Projecttasks->Projects->find('list', ['limit' => 200]);
        $this->set(compact('projecttask', 'projects'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projecttask id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /**Delete signle task */
    public function deletesingletask()
    {
        $this->loadModel('Taskgroups');
        $tid = $this->request->getQuery('tid');
        $pid = $this->request->getQuery('pid');
        $deletetask = $this->Projecttasks->find('all', [
            'conditions' => [
                'id' => $tid
            ]
        ])->first();


        $this->loadModel('TaskgroupsProjecttasks');
        $deletegrouptask =  $this->TaskgroupsProjecttasks->find('all', [
            'conditions' => [
                'projecttask_id' => $deletetask->id

            ]
        ])->contain(['Projecttasks', 'Taskgroups'])->first();

        $deletegrouptask->isDeleted = true;
        $deletegrouptask->taskgroup->price = $deletegrouptask->taskgroup->price - $deletegrouptask->projecttask->price;
        $deletegrouptask->taskgroup->tax_percentage = $deletegrouptask->taskgroup->tax_percentage - $deletegrouptask->projecttask->tax_percentage;
        $totalhrs = 0;
        $diff = abs(strtotime($deletegrouptask->projecttask->expiration_date) - strtotime($deletegrouptask->projecttask->startdate));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $totalhrs = $totalhrs + ($days + 1) * 8;
        $deletegrouptask->taskgroup->total_workinghrs = $deletegrouptask->taskgrouptotal_workunghrs - $totalhrs;
        $this->TaskgroupsProjecttasks->save($deletegrouptask);

        $this->loadModel('ProjectObject');
        $projectupdate = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $pid
            ]
        ])->first();

        $projectgroups = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' > $pid
            ]
        ])->toArray();
        $totalprice = 0;
        $totaltax = 0;
        $projecttotalhrs = 0;
        foreach ($projectgroups as $group) {
            $totalprice = $totalprice + $group->price;
            $totaltax = $totaltax + $group->tax;
            $totalhr = $projecttotalhrs + $group->total_workinghrs;
        }
        $projectupdate->price = $totalprice;
        $projectupdate->tax = $totaltax;
        $projectupdate->total_workinghrs = $totalhr;

        $this->ProjectObject->save($projectupdate);

        $deletetask->isDeleted = true;
        $this->Projecttasks->save($deletetask);

        return $this->redirect([
            'controller' => 'projectObject',
            'action' => 'view',
            $pid

        ]);
    }




    public function delete()
    {
        $this->request->allowMethod(['post', 'delete', 'Get']);
        $tid = $this->request->getQuery('taskId');
        $alltickets = $this->request->getQuery('alltickets');



        if (!empty($tid)) {


            $deletetask = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $tid
                ]
            ])->first();
            $pid = $deletetask->project_id;



            //update price and tax in taskgroup and projectobject
            $this->loadModel('TaskgroupsProjecttasks');
            $deletegrouptask =  $this->TaskgroupsProjecttasks->find('all', [
                'conditions' => [
                    'projecttask_id' => $deletetask->id,
                    'TaskgroupsProjecttasks.isDeleted' => false

                ]
            ])->contain(['Projecttasks', 'Taskgroups'])->first();
            if (!empty($deletegrouptask)) {

                $deletegrouptask->isDeleted = true;
                $deletegrouptask->taskgroup->price = $deletegrouptask->taskgroup->price - $deletegrouptask->projecttask->price;
                $deletegrouptask->taskgroup->tax_percentage = $deletegrouptask->taskgroup->tax_percentage - $deletegrouptask->projecttask->tax_percentage;
                $totalhrs = 0;
                $diff = abs(strtotime($deletegrouptask->projecttask->expiration_date) - strtotime($deletegrouptask->projecttask->startdate));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $totalhrs = $totalhrs + ($days + 1) * 8;

                $deletegrouptask->taskgroup->total_workinghrs =  $deletegrouptask->taskgroup->total_workinghrs - $totalhrs;
                $deletegrouptask->isNew(true); // when we update data throught association relation we use this function

                $this->TaskgroupsProjecttasks->save($deletegrouptask);
            }
            if ($pid != null) {
                $this->loadModel('ProjectObject');
                $projectupdate = $this->ProjectObject->find('all', [
                    'conditions' => [
                        'id in' => $pid
                    ]
                ])->first();

                $this->loadModel('Taskgroups');

                $projectgroups = $this->Taskgroups->find('all', [
                    'conditions' => [
                        'projectId' > $pid
                    ]
                ])->toArray();
                $totalprice = 0;
                $totaltax = 0;
                $projecttotalhrs = 0;
                foreach ($projectgroups as $group) {
                    $totalprice = $totalprice + $group->price;
                    $totaltax = $totaltax + $group->tax;
                    $totalhr = $projecttotalhrs + $group->total_workinghrs;
                }

                $projectupdate->price = $totalprice;
                $projectupdate->tax = $totaltax;
                $projectupdate->total_workinghrs = $totalhr;

                $this->ProjectObject->save($projectupdate);
            }

            $deletetask->isDeleted = true;

            if ($this->Projecttasks->save($deletetask)) {
                $this->Flash->success(__('The projecttask has been deleted.'));
            } else {
                $this->Flash->error(__('The projecttask could not be deleted. Please, try again.'));
            }
        }
        if (!empty($id)) {

            $this->loadModel('Taskgroups');
            $taskgroups = $this->Taskgroups->find('all')->toArray();
            $this->loadModel('TaskgroupsProjecttasks');
            $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
            $this->loadModel('ProjectObject');
            $pid =  $this->request->getQuery('pid');
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'id' => $pid
                ]
            ])->first();
            $uid = $this->request->getQuery('uid');
            $updatetask = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id' => $id
                ]
            ])->first();


            $this->loadModel('ProjectMember');
            $this->loadModel('User');

            $projectmember = $this->ProjectMember->find('all', [
                'conditions' => [
                    'type' => 'Y'
                ]
            ])->toArray();
            $customer = $this->User->find('all', [
                'conditions' => [
                    'id' => $uid
                ]
            ])->first();
            $userid = array();
            foreach ($projectmember as $member) {
                array_push($userid, $member['memberId']);
            }
            $users = $this->User->find('all', [
                'conditions' => [
                    'id in' => $userid

                ]
            ])->toArray();
            $chiefemails = array();
            foreach ($users as $user) {
                array_push($chiefemails, $user['email']);
            }
            $email = new Email();
            $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($chiefemails, $customer->email)
                ->setemailFormat('html')
                ->setSubject('Customer  ' . $customer->firstname . ' ' . $customer->lastname . '. Rejected the Ticket  ' . $updatetask->title)
                ->setTemplate('ticket', 'default')
                ->setViewVars(['updatetask' => $updatetask, 'projectObject' => $projectObject, 'manyObject' => $manyObject, 'taskgroups' => $taskgroups]);
            $email->send();
            $updatetask->isDeleted = true;

            $this->loadModel('Notifications');

            $projectmember = $this->ProjectMember->find('all', [
                'conditions' => [
                    'type' => 'Y'
                ]
            ])->toArray();
            $admins = array();
            foreach ($projectmember as $member) {
                array_push($admins, $member->memberId);
            }
            $uniqueadmin = array_unique($admins);
            $user_id =  $this->Auth->user('id');
            $admins = array_unique($admins);
            foreach ($uniqueadmin as $member) {
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = $updatetask->title;
                $notification->action_status = 'Rejected by customer';
                $notification->action_description = null;
                $notification->action_id = $updatetask->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $member;
                $notification->type = 'ticket';
                $this->Notifications->save($notification);
            }
            if ($this->Projecttasks->save($updatetask)) {
                $this->Flash->success(__('The projecttask has been deleted.'));
            } else {
                $this->Flash->error(__('The projecttask could not be deleted. Please, try again.'));
            }
        }
        if (!empty($alltickets)) {
            return $this->redirect([
                'controller' => 'projecttasks',
                'action' => 'tickets'
            ]);
        } else {
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'taskboard',
                $pid

            ]);
        }
    }

    public function updatepriority()
    {
        $taskId = $this->request->getData('taskId');
        $priority = $this->request->getData('priority');
        $this->loadModel('Projecttasks');
        $projecttask = $this->Projecttasks->find('all', [
            'conditions' => [
                'id in' => $taskId
            ]
        ])->first();
        $projecttask->priority = $priority;
        $this->Projecttasks->save($projecttask);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($projecttask));
    }


    public function grouptasks()
    {
        $this->loadModel('User');
        $this->loadModel('Taskgroups');
        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $this->loadModel('Taskusers');
        $this->loadModel('Comments');
        $this->loadModel('Followers');
        $this->loadModel('Taskfiles');
        $this->loadModel('TaskgroupsProjecttasks');
        $user_id = $this->Auth->user('id');
        $group_id = $this->request->getQuery('group_id');
        $id = $this->request->getQuery('pid');
        $selectedgroup = $this->Taskgroups->find('all', [
            'conditions' => [
                'id in' => $group_id
            ]
        ])->toArray();
        $grouptasks = $this->TaskgroupsProjecttasks->find('all', [
            'conditions' => [
                'taskgroup_id' => $group_id
            ]
        ])->toArray();
        if (!empty($grouptasks)) {
            $alltaskids = array();
            foreach ($grouptasks as $group) {
                array_push($alltaskids, $group->projecttask_id);
            }


            $tasks = $this->Projecttasks->find(
                'all',
                [
                    'conditions' => [
                        'id in' => $alltaskids
                    ]
                ]
            )->toArray();

            //todotasks
            $todoTasks =  $this->Projecttasks->find('all', [
                'conditions' => [
                    'status' => 'T',
                    'project_id' => $id,
                    'id in' => $alltaskids,
                    'Projecttasks.isDeleted' => false
                ]
            ])->toArray();

            //Inprogress tasks
            $inProTasks =  $this->Projecttasks->find('all', [
                'conditions' => [
                    'status' => 'I',
                    'project_id' => $id,
                    'id in' => $alltaskids,
                    'Projecttasks.isDeleted' => false
                ]
            ])->toArray();

            //Completed tasks
            $doneTasks =  $this->Projecttasks->find('all', [
                'conditions' => [
                    'status' => 'D',
                    'project_id' => $id,
                    'id in' => $alltaskids,
                    'Projecttasks.isDeleted' => false
                ]
            ])->toArray();
        } else {
            $alltaskids = null;
            $tasks = null;
            $todoTasks = null;
            $inProTasks = null;
            $doneTasks = null;
        }

        $alltaskfollowers = $this->Followers->find('all')->toArray();
        $taskusers = $this->Taskusers->find('all')->toArray();
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
        $this->set(compact('manyObject'));
        $taskgroups = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' => $id
            ]
        ])->toArray();
        $this->set(compact('taskgroups'));
        $allUsers = $this->User->find('all')->toArray();
        $projectMembers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id,
            ]
        ])->contain(['Designations'=> function ($q) {
            return $q->where([
               'name !=' => 'Project Manager'
            ]);
        },])->toArray();
        $managers = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $id
            ]
        ])->contain(['Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Project Manager'
            ]);
        },])->toArray();

        /**tags */
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

        $data2 = $this->ProjectMember->find(
            'all',
            [
                'conditions' => [
                    'memberId' => $user_id
                ]
            ]
        )->contain(['Designations'])->first();
        $managerids = array();
        foreach ($managers as $item) {
            array_push($managerids, $item['memberId']);
        }
        $userid = array();
        foreach ($projectMembers as $item) {
            array_push($userid, $item['memberId']);
        }
        $totalprojectmemberids = array_merge($userid, $managerids);

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
        $this->set(compact('allcomments', 'alltaskfollowers', 'user_id',  'taskusers', 'todoTasks', 'inProTasks', 'doneTasks', 'tasks', 'projectObject', 'data2', 'allUsers', 'projectMembers', 'userid', 'managerids', 'managers', 'totalprojectmemberids', 'result','group_id'));
    }


    public function checktype()
    {
        $tid = $this->request->getData('taskId');
        $pid = $this->request->getData('pid');

        $checktask = $this->Projecttasks->find('all', [
            'conditions' => [
                'id in' => $tid
            ]
        ])->first();

        $result = array();
        if ($checktask->type == 'TC') {
            $result = array(
                'RESULT' => "ERROR",
                'MESSAGE' => "Can not Drag the Ticket",
                'CHECKTASK' => null
            );
            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($result));
        } else {
            $result = array(
                'RESULT' => "SUCCESS",
                'MESSAGE' => "",
                'CHECKTASK' => $checktask
            );
            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($result));
        }
    }

    public function filterprojects()
    {
        $pid = $this->request->getData('tagvalue');
        $this->loadModel('Taskgroups');

        $taskgroups = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' => $pid
            ]
        ])->contain(['Projecttasks'])->toArray();
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($taskgroups));
    }

    public function newticket()
    {

        $typeticket = $this->request->getQuery('typeticket');
        $projectId = $this->request->getQuery('pid');
        $taskboard = $this->request->getQuery('taskboard');
        $grouptasks = $this->request->getQuery('grouptasks');

        $this->loadModel('ProjectMember');
        $projectclient = $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $projectId
            ]
        ])->contain([ 'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->first();
        $taskId = $this->request->getQuery('taskId');
        $this->loadModel('Taskgroups');
        $this->loadModel('User');
        $this->loadModel('CompaniesUser');

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $projectgroups = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' => $projectId
            ]
        ])->toArray();

        $epictasks = $this->Projecttasks->find('all',[
            'conditions' => [
                'project_id' => $projectId,
                'Projecttasks.isDeleted' => false,
                'Projecttasks.isEpic' => true
            ]
        ])->toArray();
        $authuser_company_role = $this->CompaniesUser->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'company_id ' => $authuser->choosen_companyId
            ]
        ])->contain(['Designations'])->first();



        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,

            ]
        ])->contain(['User','Designations'])->toArray();

        if (!empty($taskId)) {
            $this->loadModel('Projecttasks');
            $projecttask = $this->Projecttasks->find('all', [
                'conditions' => [
                    'id in' => $taskId
                ]
            ])->first();
        } else {
            $projecttask = null;
        }
        $epictasks = $this->Projecttasks->find('all',[
            'conditions' => [
                'Projecttasks.isDeleted' => false,
                'Projecttasks.isEpic' => true
            ]
        ])->toArray();
        $this->set(compact('projectgroups', 'projectId', 'companymembers', 'projecttask', 'typeticket', 'projectclient', 'authuser_company_role', 'taskboard','grouptasks','epictasks'));
    }


    public function taskview($taskid)
    {
        $this->loadModel('User');
        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('Taskgroups');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();

        $authuser_role = $this->CompaniesUser->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['Designations'])->first();

        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User','Designations'])->toArray();

        $allUsers = $this->User->find('all')->toArray();
        $projecttask = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.id in' => $taskid,
                'Projecttasks.isDeleted' => false,


            ]
        ])->contain([
            'EpictasksProjecttasks',
            'Subtasks.Epictasks',
            'Taskgroupsprojecttasks',
            'Projectobject.Projecttaskgroups',
            'TaskComments' => function ($q) {
                return $q->where([
                    'comment_id is' => null,
                ]);
            },
            'TaskComments.User',
            'TaskComments.Replies.Taskfiles',
            'TaskComments.Replies.User',
            'TaskComments.Taskfiles',
            'Taskusers.User',
            'Createduser',
            'Followers.Users',

        ])->first();

       // debug($projecttask);exit;
        $projecttasktickets = $this->Projecttasks->find('all',[
            'conditions' => [
                'id in' => $taskid,
                'referred_taskId is not' => null
            ]
        ])->toArray();

        $epictasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.isDeleted' => false,
                'Projecttasks.isEpic' => true
            ]
        ])->toArray();
        $taskgroups = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' => $projecttask->project_id
            ]
        ])->toArray();



        $this->set(compact('projecttask', 'user_id', 'allUsers', 'companymembers', 'authuser_role', 'manyObject', 'taskgroups', 'user_id','epictasks'));
    }

    public function updateduedate()
    {
        $taskId = $this->request->getData('taskId');
        $duedate = $this->request->getData('duedate');

        $duedate = Time::createFromFormat(
            'd/m/Y',
            $duedate,
            'Europe/Paris'
        );

        $task =  $this->Projecttasks->find('all', [
            'conditions' => [
                'id in' => $taskId
            ]
        ])->first();
        $task->expiration_date = $duedate;
        $this->Projecttasks->save($task);
        $this->Flash->success(__('Task Due Date Updated..'));

        return $this->redirect([
            'controller' => 'projecttasks',
            'action' => 'taskview',
            $taskId
        ]);
    }

    public function updatetaskusers()
    {
        $this->loadModel('CompaniesUser');

        $this->loadModel('Taskusers');
        $taskusers = $this->request->getData('usersArr');

        $taskId = $this->request->getData('tid');
        $task = $this->Projecttasks->find('all',[
            'conditions' => [
                'Projecttasks.id in' => $taskId
            ]
        ])->contain(['Projectobject', 'Taskusers'])->first();
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $task->projectobject->company_id
            ]
        ])->toArray();

        if (!empty($taskusers)) {
            foreach ($taskusers as $key => $userid) {
                if ($userid != 0) {
                    $taskuser = $this->Taskusers->newEntity();
                    $taskuser->taskId = $taskId;
                    $taskuser->assignee_id = intval($userid);
                    $taskuser->assigned_date = Time::now();
                    $this->Taskusers->save($taskuser);
                    $this->Flash->success(__('Employee is Assigned to Task.'));
                } else {
                    $taskuser = $this->Taskusers->find('all', [
                        'conditions' => [
                            'assignee_id' => $companymembers[$key]->user_id
                        ]
                    ])->first();
                    if (!empty($taskuser)) {
                        $this->Taskusers->delete($taskuser);

                    }
                }
            }
        }

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($taskuser));
    }
    public function ticketsview()
    {
        $type = $this->request->getQuery('status');


        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectObject');
        $this->loadModel('Taskgroups');
        $this->loadModel('CompaniesUser');
        $this->loadModel('Followers');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'CompaniesUser.user_id in' => $user_id
            ]
        ])->contain(['User','Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();

        $companyrole = $this->CompaniesUser->find('all', [
            'conditions' => [
                'user_id' => $user_id
            ]
        ])->contain(['Designations'])->first();

        $projectobjects = $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.company_id ' => $authuser->choosen_companyId
            ]
        ])->toArray();

        $alltickets = $this->Projecttasks->find('all', [
            'conditions' => [
                'type' => 'TC',
                'project_id is' => null,
                'referred_taskId is' => null,
                'Projecttasks.isDeleted' => false,
                'status is' => $type
            ]
        ])->contain(['Taskusers', 'Followers'])->toArray();

        $epictasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.isDeleted' => false,
                'Projecttasks.isEpic' => true
            ]
        ])->toArray();

        $this->loadModel('CompaniesUsers');
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User','Designations'])->toArray();

        $this->set(compact('companymembers', 'alltickets', 'projectobjects', 'epictasks', 'companyrole', 'type', 'authuser', 'authcompanymember'));
    }

    public function filterprojectsofclient()
    {
        $this->loadModel('ProjectMember');
        $client_id = $this->request->getData('clientid');

        $clientprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'ProjectMember.memberId' => $client_id
            ]
        ])->contain([
            'Projectobject',
            'Designations' => function ($q) {
                return $q->where([
                    'name is' => 'Customer'
                ]);
            },
        ])->toArray();

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($clientprojects));
    }
    public function chargetickets()
    {

        $ticketId = $this->request->getQuery('ticketid');
        $alltickets = $this->request->getQuery('alltickets');


        $status = $this->request->getQuery('status');

        $this->loadModel('CompaniesUser');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $ticket = $this->Projecttasks->find('all', [
            'conditions' => [
                'Projecttasks.id in' => $ticketId
            ]
        ])->contain([
            'EpictasksProjecttasks',
            'Subtasks.Epictasks',
            'Taskgroupsprojecttasks',
            'Projectobject.Projecttaskgroups',
            'TaskComments.Taskfiles',
            'TaskComments.User',
            'Taskusers.User',
            'Createduser',
            'Followers.Users',
            'Taskfiles'
        ])->first();





        if (!empty($ticket->task_comments)) {

            foreach ($ticket->task_comments as $comment) {
                $comment->creation_date = $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');

                if ($comment->last_update != null) {
                    $comment->last_update = $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                }
            }
        }


        $companyrole = $this->CompaniesUser->find('all',[
            'conditions' => [
                'user_id in' => $user_id,
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['Designations'])->first();
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User','Designations'])->toArray();


        $this->set(compact('ticket', 'companyrole', 'alltickets', 'authuser', 'companymembers', 'status', 'ticketId'));

    }

    private function updatetakprogress($pid){
        //Update Task tax,price, workinghrs to group
        $groups =  $this->TaskgroupsProjecttasks->find('all', [
            'conditions' => [
                'TaskgroupsProjecttasks.project_id' => $pid
            ]
        ])->contain([
            'Taskgroups.Projecttasks' => function ($q) {
                return $q->where([
                    'Projecttasks.isDeleted' => false,
                    'Projecttasks.isFuturedTask' => false,
                ]);
            },
        ])->toArray();

        $projectgroups = array();
        foreach ($groups as $group) {
            if (!array_key_exists($group->taskgroup_id, $projectgroups)) {
                $projectgroups[$group->taskgroup_id] = $group;
            }
        }

        $project_totalprice = 0;
        $project_totaltax = 0;
        $project_totalhrs = 0;
        foreach ($projectgroups as $projectgroup) {
            $totalprice = 0;
            $totaltax = 0;
            $totalhrs = 0;
            foreach ($projectgroup->taskgroup->projecttasks as $projecttask) {
                $totalprice = $totalprice + $projecttask->price;
                $totaltax = $totaltax +  $projecttask->tax_percentage;
                $diff = abs(strtotime($projecttask->expiration_date) - strtotime($projecttask->startdate));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $totalhrs = $totalhrs + ($days + 1) * 8;
            }
            $projectgroup->taskgroup->price =   $totalprice;
            $projectgroup->taskgroup->tax_percentage =  $totaltax;
            $projectgroup->taskgroup->total_workinghrs = $totalhrs;
            $projectgroup->isNew(true); // when we update data throught association relation we use this function
            $this->TaskgroupsProjecttasks->save($projectgroup);

            $project_totalprice = $project_totalprice + $projectgroup->taskgroup->price;
            $project_totaltax = $project_totaltax + $projectgroup->taskgroup->tax_percentage;
            $project_totalhrs = $project_totalhrs + $projectgroup->taskgroup->total_workinghrs;
        }

        //update Task-group Price to Project
        $this->loadModel('ProjectObject');
        $updateproject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $pid
            ]
        ])->first();

        $updateproject->price =  $project_totalprice;
        $updateproject->tax = $project_totaltax;
        $updateproject->total_workinghours =  $project_totalhrs;
       $this->ProjectObject->save($updateproject);

    }
}
