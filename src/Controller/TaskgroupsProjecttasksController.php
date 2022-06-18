<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TaskgroupsProjecttasks Controller
 *
 * @property \App\Model\Table\TaskgroupsProjecttasksTable $TaskgroupsProjecttasks
 *
 * @method \App\Model\Entity\TaskgroupsProjecttask[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TaskgroupsProjecttasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Taskgroups', 'Projecttasks']
        ];
        $taskgroupsProjecttasks = $this->paginate($this->TaskgroupsProjecttasks);

        $this->set(compact('taskgroupsProjecttasks'));
    }

    /**
     * View method
     *
     * @param string|null $id Taskgroups Projecttask id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->get($id, [
            'contain' => ['Taskgroups', 'Projecttasks']
        ]);

        $this->set('taskgroupsProjecttask', $taskgroupsProjecttask);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->newEntity();
        if ($this->request->is('post')) {
            $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->patchEntity($taskgroupsProjecttask, $this->request->getData());
            if ($this->TaskgroupsProjecttasks->save($taskgroupsProjecttask)) {
                $this->Flash->success(__('The taskgroups projecttask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskgroups projecttask could not be saved. Please, try again.'));
        }
        $taskgroups = $this->TaskgroupsProjecttasks->Taskgroups->find('list', ['limit' => 200]);
        $projecttasks = $this->TaskgroupsProjecttasks->Projecttasks->find('list', ['limit' => 200]);
        $this->set(compact('taskgroupsProjecttask', 'taskgroups', 'projecttasks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Taskgroups Projecttask id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->patchEntity($taskgroupsProjecttask, $this->request->getData());
            if ($this->TaskgroupsProjecttasks->save($taskgroupsProjecttask)) {
                $this->Flash->success(__('The taskgroups projecttask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskgroups projecttask could not be saved. Please, try again.'));
        }
        $taskgroups = $this->TaskgroupsProjecttasks->Taskgroups->find('list', ['limit' => 200]);
        $projecttasks = $this->TaskgroupsProjecttasks->Projecttasks->find('list', ['limit' => 200]);
        $this->set(compact('taskgroupsProjecttask', 'taskgroups', 'projecttasks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Taskgroups Projecttask id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $taskgroupsProjecttask = $this->TaskgroupsProjecttasks->get($id);
        if ($this->TaskgroupsProjecttasks->delete($taskgroupsProjecttask)) {
            $this->Flash->success(__('The taskgroups projecttask has been deleted.'));
        } else {
            $this->Flash->error(__('The taskgroups projecttask could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
