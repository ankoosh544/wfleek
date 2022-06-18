<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;

/**
 * Chatgroups Controller
 *
 * @property \App\Model\Table\ChatgroupsTable $Chatgroups
 *
 * @method \App\Model\Entity\Chatgroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatgroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $chatgroups = $this->paginate($this->Chatgroups);

        $this->set(compact('chatgroups'));
    }
     public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Chatgroup id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatgroup = $this->Chatgroups->get($id, [
            'contain' => []
        ]);

        $this->set('chatgroup', $chatgroup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatgroup = $this->Chatgroups->newEntity();
        if ($this->request->is('post')) {
            $chatgroup = $this->Chatgroups->patchEntity($chatgroup, $this->request->getData());
            if ($this->Chatgroups->save($chatgroup)) {
                $this->Flash->success(__('The chatgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatgroup could not be saved. Please, try again.'));
        }
        $this->set(compact('chatgroup'));
    }
    public function creategroup()
    {
        $this->loadModel('User');
        $groupname = $this->request->getData('groupname');
        $file = $this->request->getData('groupprofilepic');
        $groupusers = $this->request->getData()['groupusers'];
        $user_id = $this->Auth->user('id');
        $chatgroup = $this->Chatgroups->newEntity();
        $chatgroup->name =  $groupname;
        $chatgroup->creator = $user_id;
        $chatgroup->creation_date = Time::now();
        $chatgroup->groupimagename = $file['name'];
        $chatgroup->groupimagepath = "assets/chatgroupprofiles/" .  $groupname;
        $destinationFolder = WWW_ROOT . "assets/chatgroupprofiles/" .   $groupname;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        $result =  $this->Chatgroups->save($chatgroup);
        $this->loadModel('Chatgroupsusers');
        foreach ($groupusers as $user) {
        $chatgroupusers = $this->Chatgroupsusers->newEntity();
        $chatgroupusers->group_id = $chatgroup->id;
        $chatgroupusers->user_id = $user;
        $this->Chatgroupsusers->save($chatgroupusers);
        }
        //saving creator of group as group user
        $chatgroupusers = $this->Chatgroupsusers->newEntity();
        $chatgroupusers->group_id = $chatgroup->id;
        $chatgroupusers->user_id = $user_id;
        $this->Chatgroupsusers->save($chatgroupusers);
        $this->Flash->success(__('Il gruppo è stato creato.'));
        return $this->redirect(['controller'=> 'groupchats','action' => 'group-chat', $chatgroup->id ]);



    }

    function deletegroup()
    {
        $this->loadModel('User');

        $allusers = $this->User->find('all')->toArray();

        $gid = $this->request->getData('gid');
        $deletegroup = $this->Chatgroups->find('all', [
            'conditions' => [
                'id in' => $gid
            ]
        ])->first();
        $this->Chatgroups->delete($deletegroup);

        $allgroups = $this->Chatgroups->find('all')->contain(['Chatgroupsusers'])->order(['creation_date' => 'ASC'])->toArray();
        $resultarray = array($allgroups, $allusers);

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($resultarray));
    }

    function updategroupData(){
        $user_id = $this->Auth->user('id');
        $groupusers = json_decode($_POST['values']);
        $isFileNotAttached = $this->request->getData('isFileNotAttached');

        $gid = $this->request->getData('gid');
        $groupname=  $this->request->getData('editgroupname');




        $updategroup = $this->Chatgroups->find('all',[
            'conditions' => [
                'id in' => $gid
            ]
        ])->first();

        $updategroup->name = $groupname;


        if ($isFileNotAttached == 0) {
            $files = $this->request->getData()['file'];
            foreach ($files as $file) {
                $updategroup->groupimagename = $file['name'];
                $updategroup->groupimagepath = "assets/chatgroupprofiles/" .  $groupname;

                $destinationFolder = WWW_ROOT . "assets/chatgroupprofiles/" .   $groupname;

                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);

                $result =  $this->Chatgroups->save($updategroup);
            }
        } else {
            $this->Chatgroups->save($updategroup);
        }

        $this->loadModel('Chatgroupsusers');

        if (!empty($groupusers)) {
            foreach ($groupusers as $user) {
                $chatgroupusers = $this->Chatgroupsusers->newEntity();
                $chatgroupusers->group_id = $updategroup->id;
                $chatgroupusers->user_id = $user;
                $this->Chatgroupsusers->save($chatgroupusers);
            }
        }
        $this->loadModel('User');

        $allusers = $this->User->find('all')->toArray();

        //saving creator of group as group user
       /*  $chatgroupusers = $this->Chatgroupsusers->newEntity();
        $chatgroupusers->group_id = $updategroup->id;
        $chatgroupusers->user_id = $user_id;
        $this->Chatgroupsusers->save($chatgroupusers); */
        $allgroups = $this->Chatgroups->find('all')->contain(['Chatgroupsusers.Users'])->order(['creation_date' => 'ASC'])->toArray();
        $resultarray = array($allgroups, $allusers);
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($resultarray));

    }

    /**
     * Edit method
     *
     * @param string|null $id Chatgroup id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatgroup = $this->Chatgroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatgroup = $this->Chatgroups->patchEntity($chatgroup, $this->request->getData());
            if ($this->Chatgroups->save($chatgroup)) {
                $this->Flash->success(__('The chatgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatgroup could not be saved. Please, try again.'));
        }
        $this->set(compact('chatgroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chatgroup id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatgroup = $this->Chatgroups->get($id);
        if ($this->Chatgroups->delete($chatgroup)) {
            $this->Flash->success(__('The chatgroup has been deleted.'));
        } else {
            $this->Flash->error(__('The chatgroup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
