<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Groupnotes Controller
 *
 * @property \App\Model\Table\GroupnotesTable $Groupnotes
 *
 * @method \App\Model\Entity\Groupnote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupnotesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $groupnotes = $this->paginate($this->Groupnotes);

        $this->set(compact('groupnotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Groupnote id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupnote = $this->Groupnotes->get($id, [
            'contain' => ['Groups']
        ]);

        $this->set('groupnote', $groupnote);
    }

    public function isAuthorized()
    {
        return true;
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupnote = $this->Groupnotes->newEntity();
        if ($this->request->is('post')) {
            $groupnote = $this->Groupnotes->patchEntity($groupnote, $this->request->getData());
            if ($this->Groupnotes->save($groupnote)) {
                $this->Flash->success(__('The groupnote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupnote could not be saved. Please, try again.'));
        }
        $groups = $this->Groupnotes->Groups->find('list', ['limit' => 200]);
        $this->set(compact('groupnote', 'groups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupnote id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupnote = $this->Groupnotes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupnote = $this->Groupnotes->patchEntity($groupnote, $this->request->getData());
            if ($this->Groupnotes->save($groupnote)) {
                $this->Flash->success(__('The groupnote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupnote could not be saved. Please, try again.'));
        }
        $groups = $this->Groupnotes->Groups->find('list', ['limit' => 200]);
        $this->set(compact('groupnote', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupnote id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupnote = $this->Groupnotes->get($id);
        if ($this->Groupnotes->delete($groupnote)) {
            $this->Flash->success(__('The groupnote has been deleted.'));
        } else {
            $this->Flash->error(__('The groupnote could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
