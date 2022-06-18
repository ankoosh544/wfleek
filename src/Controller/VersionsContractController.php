<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Core\Configure;

/**
 * VersionsContract Controller
 *
 * @property \App\Model\Table\VersionsContractTable $VersionsContract
 *
 * @method \App\Model\Entity\VersionsContract[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VersionsContractController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProjectObjects', 'Contracts']
        ];
        $versionsContract = $this->paginate($this->VersionsContract);

        $this->set(compact('versionsContract'));
    }
    public function isAuthorized($user)
    {
        return true;
    }


    /**
     * View method
     *
     * @param string|null $id Versions Contract id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $this->loadModel('User');
        $this->loadModel('Taskgroups');
        $this->loadModel('Projecttasks');
        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('ProjectObject');
        $this->loadModel('Contracts');
        $this->loadModel('VersionsContract');
        $version = $this->VersionsContract->find('all',[
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $user_id = $this->Auth->User('id');
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
        $groupoftask = $this->Taskgroups->find('all')->toArray();


        //Thi is for pid from Summaryupdate method

            $projecttask = $this->Projecttasks->find('all', [
                'conditions' => [
                    'project_id' => $version->project_object_id
                ]
            ])->toArray();



            $this->loadModel('ProjectMember');
            $data2 = $this->ProjectMember->find(
                'all',
                [
                    'conditions' => [
                        'memberId' => $user_id
                    ]
                ]
            )->first();
            $projectObject = $this->ProjectObject->find('all', [
                'conditions' => [
                    'id' => $version->project_object_id
                ]
            ])->first();
            $projectMember = $this->ProjectMember->find(
                'all',
                [
                    'conditions' => [
                        'projectId' => $version->project_object_id
                    ]
                ]
            )->toArray();
            $userid = array();
            foreach ($projectMember as $item) {
                array_push($userid, $item['memberId']);
            }
            $res = $this->User->find('all', [
                'conditions' => [
                    'id in' => $userid
                ]
            ])->toArray();
            $this->set(compact('res', 'data2', 'projectObject', 'manyObject', 'groupoftask', 'projecttask', 'version', 'projectMember'));

    }

    /**Create New Version */
    public function createVersion()
    {
        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('Taskgroups');
        $this->loadModel('Projecttasks');
        $this->loadModel('ProjectMember');
        $this->loadModel('User');
        $this->loadModel('Contracts');
        $this->loadModel('ProjectObject');
        $this->loadModel('VersionsContract');

        $user_id = $this->Auth->user('id');
        $pid = $this->request->getQuery('projectId');
        $cid = $this->request->getQuery('contractId');

        $projectObject =  $this->ProjectObject->find('all', [
            'conditions' => [
                'ProjectObject.id in' => $pid
            ]
        ])->contain([
            'Contracts' => function ($q) {
                return $q->where([
                    'acceptance_date is not' => null
                ])->order([
                    'creation_date' => 'DESC'
                ]);
            },
            'Contracts.Versions'=> function ($q) {
                return $q->where([
                    'acceptance_date is not' => null
                ])->order([
                    'creation_date' => 'DESC'
                ]);
            },
            'Projecttypes',
            'Projectfiles',
            'Projecttasks' => function ($q) {
                return $q->where([
                    'Projecttasks.isDeleted' => false
                ]);
            },
            'Projectmembers.User',
            'Taskgroups.Projecttasks' => function ($q) {
                return $q->where([
                    'Projecttasks.isDeleted' => false
                ]);
            },
        ])->first();
        $content = $this->request->getData('content');



        if (empty($projectObject->contracts[0]->versions)) {
            $version = $this->VersionsContract->newEntity();
            $version->project_object_id = $pid;
            $version->contract_id = $cid;
            $version->title = $projectObject->contracts[0]->title;
            $version->description =$projectObject->contracts[0]->description;

            $version->content = $content;
            $version->creation_date = Time::now();
          //  $version->contract_filepath =  $destinationFolder;
         //   $version->contract_filename = $file;
            $version->acceptance_date = null;
            $version->price = $projectObject->contracts[0]->price;
            $version->tax = $projectObject->contracts[0]->tax;
            $version->total_workinghrs = $projectObject->contracts[0]->total_workinghrs;
            $this->VersionsContract->save($version);
        }else{

            $version = $this->VersionsContract->newEntity();
            $version->project_object_id = $pid;
            $version->contract_id = $cid;
            $version->title = $projectObject->contracts[0]->versions[0]->title;
            $version->description =$projectObject->contracts[0]->versions[0]->description;

            $version->content = $content;
            $version->creation_date = Time::now();
          //  $version->contract_filepath =  $destinationFolder;
         //   $version->contract_filename = $file;
            $version->acceptance_date = null;
            $version->price = $projectObject->contracts[0]->versions[0]->price;
            $version->tax = $projectObject->contracts[0]->versions[0]->tax;
            $version->total_workinghrs = $projectObject->contracts[0]->versions[0]->total_workinghrs;
            $this->VersionsContract->save($version);
        }

          //This is Engine for pdf
          Configure::write('CakePdf', [
            'engine' => [
                'className' => 'CakePdf.Dompdf',
                'options' => [
                    'isRemoteEnabled' => true
                ]
            ],
            'margin' => [
                'bottom' => 15,
                'left' => 50,
                'right' => 30,
                'top' => 45
            ],
            'orientation' => 'landscape',
            'download' => true
        ]);

        //This is cakepdf code for pdf
        $CakePdf = new \CakePdf\Pdf\CakePdf();
        $CakePdf->template('contractversion', 'default');
        $CakePdf->viewVars(['projectObject' => $projectObject, 'content' => $content, 'version' => $version,]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $destinationFolder = WWW_ROOT . "assets" . DS . "contractversionpdfs" . DS . "project_" .  $pid;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder);
        }
        $file = "contract_user_" . $user_id . "_project_" . $pid . "_contract_" . $cid . ".pdf";
        $filename = $destinationFolder . DS . "contract_user_" . $user_id . "_project_" . $pid . ".pdf";
        file_put_contents($filename, $pdf);





       /*  $names = ' ';
        foreach ($res as $item) {
            $names .=   $item->firstname . ' ';
        } */

        $customers = $this->ProjectMember->find('all', [
            'conditions' => [
                'type' => 'C'
            ]
        ])->toArray();

        $customerid = array();
        foreach ($customers as $customer) {
            array_push($customerid, $customer['memberId']);
        }
        $users = $this->User->find('all', [
            'conditions' => [
                'id in' => $customerid
            ]
        ])->toArray();
        foreach ($users as $user) {

            $protocol = Configure::read('Protocol');
            $domain = Configure::read('Domain');
            $port = Configure::read('Port');
            if ($port == 80) {
                $port = "";
            } else {
                $port = ":" . $port;
            }
            $link = $protocol . '://' . $domain . $port;

            $email = new Email();
            $emailSent =    $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo('ankoosh.sk@gmail.com')
                //->setTo($user->email)
                ->setEmailFormat('html')
                ->setSubject('New Version of Contract')
                ->setTemplate('contract_version', 'default')
                ->setAttachments([
                    'contractsummary.pdf' => [
                        'file' =>   $filename,
                        'mimetype' => 'pdf'
                    ]
                ])
                ->setViewVars(['protocol' => $protocol, 'domain' =>  $domain, 'port' => $port,  'projectObject' => $projectObject, 'user' => $user,'version' => $version]);
            $email->send();

            if ($emailSent) {
                $this->Flash->success(__('E-mail sent.'));
            } else {
                $this->Flash->error(__('Error message'));
            }
        }

        return $this->redirect([
            'controller' => 'projectObject',
            'action' => 'contractsummary',
            'projectId' => $pid

        ]);
    }

    public function downloadfile($id= null){

        $fileinfo = $this->VersionsContract->find('all',[
            'conditions' => [
                'id' => $id
            ]
        ])->first();

        $file = $fileinfo->contract_filepath . DS . $fileinfo->contract_filename;
        debug($file);exit;

        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);


        return $response;

    }

    public function updatetitle(){
       $title = $this->request->getData('title');
       $description = $this->request->getData('description');
       $versionId = $this->request->getData('versionId');
     $version = $this->VersionsContract->find('all',[
           'conditions' => [
               'id in' => $versionId
           ]
       ])->first();
       $version->title = $title;
       $version->description = $description;
       $this->VersionsContract->save($version);

       return $this->redirect(['controller' => 'projectobject','action' => 'contractsummary',$version->project_object_id]);

    }

    /**Contract Version Acceptancy method */


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $versionsContract = $this->VersionsContract->newEntity();
        if ($this->request->is('post')) {
            $versionsContract = $this->VersionsContract->patchEntity($versionsContract, $this->request->getData());
            if ($this->VersionsContract->save($versionsContract)) {
                $this->Flash->success(__('The versions contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The versions contract could not be saved. Please, try again.'));
        }
        $projectObjects = $this->VersionsContract->ProjectObjects->find('list', ['limit' => 200]);
        $contracts = $this->VersionsContract->Contracts->find('list', ['limit' => 200]);
        $this->set(compact('versionsContract', 'projectObjects', 'contracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Versions Contract id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $versionsContract = $this->VersionsContract->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $versionsContract = $this->VersionsContract->patchEntity($versionsContract, $this->request->getData());
            if ($this->VersionsContract->save($versionsContract)) {
                $this->Flash->success(__('The versions contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The versions contract could not be saved. Please, try again.'));
        }
        $projectObjects = $this->VersionsContract->ProjectObjects->find('list', ['limit' => 200]);
        $contracts = $this->VersionsContract->Contracts->find('list', ['limit' => 200]);
        $this->set(compact('versionsContract', 'projectObjects', 'contracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Versions Contract id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $versionsContract = $this->VersionsContract->get($id);
        if ($this->VersionsContract->delete($versionsContract)) {
            $this->Flash->success(__('The versions contract has been deleted.'));
        } else {
            $this->Flash->error(__('The versions contract could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
