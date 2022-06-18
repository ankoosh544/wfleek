<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Groupmembers Controller
 *
 * @property \App\Model\Table\GroupmembersTable $Groupmembers
 *
 * @method \App\Model\Entity\Groupmember[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupmembersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups', 'Users']
        ];
        $groupmembers = $this->paginate($this->Groupmembers);

        $this->set(compact('groupmembers'));
    }
    public function isAuthorized()
    {
        return true;
    }


    /**
     * View method
     *
     * @param string|null $id Groupmember id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupmember = $this->Groupmembers->get($id, [
            'contain' => ['Groups', 'Users']
        ]);

        $this->set('groupmember', $groupmember);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $groupid = $this->request->getData('groupid');

        $tagvalues = $this->request->getData('memberIds');
        $role = $this->request->getData('adddesignation');
        $this->loadModel('Groups');

        $groupmembers = $this->Groupmembers->find('all',[
            'conditions' => [
                'group_id in' => $groupid
            ]
        ])->toArray();


        $memberIds = array();
        foreach($groupmembers as $member){
            array_push($memberIds, $member->user_id);

        }

        foreach ($tagvalues as $userId) {
            if (!in_array($userId, $memberIds)) {
                $groupmember = $this->Groupmembers->newEntity();
                $groupmember->group_id = $groupid;
                $groupmember->user_id = $userId;
                $groupmember->member_role = $role;
                $this->Groupmembers->save($groupmember);
                return $this->redirect(['controller' => 'groups', 'action' => 'view', $groupid]);
            } else {

                $this->Flash->error('User Already Exit');
                return $this->redirect(['controller' => 'groups', 'action' => 'addmembers', $groupid]);
            }

        }


    }

    public function deletemember()
    {
        $this->loadModel('Groups');
        $groupid = $this->request->getQuery('groupid');
        $memberId = $this->request->getQuery('memberid');
         $groupmember = $this->Groupmembers->find('all',[
            'conditions' => [
                'group_id' => $groupid,
                'user_id' => $memberId
            ]
        ])->first();



        if($groupmember->member_role == 'Y'){
            $admin = $this->Groupmembers->find('all',[
                'conditions' => [
                'group_id' => $groupid,
                'user_id !=' => $memberId,
                'Groupmembers.isDeleted' => false
                ]
            ])->contain(['Users'])->order(['creation_date' => 'ASC'])->first();



            if (!empty($admin)) {
                $admin->member_role = 'Y';
                $this->Groupmembers->save($admin);
                $group = $this->Groups->find('all', [
                    'conditions' => [
                        'id in' => $groupid
                    ]
                ])->first();
                $group->creatorId = $admin->user_id;
                $this->Groups->save($group);
            } else {
                $group = $this->Groups->find('all', [
                    'conditions' => [
                        'id in' => $groupid
                    ]
                ])->first();
                $group->isDeleted = true;
                $this->Groups->save($group);
                $this->Flash->success(__('Gruppo eliminato'));
            }
        }
       $groupmember->isDeleted = true;
       $this->Groupmembers->save($groupmember);

        $this->loadModel('User');
       $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
       return $this->redirect(['controller' => 'usercompanies','action' => 'view',$authuser->choosen_companyId]);

    }

    /**
     * Edit method
     *
     * @param string|null $id Groupmember id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupmember = $this->Groupmembers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupmember = $this->Groupmembers->patchEntity($groupmember, $this->request->getData());
            if ($this->Groupmembers->save($groupmember)) {
                $this->Flash->success(__('The groupmember has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupmember could not be saved. Please, try again.'));
        }
        $groups = $this->Groupmembers->Groups->find('list', ['limit' => 200]);
        $users = $this->Groupmembers->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupmember', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupmember id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupmember = $this->Groupmembers->get($id);
        if ($this->Groupmembers->delete($groupmember)) {
            $this->Flash->success(__('The groupmember has been deleted.'));
        } else {
            $this->Flash->error(__('The groupmember could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
