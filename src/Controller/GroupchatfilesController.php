<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Groupchatfiles Controller
 *
 * @property \App\Model\Table\GroupchatfilesTable $Groupchatfiles
 *
 * @method \App\Model\Entity\Groupchatfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupchatfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groupchats', 'User']
        ];
        $groupchatfiles = $this->paginate($this->Groupchatfiles);

        $this->set(compact('groupchatfiles'));
    }
    public function isAuthorized($user){
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Groupchatfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupchatfile = $this->Groupchatfiles->get($id, [
            'contain' => ['Groupchats', 'User']
        ]);

        $this->set('groupchatfile', $groupchatfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupchatfile = $this->Groupchatfiles->newEntity();
        if ($this->request->is('post')) {
            $groupchatfile = $this->Groupchatfiles->patchEntity($groupchatfile, $this->request->getData());
            if ($this->Groupchatfiles->save($groupchatfile)) {
                $this->Flash->success(__('The groupchatfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupchatfile could not be saved. Please, try again.'));
        }
        $groupchats = $this->Groupchatfiles->Groupchats->find('list', ['limit' => 200]);
        $user = $this->Groupchatfiles->User->find('list', ['limit' => 200]);
        $this->set(compact('groupchatfile', 'groupchats', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupchatfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupchatfile = $this->Groupchatfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupchatfile = $this->Groupchatfiles->patchEntity($groupchatfile, $this->request->getData());
            if ($this->Groupchatfiles->save($groupchatfile)) {
                $this->Flash->success(__('The groupchatfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupchatfile could not be saved. Please, try again.'));
        }
        $groupchats = $this->Groupchatfiles->Groupchats->find('list', ['limit' => 200]);
        $user = $this->Groupchatfiles->User->find('list', ['limit' => 200]);
        $this->set(compact('groupchatfile', 'groupchats', 'user'));
    }

    public function downloadchatfile($fileid = null){

        $fileinfo = $this->Groupchatfiles->find('all', [
            'conditions' => [
                'id' => $fileid
            ]
        ])->first();
        //$file = WWW_ROOT . str_replace('/', '\\', $fileinfo->filepath . DS . $fileinfo->filename);

        $file = WWW_ROOT . $fileinfo->filepath . DS . $fileinfo->filename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

        return $response;

    }

    /**
     * Delete method
     *
     * @param string|null $id Groupchatfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupchatfile = $this->Groupchatfiles->get($id);
        if ($this->Groupchatfiles->delete($groupchatfile)) {
            $this->Flash->success(__('The groupchatfile has been deleted.'));
        } else {
            $this->Flash->error(__('The groupchatfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
