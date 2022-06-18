<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Chatgroupsusers Controller
 *
 * @property \App\Model\Table\ChatgroupsusersTable $Chatgroupsusers
 *
 * @method \App\Model\Entity\Chatgroupsuser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatgroupsusersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups', 'Users']
        ];
        $chatgroupsusers = $this->paginate($this->Chatgroupsusers);

        $this->set(compact('chatgroupsusers'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Chatgroupsuser id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatgroupsuser = $this->Chatgroupsusers->get($id, [
            'contain' => ['Groups', 'Users']
        ]);

        $this->set('chatgroupsuser', $chatgroupsuser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatgroupsuser = $this->Chatgroupsusers->newEntity();
        if ($this->request->is('post')) {
            $chatgroupsuser = $this->Chatgroupsusers->patchEntity($chatgroupsuser, $this->request->getData());
            if ($this->Chatgroupsusers->save($chatgroupsuser)) {
                $this->Flash->success(__('The chatgroupsuser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatgroupsuser could not be saved. Please, try again.'));
        }
        $groups = $this->Chatgroupsusers->Groups->find('list', ['limit' => 200]);
        $users = $this->Chatgroupsusers->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatgroupsuser', 'groups', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chatgroupsuser id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatgroupsuser = $this->Chatgroupsusers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatgroupsuser = $this->Chatgroupsusers->patchEntity($chatgroupsuser, $this->request->getData());
            if ($this->Chatgroupsusers->save($chatgroupsuser)) {
                $this->Flash->success(__('The chatgroupsuser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatgroupsuser could not be saved. Please, try again.'));
        }
        $groups = $this->Chatgroupsusers->Groups->find('list', ['limit' => 200]);
        $users = $this->Chatgroupsusers->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatgroupsuser', 'groups', 'users'));
    }
    public function updategroupusers(){
        $gid = $this->request->getData('gid');
        $gusers = $this->request->getData('gusers');

       $oldusers =  $this->Chatgroupsusers->find('all',[
            'conditions' =>[
                'group_id in ' => $gid
            ]
        ])->toArray();
        foreach($oldusers as $olduser){
            $this->Chatgroupsusers->delete($olduser);

        }
        foreach($gusers as $user)
        {
        $chatgroupusers = $this->Chatgroupsusers->newEntity();
        $chatgroupusers->group_id = $gid;
        $chatgroupusers->user_id = $user;
        $this->Chatgroupsusers->save($chatgroupusers);

        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($chatgroupusers));

    }

    /**
     * Delete method
     *
     * @param string|null $id Chatgroupsuser id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatgroupsuser = $this->Chatgroupsusers->get($id);
        if ($this->Chatgroupsusers->delete($chatgroupsuser)) {
            $this->Flash->success(__('The chatgroupsuser has been deleted.'));
        } else {
            $this->Flash->error(__('The chatgroupsuser could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
