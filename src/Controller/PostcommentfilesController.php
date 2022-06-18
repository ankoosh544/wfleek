<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Postcommentfiles Controller
 *
 * @property \App\Model\Table\PostcommentfilesTable $Postcommentfiles
 *
 * @method \App\Model\Entity\Postcommentfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostcommentfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Posts', 'Comments', 'Groups', 'Users']
        ];
        $postcommentfiles = $this->paginate($this->Postcommentfiles);

        $this->set(compact('postcommentfiles'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Postcommentfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postcommentfile = $this->Postcommentfiles->get($id, [
            'contain' => ['Posts', 'Comments', 'Groups', 'Users']
        ]);

        $this->set('postcommentfile', $postcommentfile);
    }

    public function downloadfile($fileid = null){

        $fileinfo = $this->Postcommentfiles->find('all', [
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
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postcommentfile = $this->Postcommentfiles->newEntity();
        if ($this->request->is('post')) {
            $postcommentfile = $this->Postcommentfiles->patchEntity($postcommentfile, $this->request->getData());
            if ($this->Postcommentfiles->save($postcommentfile)) {
                $this->Flash->success(__('The postcommentfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postcommentfile could not be saved. Please, try again.'));
        }
        $posts = $this->Postcommentfiles->Posts->find('list', ['limit' => 200]);
        $comments = $this->Postcommentfiles->Comments->find('list', ['limit' => 200]);
        $groups = $this->Postcommentfiles->Groups->find('list', ['limit' => 200]);
        $users = $this->Postcommentfiles->Users->find('list', ['limit' => 200]);
        $this->set(compact('postcommentfile', 'posts', 'comments', 'groups', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Postcommentfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postcommentfile = $this->Postcommentfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postcommentfile = $this->Postcommentfiles->patchEntity($postcommentfile, $this->request->getData());
            if ($this->Postcommentfiles->save($postcommentfile)) {
                $this->Flash->success(__('The postcommentfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postcommentfile could not be saved. Please, try again.'));
        }
        $posts = $this->Postcommentfiles->Posts->find('list', ['limit' => 200]);
        $comments = $this->Postcommentfiles->Comments->find('list', ['limit' => 200]);
        $groups = $this->Postcommentfiles->Groups->find('list', ['limit' => 200]);
        $users = $this->Postcommentfiles->Users->find('list', ['limit' => 200]);
        $this->set(compact('postcommentfile', 'posts', 'comments', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Postcommentfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postcommentfile = $this->Postcommentfiles->get($id);
        if ($this->Postcommentfiles->delete($postcommentfile)) {
            $this->Flash->success(__('The postcommentfile has been deleted.'));
        } else {
            $this->Flash->error(__('The postcommentfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
