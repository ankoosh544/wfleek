<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Taskusers Controller
 *
 * @property \App\Model\Table\TaskusersTable $Taskusers
 *
 * @method \App\Model\Entity\Taskuser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TaskusersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Assignees']
        ];
        $taskusers = $this->paginate($this->Taskusers);

        $this->set(compact('taskusers'));
    }

    /**
     * View method
     *
     * @param string|null $id Taskuser id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $taskuser = $this->Taskusers->get($id, [
            'contain' => ['Assignees']
        ]);

        $this->set('taskuser', $taskuser);
    }
    public function isAuthorized($user)
    {
        return true;
    }
    /**delete taskuser */
    public function deletetaskuser()
    {

        if ($this->request->is('ajax')) {
            $this->loadModel('Taskusers');
            $this->loadModel('User');

            $taskId = $this->request->getData('tid');
            $pid = $this->request->getData('pid');
            $uid = $this->request->getData('uid');
            $taskuser = $this->Taskusers->find('all', [
                'conditions' => [
                    'taskId' => $taskId,
                    'assignee_id' => $uid,
                ]
            ])->first();
            //debug($taskuser);exit;
            $this->Taskusers->delete($taskuser);

            $taskusers = $this->Taskusers->find('all',[
                'conditions' => [
                    'taskId' => $taskId
                ]
            ])->contain(['User'])->toArray();

            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($taskusers));
        } else {
            //debug('hiiiiii');exit;
            $this->loadModel('Taskusers');
            $this->loadModel('User');

            $taskId = $this->request->getQuery('taskId');
            $pid = $this->request->getQuery('pid');
            $assigneeId = $this->request->getQuery('assigneeId');
            $dummy = $this->request->getQuery('dummy');

            $taskusers = $this->Taskusers->find('all', [
                'conditions' => [
                    'taskId' => $taskId,
                    'assignee_id' => $assigneeId,
                ]
            ])->first();
            //debug($taskusers);exit;
            $this->Taskusers->delete($taskusers);
            if ($dummy == null) {
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'view',
                    $pid
                ]);
            } else
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'taskboard',
                    $pid
                ]);
        }
    }

    /**add users */

    public function addusertask()
    {

        if ($this->request->is('ajax')) {
            $this->loadModel('Taskusers');
            $this->loadModel('Notifications');
            $this->loadModel('Projecttasks');
            $this->loadModel('User');
            //$taskusers = $this->Taskusers->find('all');
            $tagvalue = $this->request->getData('tagvalue');
           // debug($tagvalue);
            foreach ($tagvalue as $value) {
                $taskId = $this->request->getData('tid');
                $pid = $this->request->getData('pid');
                $taskusers = $this->Taskusers->newEntity();
                $taskusers->taskId = $taskId;
                $taskusers->assignee_id = $value;
                $taskusers->assigned_date = Time::now();
                $this->Taskusers->save($taskusers);


                //Projecttask
                $projecttask = $this->Projecttasks->find('all', [
                    'conditions' => [
                        'id in ' => $taskId,
                        'project_id' => $pid,
                    ]
                ])->first();


            //Notification for assign taskuser
            $notification = $this->Notifications->newEntity();
            $user_id = $this->Auth->user('id');
            $notification->fromuser_id = $user_id;
            $notification->action_title = $projecttask->title;
            $notification->action_status = $projecttask->status; // $leave->status;//New
            $notification->action_description = null;
            $notification->action_id = $projecttask->id;
            $notification->creation_date = Time::now();
            $notification->touser_id = $value;
            $notification->type = 'task';
                $this->Notifications->save($notification);
            }
            $taskusers = $this->Taskusers->find('all', [
                'conditions' => [
                    'taskId' => $taskId
                ]
            ])->contain(['User'])->toArray();

            //debug($taskusers);

            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($taskusers));
        }
    }

    public function deleteallusers(){
        $taskId = $this->request->getQuery('taskId');
        $taskusers =  $this->Taskusers->find('all', [
            'conditions' => [
                'taskId' => $taskId
            ]
        ])->toArray();
        foreach ($taskusers as $taskuser) {
            $this->Taskusers->delete($taskuser);
        }

        return $this->redirect([
            'controller' => 'projecttasks',
            'action' => 'taskview',
            $taskId
        ]);
    }





    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taskuser = $this->Taskusers->newEntity();
        if ($this->request->is('post')) {
            $taskuser = $this->Taskusers->patchEntity($taskuser, $this->request->getData());
            if ($this->Taskusers->save($taskuser)) {
                $this->Flash->success(__('The taskuser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskuser could not be saved. Please, try again.'));
        }
        $assignees = $this->Taskusers->Assignees->find('list', ['limit' => 200]);
        $this->set(compact('taskuser', 'assignees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Taskuser id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $taskuser = $this->Taskusers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $taskuser = $this->Taskusers->patchEntity($taskuser, $this->request->getData());
            if ($this->Taskusers->save($taskuser)) {
                $this->Flash->success(__('The taskuser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskuser could not be saved. Please, try again.'));
        }
        $assignees = $this->Taskusers->Assignees->find('list', ['limit' => 200]);
        $this->set(compact('taskuser', 'assignees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Taskuser id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $taskuser = $this->Taskusers->get($id);
        if ($this->Taskusers->delete($taskuser)) {
            $this->Flash->success(__('The taskuser has been deleted.'));
        } else {
            $this->Flash->error(__('The taskuser could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
