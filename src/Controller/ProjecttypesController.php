<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projecttypes Controller
 *
 * @property \App\Model\Table\ProjecttypesTable $Projecttypes
 *
 * @method \App\Model\Entity\Projecttype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjecttypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $projecttypes = $this->paginate($this->Projecttypes);

        $this->set(compact('projecttypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Projecttype id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projecttype = $this->Projecttypes->get($id, [
            'contain' => []
        ]);

        $this->set('projecttype', $projecttype);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projecttype = $this->Projecttypes->newEntity();
        if ($this->request->is('post')) {
            $projecttype = $this->Projecttypes->patchEntity($projecttype, $this->request->getData());
            if ($this->Projecttypes->save($projecttype)) {
                $this->Flash->success(__('The projecttype has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projecttype could not be saved. Please, try again.'));
        }
        $this->set(compact('projecttype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Projecttype id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projecttype = $this->Projecttypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projecttype = $this->Projecttypes->patchEntity($projecttype, $this->request->getData());
            if ($this->Projecttypes->save($projecttype)) {
                $this->Flash->success(__('The projecttype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The projecttype could not be saved. Please, try again.'));
        }
        $this->set(compact('projecttype'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Projecttype id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projecttype = $this->Projecttypes->get($id);
        if ($this->Projecttypes->delete($projecttype)) {
            $this->Flash->success(__('The projecttype has been deleted.'));
        } else {
            $this->Flash->error(__('The projecttype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
