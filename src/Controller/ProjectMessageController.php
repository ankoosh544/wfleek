<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;


/**
 * ProjectMessage Controller
 *
 * @property \App\Model\Table\ProjectMessageTable $ProjectMessage
 *
 * @method \App\Model\Entity\ProjectMessage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectMessageController extends AppController
{
    public function isAuthorized($user){
        return true;
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
   /*  public function add($page = null)
    {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $idProject = $this->request->getData('idProject');
            $idSenderFather = $this->request->getData('idSender');
            $subMessage = $this->request->getData('subMessage');
            $createDateFather = $this->request->getData('createDate');
            //echo json_encode($subMessage); die();

            if ($this->request->getData('textPost') == "") {
                $this->Flash->error(__('Devi inserire un testo per il commento'));
                //return ;//$this->redirect(['action' => 'projectObject/view/'.$projectId]);
                echo json_encode('No text'); die();
            }

            if (!empty($idProject)) {


                $connection = ConnectionManager::get('default');

                $connection->begin();

                $projectMessage = $this->ProjectMessage->newEntity();
                $projectMessage->projectId = $idProject;
                $projectMessage->senderId = $this->Auth->user('id');
                $projectMessage->createDate = date('Y-m-d G:i:s');
                $projectMessage->text = $this->request->getData('textPost');
                $projectMessage->langId = 'iT'; //modificare l'it e andare avanti con l'add


                if ($subMessage == "true") {
                    $projectInfo = $this->ProjectMessage->find('all', [
                        'conditions' => [
                            'projectId' => $idProject,
                            'senderId' => $idSenderFather,
                            'createDate' => $createDateFather
                        ]
                    ])->toArray();
                    //echo json_encode($createDateFather); die();
                    $projectMessage->fatherProjectId = $idProject;
                    $projectMessage->fatherSenderId = $idSenderFather;
                    $projectMessage->fatherCreateDate = $projectInfo[0]['createDate'];

                    $projectMessage->referenceProjectId = $projectInfo[0]['referenceProjectId'];
                    $projectMessage->referenceSenderId = $projectInfo[0]['referenceSenderId'];
                    $projectMessage->referenceCreateDate = $projectInfo[0]['referenceCreateDate'];

                    $projectMessage->level = $projectInfo[0]['level'] + 1;

                } else {
                    $projectMessage->referenceProjectId = $projectMessage->projectId;
                    $projectMessage->referenceSenderId = $projectMessage->senderId;
                    $projectMessage->referenceCreateDate = $projectMessage->createDate;
                }

                $firstSave = $this->ProjectMessage->save($projectMessage);

                $this->loadModel('ProjectMessageAttachment');




                if (!empty($_FILES['postAttachment']['name'])){

                    $this->loadModel('FileObject');

                    $eventAttachment = $_FILES['postAttachment'];



                    $fileObject = $this->FileObject->newEntity();
                    $dateTemp = $projectMessage->createDate;


                    $dateTempQuery = $this->FileObject->find('all',[
                        'conditions' => [
                            'marker' => $dateTemp
                        ]
                    ])->orderDesc('cnt')->first();

                    if (!empty($dateTempQuery)){
                        $fileObject->marker = $dateTemp;
                        $fileObject->cnt = $dateTempQuery->cnt +1 ;

                    }else {
                        $fileObject->marker = $dateTemp;
                        $fileObject->cnt = 0;
                    }

                    $fileObject->ownerId = $this->Auth->user('id');
                    $fileObject->originalFileName = $eventAttachment['name'];
                    $fileObject->displayFileName = $eventAttachment['name'];


                    $fileObject->storeFileName = $fileObject->marker . '-USER=' . $this->Auth->user('id') .
                                                 '-PROJECTID=' . $idProject .'-SENDERID=' . $this->Auth->user('id') .
                                                 '-CREATEDATE=' . $fileObject->marker . '-FILECNT=' . $fileObject->cnt;

                    $fileObject->storePath = WWW_ROOT . 'resources' . DS . 'attachments' . DS . 'projects_attachments';

                    //$upload = $this->loadComponent('FileUtility');


                    $extensionFile = '.' . pathinfo($eventAttachment['name'], PATHINFO_EXTENSION);
                    $fileObject->codeExt = $extensionFile;
                    $target_file = WWW_ROOT . 'resources' . DS . 'attachments' . DS . 'projects_attachments' . DS . $fileObject->storeFileName . $extensionFile;

                    $uploadedFile = $upload->uploadFile($target_file, $eventAttachment);

                    $secondSave = $this->FileObject->save($fileObject);

                    $projectMessageAttachment = $this->ProjectMessageAttachment->newEntity();
                    $projectMessageAttachment->projectId = $idProject;
                    $projectMessageAttachment->senderId = $this->Auth->user('id');
                    $projectMessageAttachment->createDate = $dateTemp;
                    $projectMessageAttachment->fileMarker = $dateTemp;
                    $projectMessageAttachment->fileCnt = $fileObject->cnt;
                    $projectMessageAttachment->iconId = 1;

                    $thirdSave = $this->ProjectMessageAttachment->save($projectMessageAttachment);


                    if ($firstSave==true && $secondSave == true && $uploadedFile==true && $thirdSave==true){
                        $this->autoRender = false;
                        $connection->commit();
                        echo json_encode($success = true);

                    }else{
                        $this->autoRender = false;
                        $connection->rollback();
                        echo json_encode($success = false);
                    }

                } else if ($firstSave) {
                        $this->autoRender = false;
                        $connection->commit();
                        echo json_encode($success = true);

                } else {
                    $this->autoRender = false;
                    $connection->rollback();
                    echo json_encode($success = false);
                }

            } else {
                $this->autoRender = false;
                echo json_encode($success=false);
            }
        }else{
            //echo json_encode($_FILES); die();
            if ($this->request->getData('textPost') == "") {
                $this->Flash->error(__('Devi inserire un testo per il commento'));
                return $this->redirect(['action' => 'view/'.$projectId, 'controller' => 'ProjectObject']);
            }
            $idProject = $this->request->getData('idProject');

            if (!empty($idProject)) {

                $connection = ConnectionManager::get('default');

                $connection->begin();

                $projectMessage = $this->ProjectMessage->newEntity();
                $projectMessage->projectId = $idProject;
                $projectMessage->senderId = $this->Auth->user('id');
                $projectMessage->createDate = date('Y-m-d G:i:s');
                $projectMessage->text = $this->request->getData('textPost');
                $projectMessage->langId = 'iT'; //modificare l'it e andare avanti con l'add

                $projectMessage->referenceProjectId = $projectMessage->projectId;
                $projectMessage->referenceSenderId = $projectMessage->senderId;
                $projectMessage->referenceCreateDate = $projectMessage->createDate;

                $firstSave = $this->ProjectMessage->save($projectMessage);


                //echo json_encode($_FILES);
                //echo json_encode($firstSave);
                if (!empty($_FILES['postAttachment']['name'])){

                    $this->loadModel('FileObject');
                    $this->loadModel('ProjectMessageAttachment');

                    $eventAttachment = $_FILES['postAttachment'];



                    $fileObject = $this->FileObject->newEntity();
                    $dateTemp = $projectMessage->createDate;


                    $dateTempQuery = $this->FileObject->find('all',[
                        'conditions' => [
                            'marker' => $dateTemp
                        ]
                    ])->orderDesc('cnt')->first();

                    if (!empty($dateTempQuery)){
                        $fileObject->marker = $dateTemp;
                        $fileObject->cnt = $dateTempQuery->cnt +1 ;

                    }else {
                        $fileObject->marker = $dateTemp;
                        $fileObject->cnt = 0;
                    }

                    $fileObject->ownerId = $this->Auth->user('id');
                    $fileObject->originalFileName = $eventAttachment['name'];
                    $fileObject->displayFileName = $eventAttachment['name'];


                    $fileObject->storeFileName = str_replace(":", "_", str_replace(" ", "", $fileObject->marker)) . '-USER=' . $this->Auth->user('id') .
                                                 '-PROJECTID=' . $idProject .'-SENDERID=' . $this->Auth->user('id') .
                                                 '-CREATEDATE=' . str_replace(":", "_", str_replace(" ", "", $fileObject->marker)) . '-FILECNT=' . $fileObject->cnt;

                    $fileObject->storePath = WWW_ROOT . 'resources' . DS . 'attachments' . DS . 'projects_attachments';

                    //$upload = $this->loadComponent('FileUtility');


                    $extensionFile = '.' . pathinfo($eventAttachment['name'], PATHINFO_EXTENSION);
                    $fileObject->codeExt = $extensionFile;
                    $target_file = WWW_ROOT . 'resources' . DS . 'attachments' . DS . 'projects_attachments' . DS . $fileObject->storeFileName . $extensionFile;

                    $uploadedFile = $upload->uploadFile($target_file, $eventAttachment);

                    $secondSave = $this->FileObject->save($fileObject);

                    $projectMessageAttachment = $this->ProjectMessageAttachment->newEntity();
                    $projectMessageAttachment->projectId = $idProject;
                    $projectMessageAttachment->senderId = $this->Auth->user('id');
                    $projectMessageAttachment->createDate = $dateTemp;
                    $projectMessageAttachment->fileMarker = $dateTemp;
                    $projectMessageAttachment->fileCnt = $fileObject->cnt;
                    $projectMessageAttachment->iconId = 1;

                    $thirdSave = $this->ProjectMessageAttachment->save($projectMessageAttachment);


                    if ($firstSave==true && $secondSave == true && $uploadedFile==true && $thirdSave==true){
                        $this->autoRender = false;
                        $connection->commit();
                        if ($page == 'view') {
                            $page .= '/' . $idProject;
                        }
                        return $this->redirect(['action' => $page, 'controller' => 'ProjectObject']);
                        //echo json_encode($success = true);

                    }else{
                        $this->autoRender = false;
                        $connection->rollback();
                        if ($page == 'view') {
                            $page .= '/' . $idProject;
                        }
                        return $this->redirect(['action' => $page, 'controller' => 'ProjectObject']);
                        //echo json_encode($success = false);
                    }

                }else if ($firstSave) {
                        $this->autoRender = false;
                        $connection->commit();
                        if ($page == 'view') {
                            $page .= '/' . $idProject;
                        }
                        return $this->redirect(['action' => $page, 'controller' => 'ProjectObject']);
                        //echo json_encode($success = true);

                } else {
                    $this->autoRender = false;
                    $connection->rollback();
                    if ($page == 'view') {
                        $page .= '/' . $idProject;
                    }
                    return $this->redirect(['action' => $page, 'controller' => 'ProjectObject']);
                    //echo json_encode($success = false);
                }

            }

        }
    } */

    public function getMessages() {

        $this->autoRender = false;
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectMessageAttachment');


        if ($this->request->is('ajax')) {


            $fromPage = $this->request->getData('fromPage');

            if ($fromPage == 'GOview') {
                $projectId = $this->request->getData('idProject');

                $queryProject = $this->ProjectMessage->find('all', [
                    'join' => [
                        'table' => 'user',
                        'alias' => 'u',
                        'type' => 'inner',
                        'conditions' => ['u.id = ProjectMessage.senderId',
                                        'ProjectMessage.projectId = ' . $projectId,
                                        "ProjectMessage.level" => 0
                        ]
                    ],
                ])
                ->select($this->ProjectMessage)
                ->select(['u.id', 'u.firstname', 'u.lastname'])
                ->order('createDate')->limit(50)/*->page($page)*/->toArray();

                foreach ($queryProject as $qg) {
                    $queryTMP = $this->ProjectMessage->find('all', [
                        'join' => [
                            'table' => 'user',
                            'alias' => 'u',
                            'type' => 'inner',
                            'conditions' => [
                                'u.id = ProjectMessage.senderId'
                            ]
                        ],
                        'conditions' => [
                            'referenceProjectId' => $qg->toArray()['projectId'],
                            'referenceSenderId' => $qg->toArray()['senderId'],
                            'referenceCreateDate' => $qg->toArray()['createDate'],
                            'ProjectMessage.level > 0'
                        ]
                    ])
                    ->select($this->ProjectMessage)
                    ->select(['u.id', 'u.firstname', 'u.lastname'])
                    ->order('ProjectMessage.createDate');

                    $attachment = $this->ProjectMessageAttachment->find('all', [
                        'join' => [
                            'table' => 'file_object',
                            'alias' => 'fo',
                            'type' => 'inner',
                            'conditions' => [
                                'fo.marker = ProjectMessageAttachment.fileMarker AND fo.cnt = ProjectMessageAttachment.fileCnt'
                            ]
                        ],
                        'conditions' => [
                            'ProjectMessageAttachment.projectId' => $qg->toArray()['projectId'],
                            'ProjectMessageAttachment.senderId' => $qg->toArray()['senderId'],
                            'ProjectMessageAttachment.createDate' => $qg->toArray()['createDate'],

                        ]
                    ])
                    ->select($this->ProjectMessageAttachment)
                    ->select(['fo.displayFileName', 'fo.storePath', 'fo.storeFileName', 'fo.codeExt'])
                    ->toArray();

                    if(count($attachment) != 0) {
                        //echo json_encode($attachment[0]['fo']['storePath']);
                        $attachment[0]['fo']['storePath'] = str_replace("\\", "/", $attachment[0]['fo']['storePath']);
                        //echo json_encode($attachment[0]['fo']['storePath']);
                    }
                    $qg->attachment = $attachment;
                    $qg->responses = $queryTMP;
                }


            } else if ($fromPage == 'GOindex') {

                $projectstmp = $this->ProjectMember->find('all', [
                    'conditions' => [
                        'memberId' => $this->Auth->user('id')
                    ]
                ])
                ->select('ProjectMember.projectId')->toArray();

                $projects = ['none'];
                for ($i = 0; $i < count($projectstmp); $i++) {
                    array_push($projects, $projectstmp[$i]['projectId']);
                }

                //echo json_encode($projects); die();

                $queryProject = $this->ProjectMessage->find('all', [
                    'join' => [[
                        'table' => 'user',
                        'alias' => 'u',
                        'type' => 'inner',
                        'conditions' => ['u.id = ProjectMessage.senderId',
                                        'ProjectMessage.projectId IN ' => ($projects)
                        ]
                    ],
                    /*'join' => */[
                        'table' =>'project_object',
                        'alias' => 'go',
                        'type' => 'inner',
                        'conditions' => ['go.id = ProjectMessage.projectId']
                    ]]
                ])
                ->select($this->ProjectMessage)
                ->select(['u.id', 'u.firstname', 'u.lastname', 'go.name'])
                ->order('ProjectMessage.createDate')->limit(50)/*->page($page)*/->toArray();

                foreach ($queryProject as $qg) {
                    $queryTMP = $this->ProjectMessage->find('all', [
                        'join' => [
                            'table' => 'user',
                            'alias' => 'u',
                            'type' => 'inner',
                            'conditions' => [
                                'u.id = ProjectMessage.senderId'
                            ]
                        ],
                        'conditions' => [
                            'referenceProjectId' => $qg->toArray()['projectId'],
                            'referenceSenderId' => $qg->toArray()['senderId'],
                            'referenceCreateDate' => $qg->toArray()['createDate'],
                            'ProjectMessage.level > 0'
                        ]
                    ])
                    ->select($this->ProjectMessage)
                    ->select(['u.id', 'u.firstname', 'u.lastname'])
                    ->order('ProjectMessage.createDate');

                    $favorite = 0;

                    $attachment = $this->ProjectMessageAttachment->find('all', [
                        'join' => [
                            'table' => 'file_object',
                            'alias' => 'fo',
                            'type' => 'inner',
                            'conditions' => [
                                'fo.marker = ProjectMessageAttachment.fileMarker AND fo.cnt = ProjectMessageAttachment.fileCnt'
                            ]
                        ],
                        'conditions' => [
                            'ProjectMessageAttachment.projectId' => $qg->toArray()['projectId'],
                            'ProjectMessageAttachment.senderId' => $qg->toArray()['senderId'],
                            'ProjectMessageAttachment.createDate' => $qg->toArray()['createDate'],
                        ]
                    ])
                    ->select($this->ProjectMessageAttachment)
                    ->select(['fo.displayFileName', 'fo.storePath', 'fo.storeFileName', 'fo.codeExt'])
                    ->toArray();

                    if(count($attachment) != 0) {
                        str_replace('\\', '/', $attachment[0]['fo']['storePath']);
                    }

                    $qg->attachment = $attachment;
                    $qg->responses = $queryTMP;
                    $qg->favorite = $favorite;

                }

            }



            $resultJ = json_encode($queryProject);
            $this->response->withType('json');
            $this->response->body($resultJ);

            return $this->response;

            //echo json_encode($queryProject);

        }



    }

    public function likeComment() {

    }

    public function downloadFile($fileMarker = null, $fileCnt = null){
        if(empty($fileMarker) || $fileCnt == null){
            $this->Flash->error(__('Some null parameters'));
            return $this->redirect(['action' => 'index']);
        }
        //$this->loadComponent('FileUtility');
        $this->loadModel('FileObject');
        //$result = $this->FileUtility->downloadFile($filePath, $desktopObject->displayName.".".strtolower(pathinfo($filePath, PATHINFO_EXTENSION)));

        $attach = $this->FileObject->find('all', [
            'conditions' => [
                'marker = "' . $fileMarker . '" AND cnt = ' . $fileCnt
            ]
        ])->toArray();

        //debug($attach); die();

        //$filePath = WWW_ROOT.'desktop_objects'.DS.$this->Auth->user('id').DS.str_replace('/', DS, $desktopObject->note);
        $filePath = $attach[0]['storePath'] . '/' . $attach[0]['storeFileName'] . $attach[0]['codeExt'];
        //$this->loadComponent('FileUtility');
        $result = $this->FileUtility->downloadFile($filePath, 'projectobject'.".".strtolower(pathinfo($filePath, PATHINFO_EXTENSION)));

        //$result = $this->FileUtility->downloadFile($path, 'projectimage'.".".strtolower(pathinfo($path, PATHINFO_EXTENSION)));
        if(!$result){
            $this->Flash->error(__('File not found. Result null'));
            return $this->redirect(['action' => 'index']);
        }
        return $result;
    }

}
