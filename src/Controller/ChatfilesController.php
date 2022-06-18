<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Chatfiles Controller
 *
 * @property \App\Model\Table\ChatfilesTable $Chatfiles
 *
 * @method \App\Model\Entity\Chatfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChatfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $chatfiles = $this->paginate($this->Chatfiles);

        $this->set(compact('chatfiles'));
    }
    public function isAuthorized($user){
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Chatfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatfile = $this->Chatfiles->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('chatfile', $chatfile);
    }


    public function uploadfiles()
    {
        $user_id = $this->Auth->user('id');

        $files = $this->request->getData()['file'];
        $touser_id = $this->request->getData('touser_id');

        //debug($files);exit;

       // debug($tid);


        foreach($files as $file) {
           // debug($file);exit;
           $chatfiles = $this->Chatfiles->newEntity();
            $chatfiles->user_id = $user_id;
            $chatfiles->touser_id = $touser_id;
            $chatfiles->filename = $file['name'];
            $chatfiles->type = $file['type'];
            $chatfiles->size = $file['size'];
            $chatfiles->creation_date = Time::now();
            //$projectObject->projectType = 'I';
            $chatfiles->filepath = "assets/chatfiles/" .  $user_id;
            $destinationFolder = WWW_ROOT . "assets/chatfiles/" .  $user_id;

           // debug($destinationFolder);exit;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }
            $result = $this->Chatfiles->save($chatfiles);
            move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
        }

        $updatedchatfiles= $this->Chatfiles->find('all',[
            'isDeleted' => false,
            'user_id' =>$user_id
        ])->contain(['User'])->order(['creation_date' => 'DESC'])->toArray();
       // debug($updatedchatfiles);exit;



       $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($updatedchatfiles));


        //debug($reult);exit;
    }




    public function downloadchatfile($fileid = null)
    {

        /* $fileid = $this->request->getData('fileId'); */
        $fileinfo = $this->Chatfiles->find('all', [
            'conditions' => [
                'id' => $fileid
            ]
        ])->first();
        //$file = WWW_ROOT . str_replace('/', '\\', $fileinfo->filepath . DS . $fileinfo->filename);

        $file = WWW_ROOT . $fileinfo->filepath . DS . $fileinfo->filename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

        return $response;


    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatfile = $this->Chatfiles->newEntity();
        if ($this->request->is('post')) {
            $chatfile = $this->Chatfiles->patchEntity($chatfile, $this->request->getData());
            if ($this->Chatfiles->save($chatfile)) {
                $this->Flash->success(__('The chatfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatfile could not be saved. Please, try again.'));
        }
        $users = $this->Chatfiles->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatfile', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chatfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatfile = $this->Chatfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatfile = $this->Chatfiles->patchEntity($chatfile, $this->request->getData());
            if ($this->Chatfiles->save($chatfile)) {
                $this->Flash->success(__('The chatfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chatfile could not be saved. Please, try again.'));
        }
        $users = $this->Chatfiles->Users->find('list', ['limit' => 200]);
        $this->set(compact('chatfile', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chatfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatfile = $this->Chatfiles->get($id);
        if ($this->Chatfiles->delete($chatfile)) {
            $this->Flash->success(__('The chatfile has been deleted.'));
        } else {
            $this->Flash->error(__('The chatfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
