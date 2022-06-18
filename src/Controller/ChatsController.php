<?php

namespace App\Controller;

use Cake\I18n\Time;

use App\Controller\AppController;
use App\Model\Entity\Chatgroup;
use phpDocumentor\Reflection\Types\Null_;

/**
 * Chats Controller
 *
 * @property \App\Model\Table\ChatsTable $Chats
 *
 * @method \App\Model\Entity\Chat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['User']
        ];
        $chats = $this->paginate($this->Chats);

        $this->set(compact('chats'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**chatsystem */
    public function chatsystem($touser = null)
    {
        $this->loadModel('Chatcontacts');
        $this->loadModel('CompaniesUser');
        $this->loadModel('Chatgroups');
        $this->loadModel('User');
        $this->loadModel('Chatfiles');
        $this->loadModel('Groupchats');

        $allgroupchatData = $this->Groupchats->find('all',[
            'conditions' => [
                'Groupchats.isDeleted' => false
            ]
        ])->contain([
            'Chatgroups.Chatgroupsusers.Users',
            'Groupchatfiles',
            'Users'
        ])->toArray();

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User'])->toArray();

        $contacts = $this->Chatcontacts->find('all', [
            'conditions' => [
                'Chatcontacts.isDeleted' => false,
                'Chatcontacts.fromuser_id' => $user_id
            ]
        ])->order(['creation_date' => 'ASC'])->contain(['ToUser', 'FromUser'])->toArray();

        $this->loadModel('Chatgroupsusers');
        $authusergroups =  $this->Chatgroupsusers->find('all', [
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
                    'id in' =>   $authusergids
                ]
            ])->order(['creation_date' => 'ASC'])->contain(['Chatgroupsusers.Users'])->toArray();


        } else {
            $allgroups = null;
        }
        $lastchat = $this->Chats->find('all', [
            'conditions' => [
                'fromuser_id' => $user_id,
            ]
        ])->order(['creation_date' => 'DESC'])->first();
        $allchatfiles = $this->Chatfiles->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->contain(['User'])->toArray();
        $mychatfiles = $this->Chatfiles->find('all', [
            'conditions' => [
                'user_id' => $user_id
            ]
        ])->contain(['Touser'])->toArray();

        if ($touser != null && $touser != $user_id) {
            $checkchats_tousers = $this->Chatcontacts->find('all', [
                'conditions' => [
                    'touser_id' => $touser,
                    'fromuser_id' => $user_id
                ]
            ])->first();
            if (empty($checkchats_tousers)) {
                $chatcontact = $this->Chatcontacts->newEntity();
                $chatcontact->touser_id = $touser;
                $chatcontact->fromuser_id = $user_id;
                $chatcontact->creation_date = Time::now();
                $this->Chatcontacts->save($chatcontact);
            }
            $totalchatstousers = $this->Chats->find('all', [
                'conditions' => [
                    'touser_id' => $user_id,

                ]
            ])->toArray();
            $mycontacts = $this->Chatcontacts->find('all', [
                'conditions' => [
                    'fromuser_id' => $user_id
                ]
            ])->toArray();
            $contact_touserIds = array();
            foreach ($mycontacts as $contact) {
                array_push($contact_touserIds, $contact->touser_id);
            }
            foreach ($totalchatstousers as $chat_touser) {
                if (!in_array($chat_touser->touser_id, $contact_touserIds)) {
                    $chatcontact = $this->Chatcontacts->newEntity();
                    $chatcontact->touser_id = $chat_touser->touser_id;
                    $chatcontact->fromuser_id = $user_id;
                    $chatcontact->creation_date = Time::now();
                    $this->Chatcontacts->save($chatcontact);
                }
            }


            $touserdata =  $this->User->find('all', [
                'conditions' => [
                    'id in' => $touser
                ]
            ])->first();
            $conditions = array();
            $conditions = array(
                'OR' => [
                    [
                        'AND' => [
                            ['fromuser_id' => $touser],
                            ['touser_id' => $user_id],
                        ]
                    ],
                    [
                        'AND' => [
                            ['fromuser_id ' => $user_id],
                            ['touser_id' => $touser]
                        ]
                    ],


                ]
            );

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

            $contactData = $this->Chats->find('all', [
                'conditions' => $conditions,
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
            $len =  count($contactData);
            if ($len > 0) {

                foreach ($contactData as $chat) {

                    $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                    //comapare using preg_match_all() method
                    preg_match_all($test_patt, $chat->content, $valid);
                    preg_match_all("/#(\\w+)/", $chat->content, $tags);
                    if (!empty($valid)) {
                        foreach ($valid[0] as $email) {
                            foreach ($authuser as $data) {
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
                    $chat->from_user->last_login = $chat->from_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    $chat->to_user->last_login = $chat->to_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');

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

                $chatcontacts = null;
            } else {


                $chatcontacts = $this->Chatcontacts->find('all', [
                    'conditions' => [
                        'Chatcontacts.touser_id' => $touser,
                        'Chatcontacts.fromuser_id' =>  $user_id
                    ]
                ])->contain([
                    'Chatfiles',
                    'ToUser',
                    'FromUser'
                ])->first();
                $this->set(compact('chatcontacts'));
            }
            $this->set(compact('allcontactData','allgroupchatData',  'mychatfiles', 'allchatfiles', 'touser', 'touserdata', 'chatcontacts', 'contactData', 'contacts', 'companymembers', 'authuser', 'allgroups'));
        } else {
            $allcontactData = null;
            $touserdata = null;
            $chatcontacts = null;
            $contactData = null;

            $this->set(compact('allcontactData','allgroupchatData',  'mychatfiles', 'allchatfiles', 'touser', 'touserdata', 'chatcontacts', 'contactData', 'contacts', 'companymembers', 'authuser', 'allgroups'));
        }
    }


    /**Postmessage */
    public function postmessages()
    {
        $this->loadModel('User');
        $userData = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $msg = $this->request->getData('msg');
        $touser = $this->request->getData('touserid');
        $isFileNotAttached = $this->request->getData('isFileNotAttached');
        $replay = $this->request->getData('replay');
        if ($replay == 1) {
            $cid = $this->request->getData('cid');
        }
        $chats = $this->Chats->newEntity();
        if ($replay == 1) {
            $chats->parentchat_id = $cid;
        }
        $chats->fromuser_id = $user_id;
        $chats->touser_id = $touser;
        $chats->content = $msg;
        $chats->creation_date = Time::now();
        $this->Chats->save($chats);


        if ($isFileNotAttached == 0) {
            $files = $this->request->getData()['file'];
        }
        $this->loadModel('Chatfiles');
        if ($isFileNotAttached == 0) {
            foreach ($files as $file) {
                $chatfiles = $this->Chatfiles->newEntity();
                $chatfiles->user_id = $user_id;
                $chatfiles->chat_id = $chats->id;
                $chatfiles->touser_id = $touser;
                $chatfiles->filename = $file['name'];
                $chatfiles->type = $file['type'];
                $chatfiles->size = $file['size'];
                $chatfiles->creation_date = Time::now();
                $chatfiles->filepath = "assets/chatfiles/" .  $user_id . $chats->id;
                $destinationFolder = WWW_ROOT . "assets/chatfiles/" .  $user_id . $chats->id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Chatfiles->save($chatfiles);
            }
        }
        $conditions = array();
        $conditions = array(
            'OR' => [
                [
                    'AND' => [
                        ['fromuser_id' => $touser],
                        ['touser_id' => $user_id],
                    ]
                ],
                [
                    'AND' => [
                        ['fromuser_id ' => $user_id],
                        ['touser_id' => $touser]
                    ]
                ]
            ]
        );
        $contactData = $this->Chats->find('all', [
            'conditions' => $conditions,
            'Chats.isDeleted' => false,
        ])->order(['creation_date' => 'ASC'])->contain([
            'Replies',
            'Replies.chatfiles',
            'Replies.ToUser',
            'Replies.FromUser',
            'ToUser',
            'Chatfiles',
            'FromUser'
        ])->toArray();

        foreach ($contactData as $chat) {
            //Email Linking and Hashtag
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
        return $this->response->withType('application/json')->withStringBody(json_encode($contactData));
    }


    public function lastseenmessages()
    {
        $time = Time::now();
        //debug($touser);exit;
        $user_id = $this->Auth->user('id');

        $updatelastseenchats = $this->Chats->find('all', [
            'conditions' => [
                'isSeen' => false,
                'touser_id' => $user_id
            ]
        ])->toArray();
        //debug($updatelastseenchats);


        foreach ($updatelastseenchats as $chat) {
            $chat->isSeen = true;
            $chat->lastseen = $time;
            $this->Chats->save($chat);
        }
        $total = count($updatelastseenchats);
        //debug($total);exit;

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($total));
    }


    public function chatData()
    {
        if ($this->request->is('ajax')) {
            $this->loadModel('User');
            $time = Time::now();
            $user_id = $this->Auth->user('id');
            $userData = $this->User->find('all', [
                'conditions' => [
                    'isDeleted' => false
                ]
            ])->toArray();
            $contactId = $this->request->getData('contactId');
            $conditions = array();
            $conditions = array(
                'OR' => [
                    [
                        'AND' => [
                            ['fromuser_id' => $contactId],
                            ['touser_id' => $user_id],
                        ]
                    ],
                    [
                        'AND' => [
                            ['fromuser_id ' => $user_id],
                            ['touser_id' => $contactId]
                        ]
                    ]
                ]
            );

            $chatcontacts  = $this->Chats->find('all', [
                'conditions' => $conditions,
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

            $len =  count($chatcontacts);
            if ($len > 0) {
                foreach ($chatcontacts as $chat) {

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
                    $chat->from_user->last_login = $chat->from_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    $chat->to_user->last_login = $chat->to_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');

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
                return $this->response->withType('application/json')->withStringBody(json_encode($chatcontacts));
            } else {
                $this->loadModel('Chatcontacts');
                $user_id = $this->Auth->user('id');
                $contactId = $this->request->getData('contactId');
                $chatcontacts = $this->Chatcontacts->find('all', [
                    'conditions' => [
                        'Chatcontacts.touser_id' => $contactId,
                        'Chatcontacts.fromuser_id' =>  $user_id
                    ]
                ])->contain([
                    'Chatfiles',
                    'ToUser',
                    'FromUser'
                ])->toArray();

                //Loop data and assign formatted datetime where are datetimes

                $this->autoRender = false;
                // send JSON response
                return $this->response->withType('application/json')->withStringBody(json_encode($chatcontacts));
            }
        } else {
            $this->loadModel('User');
            $this->loadModel('Chatfiles');
            $user_id = $this->Auth->user('id');
            $userData = $this->User->find('all', [
                'conditions' => [
                    'isDeleted' => false
                ]
            ])->toArray();
            $file = $this->request->getData('chatfile');
            $touser = $this->request->getData('touser');
            $sharedfile = $this->Chatfiles->find('all', [
                'conditions' => [
                    'id in' => $file,
                    'isDeleted' => false
                ]
            ])->first();


            $conditions = array();
            $conditions = array(
                'OR' => [
                    [
                        'AND' => [
                            ['fromuser_id' => $touser],
                            ['touser_id' => $user_id],
                        ]
                    ],
                    [
                        'AND' => [
                            ['fromuser_id ' => $user_id],
                            ['touser_id' => $touser]
                        ]
                    ]
                ]
            );

            $contactData = $this->Chats->find('all', [
                'conditions' => $conditions,
            ])->order(['creation_date' => 'ASC'])->contain([
                'Replies',
                'Replies.chatfiles',
                'Replies.ToUser',
                'Replies.FromUser',
                'ToUser',
                'Chatfiles',
                'FromUser'
            ])->toArray();

            $len =  count($contactData);
            if ($len > 0) {
                foreach ($contactData as $chat) {
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
                    $chat->from_user->last_login = $chat->from_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    $chat->to_user->last_login = $chat->to_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');

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

                $this->Flash->success(__('File Attached to Share!'));
                return $this->redirect(['controller' => 'chats', 'action' => 'chatsystem']);
            } else {
                $this->loadModel('Chatcontacts');
                $user_id = $this->Auth->user('id');
                $contactId = $this->request->getData('contactId');
                $data = $this->Chatcontacts->find('all', [
                    'conditions' => [
                        'Chatcontacts.touser_id' => $contactId,
                        'Chatcontacts.fromuser_id' =>  $user_id
                    ]
                ])->contain([
                    'Chatfiles',
                    'ToUser',
                    'FromUser'
                ])->toArray();

                //Loop data and assign formatted datetime where are datetimes
                foreach ($data as $chat) {
                    $chat->from_user->last_login = $chat->from_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
                    $chat->to_user->last_login = $chat->to_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
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
                $this->Flash->success(__('File Attached to Share!'));
                return $this->redirect(['controller' => 'chats', 'action' => 'chatsystem']);
            }

            $this->set(compact('sharedfile'));
        }
    }

    //delete all conversation
    function deleteconversations()
    {
        $this->loadModel('Chatcontacts');
        $user_id = $this->Auth->user('id');
        $touser = $this->request->getData('touser');
        $deleconversationdata =  $this->Chats->find('all', [
            'conditions' => [
                'touser_id' => $touser,
                'fromuser_id' => $user_id
            ]
        ])->toArray();
        foreach ($deleconversationdata as $chatdata) {
            $this->Chats->delete($chatdata);
        }
        // debug($deleconversationdata);exit;
        $data = $this->Chatcontacts->find('all', [
            'conditions' => [
                'Chatcontacts.touser_id' => $touser,
                'Chatcontacts.fromuser_id' =>  $user_id
            ]
        ])->contain([
            'Chatfiles',
            'ToUser',
            'FromUser'
        ])->toArray();
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($data));
    }


    function allcontactData()
    {
        $this->loadModel('Chatcontacts');

        $alldata = $this->Chatcontacts->find('all')->contain([
            'Chatfiles',
            'ToUser',
            'FromUser'
        ])->toArray();

        $result = array();
        if (!empty($alldata)) {
            $result = array(
                'RESULT' => "SUCCESS",
                'MESSAGE' => "",
                'alldata' => $alldata
            );
        } else {
            $result = array(
                'RESULT' => "ERROR",
                'MESSAGE' => "NO Contacts Founds, Please add Contact",
                'alldata' => null
            );
        }

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($result));
    }

    function deletechat()
    {
        $this->loadModel('User');
        $userData = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $chatid = $this->request->getData('chatid');
        $touser = $this->request->getData('touser');

        $deletechat =  $this->Chats->find('all', [
            'conditions' => [
                'id in ' => $chatid
            ]
        ])->first();

        $deletechat->isDeleted = true;
        $this->Chats->save($deletechat);

        return $this->redirect(['controller' => 'chats', 'action' => 'chatsystem', $touser]);
    }

    function editchat()
    {

        $this->loadModel('User');
        $userData = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $chatid = $this->request->getData('chatid');
        $touser =  $this->request->getData('touser');
        $content = $this->request->getData('content');
        $updateChat =  $this->Chats->find('all', [
            'conditions' => [
                'id in' => $chatid,
                'touser_id' => $touser
            ]
        ])->first();
        $updateChat->content = $content;
        $updateChat->last_update = Time::now();
        $this->Chats->save($updateChat);

        $conditions = array();
        $conditions = array(
            'OR' => [
                [
                    'AND' => [
                        ['fromuser_id' => $touser],
                        ['touser_id' => $user_id],
                    ]

                ],
                [
                    'AND' => [
                        ['fromuser_id ' => $user_id],
                        ['touser_id' => $touser]
                    ]

                ]
            ]
        );
        $chatData = $this->Chats->find('all', [
            'conditions' => $conditions
        ])->order(['creation_date' => 'ASC'])->contain([
            'ToUser',
            'Chatfiles',
            'FromUser'
        ])->toArray();


        foreach ($chatData as $chat) {



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


            $chat->from_user->last_login = $chat->from_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
            $chat->to_user->last_login = $chat->to_user->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome');
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
        return $this->response->withType('application/json')->withStringBody(json_encode($chatData));
    }



    /**
     * View method
     *
     * @param string|null $id Chat id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chat = $this->Chats->get($id, [
            'contain' => ['User']
        ]);

        $this->set('chat', $chat);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chat = $this->Chats->newEntity();
        if ($this->request->is('post')) {
            $chat = $this->Chats->patchEntity($chat, $this->request->getData());
            if ($this->Chats->save($chat)) {
                $this->Flash->success(__('The chat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat could not be saved. Please, try again.'));
        }
        $user = $this->Chats->User->find('list', ['limit' => 200]);
        $this->set(compact('chat', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chat = $this->Chats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chat = $this->Chats->patchEntity($chat, $this->request->getData());
            if ($this->Chats->save($chat)) {
                $this->Flash->success(__('The chat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chat could not be saved. Please, try again.'));
        }
        $user = $this->Chats->User->find('list', ['limit' => 200]);
        $this->set(compact('chat', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chat = $this->Chats->get($id);
        if ($this->Chats->delete($chat)) {
            $this->Flash->success(__('The chat has been deleted.'));
        } else {
            $this->Flash->error(__('The chat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    // PRIVATE FUNCTIONS
    public function addUsertoChat($touser)
    {
        $this->loadModel('User');
        $this->loadModel('Chatcontacts');
        $user_id = $this->Auth->user('id');
        $chatcontact = $this->Chatcontacts->newEntity();
        $chatcontact->touser_id = $touser;
        $chatcontact->fromuser_id = $user_id;
        $chatcontact->creation_date = Time::now();
        $this->Chatcontacts->save($chatcontact);
        return $this->redirect(['action' => 'chatsystem', $touser]);
    }

    public function updatelastseenchat()
    {
        $user_id = $this->Auth->user('id');
        $touser = $this->request->getData('touser');
        $chats = $this->Chats->find('all', [
            'conditions' => [
                'fromuser_id' => $touser,
                'touser_id' =>  $user_id,
                'isSeen' => false
            ]
        ])->toArray();

        if (!empty($chats)) {
            foreach ($chats as $chat) {
                $chat->isSeen = true;
                $this->Chats->save($chat);
            }
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($chats));
    }
}
