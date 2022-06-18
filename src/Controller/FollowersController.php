<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;
use Cake\Mailer\Email;

/**
 * Followers Controller
 *
 * @property \App\Model\Table\FollowersTable $Followers
 *
 * @method \App\Model\Entity\Follower[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FollowersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Projects', 'Tasks']
        ];
        $followers = $this->paginate($this->Followers);

        $this->set(compact('followers'));
    }

    /**
     * View method
     *
     * @param string|null $id Follower id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $follower = $this->Followers->get($id, [
            'contain' => ['Users', 'Projects', 'Tasks']
        ]);

        $this->set('follower', $follower);
    }
    public function isAuthorized($user)
    {
        return true;
    }



    public function addfollowers()
    {
        $this->loadModel('User');

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in ' => $user_id
            ]
        ])->first();
        $this->loadModel('Projecttasks');
        $tid = $this->request->getData('tid');
        $followerId = $this->request->getData('user_id');
        $projecttask = $this->Projecttasks->find('all',[
            'conditions' => [
                'Projecttasks.id in' => $tid
            ]
        ])->contain(['Projectobject','Followers.Users'])->first();
        $newfollower = $this->Followers->newEntity();
        $newfollower->user_id = $followerId;
        $newfollower->task_id = $tid;
        $newfollower->project_id = $projecttask->project_id;
        $newfollower->creation_date = Time::now();
        $this->Followers->save($newfollower);
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->chooden_companyId
            ]
        ])->contain(['Designations', 'User'])->toArray();

        $finalarray = array($companymembers, $projecttask);

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($finalarray));
    }
    public function deletefollowers(){
        $this->loadModel('Projecttasks');
        $tid = $this->request->getData('tid');
        $user_id = $this->request->getData('user_id');
        $follower = $this->Followers->find('all',[
            'conditions' => [
                'task_id in' => $tid,
                'user_id' => $user_id
            ]
        ])->first();
        $this->Followers->delete($follower);

        $this->deleteFollowerNotification($tid,$user_id);

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($follower));

    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $follower = $this->Followers->newEntity();
        if ($this->request->is('post')) {
            $follower = $this->Followers->patchEntity($follower, $this->request->getData());
            if ($this->Followers->save($follower)) {
                $this->Flash->success(__('The follower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The follower could not be saved. Please, try again.'));
        }
        $users = $this->Followers->Users->find('list', ['limit' => 200]);
        $projects = $this->Followers->Projects->find('list', ['limit' => 200]);
        $tasks = $this->Followers->Tasks->find('list', ['limit' => 200]);
        $this->set(compact('follower', 'users', 'projects', 'tasks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Follower id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $follower = $this->Followers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $follower = $this->Followers->patchEntity($follower, $this->request->getData());
            if ($this->Followers->save($follower)) {
                $this->Flash->success(__('The follower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The follower could not be saved. Please, try again.'));
        }
        $users = $this->Followers->Users->find('list', ['limit' => 200]);
        $projects = $this->Followers->Projects->find('list', ['limit' => 200]);
        $tasks = $this->Followers->Tasks->find('list', ['limit' => 200]);
        $this->set(compact('follower', 'users', 'projects', 'tasks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Follower id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $follower = $this->Followers->get($id);
        if ($this->Followers->delete($follower)) {
            $this->Flash->success(__('The follower has been deleted.'));
        } else {
            $this->Flash->error(__('The follower could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    private function assignedFollower($touserId, $taskId)
    {
        $this->loadModel('CompanyModules');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $projecttask = $this->Projecttasks->find('all',[
            'conditions' => [
                'Projecttasks.id in' => $taskId
            ]
        ])->contain(['Projectobject'])->first();

        $touser = $this->User->find('all',[
            'conditions' => [
                'id in' => $touserId
            ]
        ])->first();



        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $projecttask->projectobject->company_id
            ]
        ])->toArray();

        foreach ($companymodules as $module) {
            if ($module->name == 'Followers' && $module->isNotify == true) {
                $notification = $this->Notifications->newEntity();
                $notification->company_id = $projecttask->Projectobject->company_id;
                $notification->module_id = $module->id;
                $notification->module_action = 'Assigned';
                $notification->module_action_id =  $projecttask->id;
                $notification->module_action_title = $projecttask->title;
                $notification->module_action_description = $projecttask->description;
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

                        'projecttask' => $projecttask

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

    private function deleteFollowerNotification($tid = null, $user_id = null){

        $this->loadModel('Projecttasks');
        $this->loadModel('CompanyModules');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

       $projecttask = $this->Projecttasks->find('all',[
            'conditions' => [
                'id in ' => $tid
            ]
        ])->contain(['Taskusers.User'])->first();



        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->toArray();


        foreach ($companymodules as $module) {

            if ($module->name == 'Followers' && $module->isNotify == true) {

                foreach ($projecttask->taskusers as $taskuser) {
                    $notification = $this->Notifications->newEntity();
                    $notification->company_id = $authuser->choosen_companyId;
                    $notification->module_id = $module->id;
                    $notification->module_action = 'Removed';
                    $notification->module_action_id = $user_id;
                    $notification->module_action_title = $projecttask->title;
                    $notification->module_action_description = $projecttask->description;
                    $notification->creation_date = Time::now();
                    $notification->fromuser_id = $user_id;
                    $notification->touser_id = $taskuser->assignee_id;
                    $this->Notifications->save($notification);
                }
                $email = new Email();
                $emailSent =  $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($taskuser->user->email)
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
