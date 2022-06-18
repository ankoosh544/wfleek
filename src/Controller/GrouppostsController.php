<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;

/**
 * Groupposts Controller
 *
 * @property \App\Model\Table\GrouppostsTable $Groupposts
 *
 * @method \App\Model\Entity\Grouppost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GrouppostsController extends AppController
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
        $groupposts = $this->paginate($this->Groupposts);

        $this->set(compact('groupposts'));
    }

    /**
     * View method
     *
     * @param string|null $id Grouppost id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grouppost = $this->Groupposts->get($id, [
            'contain' => ['Groups', 'Users']
        ]);

        $this->set('grouppost', $grouppost);
    }
    public function isAuthorized()
    {
        return true;
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($groupid = null)
    {
        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $user_id = $this->Auth->user('id');

        $msg = $this->request->getData('post_message');

        $tagedusers = $this->request->getData('tagedusers');


        $files = $this->request->getData()['images'];



            $grouppost = $this->Groupposts->newEntity();
            $grouppost->group_id = intval($groupid);
            $grouppost->user_id = $user_id;

            if (!empty($msg) && strlen($msg) < 255) {
                $grouppost->post_data = $msg;
            }else{
                $grouppost->isNote = true;
                $grouppost->post_data = null;

            }
            $grouppost = $this->Groupposts->save($grouppost);

            if (strlen($msg) > 255) {
                $this->loadModel('Groupnotes');
                $groupnote = $this->Groupnotes->newEntity();
                $groupnote->post_id = $grouppost->id;
                $groupnote->group_id = intval($groupid);
                $groupnote->post_data = $msg;
                $this->Groupnotes->save($groupnote);
            }

        if(!empty($tagedusers)){
            foreach($tagedusers as $user){
            $this->loadModel('Groupposttagmembers');
            $tagmember = $this->Groupposttagmembers->newEntity();
            $tagmember->group_id = $groupid;
            $tagmember->post_id = $grouppost->id;
            $tagmember->user_id = $user;
            $tagmember->isPost = true;
            $this->Groupposttagmembers->save($tagmember);
            }
        }
        //save file

        if (!empty($files)) {
            foreach ($files as $file) {
                if (!empty($file['tmp_name'])) {
                    $postfile = $this->Grouppostfiles->newEntity();
                    $postfile->user_id = $user_id;
                    $postfile->group_id = $groupid;
                    $postfile->grouppost_id = $grouppost->id;
                    $postfile->filename = $file['name'];
                    $postfile->size = $file['size'];
                    $postfile->type = $file['type'];
                    $postfile->filepath = "assets/grouppostfiles/" .  $grouppost->id;
                    $destinationFolder = WWW_ROOT . "assets" . DS . "grouppostfiles" . DS .  $grouppost->id;
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }
                    move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                    $this->Grouppostfiles->save($postfile);
                }
            }
        }
        if (!empty($msg) && strlen($msg) < 255) {
            return $this->redirect(['controller' => 'groups', 'action' => 'view', $groupid]);
        } else {
            return $this->redirect(['controller' => 'groups', 'action' => 'notes', $groupid]);
        }
    }


    public function updatepost(){

        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $user_id = $this->Auth->user('id');
        $post_id = $this->request->getData('postid');
        $msg = $this->request->getData('editpost_message');
        $isFileNotAttached = $this->request->getData('isFileNotAttached');
        if($isFileNotAttached == '0')
        {
        $files = $this->request->getData()['file'];
        }
        $editablepost = $this->Groupposts->find('all',[
            'conditions' => [
                'id in' => $post_id
            ]
        ])->first();
        $editablepost->post_data = $msg;
        $editablepost->last_update = Time::now();
        $this->Groupposts->save($editablepost);
        if (!empty($files)) {
            foreach ($files as $file) {
                $postfile = $this->Grouppostfiles->newEntity();
                $postfile->group_id = $editablepost->group_id;
                $postfile->grouppost_id = $editablepost->id;
                $postfile->user_id = $this->Auth->user('id');
                $postfile->filename = $file['name'];
                $postfile->filepath = "assets/grouppostfiles/" .  $editablepost->id;
                $destinationFolder = WWW_ROOT . "assets" . DS . "grouppostfiles" . DS .  $editablepost->id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Grouppostfiles->save($postfile);
            }
        }else{
            $postfile = 'No file';
        }


        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($postfile));

    }
    /**
     * Edit method
     *
     * @param string|null $id Grouppost id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grouppost = $this->Groupposts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grouppost = $this->Groupposts->patchEntity($grouppost, $this->request->getData());
            if ($this->Groupposts->save($grouppost)) {
                $this->Flash->success(__('The grouppost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossibile salvare il gruppo. Per favore riprova.'));
        }
        $groups = $this->Groupposts->Groups->find('list', ['limit' => 200]);
        $users = $this->Groupposts->Users->find('list', ['limit' => 200]);
        $this->set(compact('grouppost', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grouppost id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grouppost = $this->Groupposts->get($id);
        if ($this->Groupposts->delete($grouppost)) {
            $this->Flash->success(__('The grouppost has been deleted.'));
        } else {
            $this->Flash->error(__('Impossibile salvare il gruppo. Per favore riprova.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function deletepost($postid = null){


        $postrecord = $this->Groupposts->find('all',[
            'conditions' => [
                'id in' => $postid
            ]
        ])->first();
       $groupid = $postrecord->group_id;

       $postrecord->isDeleted = true;

       $this->Groupposts->save($postrecord);

       return $this->redirect(['controller' => 'groups','action' => 'view', $groupid]);


    }
    public function updatelikes(){

        $this->loadModel('Postlikes');
        $this->loadModel('Favoriteposts');
        $postid = $this->request->getData('postid');
        $userid = $this->request->getData('userid');
        $post = $this->Groupposts->find('all',[
            'conditions' => [
                'id in' => $postid
            ]
        ])->first();


        $postlike = $this->Postlikes->find('all', [
            'conditions' => [
                'post_id' => $postid,
                'user_id in' => $userid
            ]
        ])->first();


        $groupid = $post->group_id;
        if (!empty($postlike)) {

            if ($postlike->isLiked == true) {
                $postlike->isLiked = false;
                $postlike->isDeleted = true;
                $this->Postlikes->save($postlike);

            } else {
                $postlike->isLiked = true;
                $postlike->isDeleted = false;
                $this->Postlikes->save($postlike);

            }
        } else {
            $postlike = $this->Postlikes->newEntity();
            $postlike->group_id = $groupid;
            $postlike->post_id = $postid;
            $postlike->user_id = $userid;
            $this->Postlikes->save($postlike);


        }


        $post = $this->Groupposts->find('all', [
            'conditions' => [
                'id in' => $postid,
            ]
        ])->contain([
            'Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Postlikes.Users'
            ])->first();

            $likes =  $this->Postlikes->find('all',[
                'conditions' => [
                    'user_id in' => $userid,
                        'post_id' => $postid,

                ]
            ])->contain(['Users'])->first();
      //  $result = array($post,$likes);



       $result = array('likes' => $likes,
       'post' => $post);

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($result));



    }


    public function addfavourite(){

        $this->loadModel('Favoriteposts');
        $postid = $this->request->getData('postid');
        $userid = $this->request->getData('userid');

        $favouritepost = $this->Favoriteposts->find('all',[
            'conditions' => [
                'post_id' => $postid,
                'user_id' => $userid
            ]
        ])->first();

        if(!empty($favouritepost)){
            $this->Favoriteposts->delete($favouritepost);

        }else{
            $favourite = $this->Favoriteposts->newEntity();
            $favourite->post_id = $postid;
            $favourite->user_id = $userid;
            $this->Favoriteposts->save($favourite);

        }

        $favourite = $this->Favoriteposts->find('all',[
            'conditions' => [
                'post_id' => $postid,
                'user_id' => $userid
            ]
        ])->first();

        if(!empty($favourite)){
            $result = array('favourite' => $favourite,
        'message' => 'Success');
        }else{
            $result = array('favourite' => null,
            'message' => 'Error');
        }

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($result));


    }
}
