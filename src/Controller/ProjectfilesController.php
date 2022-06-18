<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;
use Phinx\Db\Action\Action;

use Cake\Http\NotFoundException;

/**
 * Projectfiles Controller
 *
 * @property \App\Model\Table\ProjectfilesTable $Projectfiles
 *
 * @method \App\Model\Entity\Projectfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects']
        ];
        $projectfiles = $this->paginate($this->Projectfiles);

        $this->set(compact('projectfiles'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Projectfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectfile = $this->Projectfiles->get($id, [
            'contain' => ['Projects']
        ]);

        $this->set('projectfile', $projectfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectfile = $this->Projectfiles->newEntity();
        if ($this->request->is('post')) {
            $projectfile = $this->Projectfiles->patchEntity($projectfile, $this->request->getData());
            if ($this->Projectfiles->save($projectfile)) {
                $this->Flash->success(__('The projectfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectfile could not be saved. Please, try again.'));
        }
        $projects = $this->Projectfiles->Projects->find('list', ['limit' => 200]);
        $this->set(compact('projectfile', 'projects'));
    }

    /*Get files*/
    public function getfiles(){
        $this->loadModel('Projectfiles');
        $pid = $this->request->getData('pid');
        $projectfiles = $this->Projectfiles->find('all',[
            'conditions' => [
                'project_id' => $pid
            ]
        ])->toArray();

        $this->set(compact('projectfiles'));


    }
    /** delete file*/
    public function deletefile(){

        //$dummy = $this->request->getQuery('dummy');
       // debug($dummy);exit;

        $id = $this->request->getData('fid');
        $pid = $this->request->getData('pid');

        //debug($fileId);exit;

        $fileinfo = $this->Projectfiles->find('all',[
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $fileinfo ->isDeleted = true;
        $this->Projectfiles->save($fileinfo);


        $file = WWW_ROOT. str_replace('/', '\\', $fileinfo->filepath.DS.$fileinfo->filename);
        $result = unlink($file);

       $files = $this->Projectfiles->find('all',[
            'conditions' => [
                'Projectfiles.isDeleted' => false,
                'project_id' => $pid
            ]
        ])->contain(['User'])->toArray();

       // return $this->redirect(['controller' => 'projectfiles', 'action' => 'filemanager']);
       $this->autoRender = false;
       // send JSON response
       return $this->response->withType('application/json')->withStringBody(json_encode($files));



    }

    public function downloadfile()
    {
        //debug($id);exit;
        $fileid = $this->request->getQuery('fileid');
        $pid = $this->request->getQuery('pid');
        $dummy = $this->request->getQuery('dummy');
        $fileinfo = $this->Projectfiles->find('all',[
            'conditions' => [
                'id' => $fileid
            ]
        ])->first();

        $file = WWW_ROOT . $fileinfo->filepath . DS . $fileinfo->filename;

       //debug($file);exit;

        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

       return $response;

       if($dummy)
       {
       return $this->redirect(['controller' => 'projectfiles', 'action' => 'filemanager',$dummy ]);
       }
    }



    /** */
    public function fileData()
    {
        $this->loadModel('ProjectObject');
        $this->loadModel('Projectfiles');
        $pid = $this->request->getData('pid');
        $projectfiles = $this->Projectfiles->find('all', [
            'conditions' => [
                'project_id' => $pid,
                'Projectfiles.isDeleted' => false
            ]
        ])->contain('User')->toArray();
        //debug($projectfiles);exit;
        $this->set(compact('projectfiles'));
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($projectfiles));
    }

    /**allprojects */
    public function allprojects($type = null)
    {
        //debug($type);exit;
        $this->loadModel('Projectfiles');
        $pid = $this->request->getData('pid');
        $allprojectfiles = $this->Projectfiles->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();
        $this->set(compact('allprojectfiles'));
        return $this->redirect(['controller' => 'projectfiles', 'action' => 'filemanager']);
    }



    /**File Manager */
    public function filemanager($type = null)
    {
        $this->loadModel('ProjectObject');
        $this->loadModel('Projectfiles');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all', [
            'conditions' => [
                'id in' => $user_id
            ]
        ])->first();


        if ($type == 'I') {
            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'company_id' => $authuser->choosen_companyId,
                    'visibility' => 'I',
                    'IsFuturedProject' => false,
                    'isDeleted' => false
                ]
            ])->toArray();

            if (!empty($projectObjects)) {
                $companyprojectIds = array();
                foreach ($projectObjects as $project) {
                    array_push($companyprojectIds, $project->id);
                }

                $allprojectfiles = $this->Projectfiles->find('all', [
                    'conditions' => [
                        'project_id in' => $companyprojectIds,
                        'isDeleted' => false
                    ]
                ])->order(['creation_date' => 'DESC'])->toArray();
            }else{
                $allprojectfiles = null;

            }
            $this->set(compact('allprojectfiles', 'projectObjects', 'type'));
        } else {

            $projectObjects = $this->ProjectObject->find('all', [
                'conditions' => [
                    'company_id' => $authuser->choosen_companyId,
                    'visibility' => 'E',
                    'IsFuturedProject' => false,
                    'isDeleted' => false
                ]
            ])->toArray();

            if (!empty($projectObjects)) {
                $companyprojectIds = array();
                foreach ($projectObjects as $project) {
                    array_push($companyprojectIds, $project->id);
                }
                $allprojectfiles = $this->Projectfiles->find('all', [
                    'conditions' => [
                        'project_id in' => $companyprojectIds,
                        'isDeleted' => false
                    ]
                ])->order(['creation_date' => 'DESC'])->toArray();
            }else{
                $allprojectfiles = null;
            }
        $this->set(compact('allprojectfiles', 'projectObjects', 'type'));

    }
        $projecttype = $this->request->getData('projecttype');

        if ($projecttype != null) {
            $allprojectfiles = $this->Projectfiles->find('all',[
                'conditions' => [
                    'isDeleted' => false
                ]
            ])->order(['creation_date' => 'DESC'])->toArray();
            $this->set(compact('allprojectfiles'));
        }
    }



    /**showAllfiles */
    public function showAllfiles(){
        $allprojectfiles = $this->Projectfiles->find('all', [
            'conditions' => [
                'isDeleted' => false
            ]
        ]
        )->order(['creation_date' => 'DESC'])->toArray();
        $this->set(compact($allprojectfiles));
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($allprojectfiles));

    }

    /** */




    /**Upload files  */

    public function uploadfiles()
    {
        $user_id = $this->Auth->user('id');
        $files = $this->request->getData()['file'];
        $projectId = $this->request->getData('pid');
        $this->loadModel('ProjectObject');
        $projectObject = $this->ProjectObject->find('all', [
            'conditions' => [
                'id in' => $projectId
            ]
        ])->first();
        foreach ($files as $file) {
            $projectfiles = $this->Projectfiles->newEntity();
            $projectfiles->user_id = $user_id;
            $projectfiles->project_id = $projectId;
            $projectfiles->filename = $file['name'];
            $projectfiles->type = $file['type'];
            $projectfiles->size = $file['size'];
            $projectfiles->temp = $file['tmp_name'];
            $projectfiles->filepath = "assets/projectfiles/" .  $projectId;
            $destinationFolder = WWW_ROOT . "assets/projectfiles/" .  $projectId;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
            $result = $this->Projectfiles->save($projectfiles);
        }

        $allprojectfiles = $this->Projectfiles->find('all', [
            'conditions' => [
                'project_id' => $projectId,
                'Projectfiles.isDeleted' => false
            ]
        ])->contain('User')->order(['creation_date' => 'DESC'])->toArray();

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($allprojectfiles));

    }

    /**
     * Edit method
     *
     * @param string|null $id Projectfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectfile = $this->Projectfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectfile = $this->Projectfiles->patchEntity($projectfile, $this->request->getData());
            if ($this->Projectfiles->save($projectfile)) {
                $this->Flash->success(__('The projectfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectfile could not be saved. Please, try again.'));
        }
        $projects = $this->Projectfiles->Projects->find('list', ['limit' => 200]);
        $this->set(compact('projectfile', 'projects'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projectfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectfile = $this->Projectfiles->get($id);
        if ($this->Projectfiles->delete($projectfile)) {
            $this->Flash->success(__('The projectfile has been deleted.'));
        } else {
            $this->Flash->error(__('The projectfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
