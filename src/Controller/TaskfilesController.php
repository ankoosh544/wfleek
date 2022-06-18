<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Taskfiles Controller
 *
 * @property \App\Model\Table\TaskfilesTable $Taskfiles
 *
 * @method \App\Model\Entity\Taskfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TaskfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $taskfiles = $this->paginate($this->Taskfiles);

        $this->set(compact('taskfiles'));
    }
    public function isAuthorized($user){
        return true;
    }




    public function uploadfiles()
    {
        $user_id = $this->Auth->user('id');

        $files = $this->request->getData()['file'];
        $tid = $this->request->getData('tid');

       // debug($tid);

        $projectId = $this->request->getData('pid');
        foreach($files as $file) {
            $taskfiles = $this->Taskfiles->newEntity();
           // debug($file);exit;
            $taskfiles->tid = $tid;
            $taskfiles->user_id = $user_id;
            $taskfiles->pid = $projectId;
            $taskfiles->filename = $file['name'];
            $taskfiles->type = $file['type'];
            $taskfiles->size = $file['size'];
            $taskfiles->creation_date = Time::now();
            //$projectObject->projectType = 'I';
            $taskfiles->filepath = "assets/taskfiles/" .  $tid;

            $destinationFolder = WWW_ROOT . "assets/taskfiles/" .  $tid;
           // debug($destinationFolder);exit;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);

            $result = $this->Taskfiles->save($taskfiles);
        }

        $updatedtaskfile= $this->Taskfiles->find('all',[
            'isDeleted' => false,
            'tid' => $tid
        ])->contain('User')->order(['creation_date' => 'DESC'])->toArray();

       $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($updatedtaskfile));


        //debug($reult);exit;


    }


    public function downloadtaskfile($fileid = null)
    {
        //debug($id);exit;

        /* $fileid = $this->request->getData('fileId'); */
        $fileinfo = $this->Taskfiles->find('all',[
            'conditions' => [
                'id' => $fileid
            ]
        ])->first();
        $file = WWW_ROOT. str_replace('/', '\\', $fileinfo->filepath.DS.$fileinfo->filename);

        //debug($fileinfo->filename);exit;

        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

       return $response;


}


    /**
     * View method
     *
     * @param string|null $id Taskfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $taskfile = $this->Taskfiles->get($id, [
            'contain' => []
        ]);

        $this->set('taskfile', $taskfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taskfile = $this->Taskfiles->newEntity();
        if ($this->request->is('post')) {
            $taskfile = $this->Taskfiles->patchEntity($taskfile, $this->request->getData());
            if ($this->Taskfiles->save($taskfile)) {
                $this->Flash->success(__('The taskfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskfile could not be saved. Please, try again.'));
        }
        $this->set(compact('taskfile'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Taskfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $taskfile = $this->Taskfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $taskfile = $this->Taskfiles->patchEntity($taskfile, $this->request->getData());
            if ($this->Taskfiles->save($taskfile)) {
                $this->Flash->success(__('The taskfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The taskfile could not be saved. Please, try again.'));
        }
        $this->set(compact('taskfile'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Taskfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $taskfile = $this->Taskfiles->get($id);
        if ($this->Taskfiles->delete($taskfile)) {
            $this->Flash->success(__('The taskfile has been deleted.'));
        } else {
            $this->Flash->error(__('The taskfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
