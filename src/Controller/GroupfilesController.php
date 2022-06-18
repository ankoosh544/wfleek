<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Groupfiles Controller
 *
 * @property \App\Model\Table\GroupfilesTable $Groupfiles
 *
 * @method \App\Model\Entity\Groupfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups', 'Companies', 'Users']
        ];
        $groupfiles = $this->paginate($this->Groupfiles);

        $this->set(compact('groupfiles'));
    }

    public function isAuthorized()
    {
        return true;
    }


    /**
     * View method
     *
     * @param string|null $id Groupfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupfile = $this->Groupfiles->get($id, [
            'contain' => ['Groups', 'Companies', 'Users']
        ]);

        $this->set('groupfile', $groupfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupfile = $this->Groupfiles->newEntity();
        if ($this->request->is('post')) {
            $groupfile = $this->Groupfiles->patchEntity($groupfile, $this->request->getData());
            if ($this->Groupfiles->save($groupfile)) {
                $this->Flash->success(__('The groupfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupfile could not be saved. Please, try again.'));
        }
        $groups = $this->Groupfiles->Groups->find('list', ['limit' => 200]);
        $companies = $this->Groupfiles->Companies->find('list', ['limit' => 200]);
        $users = $this->Groupfiles->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupfile', 'groups', 'companies', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupfile = $this->Groupfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupfile = $this->Groupfiles->patchEntity($groupfile, $this->request->getData());
            if ($this->Groupfiles->save($groupfile)) {
                $this->Flash->success(__('The groupfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupfile could not be saved. Please, try again.'));
        }
        $groups = $this->Groupfiles->Groups->find('list', ['limit' => 200]);
        $companies = $this->Groupfiles->Companies->find('list', ['limit' => 200]);
        $users = $this->Groupfiles->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupfile', 'groups', 'companies', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupfile = $this->Groupfiles->get($id);
        if ($this->Groupfiles->delete($groupfile)) {
            $this->Flash->success(__('The groupfile has been deleted.'));
        } else {
            $this->Flash->error(__('The groupfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function downloadfile($id){

        $fileinfo = $this->Groupfiles->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $file = $fileinfo->filepath . DS . $fileinfo->filename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

        return $response;

    }


}
