<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;

/**
 * Employeesdailyworkflow Controller
 *
 * @property \App\Model\Table\EmployeesdailyworkflowTable $Employeesdailyworkflow
 *
 * @method \App\Model\Entity\Employeesdailyworkflow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesdailyworkflowController extends AppController
{
    public function isAuthorized($user)
    {
        return true;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['User']
        ];
        $employeesdailyworkflow = $this->paginate($this->Employeesdailyworkflow);

        $this->set(compact('employeesdailyworkflow'));
    }

    /**Employeesworkstatus today */

    public function employeesworkstatus()
    {
        $this->loadModel('Leaves');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $date = Time::now()->i18nFormat('dd/MM/yyyy', 'Europe/Rome');

        $leaves = $this->Leaves->find('all', [
            'conditions' => [
                'fromdate <= ' => $date,
                'todate >='  => $date,
                'status' => 'A'

            ]
        ])->toArray();
        $allusers = $this->User->find('all')->toArray();
        $projectMembers = $this->ProjectMember->find('all')->toArray();
        $this->set(compact('allusers','projectMembers'));


       // $newrecord = $this->Employeesdailyworkflow->newEntity();+
        //newre
       // debug($leaves);exit;


    }

    /**
     * View method
     *
     * @param string|null $id Employeesdailyworkflow id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeesdailyworkflow = $this->Employeesdailyworkflow->get($id, [
            'contain' => ['User']
        ]);

        $this->set('employeesdailyworkflow', $employeesdailyworkflow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeesdailyworkflow = $this->Employeesdailyworkflow->newEntity();
        if ($this->request->is('post')) {
            $employeesdailyworkflow = $this->Employeesdailyworkflow->patchEntity($employeesdailyworkflow, $this->request->getData());
            if ($this->Employeesdailyworkflow->save($employeesdailyworkflow)) {
                $this->Flash->success(__('The employeesdailyworkflow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employeesdailyworkflow could not be saved. Please, try again.'));
        }
        $user = $this->Employeesdailyworkflow->User->find('list', ['limit' => 200]);
        $this->set(compact('employeesdailyworkflow', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employeesdailyworkflow id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeesdailyworkflow = $this->Employeesdailyworkflow->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeesdailyworkflow = $this->Employeesdailyworkflow->patchEntity($employeesdailyworkflow, $this->request->getData());
            if ($this->Employeesdailyworkflow->save($employeesdailyworkflow)) {
                $this->Flash->success(__('The employeesdailyworkflow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employeesdailyworkflow could not be saved. Please, try again.'));
        }
        $user = $this->Employeesdailyworkflow->User->find('list', ['limit' => 200]);
        $this->set(compact('employeesdailyworkflow', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employeesdailyworkflow id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeesdailyworkflow = $this->Employeesdailyworkflow->get($id);
        if ($this->Employeesdailyworkflow->delete($employeesdailyworkflow)) {
            $this->Flash->success(__('The employeesdailyworkflow has been deleted.'));
        } else {
            $this->Flash->error(__('The employeesdailyworkflow could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
