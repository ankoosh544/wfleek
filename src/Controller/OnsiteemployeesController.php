<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Onsiteemployees Controller
 *
 * @property \App\Model\Table\OnsiteemployeesTable $Onsiteemployees
 *
 * @method \App\Model\Entity\Onsiteemployee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OnsiteemployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('User');
        $this->loadModel('Project_Member');
        $this->loadModel('Usercompanies');

        $this->loadModel('Worklocations');

        $this->loadModel('CompaniesUser');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

         $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'member_role' => 'C'
            ]
        ])->toArray();
       // debug($clients);exit;

        $worklocations = $this->Worklocations->find('all',[
            'isDeleted' => false
        ])->toArray();
      //  $clients = $this->Usercompanies->find('all')->toArray();

        $clientids = array();
        foreach($clients as $client){
            array_push($clientids, $client->memberId);
        }

        $unique_clients = array_unique($clientids);


       // debug($unique_clients);exit;
        if(!empty($unique_clients)){
       $clientsData =  $this->User->find('all',[
            'conditions' => [
                'id in' =>  $unique_clients
            ]
        ])->toArray();
            }else{
                $clientsData = null;

            }

            //debug($clientsData);exit;

     //  $employeeonsiteworks = $this->paginate($this->Employeeonsiteworks);

        $this->set(compact('clientsData','worklocations'));
    }



    public function isAuthorized($user)
    {
        return true;
    }


    /**
     * View method
     *
     * @param string|null $id Onsiteemployee id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $onsiteemployee = $this->Onsiteemployees->get($id, [
            'contain' => ['Clients']
        ]);

        $this->set('onsiteemployee', $onsiteemployee);
    }


    /**add location */

    public function addlocation(){
        $this->loadModel('Worklocations');
        $name = $this->request->getData('location_name');
        $address = $this->request->getData('location_address');
        $worklocations = $this->Worklocations->newEntity();
        $worklocations->work_location = $name;
        $worklocations->work_address = $address;
        $this->Worklocations->save($worklocations);
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Worklocations');
        $allworklocations = $this->Worklocations->find('all')->toArray();
        $company = $this->request->getData('company');
        $project = $this->request->getData('project');
        $worklocations = json_decode($_POST['worklocation']);

        $this->loadModel('Onsiteemployees');


        foreach($worklocations as $key => $locationid){


            if ($key) {
                foreach ($locationid as $userids) {

                    $worklocations = $this->Onsiteemployees->newEntity();
                    $worklocations->client_id =  $company;
                    $worklocations->projectId = $project;
                    $worklocations->work_location_Id =  $key;
                    $worklocations->user_id = $userids;
                    $worklocations->creation_date = Time::now();
                $this->Onsiteemployees->save($worklocations);
                }
            }


        }









        $onsiteemployee = $this->Onsiteemployees->newEntity();




        $this->set(compact('onsiteemployee', 'clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Onsiteemployee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $onsiteemployee = $this->Onsiteemployees->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $onsiteemployee = $this->Onsiteemployees->patchEntity($onsiteemployee, $this->request->getData());
            if ($this->Onsiteemployees->save($onsiteemployee)) {
                $this->Flash->success(__('The onsiteemployee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The onsiteemployee could not be saved. Please, try again.'));
        }
        $clients = $this->Onsiteemployees->Clients->find('list', ['limit' => 200]);
        $this->set(compact('onsiteemployee', 'clients'));
    }


    public function companyproject(){
        $this->loadModel('CompaniesUser');
        $clientId = $this->request->getData('clientid');
        $this->loadModel('ProjectMember');
        $clientprojects  = $this->ProjectMember->find('all',[
            'conditions' => [
                'memberId in' => $clientId
            ]
        ])->contain(['ProjectObject'])->toArray();
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($clientprojects));


    }

    public function getemployees()
    {
        $this->loadModel('ProjectMember');
        $pid = $this->request->getData('projectid');
        $allmembers =  $this->ProjectMember->find('all', [
            'conditions' => [
                'projectId' => $pid,
                'type !=' => 'C'
            ]
        ])->contain(['User'])->toArray();

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($allmembers));

    }


    /**
     * Delete method
     *
     * @param string|null $id Onsiteemployee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $onsiteemployee = $this->Onsiteemployees->get($id);
        if ($this->Onsiteemployees->delete($onsiteemployee)) {
            $this->Flash->success(__('The onsiteemployee has been deleted.'));
        } else {
            $this->Flash->error(__('The onsiteemployee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function docworklocations(){
        $this->loadModel('Worklocations');
       $allworklocations =  $this->Worklocations->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($allworklocations));
    }
}
