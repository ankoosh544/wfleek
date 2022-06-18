<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 *
 * @method \App\Model\Entity\Setting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
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
            'contain' => ['User', 'Usercompanies']
        ];
        $settings = $this->paginate($this->Settings);

        $this->set(compact('settings'));
    }

    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $setting = $this->Settings->get($id, [
            'contain' => ['User', 'Usercompanies']
        ]);

        $this->set('setting', $setting);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $setting = $this->Settings->newEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $user = $this->Settings->User->find('list', ['limit' => 200]);
        $usercompanies = $this->Settings->Usercompanies->find('list', ['limit' => 200]);
        $this->set(compact('setting', 'user', 'usercompanies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $setting = $this->Settings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $user = $this->Settings->User->find('list', ['limit' => 200]);
        $usercompanies = $this->Settings->Usercompanies->find('list', ['limit' => 200]);
        $this->set(compact('setting', 'user', 'usercompanies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->get($id);
        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }




    public function updatesecuritysettings()
    {
        $this->loadModel('Settings');
        $user_id = $this->Auth->user('id');
        $two_factor =  $this->request->getData('two_factor_auth');
        $authuser = $this->Settings->find('all',[
            'conditions' => [
                'user_id in' => $user_id
            ]
        ])->first();

        $authuser->two_factor_authentication = $two_factor;
        $this->Settings->save($authuser);
        return $this->redirect(['action' => 'usercompanysettings']);

    }


    public function usercompanysettings($companyId= null)
    {
        $this->loadModel('Cities');
        $this->loadModel('RolePermissions');
        $cities = $this->Cities->find('all')->distinct(['province'])->order(['province' => 'ASC', 'name' => 'ASC'])->toArray();
        $user_id = $this->Auth->user('id');
        $this->loadModel('Settings');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $authusersettings = $this->Settings->find('all',[
            'conditions' => [
                'Settings.user_id in' => $user_id
            ]
        ])->contain(['Usercompanies','User'])->first();
        $lastaddedrole = $this->RolePermissions->find('all',[
            'conditions' => [
                'RolePermissions.company_id' => $companyId
            ]
        ])->order(['creation_date' => 'DESC'])->first();
       //debug($lastaddedrole);exit;



        $this->set(compact('authusersettings','cities', 'companyId','lastaddedrole'));

    }


}
