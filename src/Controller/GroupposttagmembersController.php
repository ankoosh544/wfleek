<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Groupposttagmembers Controller
 *
 * @property \App\Model\Table\GroupposttagmembersTable $Groupposttagmembers
 *
 * @method \App\Model\Entity\Groupposttagmember[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupposttagmembersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups', 'Posts']
        ];
        $groupposttagmembers = $this->paginate($this->Groupposttagmembers);

        $this->set(compact('groupposttagmembers'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Groupposttagmember id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupposttagmember = $this->Groupposttagmembers->get($id, [
            'contain' => ['Groups', 'Posts']
        ]);

        $this->set('groupposttagmember', $groupposttagmember);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupposttagmember = $this->Groupposttagmembers->newEntity();
        if ($this->request->is('post')) {
            $groupposttagmember = $this->Groupposttagmembers->patchEntity($groupposttagmember, $this->request->getData());
            if ($this->Groupposttagmembers->save($groupposttagmember)) {
                $this->Flash->success(__('The groupposttagmember has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupposttagmember could not be saved. Please, try again.'));
        }
        $groups = $this->Groupposttagmembers->Groups->find('list', ['limit' => 200]);
        $posts = $this->Groupposttagmembers->Posts->find('list', ['limit' => 200]);
        $this->set(compact('groupposttagmember', 'groups', 'posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupposttagmember id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupposttagmember = $this->Groupposttagmembers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupposttagmember = $this->Groupposttagmembers->patchEntity($groupposttagmember, $this->request->getData());
            if ($this->Groupposttagmembers->save($groupposttagmember)) {
                $this->Flash->success(__('The groupposttagmember has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupposttagmember could not be saved. Please, try again.'));
        }
        $groups = $this->Groupposttagmembers->Groups->find('list', ['limit' => 200]);
        $posts = $this->Groupposttagmembers->Posts->find('list', ['limit' => 200]);
        $this->set(compact('groupposttagmember', 'groups', 'posts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupposttagmember id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupposttagmember = $this->Groupposttagmembers->get($id);
        if ($this->Groupposttagmembers->delete($groupposttagmember)) {
            $this->Flash->success(__('The groupposttagmember has been deleted.'));
        } else {
            $this->Flash->error(__('The groupposttagmember could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
