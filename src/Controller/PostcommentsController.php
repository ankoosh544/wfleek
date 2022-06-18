<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Postcomments Controller
 *
 * @property \App\Model\Table\PostcommentsTable $Postcomments
 *
 * @method \App\Model\Entity\Postcomment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostcommentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentPostcomments', 'Groups', 'Posts', 'Users']
        ];
        $postcomments = $this->paginate($this->Postcomments);

        $this->set(compact('postcomments'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Postcomment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postcomment = $this->Postcomments->get($id, [
            'contain' => ['ParentPostcomments', 'Groups', 'Posts', 'Users', 'ChildPostcomments']
        ]);

        $this->set('postcomment', $postcomment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postcomment = $this->Postcomments->newEntity();
        if ($this->request->is('post')) {
            $postcomment = $this->Postcomments->patchEntity($postcomment, $this->request->getData());
            if ($this->Postcomments->save($postcomment)) {
                $this->Flash->success(__('The postcomment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postcomment could not be saved. Please, try again.'));
        }
        $parentPostcomments = $this->Postcomments->ParentPostcomments->find('list', ['limit' => 200]);
        $groups = $this->Postcomments->Groups->find('list', ['limit' => 200]);
        $posts = $this->Postcomments->Posts->find('list', ['limit' => 200]);
        $users = $this->Postcomments->Users->find('list', ['limit' => 200]);
        $this->set(compact('postcomment', 'parentPostcomments', 'groups', 'posts', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Postcomment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postcomment = $this->Postcomments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postcomment = $this->Postcomments->patchEntity($postcomment, $this->request->getData());
            if ($this->Postcomments->save($postcomment)) {
                $this->Flash->success(__('The postcomment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The postcomment could not be saved. Please, try again.'));
        }
        $parentPostcomments = $this->Postcomments->ParentPostcomments->find('list', ['limit' => 200]);
        $groups = $this->Postcomments->Groups->find('list', ['limit' => 200]);
        $posts = $this->Postcomments->Posts->find('list', ['limit' => 200]);
        $users = $this->Postcomments->Users->find('list', ['limit' => 200]);
        $this->set(compact('postcomment', 'parentPostcomments', 'groups', 'posts', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Postcomment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postcomment = $this->Postcomments->get($id);
        if ($this->Postcomments->delete($postcomment)) {
            $this->Flash->success(__('The postcomment has been deleted.'));
        } else {
            $this->Flash->error(__('The postcomment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }




    public function sendcomment()
    {
        $this->loadModel('User');
        $this->loadModel('Groupposts');
        $user_id = $this->Auth->user('id');
        $msg = $this->request->getData('msg');
        $postid = $this->request->getData('postid');
        $files = $this->request->getData('file');
        $commentid = $this->request->getData("commentid");
        $isFileNotAttached = $this->request->getData('isFileNotAttached');

        $tagusers = json_decode($_POST['values']);


        $post = $this->Groupposts->find('all', [
            'conditions' => [
                'id in' => $postid
            ]
        ])->first();
        $postcomment = $this->Postcomments->newEntity();
        $postcomment->group_id = $post->group_id;
        $postcomment->post_id = $postid;

        if($commentid != null){
            $postcomment->parent_id = $commentid;
        }
        $postcomment->user_id =  $user_id;
        $postcomment->comment_data = $msg;
      $resultpostcomment = $this->Postcomments->save($postcomment);




       //add tagged members
       if(!empty($tagusers)){
       foreach($tagusers as $user){
            $this->loadModel('Groupposttagmembers');
            $tagmember = $this->Groupposttagmembers->newEntity();
            $tagmember->group_id =  $postcomment->group_id;
            if($commentid != null){
                $tagmember->reply_id = $resultpostcomment->id;
                $tagmember->comment_id = $resultpostcomment->parent_id;
                $tagmember->isReply = true;
            }else{
                $tagmember->comment_id =$resultpostcomment->id;
                $tagmember->isComment = true;
            }
            $tagmember->post_id = $postcomment->post_id;
            $tagmember->user_id = $user;
            $this->Groupposttagmembers->save($tagmember);
            }

       }
        //  debug($postcomment->id);exit;
        if ($isFileNotAttached == 0) {
            foreach ($files as $file) {

                    $this->loadModel('Postcommentfiles');

                    $commentfile = $this->Postcommentfiles->newEntity();
                    $commentfile->post_id = $postid;

                    if($commentid != null){
                        $commentfile->reply_id = $resultpostcomment->id;
                        $commentfile->comment_id = $resultpostcomment->parent_id;
                    }else{
                        $commentfile->comment_id =$resultpostcomment->id;
                    }
                    $commentfile->group_id = $postcomment->group_id;
                    $commentfile->user_id = $this->Auth->user('id');
                    $commentfile->filename = $file['name'];
                    $commentfile->filepath = "assets/postcommentfiles/" .  $postcomment->id;
                    $destinationFolder = WWW_ROOT . "assets" . DS . "postcommentfiles" . DS .  $postcomment->id;
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                    $this->Postcommentfiles->save($commentfile);

            }
        }
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();

        $allpostcomments = $this->Postcomments->find('all', [
            'conditions' => [
                'Postcomments.group_id' => $post->group_id,
                'post_id' => $postid,
                'parent_id is' => null,
                'Postcomments.isDeleted' => false
            ]
        ])->contain(['Users',
        'Groups',
        'Posts',
        'Replies.Replytagmembers.Users',
        'Replies.Users',
        'Replies.Replyfiles',
        'Replies.Replylikes',
        'Postcommentfiles',
        'Postcommentlikes' => function ($q) {
            return $q->where([
                'isReply' => false,
                'isLiked' => true
            ]);
        },
        'Postcommentlikes.Users',
        'Groupposttagmembers.Users'])->toArray();
        foreach ($allpostcomments as $comment) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            preg_match_all($test_patt, $comment->comment_data, $valid);
            preg_match_all("/#(\\w+)/", $comment->comment_data, $tags);
            if (!empty($valid)) {
                foreach ($valid[0] as $email) {
                    foreach ($allusers as $data) {
                        if ($email == $data->email) {
                            $comment->comment_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $comment->comment_data);
                        }
                    }
                }
            }
            foreach ($tags[0] as $hashtag) {
                $pos = strpos($comment->comment_data, $hashtag);
                $str = ltrim($hashtag, '#');
                $link = "/groups/grouphashtags?groupid=" . $comment->group_id . "&tag=" . $str;
                $comment->comment_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $comment->comment_data);
            }
            //change datetime format

            $comment->creation_date = $comment->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome');

            if ($comment->replies) {
                foreach ($comment->replies as $reply) {

                    $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                    //comapare using preg_match_all() method
                    preg_match_all($test_patt, $reply->comment_data, $valid);
                    preg_match_all("/#(\\w+)/", $reply->comment_data, $tags);
                    if (!empty($valid)) {
                        foreach ($valid[0] as $email) {
                            foreach ($allusers as $data) {
                                if ($email == $data->email) {
                                    $reply->comment_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $reply->comment_data);
                                }
                            }
                        }
                    }
                    foreach ($tags[0] as $hashtag) {
                        $pos = strpos($reply->comment_data, $hashtag);
                        $str = ltrim($hashtag, '#');
                        $link = "/groups/grouphashtags?groupid=" . $reply->group_id . "&tag=" . $str;
                        $reply->comment_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $reply->comment_data);
                    }
                    $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome');
                }
            }
        }
       $this->autoRender = false;
       return $this->response->withType('application/json')->withStringBody(json_encode($allpostcomments));

    }

    public function updatecomment(){
        $this->loadModel('User');
        $this->loadModel('Postcommentfiles');
        $user_id = $this->Auth->user('id');
        $comment_id = $this->request->getData('comment_id');
        $reply_id = $this->request->getData('reply_id');
        $msg = $this->request->getData('editcomment_message');
        $isFileNotAttached = $this->request->getData('isFileNotAttached');
        if($isFileNotAttached == '0')
        {
        $files = $this->request->getData()['file'];
        }



        if ($comment_id != null) {
            $editablecomment = $this->Postcomments->find('all', [
                'conditions' => [
                    'id in' => $comment_id
                ]
            ])->first();
        } else {
            $editablecomment = $this->Postcomments->find('all', [
                'conditions' => [
                    'id in' =>  $reply_id
                ]
            ])->first();
        }
        $editablecomment->comment_data = $msg;
        $this->Postcomments->save($editablecomment);
        if (!empty($files)) {
            foreach ($files as $file) {
                    $commentfile = $this->Postcommentfiles->newEntity();
                    $commentfile->post_id = $editablecomment->post_id;
                    $commentfile->comment_id =$editablecomment->id;
                    $commentfile->group_id = $editablecomment->group_id;
                    $commentfile->user_id = $this->Auth->user('id');
                    $commentfile->filename = $file['name'];
                    $commentfile->filepath = "assets/postcommentfiles/" .  $editablecomment->id;
                    $destinationFolder = WWW_ROOT . "assets" . DS . "postcommentfiles" . DS .  $editablecomment->id;
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                    $this->Postcommentfiles->save($commentfile);
            }
        }else{
            $postfile = 'No file';
        }
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();

        $allpostcomments = $this->Postcomments->find('all', [
            'conditions' => [
                'Postcomments.group_id' => $editablecomment->group_id,
                'post_id' => $editablecomment->post_id,
                'parent_id is' => null,
                'Postcomments.isDeleted' => false
            ]
        ])->contain(['Users',
        'Groups',
        'Posts',
        'Replies.Replytagmembers.Users',
        'Replies.Users',
        'Replies.Replyfiles',
        'Replies.Replylikes',
        'Postcommentfiles',
        'Postcommentlikes' => function ($q) {
            return $q->where([
                'isReply' => false,
                'isLiked' => true,
            ]);
        },
        'Postcommentlikes.Users',
        'Groupposttagmembers.Users'])->toArray();

        foreach ($allpostcomments as $comment) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            preg_match_all($test_patt, $comment->comment_data, $valid);
            preg_match_all("/#(\\w+)/", $comment->comment_data, $tags);
            if (!empty($valid)) {
                foreach ($valid[0] as $email) {
                    foreach ($allusers as $data) {
                        if ($email == $data->email) {
                            $comment->comment_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $comment->comment_data);
                        }
                    }
                }
            }
            foreach ($tags[0] as $hashtag) {
                $pos = strpos($comment->comment_data, $hashtag);
                $str = ltrim($hashtag, '#');
                $link = "/groups/grouphashtags?groupid=" . $comment->group_id . "&tag=" . $str;
                $comment->comment_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $comment->comment_data);
            }
            //change datetime format

            $comment->creation_date = $comment->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome');
            if ($comment->replies) {
                foreach ($comment->replies as $reply) {

                    $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                    //comapare using preg_match_all() method
                    preg_match_all($test_patt, $reply->comment_data, $valid);
                    preg_match_all("/#(\\w+)/", $reply->comment_data, $tags);
                    if (!empty($valid)) {
                        foreach ($valid[0] as $email) {
                            foreach ($allusers as $data) {
                                if ($email == $data->email) {
                                    $reply->comment_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $reply->comment_data);
                                }
                            }
                        }
                    }
                    foreach ($tags[0] as $hashtag) {
                        $pos = strpos($reply->comment_data, $hashtag);
                        $str = ltrim($hashtag, '#');
                        $link = "/groups/grouphashtags?groupid=" . $reply->group_id . "&tag=" . $str;
                        $reply->comment_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $reply->comment_data);
                    }
                    $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome');
                }
            }
        }
       $this->autoRender = false;
       return $this->response->withType('application/json')->withStringBody(json_encode($allpostcomments));
    }


    public function deletecomment($comment_id = null){

        $commentrecord = $this->Postcomments->find('all',[
            'conditions' => [
                'id in' => $comment_id
            ]
        ])->contain(['Replies'])->first();

       if(!empty($commentrecord->replies)){
           foreach($commentrecord->replies as $reply){
            $reply->isDeleted = true;
            $this->Postcomments->save($reply);
           }
       }
       $commentrecord->isDeleted = true;
       $this->Postcomments->save($commentrecord);

       return $this->redirect(['controller' => 'groups', 'action' => 'view',$commentrecord->group_id]);


    }
}
