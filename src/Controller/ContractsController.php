<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;


use phpDocumentor\Reflection\Types\Null_;
use Cake\Mailer\Email;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Core\Configure;
use Cake\Dompdf\Dompdf;
use Twig\Template;


//use Cake\CakePdf\CakePdf;



/**
 * Contracts Controller
 *
 * @property \App\Model\Table\ContractsTable $Contracts
 *
 * @method \App\Model\Entity\Contract[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $contracts = $this->paginate($this->Contracts);

        $this->set(compact('contracts'));
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Auth->allow(['login', 'acceptance']);


    }

    public function isAuthorized($user)
    {
        return true;
    }

    /*pdfs*/


    public function downloadFile() {

        $this->loadModel('User');
        $this->loadModel('Taskgroups');
        $this->loadModel('Projecttasks');
        $this->loadModel('TaskgroupsProjecttasks');
        $this->loadModel('ProjectObject');
        $this->loadModel('Contracts');
        $this->loadModel('VersionsContract');
        $this->loadModel('ProjectMember');
        $user_id = $this->Auth->user('id');
        $pid = $this->request->getQuery('pid');
        $contract_id = $this->request->getQuery('contract_id');
        $manyObject = $this->TaskgroupsProjecttasks->find('all')->toArray();
        $groupoftask = $this->Taskgroups->find('all')->toArray();
        $projecttask = $this->Projecttasks->find('all',[
            'conditions' => [
                'project_id' => $pid
            ]
        ])->toArray();
        $version = null;
        $version = $this->VersionsContract->find('all', [
            'conditions' => [
                'contract_id' => $contract_id
            ]
        ])->toArray();
        $versionId = array();
        foreach ($version as $latest) {
            array_push($versionId, $latest['id']);
        }
        $latestversion = null;
        if (!empty($version)) {
            $contract = $this->VersionsContract->find('all', [
                'conditions' => [
                    'id' => max($versionId)
                ]
            ])->first();
        } else {
            $contract = $this->Contracts->find(
                'all',
                [
                    'conditions' => [
                        'id in' => $contract_id
                    ]
                ]
            )->first();
        }

           $data2 = $this->ProjectMember->find(
               'all',
               [
                   'conditions' => [
                       'memberId' => $user_id
                   ]
               ]
           )->first();


           $projectObject = $this->ProjectObject->find('all', [
               'condition' => [
                   'id' => $pid
               ]
           ])->first();
           $projectMember = $this->ProjectMember->find('all',
               [
                   'conditions' => [
                       'projectId' => $pid
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
        $this->ProjectObject->save($projectObject);
        $this->set(compact('data2','projectObject', 'manyObject', 'groupoftask', 'projecttask', 'contract', 'res'));
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
        $CakePdf->template('contract', 'default');
        $CakePdf->viewVars(['projectObject' => $projectObject, 'manyObject' => $manyObject, 'groupoftask' => $groupoftask, 'projecttask' => $projecttask, 'contract' => $contract, 'res' => $res,'projectMember' => $projectMember]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $this->autoRender = false;
        //download
        $response = $this->response;
        $response = $response->withStringBody($pdf);
        $response = $response->withType('pdf');
        $response = $response->withDownload('contract.pdf');
        return $response;
    }







    //sharecontract method


    public function sharecontract(){


        $this->loadModel('User');
        $user_id = $this->Auth->user('id');
        $allUsers = $this->User->find('all');

        $contract_id = $this->request->getQuery('contract_id');


        $this->loadModel('VersionsContract');
        $version = null;
        $latestversion = null;
        $version = $this->VersionsContract->find('all', [
            'conditions' => [
                    'contract_id' => $contract_id
                ]
            ])->first();
        if ($version != null) {
            $contract = $this->VersionsContract->find('all', [
                'conditions' => [
                    'id' =>  $version->id
                ]
            ])->first();
            $latestversion = $contract;

        }else{
            $contract = $this->Contracts->find('all', [
                'conditions' => [
                    'id in' =>  $contract_id
                ]
            ])->first();
        }



        $this->set(compact('latestversion','contract','allUsers','user_id'));

    }


    public function sendemailcontract(){
        $this->loadModel('Contracts');
        $toemails = json_decode($_POST['tovalues']);

        $subject = $this->request->getData('subject');
        $body = $this->request->getData('body');
        $contractId = $this->request->getData('contractId');
        $this->loadModel('VersionsContract');
        $version = $this->VersionsContract->find('all', [
            'conditions' => [
                'contract_id' => $contractId,
            ]
        ])->toArray();

        $versionId = array();
            foreach ($version as $latest) {
                array_push($versionId, $latest['id']);
            }
            $latestversion = null;
            if (!empty($version)) {
                $contract = $this->VersionsContract->find('all', [
                    'conditions' => [
                        'id' => max($versionId)
                    ]
                ])->first();
                $latestversion= $contract;
            }else{

                $contract = $this->Contracts->find(
                    'all',
                    [
                        'conditions' => [
                            'id in' => $contractId
                        ]
                    ]
                )->first();
            }

           // debug($contract);exit;
        $this->loadModel('User');
        $tousers = $this->User->find('all', [
            'conditions' => [
                'id in' => $toemails
            ]
        ])->toArray();

        foreach ($tousers as $user) {
                $email = new Email();
                $emailSent= $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
                ->setTo($user->email)
                ->setEmailFormat('html')
                ->setSubject($subject)
                ->setAttachments([
                    $contract->contract_filename => [
                        'file' =>   $contract->contract_filepath.'/'. $contract->contract_filename,
                        'mimetype' => 'pdf'
                    ]
                    ]);
                $email->send($body);
        }


        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($emailSent));
    }
    /**
     * View method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contract = $this->Contracts->get($id, [
            'contain' => ['Contractlines']
        ]);

        $this->set('contract', $contract);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contract = $this->Contracts->newEntity();
        if ($this->request->is('post')) {
            $contract = $this->Contracts->patchEntity($contract, $this->request->getData());
            if ($this->Contracts->save($contract)) {
                $this->Flash->success(__('The contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contract could not be saved. Please, try again.'));
        }
        $this->set(compact('contract'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contract = $this->Contracts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contract = $this->Contracts->patchEntity($contract, $this->request->getData());
            if ($this->Contracts->save($contract)) {
                $this->Flash->success(__('The contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contract could not be saved. Please, try again.'));
        }
        $this->set(compact('contract'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contract = $this->Contracts->get($id);
        if ($this->Contracts->delete($contract)) {
            $this->Flash->success(__('The contract has been deleted.'));
        } else {
            $this->Flash->error(__('The contract could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
