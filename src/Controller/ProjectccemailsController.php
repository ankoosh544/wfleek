<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projectccemails Controller
 *
 * @property \App\Model\Table\ProjectccemailsTable $Projectccemails
 *
 * @method \App\Model\Entity\Projectccemail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectccemailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Emails', 'Ccemails']
        ];
        $projectccemails = $this->paginate($this->Projectccemails);

        $this->set(compact('projectccemails'));
    }

    /**
     * View method
     *
     * @param string|null $id Projectccemail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectccemail = $this->Projectccemails->get($id, [
            'contain' => ['Emails', 'Ccemails']
        ]);

        $this->set('projectccemail', $projectccemail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectccemail = $this->Projectccemails->newEntity();
        if ($this->request->is('post')) {
            $projectccemail = $this->Projectccemails->patchEntity($projectccemail, $this->request->getData());
            if ($this->Projectccemails->save($projectccemail)) {
                $this->Flash->success(__('The projectccemail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectccemail could not be saved. Please, try again.'));
        }
        $emails = $this->Projectccemails->Emails->find('list', ['limit' => 200]);
        $ccemails = $this->Projectccemails->Ccemails->find('list', ['limit' => 200]);
        $this->set(compact('projectccemail', 'emails', 'ccemails'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Projectccemail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectccemail = $this->Projectccemails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectccemail = $this->Projectccemails->patchEntity($projectccemail, $this->request->getData());
            if ($this->Projectccemails->save($projectccemail)) {
                $this->Flash->success(__('The projectccemail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projectccemail could not be saved. Please, try again.'));
        }
        $emails = $this->Projectccemails->Emails->find('list', ['limit' => 200]);
        $ccemails = $this->Projectccemails->Ccemails->find('list', ['limit' => 200]);
        $this->set(compact('projectccemail', 'emails', 'ccemails'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projectccemail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectccemail = $this->Projectccemails->get($id);
        if ($this->Projectccemails->delete($projectccemail)) {
            $this->Flash->success(__('The projectccemail has been deleted.'));
        } else {
            $this->Flash->error(__('The projectccemail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
