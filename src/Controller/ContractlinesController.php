<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contractlines Controller
 *
 * @property \App\Model\Table\ContractlinesTable $Contractlines
 *
 * @method \App\Model\Entity\Contractline[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractlinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contracts']
        ];
        $contractlines = $this->paginate($this->Contractlines);

        $this->set(compact('contractlines'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractline id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractline = $this->Contractlines->get($id, [
            'contain' => ['Contracts']
        ]);

        $this->set('contractline', $contractline);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contractline = $this->Contractlines->newEntity();
        if ($this->request->is('post')) {
            $contractline = $this->Contractlines->patchEntity($contractline, $this->request->getData());
            if ($this->Contractlines->save($contractline)) {
                $this->Flash->success(__('The contractline has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractline could not be saved. Please, try again.'));
        }
        $contracts = $this->Contractlines->Contracts->find('list', ['limit' => 200]);
        $this->set(compact('contractline', 'contracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractline id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractline = $this->Contractlines->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractline = $this->Contractlines->patchEntity($contractline, $this->request->getData());
            if ($this->Contractlines->save($contractline)) {
                $this->Flash->success(__('The contractline has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractline could not be saved. Please, try again.'));
        }
        $contracts = $this->Contractlines->Contracts->find('list', ['limit' => 200]);
        $this->set(compact('contractline', 'contracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractline id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractline = $this->Contractlines->get($id);
        if ($this->Contractlines->delete($contractline)) {
            $this->Flash->success(__('The contractline has been deleted.'));
        } else {
            $this->Flash->error(__('The contractline could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
