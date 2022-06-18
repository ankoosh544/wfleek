<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Favoriteposts Controller
 *
 * @property \App\Model\Table\FavoritepostsTable $Favoriteposts
 *
 * @method \App\Model\Entity\Favoritepost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FavoritepostsController extends AppController
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
        $favoriteposts = $this->paginate($this->Favoriteposts);

        $this->set(compact('favoriteposts'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Favoritepost id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $myfavoriteposts = $this->Favoriteposts->find('all', [
            'conditions' => [
                'Favoriteposts.user_id' => $user_id
            ]
        ])->contain([
            'Posts.Groupnotes',
            'Posts.Users',
            'Posts.Postcomments.Postcommentlikes',
            'Posts.Postlikes',
            'Posts.Groupposttagmembers.Users',
            'Posts.Groupposttagmembers',
            'Posts.Postcomments.Users',
            'Posts.Postcomments.Postcommentlikes',
            'Posts.Postcomments.Postcommentlikes.Users',
            'Posts.Postcomments.Postcommentfiles',
            'Posts.Postcomments.Replies.Replytagmembers',
            'Posts.Postcomments.Replies.Replyfiles',
            'Posts.Postcomments.Replies.Replylikes',
            'Posts.Postcomments.Replies.Users',
        ])->toArray();

      //debug($myfavoriteposts);exit;

        $this->set(compact('myfavoriteposts', 'authuser'));


    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $favoritepost = $this->Favoriteposts->newEntity();
        if ($this->request->is('post')) {
            $favoritepost = $this->Favoriteposts->patchEntity($favoritepost, $this->request->getData());
            if ($this->Favoriteposts->save($favoritepost)) {
                $this->Flash->success(__('The favoritepost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The favoritepost could not be saved. Please, try again.'));
        }
        $users = $this->Favoriteposts->Users->find('list', ['limit' => 200]);
        $this->set(compact('favoritepost', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Favoritepost id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $favoritepost = $this->Favoriteposts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $favoritepost = $this->Favoriteposts->patchEntity($favoritepost, $this->request->getData());
            if ($this->Favoriteposts->save($favoritepost)) {
                $this->Flash->success(__('The favoritepost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The favoritepost could not be saved. Please, try again.'));
        }
        $users = $this->Favoriteposts->Users->find('list', ['limit' => 200]);
        $this->set(compact('favoritepost', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Favoritepost id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $favoritepost = $this->Favoriteposts->get($id);
        if ($this->Favoriteposts->delete($favoritepost)) {
            $this->Flash->success(__('The favoritepost has been deleted.'));
        } else {
            $this->Flash->error(__('The favoritepost could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
