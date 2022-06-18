<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 *
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Fromusers']
        ];
        $notifications = $this->paginate($this->Notifications);

        $this->set(compact('notifications'));
    }
    public function isAuthorized($user)
    {
        return true;
    }


    /**
     * View method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => ['Users', 'Fromusers']
        ]);

        $this->set('notification', $notification);
    }
    /**activities Page */

    public function activities(){
        $userid = $this->Auth->user('id');
        $this->loadModel('Notifications');
        $notifications = $this->Notifications->find('all',[
            'consitions' => [
                'touser_id' => $userid
            ]
        ])->contain(['Fromuser','Touser'])->order(['creation_date' => 'DESC'])->toArray();

        $this->set(compact('notifications', 'userid'));
        //debug($notification);exit;
    }


    public function clearall(){
        $userid = $this->Auth->user('id');
        $this->loadModel('Notifications');
        $notifications = $this->Notifications->find('all',[
            'conditions' => [
                'touser_id' => $userid
            ]
        ])->toArray();
        //debug($notifications);exit;
        foreach($notifications as $notification){

        $notification->isDeleted = 1;

        $this->Notifications->save($notification);
        }
        return $this->redirect(['controller' => 'projectObject','action' => 'index']);

    }



    public function updatelastseendate()
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('Notifications');
        $allrecords = $this->Notifications->find('all', [
            'conditions' => [
                'touser_id' => $user_id,
                'isSeen' => false
            ]
        ])->toArray();

         //debug($allrecords);
         foreach ($allrecords as $singlerecord) {
            $singlerecord->isSeen = true;
            $this->Notifications->save($singlerecord);
        }

        $this->loadModel('Comments');
        $seencomments = $this->Comments->find('all',[
            'conditions' => [
                'user_id !=' =>  $user_id
            ]
        ])->toArray();

        foreach($seencomments as $comment){
            $comment->isSeen = true;
            $this->Comments->save($comment);

        }



        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($allrecords));

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notification = $this->Notifications->newEntity();
        if ($this->request->is('post')) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $users = $this->Notifications->Users->find('list', ['limit' => 200]);
        $fromusers = $this->Notifications->Fromusers->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'users', 'fromusers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $users = $this->Notifications->Users->find('list', ['limit' => 200]);
        $fromusers = $this->Notifications->Fromusers->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'users', 'fromusers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function notificationSettings($companyId = null){
        $this->loadModel('CompanyModules');
        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->toArray();

        $this->set(compact('companyId', 'companymodules'));

    }
}
