<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Payslips Controller
 *
 * @property \App\Model\Table\PayslipsTable $Payslips
 *
 * @method \App\Model\Entity\Payslip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PayslipsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Companies']
        ];
        $payslips = $this->paginate($this->Payslips);

        $this->set(compact('payslips'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Payslip id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payslip = $this->Payslips->get($id, [
            'contain' => ['Users', 'Companies']
        ]);

        $this->set('payslip', $payslip);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payslip = $this->Payslips->newEntity();
        if ($this->request->is('post')) {
            $payslip = $this->Payslips->patchEntity($payslip, $this->request->getData());
            if ($this->Payslips->save($payslip)) {
                $this->Flash->success(__('The payslip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payslip could not be saved. Please, try again.'));
        }
        $users = $this->Payslips->Users->find('list', ['limit' => 200]);
        $companies = $this->Payslips->Companies->find('list', ['limit' => 200]);
        $this->set(compact('payslip', 'users', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payslip id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payslip = $this->Payslips->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payslip = $this->Payslips->patchEntity($payslip, $this->request->getData());
            if ($this->Payslips->save($payslip)) {
                $this->Flash->success(__('The payslip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payslip could not be saved. Please, try again.'));
        }
        $users = $this->Payslips->Users->find('list', ['limit' => 200]);
        $companies = $this->Payslips->Companies->find('list', ['limit' => 200]);
        $this->set(compact('payslip', 'users', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payslip id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payslip = $this->Payslips->get($id);
        if ($this->Payslips->delete($payslip)) {
            $this->Flash->success(__('The payslip has been deleted.'));
        } else {
            $this->Flash->error(__('The payslip could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function employeepayslips()
    {

        $user_id = $this->request->getQuery('empid');
        $companyId = $this->request->getQuery('companyId');
        $this->loadModel('Payslips');
       $userpayslips = $this->Payslips->find('all',[
            'conditions' => [
                'Payslips.company_id' => $companyId,
                'Payslips.user_id' => $user_id
            ]
        ])->contain(['User','Usercompanies'])->toArray();
        $allemployees = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User', 'Designations'])->toArray();
        $this->set(compact('user_id', 'companyId','userpayslips','allemployees','user_id','companyId'));
    }

    public function payslips($companyId = null){
        $payslips = $this->Payslips->find('all',[
            'conditions' => [
                'Payslips.company_id' => $companyId
            ]
        ])->contain(['User','Usercompanies'])->toArray();
        $allemployees = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User','Designations'])->toArray();
        $this->set(compact('payslips', 'companyId', 'allemployees'));

    }


    public function addpayslip(){

        $payslip = $this->Payslips->newEntity();
        $user_id = $this->request->getData('user_id');
        $companyId = $this->request->getData('companyId');
        $month= $this->request->getData('month');
        $year = $this->request->getData('year');
        $file = $this->request->getData()['image'];
        $payslip->user_id = $user_id;
        $payslip->company_id = $companyId;
        $payslip->month = $month;
        $payslip->year = $year;
        $payslip->payslip_filename = $file['name'];
        $payslip->payslip_filepath = "assets/payslips/" .  $month.$user_id;
        $destinationFolder = WWW_ROOT . "assets/payslips/" .  $month.$user_id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        $this->Payslips->save($payslip);

        return $this->redirect([
            'controller' => 'payslips',
            'action' => 'payslips',
             $companyId
    ]);
    }

    public function downloadpayslip($payslipId = null){

        $this->loadModel('Payslips');
        $this->loadModel('CompaniesUser');
        $downloadpayslip = $this->Payslips->find('all',[
            'conditions' => [
                'id in' => $payslipId
            ]
        ])->first();

        $file = WWW_ROOT . $downloadpayslip->payslip_filepath . DS . $downloadpayslip->payslip_filename;

        //debug($file);exit;

         $response =  $this->response->withFile($file, [
             'download' => true,
             'name' => $downloadpayslip->payslip_filename,
         ]);
        return $response;



    }

    public function searchpayslips(){
        $user_id = $this->request->getData('user_id');
        $companyId = $this->request->getData('companyId');


        $companypayslips =  $this->Payslips->find('all',[
            'conditions' => [
                'Payslips.company_id in' => $companyId,
                'Payslips.user_id in' => $user_id
            ]
        ])->contain(['User','Usercompanies'])->toArray();

        $this->loadModel('CompaniesUser');

        $allemployees = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User','Designations'])->toArray();


        $name = $this->request->getData('employeename');
        $month = $this->request->getData('month');
        $year = $this->request->getData('year');
        $matched_data = array();
        foreach($companypayslips as $payslip){
            if($month != null){
                if($month == $payslip->month){
                    array_push(
                        $matched_data,
                        $payslip
                    );

                }
             }
             if($year != null){
                if($year == $payslip->year){
                    array_push(
                        $matched_data,
                        $payslip
                    );

                }
             }
        }

        $this->set(compact('matched_data','user_id','companyId','allemployees'));
    }

    public function payslipReports($companyId = null){
        $this->loadModel('CompaniesUser');
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['Payslips.User','Designations'])->toArray();
     //  debug($companymembers);exit;



        $this->set(compact('companymembers', 'companyId'));


    }
}
