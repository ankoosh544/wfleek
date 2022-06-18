<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EpictasksProjecttasks Controller
 *
 * @property \App\Model\Table\EpictasksProjecttasksTable $EpictasksProjecttasks
 *
 * @method \App\Model\Entity\EpictasksProjecttask[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EpictasksProjecttasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Epictasks', 'Projecttasks']
        ];
        $epictasksProjecttasks = $this->paginate($this->EpictasksProjecttasks);

        $this->set(compact('epictasksProjecttasks'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Epictasks Projecttask id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $epictasksProjecttask = $this->EpictasksProjecttasks->get($id, [
            'contain' => ['Epictasks', 'Projecttasks']
        ]);

        $this->set('epictasksProjecttask', $epictasksProjecttask);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $epictasksProjecttask = $this->EpictasksProjecttasks->newEntity();
        if ($this->request->is('post')) {
            $epictasksProjecttask = $this->EpictasksProjecttasks->patchEntity($epictasksProjecttask, $this->request->getData());
            if ($this->EpictasksProjecttasks->save($epictasksProjecttask)) {
                $this->Flash->success(__('The epictasks projecttask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The epictasks projecttask could not be saved. Please, try again.'));
        }
        $epictasks = $this->EpictasksProjecttasks->Epictasks->find('list', ['limit' => 200]);
        $projecttasks = $this->EpictasksProjecttasks->Projecttasks->find('list', ['limit' => 200]);
        $this->set(compact('epictasksProjecttask', 'epictasks', 'projecttasks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Epictasks Projecttask id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $epictasksProjecttask = $this->EpictasksProjecttasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $epictasksProjecttask = $this->EpictasksProjecttasks->patchEntity($epictasksProjecttask, $this->request->getData());
            if ($this->EpictasksProjecttasks->save($epictasksProjecttask)) {
                $this->Flash->success(__('The epictasks projecttask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The epictasks projecttask could not be saved. Please, try again.'));
        }
        $epictasks = $this->EpictasksProjecttasks->Epictasks->find('list', ['limit' => 200]);
        $projecttasks = $this->EpictasksProjecttasks->Projecttasks->find('list', ['limit' => 200]);
        $this->set(compact('epictasksProjecttask', 'epictasks', 'projecttasks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Epictasks Projecttask id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $epictasksProjecttask = $this->EpictasksProjecttasks->get($id);
        if ($this->EpictasksProjecttasks->delete($epictasksProjecttask)) {
            $this->Flash->success(__('The epictasks projecttask has been deleted.'));
        } else {
            $this->Flash->error(__('The epictasks projecttask could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
