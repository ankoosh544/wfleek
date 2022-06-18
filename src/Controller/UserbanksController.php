<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Userbanks Controller
 *
 * @property \App\Model\Table\UserbanksTable $Userbanks
 *
 * @method \App\Model\Entity\Userbank[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserbanksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $userbanks = $this->paginate($this->Userbanks);

        $this->set(compact('userbanks'));
    }

    /**
     * View method
     *
     * @param string|null $id Userbank id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userbank = $this->Userbanks->get($id, [
            'contain' => []
        ]);

        $this->set('userbank', $userbank);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userbank = $this->Userbanks->newEntity();
        if ($this->request->is('post')) {
            $userbank = $this->Userbanks->patchEntity($userbank, $this->request->getData());
            if ($this->Userbanks->save($userbank)) {
                $this->Flash->success(__('The userbank has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The userbank could not be saved. Please, try again.'));
        }
        $this->set(compact('userbank'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Userbank id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userbank = $this->Userbanks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userbank = $this->Userbanks->patchEntity($userbank, $this->request->getData());
            if ($this->Userbanks->save($userbank)) {
                $this->Flash->success(__('The userbank has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The userbank could not be saved. Please, try again.'));
        }
        $this->set(compact('userbank'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Userbank id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userbank = $this->Userbanks->get($id);
        if ($this->Userbanks->delete($userbank)) {
            $this->Flash->success(__('The userbank has been deleted.'));
        } else {
            $this->Flash->error(__('The userbank could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
