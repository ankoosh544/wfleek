<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Emailfiles Controller
 *
 * @property \App\Model\Table\EmailfilesTable $Emailfiles
 *
 * @method \App\Model\Entity\Emailfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projectemail', 'Fromusers', 'Tousers']
        ];
        $emailfiles = $this->paginate($this->Emailfiles);

        $this->set(compact('emailfiles'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Emailfile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailfile = $this->Emailfiles->get($id, [
            'contain' => ['Projectemail', 'Fromusers', 'Tousers']
        ]);

        $this->set('emailfile', $emailfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailfile = $this->Emailfiles->newEntity();
        if ($this->request->is('post')) {
            $emailfile = $this->Emailfiles->patchEntity($emailfile, $this->request->getData());
            if ($this->Emailfiles->save($emailfile)) {
                $this->Flash->success(__('The emailfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emailfile could not be saved. Please, try again.'));
        }
        $projectemail = $this->Emailfiles->Projectemail->find('list', ['limit' => 200]);
        $fromusers = $this->Emailfiles->Fromusers->find('list', ['limit' => 200]);
        $tousers = $this->Emailfiles->Tousers->find('list', ['limit' => 200]);
        $this->set(compact('emailfile', 'projectemail', 'fromusers', 'tousers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Emailfile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailfile = $this->Emailfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailfile = $this->Emailfiles->patchEntity($emailfile, $this->request->getData());
            if ($this->Emailfiles->save($emailfile)) {
                $this->Flash->success(__('The emailfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emailfile could not be saved. Please, try again.'));
        }
        $projectemail = $this->Emailfiles->Projectemail->find('list', ['limit' => 200]);
        $fromusers = $this->Emailfiles->Fromusers->find('list', ['limit' => 200]);
        $tousers = $this->Emailfiles->Tousers->find('list', ['limit' => 200]);
        $this->set(compact('emailfile', 'projectemail', 'fromusers', 'tousers'));
    }
    public function deletefile()
    {

        $fid = $this->request->getData('fid');
        $eid = $this->request->getData('eid');
        $deletefile =  $this->Emailfiles->find('all', [
            'conditions' => [
                'id in' => $fid
            ]
        ])->first();
        //debug($deletefile);
        $this->Emailfiles->delete($deletefile);

        $allemailfiles = $this->Emailfiles->find('all', [
            'conditions' => [
                'email_id' => $eid
            ]
        ])->toArray();
       // debug($allemailfiles);
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($allemailfiles));
    }

    /**
     * Delete method
     *
     * @param string|null $id Emailfile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete', 'get']);
        $emailfile = $this->Emailfiles->get($id);
        if ($this->Emailfiles->delete($emailfile)) {
            $this->Flash->success(__('The emailfile has been deleted.'));
        } else {
            $this->Flash->error(__('The emailfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
