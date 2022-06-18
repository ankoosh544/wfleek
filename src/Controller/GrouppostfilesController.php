<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Grouppostfiles Controller
 *
 * @property \App\Model\Table\GrouppostfilesTable $Grouppostfiles
 *
 * @method \App\Model\Entity\Grouppostfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GrouppostfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups', 'Groupposts']
        ];
        $grouppostfiles = $this->paginate($this->Grouppostfiles);

        $this->set(compact('grouppostfiles'));
    }

    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Grouppostfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grouppostfile = $this->Grouppostfiles->get($id, [
            'contain' => ['Groups', 'Groupposts']
        ]);

        $this->set('grouppostfile', $grouppostfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $grouppostfile = $this->Grouppostfiles->newEntity();
        if ($this->request->is('post')) {
            $grouppostfile = $this->Grouppostfiles->patchEntity($grouppostfile, $this->request->getData());
            if ($this->Grouppostfiles->save($grouppostfile)) {
                $this->Flash->success(__('The grouppostfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grouppostfile could not be saved. Please, try again.'));
        }
        $groups = $this->Grouppostfiles->Groups->find('list', ['limit' => 200]);
        $groupposts = $this->Grouppostfiles->Groupposts->find('list', ['limit' => 200]);
        $this->set(compact('grouppostfile', 'groups', 'groupposts'));
    }


    public function uploadfile(){
        $this->loadModel('Groups');

        $user_id = $this->Auth->user('id');
        $group_id = $this->request->getData('groupId');
        $group = $this->Groups->find('all',[
            'conditions' => [
                'id in' => $group_id
            ]
        ])->first();
        $files = $this->request->getData()['images'];

        foreach ($files as $file) {


            if (!empty($file['tmp_name'])) {
                $grouppostfile = $this->Grouppostfiles->newEntity();
                $grouppostfile->group_id = $group_id;
                $grouppostfile->user_id = $user_id;
                $grouppostfile->grouppost_id = null;
                $grouppostfile->filename = $file['name'];
                $grouppostfile->filepath = "assets/groupfiles/" .  $group_id;
                $grouppostfile->size = $file['size'];
                $grouppostfile->type = $file['type'];

                $destinationFolder = WWW_ROOT . "assets/groupfiles/" .  $group_id;
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                move_uploaded_file($file['tmp_name'], $destinationFolder . DS . $file['name']);
                $this->Grouppostfiles->save($grouppostfile);
            }
        }

        return $this->redirect(['controller' => 'groups','action' => 'files', $group_id]);

    }


    public function downloadfile($id = null){
        $fileinfo = $this->Grouppostfiles->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();

        //debug($fileinfo);exit;
        $file = $fileinfo->filepath . DS . $fileinfo->filename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);
        return $response;
    }

    public function deletefile(){

        $fileId = $this->request->getQuery('fileId');
        $group_id = $this->request->getQuery('groupId');

        $deletefile = $this->Grouppostfiles->find('all',[
            'conditions' => [
                'id in' => $fileId,
                'isDeleted' => false
            ]
        ])->first();

        $deletefile->isDeleted = true;

        $this->Grouppostfiles->save($deletefile);

        return $this->redirect(['controller' => 'groups','action' => 'files', $group_id]);

    }

    /**
     * Edit method
     *
     * @param string|null $id Grouppostfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grouppostfile = $this->Grouppostfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grouppostfile = $this->Grouppostfiles->patchEntity($grouppostfile, $this->request->getData());
            if ($this->Grouppostfiles->save($grouppostfile)) {
                $this->Flash->success(__('The grouppostfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grouppostfile could not be saved. Please, try again.'));
        }
        $groups = $this->Grouppostfiles->Groups->find('list', ['limit' => 200]);
        $groupposts = $this->Grouppostfiles->Groupposts->find('list', ['limit' => 200]);
        $this->set(compact('grouppostfile', 'groups', 'groupposts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grouppostfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grouppostfile = $this->Grouppostfiles->get($id);
        if ($this->Grouppostfiles->delete($grouppostfile)) {
            $this->Flash->success(__('The grouppostfile has been deleted.'));
        } else {
            $this->Flash->error(__('The grouppostfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function imagefiles(){
       $group_id = $this->request->getData('groupId');

       $imagefiles = $this->Grouppostfiles->find('all',[
           'conditions' => [
               'group_id' => $group_id,
               'type is in' =>['image/jpeg', 'image/png']
           ]
       ])->toArray();

       debug($imagefiles);exit;




    }

    public function documentfiles(){
        $group_id = $this->request->getData('groupId');

        debug($group_id);exit;

    }
}
