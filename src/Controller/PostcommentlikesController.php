<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Postcommentlikes Controller
 *
 * @property \App\Model\Table\PostcommentlikesTable $Postcommentlikes
 *
 * @method \App\Model\Entity\Postcommentlike[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostcommentlikesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Comments', 'Replies', 'Groups', 'Users']
        ];
        $postcommentlikes = $this->paginate($this->Postcommentlikes);

        $this->set(compact('postcommentlikes'));
    }

    /**
     * View method
     *
     * @param string|null $id Postcommentlike id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postcommentlike = $this->Postcommentlikes->get($id, [
            'contain' => ['Comments', 'Replies', 'Groups', 'Users']
        ]);

        $this->set('postcommentlike', $postcommentlike);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postcommentlike = $this->Postcommentlikes->newEntity();
        if ($this->request->is('post')) {
            $postcommentlike = $this->Postcommentlikes->patchEntity($postcommentlike, $this->request->getData());
            if ($this->Postcommentlikes->save($postcommentlike)) {
                $this->Flash->success(__('The postcommentlike has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postcommentlike could not be saved. Please, try again.'));
        }
        $comments = $this->Postcommentlikes->Comments->find('list', ['limit' => 200]);
        $replies = $this->Postcommentlikes->Replies->find('list', ['limit' => 200]);
        $groups = $this->Postcommentlikes->Groups->find('list', ['limit' => 200]);
        $users = $this->Postcommentlikes->Users->find('list', ['limit' => 200]);
        $this->set(compact('postcommentlike', 'comments', 'replies', 'groups', 'users'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * Edit method
     *
     * @param string|null $id Postcommentlike id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postcommentlike = $this->Postcommentlikes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postcommentlike = $this->Postcommentlikes->patchEntity($postcommentlike, $this->request->getData());
            if ($this->Postcommentlikes->save($postcommentlike)) {
                $this->Flash->success(__('The postcommentlike has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postcommentlike could not be saved. Please, try again.'));
        }
        $comments = $this->Postcommentlikes->Comments->find('list', ['limit' => 200]);
        $replies = $this->Postcommentlikes->Replies->find('list', ['limit' => 200]);
        $groups = $this->Postcommentlikes->Groups->find('list', ['limit' => 200]);
        $users = $this->Postcommentlikes->Users->find('list', ['limit' => 200]);
        $this->set(compact('postcommentlike', 'comments', 'replies', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Postcommentlike id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postcommentlike = $this->Postcommentlikes->get($id);
        if ($this->Postcommentlikes->delete($postcommentlike)) {
            $this->Flash->success(__('The postcommentlike has been deleted.'));
        } else {
            $this->Flash->error(__('The postcommentlike could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function updatecommentlikes(){
        $this->loadModel('Groupposts');
        $this->loadModel('Postcomments');
        $user_id = $this->Auth->user('id');
        $commentid = $this->request->getData('commentid');
        $postid = $this->request->getData('postid');


        $post = $this->Groupposts->find('all',[
            'conditions' => [
                'id in' => $postid,

            ]
        ])->first();
        $commentlike = $this->Postcommentlikes->find('all', [
            'conditions' => [
                'comment_id in' => $commentid,
                'user_id in' => $user_id,
                'isReply' => false
            ]
        ])->first();



        if (!empty($commentlike)) {

                 if($commentlike->isLiked == true){
                    $commentlike->isLiked = false;
                    $commentlike->isDeleted = true;
                    $this->Postcommentlikes->save($commentlike);

                 }else{
                    $commentlike->isLiked = true;
                    $commentlike->isDeleted = false;
                    $this->Postcommentlikes->save($commentlike);
                 }


        } else {

            $commentlike = $this->Postcommentlikes->newEntity();
            $commentlike->comment_id = $commentid;
            $commentlike->group_id = $post->group_id;
            $commentlike->post_id = $postid;
            $commentlike->user_id = $user_id;
            $this->Postcommentlikes->save($commentlike);
        }
        $this->loadModel('Postcomments');

        $commentlikes =  $this->Postcomments->find('all',[
            'conditions' => [
                  'id in' => $commentid
            ]
        ])->contain(['postcommentlikes' => function ($q) {
            return $q->where([
                'isLiked' => true,
                'isReply' => false
            ]);
        },
        'postcommentlikes.Users'
        ])->first();
        $likecount =  $this->Postcommentlikes->find('all', [
            'conditions' => [
                'comment_id' => $commentid,
                'isLiked' => true,
                'isReply' => false
            ]
        ])->toArray();
        $total = count($likecount);

        $result = array(
            'commentlikes' => $commentlikes,
            'count' => $total
        );

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($result));

    }

    public function updatereplylikes(){

        $this->loadModel('Groupposts');
        $this->loadModel('Postcomments');
        $user_id = $this->Auth->user('id');
        $reply_id = $this->request->getData('reply_id');
        $postid = $this->request->getData('postid');


        $comment = $this->Postcomments->find('all',[
            'conditions' => [
                'id in' => $reply_id
            ]
        ])->first();





        $replylike = $this->Postcommentlikes->find('all', [
            'conditions' => [
                'reply_id in' => $reply_id,
                'user_id in' => $user_id
            ]
        ])->first();

        if (!empty($replylike)) {

                 if($replylike->isLiked == true){
                    $replylike->isLiked = false;
                    $replylike->isDeleted = true;
                    $replylike->isReply = true;
                    $this->Postcommentlikes->save($replylike);

                 }else{
                    $replylike->isLiked = true;
                    $replylike->isReply = true;
                    $replylike->isDeleted = false;
                    $this->Postcommentlikes->save($replylike);
                 }


        } else {

            $replylike = $this->Postcommentlikes->newEntity();
            $replylike->reply_id = $reply_id;
            $replylike->comment_id =$comment->parent_id;
            $replylike->group_id = $comment->group_id;
            $replylike->post_id = $postid;
            $replylike->user_id = $user_id;
            $replylike->isReply = true;
            $this->Postcommentlikes->save($replylike);
        }

        $replylikes =  $this->Postcomments->find('all',[
            'conditions' => [

                  'id in' => $reply_id
            ]
        ])->contain(['Replylikes' => function ($q) {
            return $q->where([
                'isLiked' => true
            ]);
        },
        'Replylikes.Users'
        ])->first();

        $likecount =  $this->Postcommentlikes->find('all', [
            'conditions' => [
                'reply_id' => $reply_id,
                'isLiked' => true
            ]
        ])->toArray();
        $total = count($likecount);

        $result = array(
            'replylikes' => $replylikes,
            'count' => $total
        );


        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($result));

    }
}
