<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsermodulePermissions Controller
 *
 *
 * @method \App\Model\Entity\UsermodulePermission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsermodulePermissionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $usermodulePermissions = $this->paginate($this->UsermodulePermissions);

        $this->set(compact('usermodulePermissions'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Usermodule Permission id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usermodulePermission = $this->UsermodulePermissions->get($id, [
            'contain' => []
        ]);

        $this->set('usermodulePermission', $usermodulePermission);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usermodulePermission = $this->UsermodulePermissions->newEntity();
        if ($this->request->is('post')) {
            $usermodulePermission = $this->UsermodulePermissions->patchEntity($usermodulePermission, $this->request->getData());
            if ($this->UsermodulePermissions->save($usermodulePermission)) {
                $this->Flash->success(__('The usermodule permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usermodule permission could not be saved. Please, try again.'));
        }
        $this->set(compact('usermodulePermission'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Usermodule Permission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usermodulePermission = $this->UsermodulePermissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usermodulePermission = $this->UsermodulePermissions->patchEntity($usermodulePermission, $this->request->getData());
            if ($this->UsermodulePermissions->save($usermodulePermission)) {
                $this->Flash->success(__('The usermodule permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usermodule permission could not be saved. Please, try again.'));
        }
        $this->set(compact('usermodulePermission'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Usermodule Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usermodulePermission = $this->UsermodulePermissions->get($id);
        if ($this->UsermodulePermissions->delete($usermodulePermission)) {
            $this->Flash->success(__('The usermodule permission has been deleted.'));
        } else {
            $this->Flash->error(__('The usermodule permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updatemoduleaccess(){
       $usermoduleId = $this->request->getData('usermoduleId');
       $access = $this->request->getData('access');
       $usermodule = $this->UsermodulePermissions->find('all',[
           'conditions' => [
               'id in' => $usermoduleId
           ]
       ])->first();
       $usermodule->isAccessed = json_decode($access);
       if(json_decode($access) == false){
        $usermodule->isRead = false;
        $usermodule->isWrite = false;
        $usermodule->isCreate = false;
        $usermodule->isDelete = false;
        $usermodule->isImport = false;
        $usermodule->isExport = false;
       }
       $this->UsermodulePermissions->save($usermodule);

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($usermodule));
    }
    public function updatePermissions(){
        $companyId = $this->request->getData('companyId');
        $usermoduleId = $this->request->getData('usermodule');
        $read = $this->request->getData('read') === null ? false : true;
        $write = $this->request->getData('write') === null ? false : true;
        $create = $this->request->getData('create') === null ? false : true;
        $delete = $this->request->getData('delete') === null ? false : true;
        $import = $this->request->getData('import') === null ? false : true;
        $export = $this->request->getData('export') === null ? false : true;



        $updateusermodule = $this->UsermodulePermissions->find('all',[
            'conditions' => [
                'id in' => $usermoduleId
            ]
        ])->first();
        $updateusermodule->isRead = $read;
        $updateusermodule->isWrite = $write;
        $updateusermodule->isCreate = $create;
        $updateusermodule->isDelete = $delete;
        $updateusermodule->isImport = $import;
        $updateusermodule->isExport = $export;

        $this->UsermodulePermissions->save($updateusermodule);

        return $this->redirect([
            'controller' => 'rolePermissions',
            'action' => 'roles-permissions',
            'companyId' => $companyId,
            'roleId' => $updateusermodule->designation_id
        ]);



    }
}
