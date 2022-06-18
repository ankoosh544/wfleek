<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clientsexpenditure Controller
 *
 * @property \App\Model\Table\ClientsexpenditureTable $Clientsexpenditure
 *
 * @method \App\Model\Entity\Clientsexpenditure[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientsexpenditureController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $clientsexpenditure = $this->paginate($this->Clientsexpenditure);

        $this->set(compact('clientsexpenditure'));
    }

    /**
     * View method
     *
     * @param string|null $id Clientsexpenditure id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientsexpenditure = $this->Clientsexpenditure->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('clientsexpenditure', $clientsexpenditure);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientsexpenditure = $this->Clientsexpenditure->newEntity();
        if ($this->request->is('post')) {
            $clientsexpenditure = $this->Clientsexpenditure->patchEntity($clientsexpenditure, $this->request->getData());
            if ($this->Clientsexpenditure->save($clientsexpenditure)) {
                $this->Flash->success(__('The clientsexpenditure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clientsexpenditure could not be saved. Please, try again.'));
        }
        $users = $this->Clientsexpenditure->Users->find('list', ['limit' => 200]);
        $this->set(compact('clientsexpenditure', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Clientsexpenditure id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientsexpenditure = $this->Clientsexpenditure->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientsexpenditure = $this->Clientsexpenditure->patchEntity($clientsexpenditure, $this->request->getData());
            if ($this->Clientsexpenditure->save($clientsexpenditure)) {
                $this->Flash->success(__('The clientsexpenditure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clientsexpenditure could not be saved. Please, try again.'));
        }
        $users = $this->Clientsexpenditure->Users->find('list', ['limit' => 200]);
        $this->set(compact('clientsexpenditure', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clientsexpenditure id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientsexpenditure = $this->Clientsexpenditure->get($id);
        if ($this->Clientsexpenditure->delete($clientsexpenditure)) {
            $this->Flash->success(__('The clientsexpenditure has been deleted.'));
        } else {
            $this->Flash->error(__('The clientsexpenditure could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
