<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Touseremails Controller
 *
 * @property \App\Model\Table\TouseremailsTable $Touseremails
 *
 * @method \App\Model\Entity\Touseremail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TouseremailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projectemail', 'User']
        ];
        $touseremails = $this->paginate($this->Touseremails);

        $this->set(compact('touseremails'));
    }

    /**
     * View method
     *
     * @param string|null $id Touseremail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $touseremail = $this->Touseremails->get($id, [
            'contain' => ['Projectemail', 'User']
        ]);

        $this->set('touseremail', $touseremail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $touseremail = $this->Touseremails->newEntity();
        if ($this->request->is('post')) {
            $touseremail = $this->Touseremails->patchEntity($touseremail, $this->request->getData());
            if ($this->Touseremails->save($touseremail)) {
                $this->Flash->success(__('The touseremail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The touseremail could not be saved. Please, try again.'));
        }
        $projectemail = $this->Touseremails->Projectemail->find('list', ['limit' => 200]);
        $user = $this->Touseremails->User->find('list', ['limit' => 200]);
        $this->set(compact('touseremail', 'projectemail', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Touseremail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $touseremail = $this->Touseremails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $touseremail = $this->Touseremails->patchEntity($touseremail, $this->request->getData());
            if ($this->Touseremails->save($touseremail)) {
                $this->Flash->success(__('The touseremail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The touseremail could not be saved. Please, try again.'));
        }
        $projectemail = $this->Touseremails->Projectemail->find('list', ['limit' => 200]);
        $user = $this->Touseremails->User->find('list', ['limit' => 200]);
        $this->set(compact('touseremail', 'projectemail', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Touseremail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $touseremail = $this->Touseremails->get($id);
        if ($this->Touseremails->delete($touseremail)) {
            $this->Flash->success(__('The touseremail has been deleted.'));
        } else {
            $this->Flash->error(__('The touseremail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
