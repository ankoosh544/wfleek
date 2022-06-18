<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Worklocations Controller
 *
 * @property \App\Model\Table\WorklocationsTable $Worklocations
 *
 * @method \App\Model\Entity\Worklocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorklocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $worklocations = $this->paginate($this->Worklocations);

        $this->set(compact('worklocations'));
    }

    /**
     * View method
     *
     * @param string|null $id Worklocation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $worklocation = $this->Worklocations->get($id, [
            'contain' => []
        ]);

        $this->set('worklocation', $worklocation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $worklocation = $this->Worklocations->newEntity();
        if ($this->request->is('post')) {
            $worklocation = $this->Worklocations->patchEntity($worklocation, $this->request->getData());
            if ($this->Worklocations->save($worklocation)) {
                $this->Flash->success(__('The worklocation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worklocation could not be saved. Please, try again.'));
        }
        $this->set(compact('worklocation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Worklocation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $worklocation = $this->Worklocations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $worklocation = $this->Worklocations->patchEntity($worklocation, $this->request->getData());
            if ($this->Worklocations->save($worklocation)) {
                $this->Flash->success(__('The worklocation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The worklocation could not be saved. Please, try again.'));
        }
        $this->set(compact('worklocation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Worklocation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $worklocation = $this->Worklocations->get($id);
        if ($this->Worklocations->delete($worklocation)) {
            $this->Flash->success(__('The worklocation has been deleted.'));
        } else {
            $this->Flash->error(__('The worklocation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
