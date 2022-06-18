<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Core\Configure;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{
    public function isAuthorized($user)
    {
        return true;
    }

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
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
    }

    /*Replay comments*/
    public function replycomment()
    {
        $this->loadModel('Projecttasks');
        $comment = $this->Comments->newEntity();
        $taskId = $this->request->getData('taskId');
        $commentId = $this->request->getData('commentId');
        $content = $this->request->getData('reply');
        $pid = $this->request->getData('pid');
        //$mydiv = $this->request->getData('mydiv');
        //debug($mydiv);exit;
        //if($content != null){
        $comment->taskId = $taskId;
        $comment->project_id = $pid;
        $comment->comment_id = $commentId;
        $comment->content = $content;
        $comment->user_id = $this->Auth->user('id');
        $comment->creation_date = Time::now();
        // $comment->last_update = null;
        //debug($comment);exit;
        $this->Comments->save($comment);

        //get the task
        $task = $this->Projecttasks->find('all', [
            'conditions' => [
                'id' => $taskId
            ]
        ])->first();
        //Get the Comment
        $oldcomment = $this->Comments->find('all', [
            'conditions' => [
                'id in' => $commentId
            ]
        ])->first();


        //notification

        $user_id = $this->Auth->user('id');
        $notification = $this->Notifications->newEntity();
        $notification->fromuser_id = $user_id;
        $notification->action_title = $task->title;
        $notification->action_status = 'reply'; // $leave->status;//New
        $notification->action_description = $comment->content;
        $notification->action_id = $comment->id;
        $notification->creation_date = Time::now();
        $notification->touser_id = $oldcomment->user_id;
        $notification->type = 'comment';
        $this->Notifications->save($notification);




        return $this->redirect([
            'controller' => 'projectObject',
            'action' => 'comments',
            $pid,


        ]);

    }

    /*singletask Replay*/

    public function singletaskReply()
    {

        $comment = $this->Comments->newEntity();
        $taskId = $this->request->getData('taskId');
        $commentId = $this->request->getData('commentId');
        $content = $this->request->getData('reply');
        $pid = $this->request->getData('pid');
        //$mydiv = $this->request->getData('mydiv');
        //debug($mydiv);exit;
        //if($content != null){
        $comment->taskId = $taskId;
        $comment->project_id = $pid;
        $comment->comment_id = $commentId;
        $comment->content = $content;
        $comment->user_id = $this->Auth->user('id');
        $comment->creation_date = Time::now();
        $comment->last_update = null;
        //debug($pid);exit;
        $this->Comments->save($comment);


        return $this->redirect([
            'controller' => 'projecttasks',
            'action' => 'view',
            $taskId,
            $pid,


        ]);
    }
    /**Delete Singletaskcomments */
    public function deletesingletaskComment()
    {
        $this->request->getData(['post', 'delete', 'PUT']);
        //$user_id = $this->Auth->user('id');
        //debug('Hiii');exit;

        $pid = $this->request->getQuery('pid');
        $taskId = $this->request->getQuery('taskId');
        $commentId = $this->request->getQuery('commentId');
        //debug($taskId);exit;
        $deletecomment = $this->Comments->find('all', [
            'conditions' => [
                'id' => $commentId
            ]

        ])->first();

        $this->Comments->delete($deletecomment);

        return $this->redirect([
            'controller' => 'projecttasks',
            'action' => 'view',
            $taskId,
            $pid
        ]);
    }




    /*SingleTask Comments*/

    public function singletaskComments($tid)
    {

        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttasks');
        //$pid = $this->request->getData('pid');
        $pid = $this->request->getData('pid');

        $newcomment = $this->Comments->newEntity();


        $content = $this->request->getData('content');
        //debug($content); exit;
        $newcomment->project_id = $pid;
        $newcomment->taskId = $tid;
        $newcomment->user_id = $this->Auth->user('id');
        $newcomment->content = $content;
        $newcomment->last_update = null;
        $newcomment->creation_date = Time::now();

        $this->Comments->save($newcomment);
        return $this->redirect([
            'controller' => 'projecttasks',
            'action' => 'view',
            $tid,
            $pid

        ]);
    }

    /**Update is seen */

    public function updateIsseen()
    {
        $tid = $this->request->getData('tid');
        $this->loadModel('Comments');
        $comments = $this->Comments->find('all', [
            'conditions' => [
                'comment_id is' => null,
                'taskId' => $tid,
            ]
        ])->contain(['User'])->toArray();

        foreach ($comments as $comment) {
            $cmt = $this->Comments->find('all', [
                'conditions' => [
                    'comment_id is' => null,
                    'taskId' => $tid,
                    'id' => $comment->id

                ]
            ])->first();
            $cmt->isSeen = true;
            $cmt->creation_date = Time::now();
            $this->Comments->save($cmt);
            $allcomments = $this->Comments->find('all', [
                'conditions' => [
                    'comment_id is' => null,
                    'taskId' => $tid
                ]
            ])->order(['creation_date' => 'ASC'])->contain([
                'Replies',
                'Replies.Taskfiles',
                'Replies.User',
                'User',
                'Taskfiles'
            ])->toArray();
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($allcomments));
        }
    }

    /**ajax messages retriew */

    public function retrieveMessages()
    {
        $this->loadModel('User');
        $this->loadModel('Comments');
        $tid = $this->request->getData('tid');
        //debug($tid);exit;

        $allcomments = $this->Comments->find('all', [
            'conditions' => [
                'comment_id is' => null,
                'taskId' => $tid
            ]
        ])->contain(['User'])->order(['creation_date' => 'ASC'])->toArray();

        debug($allcomments);
        exit;

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($allcomments));
    }

    public function submitMessage()
    {

        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttasks');
        $this->loadModel('Taskfiles');
        $this->loadModel('Followers');
        $isFileNotAttached = $this->request->getData('isFileNotAttached');
        $generalticket = $this->request->getData('generalticket');
        $tid = $this->request->getData('tid');
        if($isFileNotAttached == 0) {
            $files = $this->request->getData()['file'];
        }

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $task = $this->Projecttasks->find('all',[
            'conditions' => [
                'id in' => $tid
            ]
        ])->first();

        $pid =$task->project_id;
        $replay = $this->request->getData('replay');
       if($replay == 1){
        $cid = $this->request->getData('cid');
       }
        $content = $this->request->getData('content');
        $this->loadModel('Taskusers');
        $usersoftask = $this->Taskusers->find('all', [
            'conditions' => [
                'taskId' => $tid
            ]
        ])->toArray();
        if($pid != null){
            $allmembers = $this->ProjectMember->find('all', [
                'conditions' => [
                    'projectId' => $pid
                ]
            ])->toArray();
            $followers = $this->Followers->find('all', [
                'conditions' => [
                    //'isDeleted' => false,
                    'project_id' => $pid
                ]
            ])->toArray();

            $touserids = array();
            foreach ($usersoftask as $usertask) {
                array_push($touserids, $usertask['assignee_id']);
            }
            foreach ($allmembers as $member) {
                if($member->type == 'Y'||$member->type =='Z' || $member->type =='C'){
                    array_push($touserids, $member['memberId']);
                }

            }

            foreach ($followers as $follower) {
                array_push($touserids, $follower->user_id);
            }
            $touserids = array_unique($touserids);

        }else{
            $this->loadModel('CompaniesUser');
            $touserids = array();
            array_push($touserids, $task->creatorId);
            $companymembers = $this->CompaniesUser->find('all')->contain('Designations')->toArray();
            foreach($companymembers as $companymember){
                if($companymember->designation->name == 'Administrator' || $companymember->member_role =='Functional Analyst'){
                    array_push($touserids, $companymember->user_id);

                }
            }
        }




        $newcomment = $this->Comments->newEntity();
        $newcomment->project_id = $pid;
        $newcomment->taskId = $tid;
        $newcomment->user_id = $this->Auth->user('id');
        $newcomment->content = $content;
        $newcomment->last_update = null;
        $newcomment->creation_date = Time::now();
        if($replay ==1){
            $newcomment->comment_id = $cid;
        }

        $this->Comments->save($newcomment);
        //save file
        if($isFileNotAttached == 0) {
        foreach ($files as $file) {
            $taskfiles = $this->Taskfiles->newEntity();
            $taskfiles->comment_id = $newcomment->id;
            $taskfiles->tid = $tid;
            $taskfiles->user_id = $user_id;
            $taskfiles->pid = $pid;
            $taskfiles->filename = $file['name'];
            $taskfiles->type = $file['type'];
            $taskfiles->size = $file['size'];
            $taskfiles->creation_date = Time::now();
            $taskfiles->filepath = "assets/taskfiles/" .  $tid . $newcomment->id;
            $destinationFolder = WWW_ROOT . "assets/taskfiles/" .  $tid . $newcomment->id;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);

            $this->Taskfiles->save($taskfiles);
        }
    }

        //get the task
        $task = $this->Projecttasks->find('all', [
            'conditions' => [
                'id' => $tid
            ]
        ])->first();

                $finalarray = array_unique($touserids);
        //Notification on comments
        if (!empty($finalarray)) {
            foreach ($finalarray as $toId) {
                if ($toId != $user_id) {
                   $this->commentPostedNotification($toId, $newcomment->id);
                }
            }
        }
       // debug($isFileNotAttached);exit;


            $allcomments = $this->Comments->find('all', [
                'conditions' => [
                    'comment_id is' => null,
                    'taskId' => $tid
                ]
            ])->order(['creation_date' => 'ASC'])->contain([
                'Replies',
                'Replies.Taskfiles',
                'Replies.User',
                'User',
                'Taskfiles'
            ])->toArray();

            foreach($allcomments as $comment){
                $comment->creation_date = $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                 if($comment->replies){
                    foreach($comment->replies as $reply){
                        $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        if($reply->last_update != null){
                            $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                            }
                    }
                 }
                if($comment->last_update != null){
                $comment->last_update = $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                }
            }

            $this->autoRender = false;
            return $this->response->withType('application/json')->withStringBody(json_encode($allcomments));
    }








    public function isSeenComment(){
        $id = $this->request->getData('id');

      $isSeenComment=  $this->Comments->find('all',[
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $isSeenComment->isSeen = true;
        $this->Comments->save($isSeenComment);


    }




    /**Postcomments method */

    public function postcomments($pid)
    {
        $this->loadModel('User');
        $this->loadModel('ProjectObject');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projecttasks');


        //$pid = $this->request->getData('pid');
        $tid = $this->request->getData('tid');

        //assignee of the user
        $this->loadModel('Taskusers');
        $usersoftask = $this->Taskusers->find('all', [
            'conditions' => [
                'taskId' => $tid
            ]
        ])->toArray();
        $admin = $this->ProjectMember->find('all', [
            'conditions' => [
                'type' => 'Y',
                'projectId' => $pid
            ]
        ])->toArray();
        $projectManagers = $this->ProjectMember->find('all', [
            'conditons' => [
                'type' => 'Z',
                'projectId' => '$pid'
            ]
        ])->first();
        //debug($usersoftask);exit;
        $touserids = array();
        foreach ($usersoftask as $usertask) {
            array_push($touserids, $usertask['assignee_id']);
        }
        foreach ($admin as $singleadmin) {
            array_push($touserids, $singleadmin['memberId']);
        }
        array_push($touserids, $projectManagers->memberId);

        //debug($touserids);
        $touserids = array_unique($touserids);




        // $this->loadModel('User')
        $newcomment = $this->Comments->newEntity();


        $content = $this->request->getData('content');
        //debug($content); exit;
        $newcomment->project_id = $pid;
        $newcomment->taskId = $tid;
        $newcomment->user_id = $this->Auth->user('id');
        $newcomment->content = $content;
        $newcomment->last_update = null;
        $newcomment->creation_date = Time::now();

        $this->Comments->save($newcomment);

        //get the task
        $task = $this->Projecttasks->find('all', [
            'conditions' => [
                'id' => $tid
            ]
        ])->first();



        //Notification on comments
        foreach ($touserids as $toId) {


            $user_id = $this->Auth->user('id');
            $notification = $this->Notifications->newEntity();
            $notification->fromuser_id = $user_id;
            $notification->action_title = $task->title;
            $notification->action_status = 'comment'; // $leave->status;//New
            $notification->action_description = $newcomment->content;
            $notification->action_id = $newcomment->id;
            $notification->creation_date = Time::now();
            $notification->touser_id = $toId;
            $notification->type = 'comment';
            $this->Notifications->save($notification);
        }




        //debug($newcomment);exit;

        //debug($pid);exit;


        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('Taskgroups');
        $this->loadModel('Comments');

        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $pid
            ]
        ])->first();

        //debug($projectObject);exit;

        $commentMembers = $this->Comments->find('all', [
            'conditions' => [
                'project_id' => $pid,
            ]
        ])->toArray();

        $userid = array();
        foreach ($commentMembers as $item) {
            array_push($userid, $item['user_id']);
        }
        //debug($userid);exit;
        $taskgroups = $this->Taskgroups->find('all')->toArray();
        $manytaskObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
        $userData = $this->User->find('all')->toArray();

        $allprojecttask = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $pid
            ]
        ])->toArray();
        $totaltasks = $this->Projecttasks->find('all', [
            'conditions' => [
                'project_id' => $pid,
                'type' => 'TS',
                'isDeleted' => false
            ]
        ])->toArray();
        //debug($totaltasks); exit;

        $total = count($totaltasks);
        //debug($allprojecttask);exit;

        $comments = $this->Comments->find('all', [
            'conditions' => [
                'comment_id is' => null
            ]
        ])->contain(['User'])->order(['creation_date' => 'ASC'])->toArray();
        //debug($comments);exit;
        $taskgroup = $this->Taskgroups->find('all')->toArray();
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->first();
        $replies = array();
        foreach ($comments as $comment) {
            $arrayOfReplies = $this->Comments->find('all', [
                'comment_id' => $comment->id
            ])->order(['last_update' => 'ASC'])->contain(['User'])->toArray();

            $replies[$comment->id] = $arrayOfReplies;
            //$this->set(compact('pid, tid', 'comment', 'projecttask', 'projectObject'));
            $this->set(compact('allprojecttask', 'comments', 'userData', 'total', 'totaltasks', 'projectObject', 'userid'));
            return $this->redirect([
                'controller' => 'projectObject',
                'action' => 'comments',
                $pid


            ]);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => ['User']
        ]);

        $this->set('comment', $comment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $user = $this->Comments->User->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'user'));
    }

    /*hashtag*/
    public function hashtags()
    {
        $this->loadModel('ProjectObject');
        $text = $this->request->getQuery('str');

        $pid = $this->request->getQuery('pid');
        //debug($pid);exit;
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $pid
            ]
        ])->first();

        $comment = $this->Comments->find('all')->toArray();


        //debug($comment); exit;
        $this->set(compact('comment', 'text', 'projectObject'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['controller' => 'Projecttasks', 'action' => 'view']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $user = $this->Comments->User->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'user'));
        return $this->redirect(['controller' => 'Projecttasks', 'action' => 'view']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->loadModel('User');
        $this->loadModel('Taskfiles');

        if ($this->request->is('ajax')) {
           // $pid = $this->request->getData('pid');
           $tid = $this->request->getData('tid');
            $cid = $this->request->getData('cid');

            //debug($cid);exit;
            $deletecomment = $this->Comments->find('all', [
                'conditions' => [
                    'id' => $cid
                ]

            ])->first();
            $this->Comments->delete($deletecomment);

            $allcomments = $this->Comments->find('all', [
                'conditions' => [
                    'comment_id is' => null,
                    'taskId' => $tid

                ]
            ])->contain([
                'Replies',
                'Replies.Taskfiles',
                'Replies.User',
                'User',
                'Taskfiles'
            ])->order(['creation_date' => 'ASC'])->toArray();

            foreach ($allcomments as $comment) {
                $comment->creation_date = $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                if ($comment->replies) {
                    foreach ($comment->replies as $reply) {
                        $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        if ($reply->last_update != null) {
                            $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        }
                    }
                }
                if ($comment->last_update != null) {
                    $comment->last_update = $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                }
            }

            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($allcomments));
        }



        $this->request->getData(['post', 'delete', 'PUT']);
        $user_id = $this->Auth->user('id');
        $ticketid = $this->request->getQuery('ticketid');



        $pid = $this->request->getQuery('pid');

        $commentId = $this->request->getQuery('commentId');


        //debug($commentId);exit;
        $deletecomment = $this->Comments->find('all', [
            'conditions' => [
                'id' => $commentId
            ]

        ])->first();
        $taskId = $deletecomment->taskId;
        $this->Comments->delete($deletecomment);

        if(!empty($ticketid)){
            $this->Flash->success(__('Comment Deleted'));
            return $this->redirect(['controller' => 'projecttasks',
            'action' => 'chargetickets',
            'ticketid' => $taskId,
            'alltickets' => $taskId

        ]);

        }

        return $this->redirect(['controller' => 'projectObject', 'action' => 'comments', $pid]);
    }

    public function updatecomment()
    {

        $userId = $this->Auth->user('id');
        $pid = $this->request->getData('pid');


        $commentId = $this->request->getData('commentId');
        $content = $this->request->getData('content');



        $updatecomment = $this->Comments->find('all', [
            'conditions' => [
                'id' => $commentId,
            ]
        ])->first();


        $updatecomment->content = $content;
        $updatecomment->last_update = Time::now();
        $this->Comments->save($updatecomment);

        $taskId =$updatecomment->taskId;

        $allcomments = $this->Comments->find('all', [
            'conditions' => [
                'comment_id is' => null,
                 'taskId' => $taskId
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
            if ($comment->replies) {
                foreach ($comment->replies as $reply) {
                    $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    if ($reply->last_update != null) {
                        $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    }
                }
            }
            if ($comment->last_update != null) {
                $comment->last_update = $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            }
        }

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($allcomments));

    }

    /*updateSingletaskComment method*/

    public function updateSingletaskComment()
    {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');

            //  debug($result);exit;
            $pid = $this->request->getData('pid');
            $taskId = $this->request->getData('taskId');
            $commentId = $this->request->getData('commentId');
            $content = $this->request->getData('content');
            //debug($content);exit;
            $updatecomment = $this->Comments->find('all', [
                'conditions' => [
                    'id' => $commentId
                ]

            ])->first();
            //debug($deletecomment);
            $updatecomment->content = $content;
            $updatecomment->last_update = Time::now();

            $this->Comments->save($updatecomment);
            return $this->redirect([
                'controller' => 'projecttasks',
                'action' => 'view',
                $taskId,
                $pid
            ]);
        }
    }
    //private functions
    private function sendcommentMailnotification($touserId, $commentId, $notificationtype){
        $this->loadModel('User');
        $this->loadModel('Comments');
        $this->loadModel('Projecttasks');
        $touserdata = $this->User->find('all',[
            'conditions' => [
                'id in' => $touserId
            ]
        ])->first();
        $comment = $this->Comments->find('all',[
            'conditions' => [
                'Comments.id in' => $commentId
            ]
        ])->contain('User')->first();
        $task = $this->Projecttasks->find('all',[
            'conditions' => [
                'id in' => $comment->taskId
            ]
        ])->first();

        $userId = $this->Auth->user('id');

        $email = new Email();
        $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($touserdata->email)
            ->setemailFormat('html')
            ->setSubject('Comment Notification')
            ->setViewVars([
                'touserdata' => $touserdata,
                'comment' => $comment,
                'task' => $task,
                'notificationtype' => $notificationtype

            ])
            ->setTemplate('comment_notification')
            ->send();

        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }

    }


    private function commentPostedNotification($touserId, $commentId)
    {

        $this->loadModel('ProjectMember');
        $this->loadModel('Comments');
        $this->loadModel('CompanyModules');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $touser = $this->User->find('all',[
            'conditions' => [
                'id in' => $touserId
            ]
        ])->first();



        $comment = $this->Comments->find('all',[
            'conditions' => [
                'Comments.id in' => $commentId
            ]
        ])->contain(['User'])->first();

        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->toArray();

        foreach ($companymodules as $module) {
            if ($module->name == 'Comments' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id = $authuser->choosen_companyId;
                $notification->module_id = $module->id;
                $notification->module_action = 'Posted';
                $notification->module_action_id = $comment->id;
                $notification->module_action_title = $comment->content;
                $notification->module_action_description = $comment->content;
                $notification->creation_date = Time::now();
                $notification->fromuser_id = $user_id;
                $notification->touser_id = $touserId;
                $this->Notifications->save($notification);

                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($touser->email)
                    ->setemailFormat('html')
                    ->setSubject('Notification')
                    ->setViewVars([
                        'comment' => $comment

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
