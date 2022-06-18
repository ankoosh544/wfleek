<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Groupfileposts Controller
 *
 * @property \App\Model\Table\GroupfilepostsTable $Groupfileposts
 *
 * @method \App\Model\Entity\Groupfilepost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupfilepostsController extends AppController
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
        $groupfileposts = $this->paginate($this->Groupfileposts);

        $this->set(compact('groupfileposts'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Groupfilepost id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupfilepost = $this->Groupfileposts->get($id, [
            'contain' => ['Groups', 'Users']
        ]);

        $this->set('groupfilepost', $groupfilepost);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupfilepost = $this->Groupfileposts->newEntity();
        if ($this->request->is('post')) {
            $groupfilepost = $this->Groupfileposts->patchEntity($groupfilepost, $this->request->getData());
            if ($this->Groupfileposts->save($groupfilepost)) {
                $this->Flash->success(__('The groupfilepost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupfilepost could not be saved. Please, try again.'));
        }
        $groups = $this->Groupfileposts->Groups->find('list', ['limit' => 200]);
        $users = $this->Groupfileposts->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupfilepost', 'groups', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupfilepost id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupfilepost = $this->Groupfileposts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupfilepost = $this->Groupfileposts->patchEntity($groupfilepost, $this->request->getData());
            if ($this->Groupfileposts->save($groupfilepost)) {
                $this->Flash->success(__('The groupfilepost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupfilepost could not be saved. Please, try again.'));
        }
        $groups = $this->Groupfileposts->Groups->find('list', ['limit' => 200]);
        $users = $this->Groupfileposts->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupfilepost', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupfilepost id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupfilepost = $this->Groupfileposts->get($id);
        if ($this->Groupfileposts->delete($groupfilepost)) {
            $this->Flash->success(__('The groupfilepost has been deleted.'));
        } else {
            $this->Flash->error(__('The groupfilepost could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function uploadfile(){
        $this->loadModel('Groups');
        $this->loadModel('Groupfiles');
        $user_id = $this->Auth->user('id');
        $group_id = $this->request->getData('groupId');
        $group = $this->Groups->find('all',[
            'conditions' => [
                'id in' => $group_id
            ]
        ])->first();
        $files = $this->request->getData()['images'];
        $groupfilepost = $this->Groupfileposts->newEntity();
        $groupfilepost->group_id = $group_id;
        $groupfilepost->user_id = $user_id;
        $this->Groupfileposts->save($groupfilepost);

        foreach ($files as $file) {
            if (!empty($file['tmp_name'])) {
                $groupfile = $this->Groupfiles->newEntity();
                $groupfile->groupfilepost_id = $groupfilepost->id;
                $groupfile->filename = $file['name'];
                $groupfile->filepath = "assets/groupfiles/" .  $group_id;
                $groupfile->size = $file['size'];
                $destinationFolder = WWW_ROOT . "assets/groupfiles/" .  $group_id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Groupfiles->save($groupfile);
            }
        }
        return $this->redirect(['controller' => 'groups','action' => 'groupfiles', $group_id]);
    }


    public function deletepost($id = null){

        $filepost = $this->Groupfileposts->find('all',[
            'conditions' => [
                'id in' => $id
            ]
        ])->first();

        $filepost->isDeleted = true;
        $this->Groupfileposts->save($filepost);
        return $this->redirect(['controller' => 'groups','action' => 'groupfiles', $filepost->group_id]);

    }
}
