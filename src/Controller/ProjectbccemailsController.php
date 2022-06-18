<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projectbccemails Controller
 *
 * @property \App\Model\Table\ProjectbccemailsTable $Projectbccemails
 *
 * @method \App\Model\Entity\Projectbccemail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectbccemailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Emails', 'Bccusers']
        ];
        $projectbccemails = $this->paginate($this->Projectbccemails);

        $this->set(compact('projectbccemails'));
    }

    /**
     * View method
     *
     * @param string|null $id Projectbccemail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectbccemail = $this->Projectbccemails->get($id, [
            'contain' => ['Emails', 'Bccusers']
        ]);

        $this->set('projectbccemail', $projectbccemail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectbccemail = $this->Projectbccemails->newEntity();
        if ($this->request->is('post')) {
            $projectbccemail = $this->Projectbccemails->patchEntity($projectbccemail, $this->request->getData());
            if ($this->Projectbccemails->save($projectbccemail)) {
                $this->Flash->success(__('The projectbccemail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectbccemail could not be saved. Please, try again.'));
        }
        $emails = $this->Projectbccemails->Emails->find('list', ['limit' => 200]);
        $bccusers = $this->Projectbccemails->Bccusers->find('list', ['limit' => 200]);
        $this->set(compact('projectbccemail', 'emails', 'bccusers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Projectbccemail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectbccemail = $this->Projectbccemails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectbccemail = $this->Projectbccemails->patchEntity($projectbccemail, $this->request->getData());
            if ($this->Projectbccemails->save($projectbccemail)) {
                $this->Flash->success(__('The projectbccemail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectbccemail could not be saved. Please, try again.'));
        }
        $emails = $this->Projectbccemails->Emails->find('list', ['limit' => 200]);
        $bccusers = $this->Projectbccemails->Bccusers->find('list', ['limit' => 200]);
        $this->set(compact('projectbccemail', 'emails', 'bccusers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projectbccemail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectbccemail = $this->Projectbccemails->get($id);
        if ($this->Projectbccemails->delete($projectbccemail)) {
            $this->Flash->success(__('The projectbccemail has been deleted.'));
        } else {
            $this->Flash->error(__('The projectbccemail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
