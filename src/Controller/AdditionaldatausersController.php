<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Additionaldatausers Controller
 *
 * @property \App\Model\Table\AdditionaldatausersTable $Additionaldatausers
 *
 * @method \App\Model\Entity\Additionaldatauser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdditionaldatausersController extends AppController
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
        $additionaldatausers = $this->paginate($this->Additionaldatausers);

        $this->set(compact('additionaldatausers'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Additionaldatauser id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $additionaldatauser = $this->Additionaldatausers->get($id, [
            'contain' => ['Companies']
        ]);

        $this->set('additionaldatauser', $additionaldatauser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $additionaldatauser = $this->Additionaldatausers->newEntity();
        if ($this->request->is('post')) {
            $additionaldatauser = $this->Additionaldatausers->patchEntity($additionaldatauser, $this->request->getData());
            if ($this->Additionaldatausers->save($additionaldatauser)) {
                $this->Flash->success(__('The additionaldatauser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The additionaldatauser could not be saved. Please, try again.'));
        }
        $companies = $this->Additionaldatausers->Companies->find('list', ['limit' => 200]);
        $this->set(compact('additionaldatauser', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Additionaldatauser id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $additionaldatauser = $this->Additionaldatausers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $additionaldatauser = $this->Additionaldatausers->patchEntity($additionaldatauser, $this->request->getData());
            if ($this->Additionaldatausers->save($additionaldatauser)) {
                $this->Flash->success(__('The additionaldatauser has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The additionaldatauser could not be saved. Please, try again.'));
        }
        $companies = $this->Additionaldatausers->Companies->find('list', ['limit' => 200]);
        $this->set(compact('additionaldatauser', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Additionaldatauser id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $additionaldatauser = $this->Additionaldatausers->get($id);
        if ($this->Additionaldatausers->delete($additionaldatauser)) {
            $this->Flash->success(__('The additionaldatauser has been deleted.'));
        } else {
            $this->Flash->error(__('The additionaldatauser could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function addupdatedemployee(){
        $this->loadModel('Additionaldatausers');

        $user_id = $this->request->getData('emp_id');
       $companyId = $this->request->getData('company_id');
       $role = $this->request->getData('role');
       $tax_code = $this->request->getData('tax_code');
       $vat_code = $this->request->getData('vat_code');
       $contract_name = $this->request->getData('contract_name');
       $file = $this->request->getData()['contractfile'];

        $additionaldatauser = $this->Additionaldatausers->newEntity();
        $additionaldatauser->user_id = $user_id;
        $additionaldatauser->company_id = $companyId;
        $additionaldatauser->member_role = $role;
        $additionaldatauser->vat_code = $vat_code;
        $additionaldatauser->tax_code = $tax_code;
        $additionaldatauser->employee_contract_type = $contract_name;


        $additionaldatauser->contract_filename = $file['name'];
        $additionaldatauser->contract_filepath = "assets/employeecontracts/" .  $companyId. $user_id;
        $destinationFolder = WWW_ROOT . "assets/employeecontracts/" .  $companyId. $user_id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);

        $this->Additionaldatausers->save($additionaldatauser);
        $this->loadModel('CompaniesUser');
       $updateemployee = $this->CompaniesUser->find('all',[
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $companyId
            ]
        ])->first();

        $updateemployee->member_role = $role;
        $this->CompaniesUser->save($updateemployee);

        return $this->redirect(['controller' => 'companiesuser',
        'action' => 'employeesdata',
        'emp_id' => $user_id,
        'company_id' => $companyId
    ]);

    }
}
