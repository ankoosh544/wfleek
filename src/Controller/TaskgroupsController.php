<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Taskgroups Controller
 *
 * @property \App\Model\Table\TaskgroupsTable $Taskgroups
 *
 * @method \App\Model\Entity\Taskgroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TaskgroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $taskgroups = $this->paginate($this->Taskgroups);

        $this->set(compact('taskgroups'));
    }

    public function isAuthorized($user)
    {
        return true;
    }




    /*taskgroups*/

    public function addtaskgroups()
    {
        $isFutured = $this->request->getData('isFutured');
        $this->loadModel("ProjectObject");
        $pid = $this->request->getData('pid');
        $title = $this->request->getData('group_title');
        $description = $this->request->getData('group_description');
        $price = $this->request->getData('price');
        $tax = $this->request->getData('tax');
        $startdate = $this->request->getData('startdate');
        $startdate = Time::createFromFormat(
            'd/m/Y',
            $startdate,
            'Europe/Paris'
        );
        $expirydate = $this->request->getData('expirydate');
        $expirydate = Time::createFromFormat(
            'd/m/Y',
            $expirydate,
            'Europe/Paris'
        );
        $taskgroups = $this->Taskgroups->newEntity();
        $taskgroups->projectId = $pid;
        $taskgroups->title = $title;
        $taskgroups->description = $description;
        $taskgroups->price = $price;
        $taskgroups->tax_percentage = $tax;
        $taskgroups->last_update = Time::now();
        $taskgroups->creation_date = Time::now();
        $taskgroups->startdate = $startdate;
        $taskgroups->expirydate = $expirydate;
        $this->loadModel('ProjectObject');
        $projectobject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id' => $pid
            ]
        ])->first();
        $totaltaskgroup = $this->Taskgroups->find('all', [
            'conditions' => [
                'projectId' => $pid
            ]
        ])->toArray();
        $total =  count($totaltaskgroup);

        if ($isFutured != null) {
            $taskgroups->isFuturedGroup = 1;
            if ($total < $projectobject->totalgroups) {
                $this->Taskgroups->save($taskgroups);
                $this->Flash->success(__('Group Created Sucessfully'));
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'futureprojectsview',
                    $pid
                ]);
            } else {
                $this->Flash->error(__('Number of Groups in this Project Exceeded.'));
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'futureprojectsview',
                    $pid
                ]);
            }
        } else {
            if ($total < $projectobject->totalgroups) {
                $this->Taskgroups->save($taskgroups);
                $this->Flash->success(__('Group Created Sucessfully'));
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'taskboard',
                    $pid
                ]);
            } else {
                $this->Flash->error(__('Number of Groups in this Project Exceeded.'));
                return $this->redirect([
                    'controller' => 'projectObject',
                    'action' => 'taskboard',
                    $pid
                ]);
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Taskgroup id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $taskgroup = $this->Taskgroups->get($id, [
            'contain' => ['Projecttasks']
        ]);

        $this->set('taskgroup', $taskgroup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taskgroup = $this->Taskgroups->newEntity();
        if ($this->request->is('post')) {
            $taskgroup = $this->Taskgroups->patchEntity($taskgroup, $this->request->getData());
            if ($this->Taskgroups->save($taskgroup)) {
                $this->Flash->success(__('The taskgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskgroup could not be saved. Please, try again.'));
        }
        $projecttasks = $this->Taskgroups->Projecttasks->find('list', ['limit' => 200]);
        $this->set(compact('taskgroup', 'projecttasks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Taskgroup id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $taskgroup = $this->Taskgroups->get($id, [
            'contain' => ['Projecttasks']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $taskgroup = $this->Taskgroups->patchEntity($taskgroup, $this->request->getData());
            if ($this->Taskgroups->save($taskgroup)) {
                $this->Flash->success(__('The taskgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskgroup could not be saved. Please, try again.'));
        }
        $projecttasks = $this->Taskgroups->Projecttasks->find('list', ['limit' => 200]);
        $this->set(compact('taskgroup', 'projecttasks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Taskgroup id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $taskgroup = $this->Taskgroups->get($id);
        if ($this->Taskgroups->delete($taskgroup)) {
            $this->Flash->success(__('The taskgroup has been deleted.'));
        } else {
            $this->Flash->error(__('The taskgroup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
