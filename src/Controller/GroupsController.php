<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use SebastianBergmann\Environment\Console;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 *
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $groups = $this->paginate($this->Groups);

        $this->set(compact('groups'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $this->loadModel('CompaniesUser');
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },
        ])->toArray();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false,
                    'Groupposts.isDeleted' => false
                ]);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();

        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }
        $this->set(compact('group', 'authuser','clients'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $group = $this->Groups->newEntity();
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossibile salvare il gruppo. Per favore riprova.'));
        }
        $this->set(compact('group'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossibile salvare il gruppo. Per favore riprova.'));
        }
        $this->set(compact('group'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $id = $this->request->getData('companygroup_id');
        $group =  $this->Groups->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $companyId = $group->company_id;

        $group->isDeleted = true;

        $this->Groups->save($group);
        $this->Flash->success(__('Gruppo eliminato'));
        return $this->redirect(['controller' => 'usercompanies', 'action' => 'view', $companyId]);
    }

    public function newgroup($companyId = null)
    {

        $this->set(compact('companyId'));
    }

    public function grouppage()
    {

        $this->loadModel('Groupmembers');
        $user_id = $this->Auth->user('id');
        $group = $this->Groups->newEntity();
        $group_name = $this->request->getData('group_name');
        $group_description = $this->request->getData('group_description');
        $group_profile = $this->request->getData('group_profile');

        $companyId = $this->request->getData('companyId');
        $group->company_id = $companyId;
        $group->creatorId = $user_id;
        $group->name = $group_name;
        $group->description = $group_description;
        $group->creation_date = Time::now();
        $group->group_profileFilename = $group_profile['name'];


        $group->group_profileFilepath = "assets/img/" .  $companyId . $user_id . $group_profile['name'];
        $destinationFolder = WWW_ROOT . "assets/img/" .  $companyId . $user_id . $group_profile['name'];
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($group_profile['tmp_name'], $destinationFolder . DS . $group_profile['name']);

        $this->Groups->save($group);

        $groupmember = $this->Groupmembers->newEntity();
        $groupmember->group_id = $group->id;
        $groupmember->user_id = $user_id;
        $groupmember->member_role = 'Y';


        // debug($groupmember);exit;
        $this->Groupmembers->save($groupmember);

        return $this->redirect(['controller' => 'groups', 'action' => 'view', $group->id]);
    }

    public function addmembers()
    {
        $this->loadModel('CompaniesUser');

        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $companygroups = $this->Groups->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->toArray();

        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User'])->toArray();


        $this->set(compact('companymembers', 'companygroups'));
    }

    public function files($group_id = null)
    {
        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $this->loadModel('Groupmembers');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id,
            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts', 'Grouppostfiles.Users'])->first();
        $groupfiles = $this->Grouppostfiles->find('all', [
            'conditions' => [
                'Grouppostfiles.isDeleted' => false,
            ]
        ])->order(['creation_date' => 'DESC'])->contain(['Users'])->toArray();

        $allcompanygroups = $this->Groups->find('all', [
            'conditions' => [
                'company_id' => $group->company_id
            ]
        ])->toArray();

        $allgroupids = array();
        foreach ($allcompanygroups as $group) {
            array_push($allgroupids, $group->id);
        }
        $uniqueids = array_unique($allgroupids);

        $companygroups = $this->Groupmembers->find('all', [
            'conditions' => [
                'group_id in' => $uniqueids,
                'user_id in' =>  $user_id
            ]
        ])->contain(['Groups'])->toArray();



        $this->set(compact('group', 'authuser', 'groupfiles', 'companygroups'));
    }
    public function documentfiles($group_id = null)
    {
        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id,
            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts', 'Grouppostfiles.Users'])->first();
        $documentfiles = $this->Grouppostfiles->find('all', [
            'conditions' => [
                'Grouppostfiles.isDeleted' => false,
                'type not in' => [
                    'image/jpeg',
                    'video/mp4'
                ]
            ]
        ])->order(['creation_date' => 'DESC'])->contain(['Users'])->toArray();

        $this->set(compact('group', 'authuser', 'documentfiles'));
    }

    public function videofiles($group_id = null)
    {

        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id,
            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts', 'Grouppostfiles.Users'])->first();
        $videofiles = $this->Grouppostfiles->find('all', [
            'conditions' => [
                'Grouppostfiles.isDeleted' => false,
                'type in' => [
                    'video/mp4'
                ]
            ]
        ])->contain(['Users'])->order(['creation_date' => 'DESC'])->toArray();

        $this->set(compact('group', 'authuser', 'videofiles'));
    }
    public function imagefiles($group_id = null)
    {
        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id,
            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts', 'Grouppostfiles.Users'])->first();
        $imagefiles = $this->Grouppostfiles->find('all', [
            'conditions' => [
                'Grouppostfiles.isDeleted' => false,
                'type not in' => [
                    'application/pdf',
                    'application/octet-stream',
                    'application/x-zip-compressed'
                ]
            ]
        ])->contain(['Users'])->order(['creation_date' => 'DESC'])->toArray();

        $this->set(compact('group', 'authuser', 'imagefiles'));
    }


    public function groupmembers($group_id = null)
    {
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id,

            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts', 'Grouppostfiles.Users'])->first();

        $this->loadModel('Groupmembers');

        $groupmembers = $this->Groupmembers->find('all', [
            'conditions' => [
                'group_id' => $group_id,
                'Groupmembers.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $this->set(compact('group', 'authuser', 'groupmembers'));
    }

    public function companygroups($group_id = null)
    {
        $this->loadModel('User');
        $this->loadModel('Groupmembers');

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $companygroups = $this->Groups->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'Groups.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $allmembers = $this->Groupmembers->find('all', [
            'conditions' => [
                'Groupmembers.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id,

            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts', 'Grouppostfiles.Users'])->first();


        $this->set(compact('group', 'authuser', 'companygroups', 'allmembers'));
    }

    public function searchdata($group_id = null)
    {
        $this->loadModel('Groupposts');
        $this->loadModel('User');
        $this->loadModel('Postlikes');
        $this->loadModel('Postcommentlikes');
        $this->loadModel('Postcomments');
        $this->loadModel('Groupmembers');



        $groupmembers = $this->Groupmembers->find('all', [
            'conditions' => [
                'group_id' => $group_id,
                'Groupmembers.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $search_key = $this->request->getQuery('searchkey');


        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {

                return $q->where([
                    'isNote' => false,
                ]);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();

        $allgroupposts = array();
        foreach ($group->groupposts as $post) {

            if (preg_match("/{$search_key}/i", $post->post_data)) {
                array_push(
                    $allgroupposts,
                    $post
                );
            }
        }


        $group = $this->Groups->find('all', [
            'conditions' => [
                'id in' => $group_id
            ]
        ])->contain(['Groupmembers.Users'])->first();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $likes =  $this->Postlikes->find('all', [
            'conditions' => [
                'group_id' => $group_id,
            ]
        ])->contain(['Users'])->toArray();
        $postcommentlikes =  $this->Postcommentlikes->find('all', [
            'conditions' => [
                'group_id' => $group_id
            ]
        ])->contain(['Users'])->toArray();

        $postcomments = $this->Postcomments->find('all', [
            'conditions' => [
                'Postcomments.group_id' => $group_id,
                'parent_id is' => null
            ]
        ])->contain(['Users', 'Posts', 'Replies', 'Replies.Users', 'Postcommentfiles'])->toArray();

        $this->loadModel('CompaniesUser');
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();




        $this->set(compact('clients','group', 'authuser', 'allgroupposts', 'likes', 'postcommentlikes', 'postcomments', 'groupmembers', 'search_key'));
    }

    public function sharefile($group_id = null)
    {

        $this->loadModel('Groupposts');
        $togroupid = $this->request->getData('groupid');
        $emailid = $this->request->getData('email');

        $this->loadModel('User');
        $this->loadModel('Grouppostfiles');
        $user_id = $this->Auth->user('id');
        $msg = $this->request->getData('post_message');
        $file_id = $this->request->getData('fileid');
        $sharedfiledata = $this->Grouppostfiles->find('all', [
            'conditions' => [
                'id in' => $file_id
            ]
        ])->first();

        if (!empty($emailid)) {

            $protocol = Configure::read('Protocol');
            $domain = Configure::read('Domain');
            $port = Configure::read('Port');
            $email = new Email();
            $emailSent =   $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                //  ->setTo('ankoosh.sk@gmail.com')
                ->setTo($emailid)
                ->setEmailFormat('html')
                ->setSubject('Sharred file')
                //->setTemplate('summary', 'default')
                ->setAttachments(array(
                    1 => WWW_ROOT . $sharedfiledata->filepath . DS . $sharedfiledata->filename
                ));
            $email->send();
            if ($emailSent) {
                $this->Flash->success(__('Email inviata.'));
            } else {
                $this->Flash->error(__('Errore'));
            }
            return $this->redirect(['controller' => 'groups', 'action' => 'files', $togroupid]);
        } else {

            $sourcepath = WWW_ROOT . $sharedfiledata->filepath . DS . $sharedfiledata->filename;
            $grouppost = $this->Groupposts->newEntity();
            $grouppost->group_id = $togroupid;
            $grouppost->user_id = $user_id;
            if (!empty($msg)) {
                $grouppost->post_data = $msg;
            }
            $grouppost->isShared = true;
            $this->Groupposts->save($grouppost);
            //save file
            $postfile = $this->Grouppostfiles->newEntity();
            $postfile->user_id = $user_id;
            $postfile->group_id = $togroupid;
            $postfile->grouppost_id = $grouppost->id;
            $postfile->filename = $sharedfiledata->filename;
            $postfile->size = $sharedfiledata->size;
            $postfile->type = $sharedfiledata->type;
            $postfile->filepath = "assets/groupsharedfiles/" .  $grouppost->id;
            $destinationFolder = WWW_ROOT . "assets" . DS . "groupsharedfiles" . DS .  $grouppost->id;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            copy($sourcepath, $destinationFolder . DS . $sharedfiledata->filename);
            $this->Grouppostfiles->save($postfile);
            return $this->redirect(['controller' => 'groups', 'action' => 'view', $togroupid]);
        }
    }

    public function grouphashtags()
    {
        $this->loadModel('User');
        $this->loadModel('Groupposts');
        $this->loadModel('Groupmembers');
        $this->loadModel('Postlikes');
        $this->loadModel('Postcomments');
        $this->loadModel('Postcommentlikes');
        $this->loadModel('Grouppostfiles');
        $id = $this->request->getQuery('groupid');
        $tag = $this->request->getQuery('tag');
        $postcomments = $this->Postcomments->find('all', [
            'conditions' => [
                'Postcomments.group_id' => $id,
                'parent_id is' => null
            ]
        ])->contain(['Users', 'Posts', 'Replies', 'Replies.Users', 'Postcommentfiles'])->toArray();

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();

        $companygroups = $this->Groups->find('all', [
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,
                'Groups.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $group = $this->Groups->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->contain(['Grouppostfiles', 'Grouppostfiles.Groupposts.Users'])->first();
        $allgroupposts = $this->Groupposts->find('all', [
            'conditions' => [
                'group_id in' => $id,
                'Groupposts.isDeleted' => false
            ]
        ])->order(['creation_date' => 'DESC'])->contain(['Grouppostfiles', 'Users', 'groupposttagmembers.Users'])->toArray();
        $matchedposts = array();
        foreach ($allgroupposts as $post) {
            if (preg_match("/{$tag}/i", $post->post_data)) {
                array_push(
                    $matchedposts,
                    $post
                );
            }
        }

        foreach ($matchedposts as $post) {
            $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
            //comapare using preg_match_all() method
            preg_match_all($test_patt, $post->post_data, $valid);
            preg_match_all("/#(\\w+)/", $post->post_data, $tags);
            if (!empty($valid)) {
                foreach ($valid[0] as $email) {
                    foreach ($allusers as $data) {
                        if ($email == $data->email) {
                            $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                        }
                    }
                }
            }
            foreach ($tags[0] as $hashtag) {
                $pos = strpos($post->post_data, $hashtag);
                $str = ltrim($hashtag, '#');
                $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
            }
        }

        $groupmembers = $this->Groupmembers->find('all', [
            'conditions' => [
                'group_id' => $id,
                'Groupmembers.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $allmembers = $this->Groupmembers->find('all', [
            'conditions' => [
                'Groupmembers.isDeleted' => false
            ]
        ])->contain(['Users'])->toArray();
        $likes =  $this->Postlikes->find('all', [
            'conditions' => [
                'group_id' => $id,
            ]
        ])->contain(['Users'])->toArray();
        $postcommentlikes =  $this->Postcommentlikes->find('all', [
            'conditions' => [
                'group_id' => $id
            ]
        ])->contain(['Users'])->toArray();
        $this->set(compact('group', 'authuser', 'matchedposts', 'groupmembers', 'likes', 'postcomments', 'companygroups', 'allmembers', 'postcommentlikes'));
    }

    public function updatebackgroundimg()
    {
        $group_id = $this->request->getData('group_id');
        $file = $this->request->getData('background_image');

        $group = $this->Groups->find('all', [
            'conditions' => [
                'id in' => $group_id
            ]
        ])->first();
        $group->group_backgroundimagepath = "assets/img/" .  $group_id;
        $group->group_backgroundimagename = $file['name'];


        $destinationFolder = WWW_ROOT . "assets/img/" .  $group_id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        $this->Groups->save($group);

        return $this->redirect(['controller' => 'groups', 'action' => 'view', $group_id]);
    }

    public function notes($group_id)
    {

        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $this->loadModel('CompaniesUser');
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();


        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => true
                ]);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts'

        ])->first();

        //debug($group);exit;
        $this->set(compact('group', 'authuser', 'clients'));
    }

    public function postscreationdateAsc($group_id = null)
    {
        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false
                ])->order(['creation_date' => 'ASC']);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();
        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }

        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
         'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();

        $this->set(compact('group', 'authuser', 'clients'));
    }
    public function postscreationdateDesc($group_id = null)
    {
        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false
                ])->order(['creation_date' => 'DESC']);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();
        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();

        $this->set(compact('group', 'authuser', 'clients'));
    }
    public function postsupdateAsc($group_id = null)
    {
        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false
                ])->order(['last_update' => 'ASC']);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();
        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();

        $this->set(compact('group', 'authuser', 'clients'));
    }
    public function postsupdateDesc($group_id = null)
    {

        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false
                ])->order(['last_update' => 'DESC']);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();
        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,

            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();

        $this->set(compact('group', 'authuser', 'clients'));
    }
    public function postsalphabetsAsc($group_id = null)
    {
        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false
                ])->order(['Groupposts.post_data' => 'ASC']);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();
        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }
        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId,

            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();

        $this->set(compact('group', 'authuser', 'clients'));
    }
    public function postsalphabetsDesc($group_id = null)
    {
        $this->loadModel('User');
        $allusers = $this->User->find('all', [
            'conditions' => [
                'User.isDeleted' => false
            ]
        ])->toArray();
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $group = $this->Groups->find('all', [
            'conditions' => [
                'Groups.id in' => $group_id
            ]
        ])->contain([
            'Groupmembers.Users',

            'Groupposts' => function ($q) {
                return $q->where([
                    'isNote' => false
                ])->order(['Groupposts.post_data' => 'DESC']);
            },
            'Groupposts.Users',
            'Groupposts.Groupnotes',
            'Groupposts.Grouppostfiles',
            'Groupposts.Groupposttagmembers.Users',

            'Groupmembers.Users',
            'Groupposts.Postlikes' => function ($q) {
                return $q->where([
                    'isLiked' => true
                ]);
            },
            'Groupposts.Postlikes.Users',
            'Groupposts.Postcomments.Users',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Favoriteposts',
            'Groupposts.Postcomments.Postcommentlikes' => function ($q) {
                return $q->where([
                    'isReply' => false,
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Postcommentlikes.Users',
            'Groupposts.Postcomments.groupposttagmembers.Users',
            'Groupposts.Postcomments.Replies.Users',
            'Groupposts.Postcomments.Replies.Replytagmembers.Users',
            'Groupposts.Postcomments.Replies.Replyfiles',
            'Groupposts.Postcomments.Replies.Replylikes' => function ($q) {
                return $q->where([
                    'isLiked' => true,
                ]);
            },
            'Groupposts.Postcomments.Replies.Replylikes.Users',
            'Groupposts.Postcomments.Postcommentfiles',

        ])->first();
        foreach ($group->groupposts as $grouppost) {
            foreach ($grouppost->postcomments as $post) {
                $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
                //comapare using preg_match_all() method
                preg_match_all($test_patt, $post->post_data, $valid);
                preg_match_all("/#(\\w+)/", $post->post_data, $tags);
                if (!empty($valid)) {
                    foreach ($valid[0] as $email) {
                        foreach ($allusers as $data) {
                            if ($email == $data->email) {
                                $post->post_data = str_replace($email, "<a href='/project-member/userprofile/" . $data->id . "'>" . $email . "</a>", $post->post_data);
                            }
                        }
                    }
                }
                foreach ($tags[0] as $hashtag) {
                    $pos = strpos($post->post_data, $hashtag);
                    $str = ltrim($hashtag, '#');
                    $link = "/groups/grouphashtags?groupid=" . $post->group_id . "&tag=" . $str;
                    $post->post_data = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $post->post_data);
                }

                if ($post->replies) {
                    foreach ($post->replies as $reply) {

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
                    }
                }
            }
        }

        $clients = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $authuser->choosen_companyId
            ]
        ])->contain(['User',
        'Designations'=> function ($q) {
            return $q->where([
               'name is' => 'Customer'
            ]);
        },])->toArray();
        $this->set(compact('group', 'authuser','clients'));
    }
}
