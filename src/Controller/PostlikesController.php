<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Postlikes Controller
 *
 * @property \App\Model\Table\PostlikesTable $Postlikes
 *
 * @method \App\Model\Entity\Postlike[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostlikesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Posts', 'Users']
        ];
        $postlikes = $this->paginate($this->Postlikes);

        $this->set(compact('postlikes'));
    }

    /**
     * View method
     *
     * @param string|null $id Postlike id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postlike = $this->Postlikes->get($id, [
            'contain' => ['Posts', 'Users']
        ]);

        $this->set('postlike', $postlike);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postlike = $this->Postlikes->newEntity();
        if ($this->request->is('post')) {
            $postlike = $this->Postlikes->patchEntity($postlike, $this->request->getData());
            if ($this->Postlikes->save($postlike)) {
                $this->Flash->success(__('The postlike has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postlike could not be saved. Please, try again.'));
        }
        $posts = $this->Postlikes->Posts->find('list', ['limit' => 200]);
        $users = $this->Postlikes->Users->find('list', ['limit' => 200]);
        $this->set(compact('postlike', 'posts', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Postlike id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postlike = $this->Postlikes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postlike = $this->Postlikes->patchEntity($postlike, $this->request->getData());
            if ($this->Postlikes->save($postlike)) {
                $this->Flash->success(__('The postlike has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postlike could not be saved. Please, try again.'));
        }
        $posts = $this->Postlikes->Posts->find('list', ['limit' => 200]);
        $users = $this->Postlikes->Users->find('list', ['limit' => 200]);
        $this->set(compact('postlike', 'posts', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Postlike id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postlike = $this->Postlikes->get($id);
        if ($this->Postlikes->delete($postlike)) {
            $this->Flash->success(__('The postlike has been deleted.'));
        } else {
            $this->Flash->error(__('The postlike could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
