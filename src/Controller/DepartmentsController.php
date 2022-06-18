<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 *
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DepartmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies']
        ];
        $departments = $this->paginate($this->Departments);

        $this->set(compact('departments'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($companyId = null)
    {
        $departments = $this->Departments->find('all',[
            'conditions' => [
                'Departments.company_id' => $companyId,
                'Departments.isDeleted' => false
            ]
        ])->contain(['Companiesuser.Designations'])->toArray();

       // debug($departments);exit;
        $this->set(compact('companyId', 'departments'));
    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyId = $this->request->getQuery('companyId');
        $name = $this->request->getQuery('departmentname');
        $department = $this->Departments->newEntity();

        $department->company_id = $companyId;
        $department->name = $name;
        if ($this->Departments->save($department)) {
            $this->Flash->success(__('The department has been saved.'));

            return $this->redirect(['action' => 'view', $companyId]);
        }
        $this->Flash->error(__('The department could not be saved. Please, try again.'));

        $companies = $this->Departments->CompaniesUser->find('list', ['limit' => 200]);
        $this->set(compact('department', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $department = $this->Departments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
        $companies = $this->Departments->Companies->find('list', ['limit' => 200]);
        $this->set(compact('department', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $department = $this->Departments->get($id);
        if ($this->Departments->delete($department)) {
            $this->Flash->success(__('The department has been deleted.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function filterdesignations(){
        $this->loadModel('Designations');

        $departmentId = $this->request->getData('departmentId');

        $designations = $this->Designations->find('all',[
            'conditions' => [
                'department_id in' => $departmentId
            ]
        ])->toArray();

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($designations));

    }

}
