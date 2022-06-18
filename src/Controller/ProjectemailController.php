<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use phpDocumentor\Reflection\Types\Null_;
use Seld\JsonLint\Undefined;

/**
 * Projectemail Controller
 *
 * @property \App\Model\Table\ProjectemailTable $Projectemail
 *
 * @method \App\Model\Entity\Projectemail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectemailController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $projectemail = $this->paginate($this->Projectemail);

        $this->set(compact('projectemail'));
    }


    /**Trash mails */
    public function trashMails()
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('Projectemail');
        $this->loadModel('User');

        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();
        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();
        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();
        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }
        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);

        $projectemails = $this->Projectemail->find('all', [
            'conditions' => [
                'Projectemail.id in' => $finalarray,
                'Projectemail.isDeleted' => true
            ]
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers.User',
            'Ccusers.User',
            'Bccusers.User',
            'Replies',
            'Replies.Tousers',
            'Childmails.Emailfiles',
            'Childmails.FromUser',
            'Childmails.Tousers.User',
            'Childmails.Ccusers.User',
            'Childmails.Bccusers.User',
            'Forwardemails',
            'Forwardemails.Tousers'
        ])->order(['send_date' => 'DESC'])->toArray();

        $forwardemails = $this->Projectemail->find('all', [
            'conditions' => [
                'forwarded_id is not' => null
            ]
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers.User',
            'Ccusers.User',
            'Bccusers.User',
            'Replies',
            'Replies.Tousers',
            'Forwardemails',
            'Forwardemails.Tousers',
            'Forwardemails.FromUser'
        ])->order(['send_date' => 'DESC'])->toArray();


        $this->set(compact('projectemails', 'forwardemails'));
    }

    //mark as readmail
    public function markasReadandUnreadmails()
    {

        $this->loadModel('Touseremails');
        $this->loadModel('Projectccemails');
        $this->loadModel('Projectbccemails');
        $user_id = $this->Auth->user('id');
        $reademails = null;
        $unreadmails = null;
        $reademails = $this->request->getData('readmails');

        $unreadmails = $this->request->getData('unreadmails');
        if ($reademails != null) {

            foreach ($reademails as $mail) {
                $readmailsobject =  $this->Projectemail->find('all', [
                    'conditions' => [
                        'id in' => $mail

                    ]
                ])->first();
                $readmailsobject->isRead = true;
                $this->Projectemail->save($readmailsobject);
            }
        }

        if ($unreadmails != null) {
            foreach ($unreadmails as $unreadmail) {
                $unread =  $this->Projectemail->find('all', [
                    'conditions' => [
                        'id in' => $unreadmail
                    ]
                ])->first();
                $unread->isRead = false;
                $this->Projectemail->save($unread);
            }
        }

        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();

        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();

        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();

        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }

        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }
        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);
        if (!empty($finalarray)) {
            $conditions = array(
                'and' => array(
                    array(
                        'Projectemail.id in' => $finalarray,
                    ),

                    'Projectemail.isDeleted' => false,
                    'Projectemail.worklable is' => null,
                )
            );
            $projectemails = $this->Projectemail->find('all', [
                'conditions' => $conditions
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers.User',
                'Bccusers.User',
                'Replies',
                'Replies.Tousers',
                'Forwardemails',
                'Forwardemails.Tousers.User',
                'Forwardemails.Ccusers.User',
                'Forwardemails.Bccusers.User'
            ])->order(['send_date' => 'DESC'])->toArray();
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($projectemails));
        }
    }


    public function deleteallmails()
    {
        $this->loadModel('Touseremails');
        $this->loadModel('Projectccemails');
        $this->loadModel('Projectbccemails');


        $user_id = $this->Auth->user('id');
        $deletemail = $this->request->getData('deletemail');

        foreach ($deletemail as $mail) {
            $deletedmail =  $this->Projectemail->find('all', [
                'conditions' => [
                    'id in' => $mail
                ]
            ])->first();
            $deletedmail->isDeleted = true;
            $this->Projectemail->save($deletedmail);
        }
        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();
        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();
        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();
        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }

        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);
        if (!empty($finalarray)) {
            $conditions = array(
                'and' => array(
                    array(
                        'Projectemail.id in' => $finalarray,
                    ),
                    //'parentemail_id is' => null,
                    'Projectemail.isDeleted' => false,
                    'isDraft' => false,
                    'worklable is' => null
                )
            );


            $projectemails = $this->Projectemail->find('all', [
                'conditions' => $conditions
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers.User',
                'Bccusers.User',
                'Replies',
                'Replies.Tousers',
                'Forwardemails',
                'Forwardemails.Tousers.User',
                'Forwardemails.Ccusers.User',
                'Forwardemails.Bccusers.User'
            ])->order(['send_date' => 'DESC'])->toArray();
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($projectemails));
        }
    }



    /**Sent Mails method */

    public function sentMails()
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $projectemails = $this->Projectemail->find('all', [
            'conditions' => [
                'fromuser_id' => $user_id,
                'isSent' => 1,
                'Projectemail.isDeleted' => false
            ]
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers.User',
            'Ccusers.User',
            'Bccusers.User',
            'Replies',
            'Replies.Tousers',
            'Childmails.Emailfiles',
            'Childmails.FromUser',
            'Childmails.Tousers.User',
            'Childmails.Ccusers.User',
            'Childmails.Bccusers.User',
            'Forwardemails',
            'Forwardemails.Tousers'
        ])->order(['send_date' => 'DESC'])->toArray();


        $forwardemails = $this->Projectemail->find('all', [
            'conditions' => [
                'forwarded_id is not' => null
            ]
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers.User',
            'Ccusers.User',
            'Bccusers.User',
            'Replies',
            'Replies.Tousers',
            'Forwardemails',
            'Forwardemails.Tousers',
            'Forwardemails.FromUser'
        ])->order(['send_date' => 'DESC'])->toArray();

        $allusers = $this->User->find('all')->toArray();
        if ($this->request->is('ajax')) {
            $projectemails = $this->Projectemail->find('all', [
                'conditions' => [
                    'fromuser_id' => $user_id,
                    'isSent' => 1,
                    'Projectemail.isDeleted' => false
                ]
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers.User',
                'Bccusers.User',
                'Replies',
                'Replies.Tousers',
                'Childmails.Emailfiles',
                'Childmails.FromUser',
                'Childmails.Tousers.User',
                'Childmails.Ccusers.User',
                'Childmails.Bccusers.User',
                'Forwardemails',
                'Forwardemails.Tousers'
            ])->order(['send_date' => 'DESC'])->toArray();

            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($projectemails));
        }


        $this->set(compact('projectemails', 'allusers', 'forwardemails'));
    }

    public function composeEmail($id = null)
    {
        $this->loadModel('CompaniesUser');
        $this->loadModel('User');

        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $projectMembers = $this->CompaniesUser->find('all')->contain(['Designations' => function ($q) {
            return $q->where([
                'name !=' => 'Customer'
            ]);
        },])->toArray();

        if ($id != null) {
            $draftMail  = $this->Projectemail->find('all', [
                'conditions' => [
                    'Projectemail.id' => $id
                ]
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers',
                'Ccusers.User',
                'Bccusers',
                'Bccusers.User',
                'Replies',
                'Replies.FromUser',
                'Replies.Tousers',
                'Replies.Ccusers.User',
                'Replies.Bccusers.User',
                'Forwardemails',
                'Forwardemails.Tousers.User',
                'Forwardemails.Ccusers.User',
                'Forwardemails.Bccusers.User'
            ])->first();
        } else {
            $draftMail = null;
        }


        $members = array_unique(array());
        foreach ($projectMembers as $member) {
            array_push($members, $member['user_id']);
        }

        $allprojectuserIds = array_unique($members);
        $allUsers = $this->User->find('all')->toArray();
        $file = $this->request->getQuery('fileid');
        $pid = $this->request->getQuery('projectid');
        if (!empty($file)) {
            $this->loadModel('Projectfiles');
            $projectfile = $this->Projectfiles->find('all', [
                'conditions' => [
                    'id' => $file
                ]
            ])->first();
        } else {
            $projectfile = null;
            $user_id = $this->Auth->user('id');
            $this->loadModel('User');
            $allusers = $this->User->find('all')->toArray();
        }
        $this->set(compact('authuser', 'projectfile', 'allUsers', 'projectMembers', 'allprojectuserIds', 'draftMail'));
    }

    public function sendemail()
    {
        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $this->loadModel('ProjectMember');
        $this->loadModel('Emailfiles');
        $drafteid = $this->request->getData('drafteid');
        if ($drafteid == null) {
            $drafteid = 0;
        }
        $sharedfile = $this->request->getData('sharedfile');
        if ($sharedfile == 'undefined') {
            $sharedfile = null;
        }
        $toemails = json_decode($_POST['tovalues']);
        $ccemails = json_decode($_POST['ccvalues']);
        $bccemails = json_decode($_POST['bccvalues']);
        $isFileNotAttached = $this->request->getData('isFileNotAttached');
        $subject = $this->request->getData('subject');
        $body = $this->request->getData('body');
        $parentemail = $this->request->getData('parentemail');

        $forwardeid = $this->request->getData('forwardeid');
        if ($drafteid == 0) {
            $projectemail = $this->Projectemail->newEntity();
            if (!empty($parentemail)) {
                $projectemail->parentemail_id =  $parentemail;
                while (1) {
                    $parentrecord = $this->Projectemail->find('all', [
                        'conditions' => [
                            'Projectemail.id' => $parentemail
                        ]
                    ])->first();
                    if ($parentrecord->parentemail_id != null) {
                        $parentemail = $parentrecord->parentemail_id;
                        continue;
                    } else
                        $projectemail->rootmail_id =  $parentemail;
                    break;
                }
            }

            if (!empty($forwardeid)) {
                // $projectemail->parentemail_id =  $forwardeid;
                $projectemail->forwarded_id =  $forwardeid;
            }
            $projectemail->fromuser_id = $user_id;
            $projectemail->subject = $subject;
            $projectemail->body = $body;
            $projectemail->creation_date = Time::now();
            $projectemail->send_date = Time::now();
            $projectemail->isSent = 1;
            // $projectemail->isRead = false;
            $this->Projectemail->save($projectemail);
        } else {
            $projectemail = $this->Projectemail->find('all', [
                'conditions' => [
                    'id' => $drafteid
                ]
            ])->first();
            if (!empty($parentemail)) {
                $projectemail->parentemail_id =  $parentemail;
            }
            if (!empty($forwardeid)) {
                $projectemail->forwarded_id =  $forwardeid;
                // $projectemail->parentemail_id = $forwardeid;
            }
            $projectemail->fromuser_id = $user_id;
            $projectemail->subject = $subject;
            $projectemail->body = $body;
            $projectemail->creation_date = Time::now();
            $projectemail->send_date = Time::now();
            $projectemail->isSent = 1;
            $projectemail->isDraft = 0;
            $this->Projectemail->save($projectemail);
        }
        //save multiple toemails

        if (!empty($toemails)) {

            foreach ($toemails as $email) {
                $this->loadModel('Touseremails');
                $touseremails = $this->Touseremails->newEntity();
                $touseremails->email_id = $projectemail->id;
                $touseremails->touser_id = $email;
                $this->Touseremails->save($touseremails);

                //Notifications
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = null;
                $notification->action_status = 'sending'; // $leave->status;//New
                $notification->action_description = $projectemail->subject;
                $notification->action_id = $projectemail->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $email;
                $notification->type = 'mail';
                $this->Notifications->save($notification);
            }
        }
        if (!empty($ccemails)) {
            foreach ($ccemails as $ccemail) {
                $this->loadModel('Projectccemails');
                $ccemails = $this->Projectccemails->newEntity();
                $ccemails->email_id = $projectemail->id;
                $ccemails->ccuser_id = $ccemail;
                $this->Projectccemails->save($ccemails);
                //Notifications
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = null;
                $notification->action_status = 'sending'; // $leave->status;//New
                $notification->action_description = $projectemail->subject;
                $notification->action_id = $projectemail->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $ccemail;
                $notification->type = 'mail';
                $this->Notifications->save($notification);
            }
        }
        if (!empty($bccemails)) {
            foreach ($bccemails as $bccemail) {
                $this->loadModel('Projectbccemails');
                $bccemails = $this->Projectbccemails->newEntity();
                $bccemails->email_id = $projectemail->id;
                $bccemails->bccuser_id = $bccemail;
                $this->Projectbccemails->save($bccemails);
                //Notifications
                $notification = $this->Notifications->newEntity();
                $notification->fromuser_id = $user_id;
                $notification->action_title = null;
                $notification->action_status = 'sending'; // $leave->status;//New
                $notification->action_description = $projectemail->subject;
                $notification->action_id = $projectemail->id;
                $notification->creation_date = Time::now();
                $notification->touser_id = $bccemail;
                $notification->type = 'mail';
                $this->Notifications->save($notification);
            }
        }

        if ($sharedfile != null) {

            $this->loadModel('Projectfiles');
            $sharedfiledata = $this->Projectfiles->find('all', [
                'conditions' => [
                    'id in' => $sharedfile
                ]
            ])->first();

            $sourcepath = WWW_ROOT . $sharedfiledata->filepath . DS . $sharedfiledata->filename;

            $emailfiles = $this->Emailfiles->newEntity();
            $emailfiles->email_id = $projectemail->id;
            if (!empty($parentemail)) {
                $emailfiles->parentemail_id =  $parentemail;
            }
            if (!empty($forwardeid)) {
                $projectemail->forwarded_id =  $forwardeid;
                //  $emailfiles->parentemail_id = $forwardeid;
            }
            $emailfiles->fromuser_id = $user_id;
            $emailfiles->filename = $sharedfiledata->filename;
            $emailfiles->type = $sharedfiledata['type'];
            $emailfiles->size = $sharedfiledata['size'];
            $emailfiles->filepath = "assets/emailfiles/" . $user_id . '/' . $projectemail['id'];
            $destinationFolder = WWW_ROOT . "assets/emailfiles/" .  $user_id . '/' . $projectemail['id'];
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            copy($sourcepath, $destinationFolder . DS . $sharedfiledata->filename);
            //  move_uploaded_file($sourcepath, $destinationFolder . DS . $sharedfiledata->filename);
            $this->Emailfiles->save($emailfiles);
        }

        if ($isFileNotAttached == 0) {
            $attachments = $this->request->getData()['file'];
            foreach ($attachments as $attachment) {
                $emailfiles = $this->Emailfiles->newEntity();
                $emailfiles->email_id = $projectemail->id;
                if (!empty($parentemail)) {
                    $emailfiles->parentemail_id =  $parentemail;
                }
                if (!empty($forwardeid)) {
                    $projectemail->forwarded_id =  $forwardeid;
                    // $emailfiles->parentemail_id =  $forwardeid;
                }
                $emailfiles->fromuser_id = $user_id;
                $emailfiles->filename = $attachment['name'];
                $emailfiles->type = $attachment['type'];
                $emailfiles->size = $attachment['size'];
                $emailfiles->filepath = "assets/emailfiles/" . $user_id . '/' . $projectemail['id'];
                $destinationFolder = WWW_ROOT . "assets/emailfiles/" .  $user_id . '/' . $projectemail['id'];
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($attachment['tmp_name'], $destinationFolder . DS . $attachment['name']);
                $this->Emailfiles->save($emailfiles);
            }
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectemail));
    }
    /**downloadall files */
    public function downloadall()
    {
        $fid =  $this->request->getQuery('fid');
        $mid =  $this->request->getQuery('mid');
        $this->loadModel('Emailfiles');
        $emailfiles = $this->Emailfiles->find('all', [
            'conditions' => [
                'id' => $fid,
                'email_id' => $mid
            ]
        ])->first();

        //$file = WWW_ROOT . str_replace('/', '\\', $emailfiles->filepath . DS . $emailfiles->filename);
        $file = WWW_ROOT . $emailfiles->filepath . DS . $emailfiles->filename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $emailfiles->filename,
        ]);
        return $response;
    }


    public function allmaildata()
    {

        $this->loadModel('Touseremails');
        $this->loadModel('Projectccemails');
        $this->loadModel('Projectbccemails');
        $user_id = $this->Auth->user('id');
        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();
        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();
        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();
        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }
        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }

        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);

        if (!empty($finalarray)) {
            $conditions = array(
                'and' => array(
                    array(
                        'Projectemail.id in' => $finalarray,
                    ),

                    'Projectemail.isDeleted' => false,
                )
            );

            $projectemails = $this->Projectemail->find('all', [
                'conditions' => $conditions
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers.User',
                'Bccusers.User',
                'Replies',
                'Replies.Tousers',
                'Forwardemails',
                'Forwardemails.Tousers'
            ])->order(['send_date' => 'DESC'])->toArray();
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectemails));
    }

    public function deletedmails()
    {

        $this->loadModel('Touseremails');
        $this->loadModel('Projectccemails');
        $this->loadModel('Projectbccemails');
        $user_id = $this->Auth->user('id');
        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();
        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();
        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();
        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }
        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();

        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);
        if (!empty($finalarray)) {
            $conditions = array(
                'and' => array(
                    array(
                        'Projectemail.id in' => $finalarray,
                    ),

                    'Projectemail.isDeleted' => true,
                )
            );

            $projectemails = $this->Projectemail->find('all', [
                'conditions' => $conditions
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers.User',
                'Bccusers.User',
                'Replies',
                'Replies.Tousers',
                'Forwardemails',
                'Forwardemails.Tousers'
            ])->order(['send_date' => 'DESC'])->toArray();
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectemails));
    }







    /**email inbox */

    public function inbox()
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('User');
        $this->loadModel('ProjectMember');
        $this->loadModel('Projectemail');
        $this->loadModel('Touseremails');
        $this->loadModel('Projectccemails');
        $this->loadModel('Projectbccemails');
        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();
        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();
        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();
        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }
        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);

        if (!empty($finalarray)) {
            $conditions = array(
                'and' => array(
                    array(
                        'Projectemail.id in' => $finalarray,
                    ),
                    //'parentemail_id is' => null,
                    //'Projectemail.rootmail_id is' => null,
                    'Projectemail.isDeleted' => false,
                    'isSent' => 1,
                    'worklable is' => null
                )
            );

            $projectemails = $this->Projectemail->find('all', [
                'conditions' => $conditions
            ])->contain([
                'FromUser',
                'Emailfiles',
                'Tousers.User',
                'Ccusers.User',
                'Bccusers.User',
                'Replies',
                'Replies.Tousers',
                'Childmails.Emailfiles',
                'Childmails.FromUser',
                'Childmails.Tousers.User',
                'Childmails.Ccusers.User',
                'Childmails.Bccusers.User',
                'Forwardemails',
                'Forwardemails.Tousers'
            ])->order(['send_date' => 'DESC'])->toArray();

            $this->set(compact('projectemails', 'user_id'));
        }
    }

    /**all list starred emails */

    public function starred()

    {
        $user_id = $this->Auth->user('id');
        $touseremails = $this->Touseremails->find('all', [
            'conditions' => [
                'touser_id' => $user_id
            ]
        ])->toArray();
        $bccuseremails = $this->Projectbccemails->find('all', [
            'conditions' => [
                'bccuser_id' => $user_id
            ]
        ])->toArray();
        $ccuseremails = $this->Projectccemails->find('all', [
            'conditions' => [
                'ccuser_id' => $user_id
            ]
        ])->toArray();
        $ccmailids = array();
        foreach ($ccuseremails as $email) {
            array_push($ccmailids, $email['email_id']);
        }
        $bccmailids = array();
        foreach ($bccuseremails as $email) {
            array_push($bccmailids, $email['email_id']);
        }
        $mailids = array();
        foreach ($touseremails as $email) {
            array_push($mailids, $email['email_id']);
        }
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $array1 = array_merge((array)$ccmailids, (array)$bccmailids);
        $finalarray = array_merge((array)$array1, (array)$mailids);


        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $starredmails = $this->Projectemail->find('all', [
            'conditions' => [
                'isStarred' => 1,
                'Projectemail.id in' =>  $finalarray
            ]
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers.User',
            'Ccusers.User',
            'Bccusers.User',
            'Replies',
            'Replies.Tousers',
            'Forwardemails',
            'Forwardemails.Tousers'
        ])->order(['send_date' => 'DESC'])->toArray();
        $allusers = $this->User->find('all')->toArray();
        $this->set(compact('starredmails', 'allusers'));
    }









    /**draftMails  */

    public function senddraft()
    {
        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $this->loadModel('ProjectMember');
        $toemails = json_decode($_POST['tovalues']);
        $ccemails = json_decode($_POST['ccvalues']);
        $bccemails = json_decode($_POST['bccvalues']);

        $isFileNotAttached = $this->request->getData('isFileNotAttached');
        $subject = $this->request->getData('subject');
        $body = $this->request->getData('body');

        $parentemail = $this->request->getData('parentemail');

        $forwardeid = $this->request->getData('forwardeid');
        $useremail = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $projectemail = $this->Projectemail->newEntity();
        if (!empty($parentemail)) {
            $projectemail->parentemail_id =  $parentemail;
        }
        if (!empty($forwardeid)) {
            $projectemail->forwarded_id =  $forwardeid;
            $projectemail->parentemail_id =  $forwardeid;
        }
        $projectemail->fromuser_id = $user_id;
        $projectemail->subject = $subject;
        $projectemail->body = $body;
        $projectemail->creation_date = Time::now();
        $projectemail->send_date = Time::now();
        $projectemail->isDraft = 1;
        $this->Projectemail->save($projectemail);
        if (!empty($toemails)) {
            foreach ($toemails as $email) {
                $this->loadModel('Touseremails');
                $touseremails = $this->Touseremails->newEntity();
                $touseremails->email_id = $projectemail->id;
                $touseremails->touser_id = $email;
                $this->Touseremails->save($touseremails);
            }
        }
        if (!empty($ccemails)) {
            foreach ($ccemails as $ccemail) {
                $this->loadModel('Projectccemails');
                $ccemails = $this->Projectccemails->newEntity();
                $ccemails->email_id = $projectemail->id;
                $ccemails->ccuser_id = $ccemail;
                $this->Projectccemails->save($ccemails);
            }
        }
        if (!empty($bccemails)) {
            foreach ($bccemails as $bccemail) {
                $this->loadModel('Projectbccemails');
                $bccemails = $this->Projectbccemails->newEntity();
                $bccemails->email_id = $projectemail->id;
                $bccemails->bccuser_id = $bccemail;
                $this->Projectbccemails->save($bccemails);
            }
        }
        if ($isFileNotAttached == 0) {
            $attachments = $this->request->getData()['file'];
            $this->loadModel('Emailfiles');
            foreach ($attachments as $attachment) {
                $emailfiles = $this->Emailfiles->newEntity();
                $emailfiles->email_id = $projectemail->id;
                if (!empty($parentemail)) {
                    $emailfiles->parentemail_id =  $parentemail;
                }
                $emailfiles->fromuser_id = $user_id;
                $emailfiles->filename = $attachment['name'];
                $emailfiles->type = $attachment['type'];
                $emailfiles->size = $attachment['size'];
                $emailfiles->filepath = "assets/emailfiles/" . $user_id . '/' . $projectemail['id'];
                $destinationFolder = WWW_ROOT . "assets/emailfiles/" .  $user_id . '/' . $projectemail['id'];
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($attachment['tmp_name'], $destinationFolder . DS . $attachment['name']);
                $this->Emailfiles->save($emailfiles);
            }
        }
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectemail));
    }

    public function draftMails()
    {

        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $draftMails = $this->Projectemail->find('all', [
            'conditions' => [
                'isDraft' => 1
            ]
        ])->toArray();
        $allusers = $this->User->find('all')->toArray();
        $this->set(compact('draftMails', 'allusers'));
    }





    /**Starred  Ajax Emails */

    public function starredemails()
    {
        $mid = $this->request->getData('mid');
        $controlsEnabled = intval($this->request->getData('controlsEnabled'));

        $starredEmails = $this->Projectemail->find('all', [
            'conditions' => [
                'id' => $mid
            ]
        ])->first();

        $starredEmails->isStarred = $controlsEnabled;
        $starredEmails = $this->Projectemail->save($starredEmails);
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($starredEmails));
    }


    //Update worklabel


    public function updateworklable()
    {
        $user_id = $this->Auth->user('id');
        $mid = $this->request->getData('mid');
        $worklable = $this->request->getData('lablename');
        $projectemail = $this->Projectemail->find('all', [
            'conditions' => [
                'id' => $mid
            ]
        ])->first();

        $projectemail->worklable = $worklable;
        $this->Projectemail->save($projectemail);
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectemail));
    }


    /**workEmails */
    public function workEmails()
    {
        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $projectemails = $this->Projectemail->find('all', [
            'conditions' => [
                'worklable' => 'W',
                'isDeleted' => false
            ]
        ])->toArray();
        $allusers = $this->User->find('all')->toArray();
        $this->set(compact('projectemails', 'allusers'));
    }
    public function personalEmails()
    {
        $this->loadModel('Projectemail');
        $this->loadModel('User');
        $projectemails = $this->Projectemail->find('all', [
            'conditions' => [
                'worklable' => 'P'
            ]
        ])->toArray();
        $allusers = $this->User->find('all')->toArray();
        $this->set(compact('projectemails', 'allusers'));
    }


    /**Delete email method */

    public function deleteEmail($mid = null)
    {

        $this->loadModel('Projectemail');
        $this->loadModel('User');
        if ($mid == null) {
            $mid = $this->request->getData('mid');
        }
        $touser = $this->Projectemail->find('all', [
            'conditions' => [
                'id' => $mid
            ]
        ])->first();
        $touser->isDeleted = 1;
        $this->Projectemail->save($touser);
        return $this->redirect([
            'controller' => 'projectemail',
            'action' => 'inbox',

        ]);
    }
    /**
     * View method
     *
     * @param string|null $id Projectemail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        /* $draft = null;
        if ($id == null) {
            $id =  $this->request->getQuery('eid');
            $draft = $this->request->getQuery('draft');
        } */
        $user_id = $this->Auth->user('id');
        $this->loadModel('Projectccemails');
        $this->loadModel('Projectbccemails');
        $allusers = $this->User->find('all')->toArray();


        $conditions = array(
            'and' => array(
                array(
                    'Projectemail.id in' =>  $id,
                ),
            )
        );

        $projectemail = $this->Projectemail->find('all', [
            'conditions' => $conditions
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies.Emailfiles',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Childmails.Emailfiles',
            'Childmails.FromUser',
            'Childmails.Tousers.User',
            'Childmails.Ccusers.User',
            'Childmails.Bccusers.User',
            'Forwardemails',
            'Forwardemails.FromUser',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'

        ])->first();
        $authprojectemail = $this->Projectemail->find('all', [
            'conditions' => ['Projectemail.id in' =>  $id]

        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies.Emailfiles',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Forwardemails',
            'Forwardemails.FromUser',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'
        ])->first();
        $allprojectemails = $this->Projectemail->find('all', [
            'isDeleted' => false
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies.Emailfiles',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Childmails.Emailfiles',
            'Childmails.FromUser',
            'Childmails.Tousers.User',
            'Childmails.Ccusers.User',
            'Childmails.Bccusers.User',
            'Forwardemails',
            'Forwardemails.FromUser',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'
        ])->toArray();
        $replyemails = $this->Projectemail->find('all', [
            'conditions' => [
                'parentemail_id is' => $id,

            ]
        ])->toArray();
        $forwardemails = $this->Projectemail->find('all', [
            'conditions' => [
                'Projectemail.id' => $id
            ]
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Forwardemails',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'
        ])->first();

        $this->loadModel('Emailfiles');
        $emailfiles =  $this->Emailfiles->find('all', [
            'conditions' => [
                'email_id' => $id
            ]
        ])->toArray();
        $this->set(compact('authprojectemail', 'projectemail', 'allusers', 'emailfiles', 'replyemails', 'forwardemails', 'allprojectemails', 'user_id'));
    }

    public function docreadyfunction()
    {

        $projectemail = $this->Projectemail->find('all')->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies.Emailfiles',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Forwardemails',
            'Forwardemails.FromUser',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'

        ])->toArray();

        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectemail));
    }

    public function viewmail()
    {
        $mailid = $this->request->getData('parentmailid');

        $conditions = array(
            'and' => array(
                array(
                    'Projectemail.id in' =>  $mailid,
                ),
            )
        );

        $projectemail = $this->Projectemail->find('all', [
            'conditions' => $conditions
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies.Emailfiles',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Forwardemails',
            'Forwardemails.FromUser',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'

        ])->first();

        $this->loadModel('User');
        $allUsers = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $finalarray = array($projectemail, $allUsers);


        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($finalarray));
    }


    public function viewforwardmail()
    {

        $mailid = $this->request->getData('forwardedid');

        $conditions = array(
            'and' => array(
                array(
                    'Projectemail.id in' =>  $mailid,
                ),
                //'parentemail_id is' => null,
                'Projectemail.isDeleted' => false,

            )
        );

        $projectemail = $this->Projectemail->find('all', [
            'conditions' => $conditions
        ])->contain([
            'FromUser',
            'Emailfiles',
            'Tousers',
            'Tousers.User',
            'Ccusers',
            'Ccusers.User',
            'Bccusers',
            'Bccusers.User',
            'Replies.Emailfiles',
            'Replies.FromUser',
            'Replies.Tousers.User',
            'Replies.Ccusers.User',
            'Replies.Bccusers.User',
            'Forwardemails',
            'Forwardemails.FromUser',
            'Forwardemails.Tousers.User',
            'Forwardemails.Ccusers.User',
            'Forwardemails.Bccusers.User'

        ])->first();

        $this->loadModel('User');
        $allUsers = $this->User->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $finalarray = array($projectemail, $allUsers);


        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($finalarray));
    }

    public function isreadInbox()
    {
        $user_id = $this->Auth->user('id');
        $mid = $this->request->getData('mid');
        $reademail =  $this->Projectemail->find('all', [
            'conditions' => [
                'isDeleted' => false,
                'id' => $mid
            ]
        ])->first();
        $reademail->isRead = true;
        $this->Projectemail->save($reademail);
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();
        $allemail = $this->Projectemail->find('all', [
            'conditions' => [
                'touser_email' => $authuser->email,
                'isDeleted' => 0,
                'isSent' => 1,
                'isRead' => true
            ]
        ])->toArray();
        $total = count($allemail);
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($total));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectemail = $this->Projectemail->newEntity();
        if ($this->request->is('post')) {
            $projectemail = $this->Projectemail->patchEntity($projectemail, $this->request->getData());
            if ($this->Projectemail->save($projectemail)) {
                $this->Flash->success(__('The projectemail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectemail could not be saved. Please, try again.'));
        }
        $this->set(compact('projectemail'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Projectemail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectemail = $this->Projectemail->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectemail = $this->Projectemail->patchEntity($projectemail, $this->request->getData());
            if ($this->Projectemail->save($projectemail)) {
                $this->Flash->success(__('The projectemail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectemail could not be saved. Please, try again.'));
        }
        $this->set(compact('projectemail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projectemail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectemail = $this->Projectemail->get($id);
        if ($this->Projectemail->delete($projectemail)) {
            $this->Flash->success(__('The projectemail has been deleted.'));
        } else {
            $this->Flash->error(__('The projectemail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //projectemail settings
    public function emailSettings($companyId = null)
    {

        $this->set(compact('companyId'));
    }
}
