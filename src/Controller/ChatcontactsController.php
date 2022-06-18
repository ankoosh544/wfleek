<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;

/**
 * Chatcontacts Controller
 *
 * @property \App\Model\Table\ChatcontactsTable $Chatcontacts
 *
 * @method \App\Model\Entity\Chatcontact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatcontactsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $chatcontacts = $this->paginate($this->Chatcontacts);

        $this->set(compact('chatcontacts'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Chatcontact id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatcontact = $this->Chatcontacts->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('chatcontact', $chatcontact);
    }

    /**delete contact */
    public function deletecontact($contactid = null){
        $contactid =  $this->request->getQuery('contactId');
        $type = $this->request->getQuery('type');
        $companyId = $this->request->getQuery('companyId');

        if ($contactid != null) {
            $user_id = $this->Auth->user('id');
            $deletecontact = $this->Chatcontacts->find('all', [
                'conditions' => [
                    'id ' => $contactid
                ]
            ])->first();
            $deletecontact->isDeleted = true;
            $this->Chatcontacts->save($deletecontact);
            return $this->redirect([
                'controller' => 'Chatcontacts',
                'action' => 'contacts',
                'companyId' => $companyId,
                'type' => $type

            ]);
        }

        if ($this->request->is('ajax')) {
        $user_id = $this->Auth->user('id');
        $contactid = $this->request->getData('contactid');
        //debug($contactid);exit;
        $deletecontact = $this->Chatcontacts->find('all',[
            'conditions'=>[
                'id ' => $contactid
            ]
        ])->first();
        $this->Chatcontacts->delete($deletecontact);

        $contacts = $this->Chatcontacts->find('all', [
            'conditions' => [
                'fromuser_id' => $user_id
            ]
        ])->order(['creation_date' => 'ASC'])->contain(['ToUser', 'FromUser'])->toArray();

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($contacts));
        //debug($deletecontact);exit;
            }

    }

    /**Add user for chat contacts */
    public function adduser(){
        $this->loadModel('User');
        $this->loadModel('Chatcontacts');

        $user_id = $this->Auth->user('id');
        $companyId = $this->request->getData('companyId');
        $chatcontacts = $this->request->getData()['chatcontacts'];
        $contacttype = $this->request->getData('contacttype');

        $render = $this->request->getData('rendertocontact');
        $allcontacts =  $this->Chatcontacts->find('all', [
            'conditions' => [
                'Chatcontacts.isDeleted' => false,
                'fromuser_id' => $user_id,
                'company_id' => $companyId
            ]
        ])->order(['creation_date' => 'ASC'])->contain(['ToUser', 'FromUser'])->toArray();

        $addedcids =array();
        foreach($allcontacts as $user){
            array_push($addedcids, $user->id);
        }
        foreach ($chatcontacts as $contactId) {
            $chatcontact = $this->Chatcontacts->newEntity();
            $chatcontact->company_id = $companyId;
            $chatcontact->touser_id = $contactId;
            $chatcontact->fromuser_id = $user_id;
            $chatcontact->creation_date = Time::now();

            $this->Chatcontacts->save($chatcontact);
        }


        if($render == null){
        return $this->redirect(['controller' => 'chats',
        'action' => 'chatsystem']);
        }else{
            return $this->redirect([
                'controller' => 'chatcontacts',
                'action' => 'contacts',
                'companyId' => $companyId,
                'type' => $contacttype

            ]);

        }
    }
    public function getcontacts()
    {
        $dummy = $this->request->getData('dummy');

        $allcontacts = $this->Chatcontacts->find('all')->toArray();
        $this->autoRender = false;
        $total = count($allcontacts);
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($total));
    }


    /*contacts*/
    public function contacts()
    {

        $this->loadModel('Chatcontacts');
        $this->loadModel('CompaniesUser');
        $companyId = $this->request->getQuery('companyId');
        $type = $this->request->getQuery('type');
        $user_id = $this->Auth->user('id');
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User'])->toArray();
        $authcompanymember = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.company_id' => $companyId,
                'CompaniesUser.user_id' => $user_id
            ]
        ])->contain(['User', 'Usercompanies', 'Designations.Usermodulepermissions.Modules'])->first();
        $alluserData =  $this->Chatcontacts->find('all', [
            'conditions' => [
                'Chatcontacts.isDeleted' => false,
                'Chatcontacts.fromuser_id' => $user_id,
                'Chatcontacts.company_id' => $companyId
            ]
        ])->order(['creation_date' => 'ASC'])->contain(['ToUser', 'FromUser'])->toArray();
        $addedcids = array();
        foreach ($alluserData as $user) {
            array_push($addedcids, $user->id);
        }
        $this->set(compact('addedcids', 'alluserData', 'companyId', 'authcompanymember', 'companymembers', 'type'));
    }
    public function employeescontacts(){
        $user_id = $this->Auth->user('id');
        $this->loadModel('ProjectMember');



        $conditions = array(
            'or' => array(
                array(
                    'ProjectMember.type' =>  'H',

                ),
                array(
                    'ProjectMember.type' =>  'D',

                ),

                'ProjectMember.type' =>  'Z',
            )
        );
       $employees =  $this->ProjectMember->find('all',[
            'conditions' => $conditions
        ])->toArray();
        //debug($employees);exit;

        $employeeids = array();
        foreach($employees as $employee){
            array_push($employeeids, $employee->memberId);
        }
        $unique_employees = array_unique($employeeids);

            $allusers =  $this->Chatcontacts->find('all', [
                'conditions' => [
                    'Chatcontacts.isDeleted' => false,
                    'Chatcontacts.fromuser_id in' =>  $user_id,
                    'touser_id in' => $unique_employees
                ]
            ])->contain(['ToUser', 'FromUser'])->toArray();


        //debug($allusers);exit;
        $this->set(compact('allusers'));

    }


    public function clientcontacts(){
        $user_id = $this->Auth->user('id');
        $this->loadModel('ProjectMember');
       $allclients =  $this->ProjectMember->find('all',[
            'conditions' => [
                'type' => 'C'
            ]
        ])->toArray();

        $clients = array();
        foreach($allclients as $client){
            array_push($clients, $client->memberId);
        }
        $unique_clients = array_unique($clients);
        //debug($clients);exit;

      /*   $allusers = array(); */
       /*  foreach ($unique_clients as $client) { */
            $allusers =  $this->Chatcontacts->find('all', [
                'conditions' => [
                    'Chatcontacts.isDeleted' => false,
                    'Chatcontacts.fromuser_id in' =>  $user_id,
                    'touser_id in' =>$unique_clients
                ]
            ])->contain(['ToUser', 'FromUser'])->toArray();
           /*  array_push($allusers, $user); */
      /*   } */

        $this->set(compact('allusers'));


    }




    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatcontact = $this->Chatcontacts->newEntity();
        if ($this->request->is('post')) {
            $chatcontact = $this->Chatcontacts->patchEntity($chatcontact, $this->request->getData());
            if ($this->Chatcontacts->save($chatcontact)) {
                $this->Flash->success(__('The chatcontact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatcontact could not be saved. Please, try again.'));
        }
        $users = $this->Chatcontacts->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatcontact', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chatcontact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatcontact = $this->Chatcontacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatcontact = $this->Chatcontacts->patchEntity($chatcontact, $this->request->getData());
            if ($this->Chatcontacts->save($chatcontact)) {
                $this->Flash->success(__('The chatcontact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatcontact could not be saved. Please, try again.'));
        }
        $users = $this->Chatcontacts->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatcontact', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chatcontact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatcontact = $this->Chatcontacts->get($id);
        if ($this->Chatcontacts->delete($chatcontact)) {
            $this->Flash->success(__('The chatcontact has been deleted.'));
        } else {
            $this->Flash->error(__('The chatcontact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
