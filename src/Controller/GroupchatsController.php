<?php

namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;
use App\Model\Entity\Groupchat;

/**
 * Groupchats Controller
 *
 * @property \App\Model\Table\GroupchatsTable $Groupchats
 *
 * @method \App\Model\Entity\Groupchat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupchatsController extends AppController
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
        $groupchats = $this->paginate($this->Groupchats);

        $this->set(compact('groupchats'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Groupchat id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupchat = $this->Groupchats->get($id, [
            'contain' => ['Groups', 'Users']
        ]);

        $this->set('groupchat', $groupchat);
    }

    public function groupChat($groupid = null)
    {
        $this->loadModel('User');
        $this->loadModel('Chats');
        $this->loadModel('Chatcontacts');
        $this->loadModel('CompaniesUser');
        $this->loadModel('Chatgroups');
        $this->loadModel('Chatfiles');
        $this->loadModel('Chatgroupsusers');
        $user_id = $this->Auth->user('id');

        $allcontactData = $this->Chats->find('all', [
            'Chats.isDeleted' => false
        ])->order(['creation_date' => 'ASC'])->contain([
            'Replies',
            'Replies.chatfiles',
            'Replies.ToUser',
            'Replies.FromUser',
            'ToUser',
            'Chatfiles',
            'FromUser'
        ])->toArray();

        $chatgroup =  $this->Chatgroups->find('all', [
            'conditions' => [
                'id in' => $groupid
            ]
        ])->contain(['Chatgroupsusers.Users'])->order(['creation_date' => 'ASC'])->first();
        $lastchat = $this->Chats->find('all',[
            'conditions' => [
                'fromuser_id' => $user_id,
            ]
        ])->order(['creation_date' => 'DESC'])->first();
        if (!empty($lastchat)) {
            $touser = $lastchat->touser_id;
        } else {
            $contacts = $this->Chatcontacts->find('all', [
                'conditions' => [
                    'Chatcontacts.isDeleted' => false,
                    'fromuser_id' => $user_id
                ]
            ])->order(['creation_date' => 'DESC'])->first();

            if (!empty($contacts)) {
                $touser = $contacts->touser_id;
            } else {
                $touser = null;
            }
        }
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $userData = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User','Designations'])->toArray();
        $contacts = $this->Chatcontacts->find('all', [
            'conditions' => [
                'Chatcontacts.isDeleted' => false,
                'Chatcontacts.fromuser_id' => $user_id
            ]
        ])->order(['creation_date' => 'ASC'])->contain(['ToUser', 'FromUser'])->toArray();

        $this->loadModel('Chatgroupsusers');
        $authusergroups =  $this->Chatgroupsusers->find('all',[
            'conditions' => [
                'user_id' =>  $user_id
            ]
        ])->toArray();


        if (!empty($authusergroups)) {
            $authusergids = array();
            foreach ($authusergroups as $group) {
                array_push($authusergids, $group->group_id);
            }
            $allgroups = $this->Chatgroups->find('all', [
                'conditions' => [
                    'id in' =>  $authusergids
                ]
            ])->order(['creation_date' => 'ASC'])->contain(['Chatgroupsusers.Users'])->toArray();
        }else{
            $allgroups = null;
        }
        $allchatfiles = $this->Chatfiles->find('all',[
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->contain(['User'])->toArray();
        $mychatfiles = $this->Chatfiles->find('all',[
            'conditions' => [
                'user_id' => $user_id
            ]
        ])->contain(['Touser'])->toArray();
        $groupchatData = $this->Groupchats->find('all', [
            'conditions' => [
                'Groupchats.group_id' => $groupid,
                'Groupchats.isDeleted' => false
            ]
        ])->contain([
            'Chatgroups.Chatgroupsusers.Users',
            'Groupchatfiles',
            'Users'
        ])->toArray();

        $allgroupchatData = $this->Groupchats->find('all',[
            'conditions' => [
                'Groupchats.isDeleted' => false
            ]
        ])->contain([
            'Chatgroups.Chatgroupsusers.Users',
            'Groupchatfiles',
            'Users'
        ])->toArray();
        $len = count($groupchatData);
        if ($len > 0) {
            foreach ($groupchatData as $chat) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                preg_match_all($test_patt, $chat->content, $valid);
                preg_match_all("/#(\\w+)/", $chat->content, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($userData as $data) {
                            if ($email == $data->email) {
                                $chat->content = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $chat->content);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($chat->content, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/chats/hashtags/$str";
                    $chat->content = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $chat->content);
                }
                $chat->creation_date = $chat->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                if ($chat->replies) {
                    foreach ($chat->replies as $reply) {
                        if ($reply->creation_date != null) {
                            $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        }
                        if ($reply->last_update != null) {
                            $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        }
                    }
                }
                if ($chat->last_update != null) {
                    $chat->last_update = $chat->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                }
            }
            $mygroupusers = null;

        } else {
            $mygroupusers = $this->Chatgroupsusers->find('all')->contain(['Chatgroups.Chatgroupsusers.Users', 'Users'])->toArray();
            foreach ($mygroupusers as $chat) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $chat->content, $valid);
                preg_match_all("/#(\\w+)/", $chat->content, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($userData as $data) {
                            if ($email == $data->email) {
                                $chat->content = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $chat->content);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($chat->content, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/chats/hashtags/$str";
                    $chat->content = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $chat->content);
                }
                if ($chat->creation_date != null) {
                    $chat->creation_date = $chat->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                }
                if ($chat->replies) {
                    foreach ($chat->replies as $reply) {
                        $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        if ($reply->last_update != null) {
                            $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                        }
                    }
                }
                if ($chat->last_update != null) {
                    $chat->last_update = $chat->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                }
            }
        }
        $this->set(compact('allgroupchatData','allcontactData','chatgroup','groupchatData','mygroupusers','mychatfiles','allchatfiles','groupid','contacts','companymembers','authuser','allgroups'));
    }

    public function groupmessages()
    {
        $this->loadModel('User');
        $userData = $this->User->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $msg = $this->request->getData('msg');
        $gid = $this->request->getData('gid');
        $replay = $this->request->getData('replay');
        $isFileNotAttached = $this->request->getData('isFileNotAttached');
       if($replay == 1){
        $cid = $this->request->getData('cid');
       }
        if($isFileNotAttached == 0) {
            $files = $this->request->getData()['file'];
        }
        $groupchats = $this->Groupchats->newEntity();
        if($replay ==1){
             $groupchats->parentgroupchat_id = $cid;
         }
        $groupchats->user_id = $user_id;
        $groupchats->group_id = $gid;
       //$groupchats->chatgroup_id = $gid;
        $groupchats->content = $msg;
        $groupchats->creation_date = Time::now();
        $this->Groupchats->save($groupchats);
        $this->loadModel('Groupchatfiles');
        if($isFileNotAttached == 0) {
            foreach ($files as $file) {
                $groupchatfiles = $this->Groupchatfiles->newEntity();
                $groupchatfiles->user_id = $user_id;
                $groupchatfiles->groupchat_id = $groupchats->id;
                $groupchatfiles->group_id = $gid;
                $groupchatfiles->filename = $file['name'];
                $groupchatfiles->type = $file['type'];
                $groupchatfiles->size = $file['size'];
                $groupchatfiles->creation_date = Time::now();
                $groupchatfiles->filepath = "assets/groupchatfiles/" .  $user_id. $groupchats->id;
                $destinationFolder = WWW_ROOT . "assets/groupchatfiles/" .  $user_id. $groupchats->id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Groupchatfiles->save($groupchatfiles);
            }
        }
        $mygroupchat = $this->Groupchats->find('all', [
            'conditions' => [
                'Groupchats.group_id' => $gid
            ]
        ])->order(['Groupchats.creation_date' => 'ASC'])->contain([
            'Chatgroups.Chatgroupsusers.Users',
            'Groupchatfiles',
            'Replies',
            'Replies.Groupchatfiles',
            'Replies.Chatgroups.Chatgroupsusers.Users',
            'Users'
        ])->toArray();

        foreach ($mygroupchat as $chat) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            preg_match_all($test_patt, $chat->content, $valid);
            preg_match_all("/#(\\w+)/", $chat->content, $tags);
            if (!empty($valid)) {
                foreach ($valid[0] as $email) {
                    foreach ($userData as $data) {
                        if ($email == $data->email) {
                            $chat->content = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $chat->content);
                        }
                    }
                }
            }

            foreach ($tags[0] as $hashtag) {
                $pos = strpos($chat->content, $hashtag);
                $str = ltrim($hashtag, '#');
                $link = "/chats/hashtags/$str";
                $chat->content = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $chat->content);
            }
            $chat->creation_date = $chat->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            if ($chat->replies) {
                foreach ($chat->replies as $reply) {
                    $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    if ($reply->last_update != null) {
                        $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    }
                }
            }
            if ($chat->last_update != null) {
                $chat->last_update = $chat->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            }
        }

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($mygroupchat));
    }

    function deletegroupchatData(){

        $this->loadModel('User');
        $userData = $this->User->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $gid = $this->request->getData('gid');
       $groupchatid =  $this->request->getData('groupchatid');
       $deletegroupchat =  $this->Groupchats->find('all',[
            'conditions' => [
                'id in' => $groupchatid,
                'group_id' => $gid
            ]
        ])->first();
        $this->Groupchats->delete($deletegroupchat);


        $mygroupchat = $this->Groupchats->find('all', [
            'conditions' => [
                'Groupchats.group_id' => $gid
            ]
        ])->order(['Groupchats.creation_date' => 'ASC'])->contain([
            'Chatgroups.Chatgroupsusers.Users',
            'Groupchatfiles',
            'Users'
        ])->toArray();



        foreach ($mygroupchat as $chat) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            preg_match_all($test_patt, $chat->content, $valid);
            preg_match_all("/#(\\w+)/", $chat->content, $tags);


            if (!empty($valid)) {
                foreach ($valid[0] as $email) {


                    foreach ($userData as $data) {

                        if ($email == $data->email) {

                            $chat->content = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $chat->content);


                        }
                    }
                }
            }

            foreach ($tags[0] as $hashtag) {

                $pos = strpos($chat->content, $hashtag);
                $str = ltrim($hashtag, '#');
                $link = "/chats/hashtags/$str";
                $chat->content = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $chat->content);
            }

            $chat->creation_date = $chat->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            if ($chat->replies) {
                foreach ($chat->replies as $reply) {
                    $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    if ($reply->last_update != null) {
                        $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    }
                }
            }
            if ($chat->last_update != null) {
                $chat->last_update = $chat->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            }
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($mygroupchat));
    }

    function updategroupChat(){
        $this->loadModel('User');

        $userData = $this->User->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();

        $groupchatid = $this->request->getData('groupchatid');
        $gid = $this->request->getData('group_id');
        $content = $this->request->getData('content');

       $updategroupchat =  $this->Groupchats->find('all',[
            'conditions' => [
                'id in' => $groupchatid,
                'group_id' => $gid,
            ]
        ])->first();
        $updategroupchat->content = $content;
        $updategroupchat->last_update = Time::now();
        $this->Groupchats->save($updategroupchat);

        $mygroupchat = $this->Groupchats->find('all', [
            'conditions' => [
                'Groupchats.group_id' => $gid
            ]
        ])->contain([
            'Chatgroups.Chatgroupsusers.Users',
            'Groupchatfiles',
            'Users'
        ])->toArray();


        foreach ($mygroupchat as $chat) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            preg_match_all($test_patt, $chat->content, $valid);
            preg_match_all("/#(\\w+)/", $chat->content, $tags);


            if (!empty($valid)) {
                foreach ($valid[0] as $email) {


                    foreach ($userData as $data) {

                        if ($email == $data->email) {

                            $chat->content = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $chat->content);


                        }
                    }
                }
            }

            foreach ($tags[0] as $hashtag) {

                $pos = strpos($chat->content, $hashtag);
                $str = ltrim($hashtag, '#');
                $link = "/chats/hashtags/$str";
                $chat->content = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $chat->content);
            }

            $chat->creation_date = $chat->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            if ($chat->replies) {
                foreach ($chat->replies as $reply) {
                    $reply->creation_date = $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    if ($reply->last_update != null) {
                        $reply->last_update = $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    }
                }
            }
            if ($chat->last_update != null) {
                $chat->last_update = $chat->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            }
        }


        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($mygroupchat));


    }

    //groupdata





    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupchat = $this->Groupchats->newEntity();
        if ($this->request->is('post')) {
            $groupchat = $this->Groupchats->patchEntity($groupchat, $this->request->getData());
            if ($this->Groupchats->save($groupchat)) {
                $this->Flash->success(__('The groupchat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupchat could not be saved. Please, try again.'));
        }
        $groups = $this->Groupchats->Groups->find('list', ['limit' => 200]);
        $users = $this->Groupchats->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupchat', 'groups', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupchat id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupchat = $this->Groupchats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupchat = $this->Groupchats->patchEntity($groupchat, $this->request->getData());
            if ($this->Groupchats->save($groupchat)) {
                $this->Flash->success(__('The groupchat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupchat could not be saved. Please, try again.'));
        }
        $groups = $this->Groupchats->Groups->find('list', ['limit' => 200]);
        $users = $this->Groupchats->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupchat', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupchat id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupchat = $this->Groupchats->get($id);
        if ($this->Groupchats->delete($groupchat)) {
            $this->Flash->success(__('The groupchat has been deleted.'));
        } else {
            $this->Flash->error(__('The groupchat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deletechat(){

        $chatid = $this->request->getData('chatid');


       $deletechat = $this->Groupchats->find('all',[
            'conditions' => [
                'id in' => $chatid
            ]
        ])->first();

        $deletechat->isDeleted = true;
        $this->Groupchats->save($deletechat);

        return $this->redirect(['action' => 'groupChat', $deletechat->group_id]);

    }

    public function updatelastseen(){
        $group_id = $this->request->getData('group_id');

        $groupchats = $this->Groupchats->find('all',[
            'conditions' => [
                'group_id' => $group_id,
                'isSeen' => false
            ]

        ])->toArray();
        if (!empty($groupchats)) {
            foreach ($groupchats as $groupchat) {
                $groupchat->isSeen = true;
                $this->Groupchats->save($groupchat);
            }
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($groupchats));
    }
}
