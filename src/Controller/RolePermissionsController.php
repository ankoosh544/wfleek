<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RolePermissions Controller
 *
 * @property \App\Model\Table\RolePermissionsTable $RolePermissions
 *
 * @method \App\Model\Entity\RolePermission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolePermissionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies', 'UsermodulePermissions', 'Designations']
        ];
        $rolePermissions = $this->paginate($this->RolePermissions);

        $this->set(compact('rolePermissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Role Permission id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rolePermission = $this->RolePermissions->get($id, [
            'contain' => ['Companies', 'UsermodulePermissions', 'Designations']
        ]);

        $this->set('rolePermission', $rolePermission);
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */


    /**
     * Edit method
     *
     * @param string|null $id Role Permission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rolePermission = $this->RolePermissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rolePermission = $this->RolePermissions->patchEntity($rolePermission, $this->request->getData());
            if ($this->RolePermissions->save($rolePermission)) {
                $this->Flash->success(__('The role permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role permission could not be saved. Please, try again.'));
        }
        $companies = $this->RolePermissions->Companies->find('list', ['limit' => 200]);
        $usermodulePermissions = $this->RolePermissions->UsermodulePermissions->find('list', ['limit' => 200]);
        $designations = $this->RolePermissions->Designations->find('list', ['limit' => 200]);
        $this->set(compact('rolePermission', 'companies', 'usermodulePermissions', 'designations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rolePermission = $this->RolePermissions->get($id);
        if ($this->RolePermissions->delete($rolePermission)) {
            $this->Flash->success(__('The role permission has been deleted.'));
        } else {
            $this->Flash->error(__('The role permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function rolesPermissions()
    {
        $companyId = $this->request->getQuery('companyId');
        $lastroleId = $this->request->getQuery('roleId');
     // debug($lastroleId);exit;
        $this->loadModel('Departments');
        $departments = $this->Departments->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Designations'])->toArray();
       // debug($departments[0]->designations);exit;

        $companyrolepermissions = $this->RolePermissions->find('all',[
            'conditions' => [
                'RolePermissions.company_id' => $companyId
            ]
        ])->order(['creation_date' => 'DESC'])->contain(['Designations.Usermodulepermissions.Modules'])->toArray();

      //debug($companyrolepermissions);exit;

        $roledata = $this->RolePermissions->find('all',[
            'conditions' => [
                'RolePermissions.company_id' => $companyId,
                'RolePermissions.designation_id' => $lastroleId
            ]
        ])->contain(['Designations.Usermodulepermissions.Modules'])->first();
     // debug($roledata);exit;


        $this->set(compact('companyId', 'departments', 'companyrolepermissions','roledata'));
    }

 public function add()
    {
        $this->loadModel('CompanyModules');
        $this->loadModel('UsermodulePermissions');
        $this->loadModel('Designations');
        $roleId = $this->request->getQuery('roleId');
        //debug($roleId);exit;
        $designation = $this->Designations->find('all',[
            'conditions' => [
                'id' => $roleId
            ]
        ])->first();

        $companyId = $this->request->getQuery('companyId');

        $companymodules = $this->CompanyModules->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->toArray();
        foreach ($companymodules as $companymodule) {
            if($designation->name != 'Administrator') {
                $usermodule = $this->UsermodulePermissions->newEntity();
                $usermodule->designation_id = $roleId;
                $usermodule->module_id =  $companymodule->id;
                $this->UsermodulePermissions->save($usermodule);

                $rolePermission = $this->RolePermissions->newEntity();
                $rolePermission->designation_id = $roleId;
                $rolePermission->company_id = $companyId;
                $rolePermission->usermodule_id = $usermodule->id;
                $this->RolePermissions->save($rolePermission);
            }else{
                $usermodule = $this->UsermodulePermissions->newEntity();
                $usermodule->designation_id = $roleId;
                $usermodule->module_id =  $companymodule->id;
                $usermodule->isAccessed = true;
                $usermodule->isRead = true;
                $usermodule->isWrite = true;
                $usermodule->isCreate = true;
                $usermodule->isDelete = true;
                $usermodule->isImport = true;
                $usermodule->isExport = true;
                $this->UsermodulePermissions->save($usermodule);

                $rolePermission = $this->RolePermissions->newEntity();
                $rolePermission->designation_id = $roleId;
                $rolePermission->company_id = $companyId;
                $rolePermission->usermodule_id = $usermodule->id;
                $this->RolePermissions->save($rolePermission);

            }




        }
        if ($this->RolePermissions->save($rolePermission)) {
            $this->Flash->success(__('The role permission has been saved.'));
            return $this->redirect([
                'controller' => 'rolePermissions',
                'action' => 'roles-permissions',
                'companyId' => $companyId,
                'roleId' => $roleId
            ]);
        }
        $this->Flash->error(__('The role permission could not be saved. Please, try again.'));
        return $this->redirect([
            'controller' => 'rolePermissions',
            'action' => 'roles-permissions',
            'companyId' => $companyId,
            '$roleId' => $roleId
        ]);

    }
}
