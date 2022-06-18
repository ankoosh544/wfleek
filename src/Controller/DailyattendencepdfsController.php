<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Dailyattendencepdfs Controller
 *
 * @property \App\Model\Table\DailyattendencepdfsTable $Dailyattendencepdfs
 *
 * @method \App\Model\Entity\Dailyattendencepdf[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DailyattendencepdfsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies']
        ];
        $dailyattendencepdfs = $this->paginate($this->Dailyattendencepdfs);

        $this->set(compact('dailyattendencepdfs'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Dailyattendencepdf id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dailyattendencepdf = $this->Dailyattendencepdfs->get($id, [
            'contain' => ['Companies']
        ]);

        $this->set('dailyattendencepdf', $dailyattendencepdf);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dailyattendencepdf = $this->Dailyattendencepdfs->newEntity();
        if ($this->request->is('post')) {
            $dailyattendencepdf = $this->Dailyattendencepdfs->patchEntity($dailyattendencepdf, $this->request->getData());
            if ($this->Dailyattendencepdfs->save($dailyattendencepdf)) {
                $this->Flash->success(__('The dailyattendencepdf has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dailyattendencepdf could not be saved. Please, try again.'));
        }
        $companies = $this->Dailyattendencepdfs->Companies->find('list', ['limit' => 200]);
        $this->set(compact('dailyattendencepdf', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dailyattendencepdf id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dailyattendencepdf = $this->Dailyattendencepdfs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dailyattendencepdf = $this->Dailyattendencepdfs->patchEntity($dailyattendencepdf, $this->request->getData());
            if ($this->Dailyattendencepdfs->save($dailyattendencepdf)) {
                $this->Flash->success(__('The dailyattendencepdf has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dailyattendencepdf could not be saved. Please, try again.'));
        }
        $companies = $this->Dailyattendencepdfs->Companies->find('list', ['limit' => 200]);
        $this->set(compact('dailyattendencepdf', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dailyattendencepdf id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dailyattendencepdf = $this->Dailyattendencepdfs->get($id);
        if ($this->Dailyattendencepdfs->delete($dailyattendencepdf)) {
            $this->Flash->success(__('The dailyattendencepdf has been deleted.'));
        } else {
            $this->Flash->error(__('The dailyattendencepdf could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function downloadpdf($id=null){
        $fileinfo = $this->Dailyattendencepdfs->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $file = $fileinfo->filepath . DS . $fileinfo->filename;
        $response =  $this->response->withFile($file, [
            'download' => true,
            'name' => $fileinfo->filename,
        ]);

        return $response;

    }
}
