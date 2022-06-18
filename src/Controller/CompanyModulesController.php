<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CompanyModules Controller
 *
 * @property \App\Model\Table\CompanyModulesTable $CompanyModules
 *
 * @method \App\Model\Entity\CompanyModule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyModulesController extends AppController
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
        $companyModules = $this->paginate($this->CompanyModules);

        $this->set(compact('companyModules'));
    }

    /**
     * View method
     *
     * @param string|null $id Company Module id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyModule = $this->CompanyModules->get($id, [
            'contain' => ['Companies']
        ]);

        $this->set('companyModule', $companyModule);
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('RolePermissions');
        $this->loadModel('Designations');
        $this->loadModel('UsermodulePermissions');
        $companyModule = $this->CompanyModules->newEntity();
        $companyId = $this->request->getQuery('companyId');

        $rolepermissions = $this->RolePermissions->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->toArray();

        $name = $this->request->getQuery('modulename');
        $companyModule->name = $name;
        $companyModule->company_id = $companyId;
        if ($this->CompanyModules->save($companyModule)) {

            if(!empty($rolepermissions)){
                foreach($rolepermissions as $rolepermission){
                    $designation = $this->Designations->find('all',[
                        'conditions' => [
                            'id' => $rolepermission->designation_id
                        ]
                    ])->first();
                    if($designation->name != 'Administrator') {
                        $usermodule = $this->UsermodulePermissions->newEntity();
                        $usermodule->designation_id = $designation->id;
                        $usermodule->module_id =  $companyModule->id;
                        $this->UsermodulePermissions->save($usermodule);

                        $rolePermission = $this->RolePermissions->newEntity();
                        $rolePermission->designation_id = $designation->id;
                        $rolePermission->company_id = $companyId;
                        $rolePermission->usermodule_id = $usermodule->id;
                        $this->RolePermissions->save($rolePermission);
                    }else{
                        $usermodule = $this->UsermodulePermissions->newEntity();
                        $usermodule->designation_id = $designation->id;
                        $usermodule->module_id =  $companyModule->id;
                        $usermodule->isAccessed = true;
                        $usermodule->isRead = true;
                        $usermodule->isWrite = true;
                        $usermodule->isCreate = true;
                        $usermodule->isDelete = true;
                        $usermodule->isImport = true;
                        $usermodule->isExport = true;
                        $this->UsermodulePermissions->save($usermodule);

                        $rolePermission = $this->RolePermissions->newEntity();
                        $rolePermission->designation_id = $designation->id;
                        $rolePermission->company_id = $companyId;
                        $rolePermission->usermodule_id = $usermodule->id;
                        $this->RolePermissions->save($rolePermission);

                    }

                }
            }

            $lastaddedrole = $this->RolePermissions->find('all',[
                'conditions' => [
                    'RolePermissions.company_id' => $companyId
                ]
            ])->order(['creation_date' => 'DESC'])->first();

            $this->Flash->success(__('The company module has been saved.'));
            if(!empty($lastaddedrole)){
                return $this->redirect([
                    'controller' => 'rolePermissions',
                    'action' => 'roles-permissions',
                    'companyId' => $companyId,
                    'roleId' => $lastaddedrole->designation_id
                ]);

            }else{
                return $this->redirect([
                    'controller' => 'rolePermissions',
                    'action' => 'roles-permissions',
                    'companyId' => $companyId
                ]);

            }

        }
        $this->Flash->error(__('The company module could not be saved. Please, try again.'));
        return $this->redirect([
            'controller' => 'rolePermissions',
            'action' => 'roles-permissions',
            'companyId' => $companyId
        ]);
        $companies = $this->CompanyModules->Companies->find('list', ['limit' => 200]);

    }

    /**
     * Edit method
     *
     * @param string|null $id Company Module id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyModule = $this->CompanyModules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyModule = $this->CompanyModules->patchEntity($companyModule, $this->request->getData());
            if ($this->CompanyModules->save($companyModule)) {
                $this->Flash->success(__('The company module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company module could not be saved. Please, try again.'));
        }
        $companies = $this->CompanyModules->Companies->find('list', ['limit' => 200]);
        $this->set(compact('companyModule', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Module id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyModule = $this->CompanyModules->get($id);
        if ($this->CompanyModules->delete($companyModule)) {
            $this->Flash->success(__('The company module has been deleted.'));
        } else {
            $this->Flash->error(__('The company module could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updatemoduleaccess(){
        $moduleId = $this->request->getData('moduleId');
        $access = $this->request->getData('access');



        $module = $this->CompanyModules->find('all',[
            'conditions' => [
                'id' => $moduleId
            ]
        ])->first();

        $module->isNotify =json_decode($access);
        $this->CompanyModules->save($module);

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($module));


    }
}
