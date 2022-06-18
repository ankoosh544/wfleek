<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Designations Controller
 *
 * @property \App\Model\Table\DesignationsTable $Designations
 *
 * @method \App\Model\Entity\Designation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DesignationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Departments']
        ];
        $designations = $this->paginate($this->Designations);

        $this->set(compact('designations'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($companyId = null)
    {
        $this->loadModel('Departments');
        $departments = $this->Departments->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Designations'])->toArray();

       // debug($departments);exit;

        $this->set(compact('departments', 'companyId'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $name = $this->request->getQuery('designation_name');
        $departmentId = $this->request->getQuery('departmentId');
        $companyId = $this->request->getQuery('companyId');

        $designation = $this->Designations->newEntity();

        $designation->department_id = $departmentId;
        $designation->name = $name;
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'view', $companyId ]);
            }
            $this->Flash->error(__('The designation could not be saved. Please, try again.'));
        $departments = $this->Designations->Departments->find('list', ['limit' => 200]);
        $this->set(compact('designation', 'departments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $designation = $this->Designations->patchEntity($designation, $this->request->getData());
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The designation could not be saved. Please, try again.'));
        }
        $departments = $this->Designations->Departments->find('list', ['limit' => 200]);
        $this->set(compact('designation', 'departments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $designation = $this->Designations->get($id);
        if ($this->Designations->delete($designation)) {
            $this->Flash->success(__('The designation has been deleted.'));
        } else {
            $this->Flash->error(__('The designation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function filteremployees(){
        $this->loadModel('CompaniesUser');
        $companyId = $this->request->getData('companyId');
        $designationId = $this->request->getData('designationId');
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'member_role' => $designationId
            ]
        ])->contain(['User'])->toArray();

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($companymembers));

    }
}
