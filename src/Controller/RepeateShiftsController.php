<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RepeateShifts Controller
 *
 * @property \App\Model\Table\RepeateShiftsTable $RepeateShifts
 *
 * @method \App\Model\Entity\RepeateShift[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RepeateShiftsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Shifts']
        ];
        $repeateShifts = $this->paginate($this->RepeateShifts);

        $this->set(compact('repeateShifts'));
    }

    /**
     * View method
     *
     * @param string|null $id Repeate Shift id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $repeateShift = $this->RepeateShifts->get($id, [
            'contain' => ['Shifts']
        ]);

        $this->set('repeateShift', $repeateShift);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $repeateShift = $this->RepeateShifts->newEntity();
        if ($this->request->is('post')) {
            $repeateShift = $this->RepeateShifts->patchEntity($repeateShift, $this->request->getData());
            if ($this->RepeateShifts->save($repeateShift)) {
                $this->Flash->success(__('The repeate shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The repeate shift could not be saved. Please, try again.'));
        }
        $shifts = $this->RepeateShifts->Shifts->find('list', ['limit' => 200]);
        $this->set(compact('repeateShift', 'shifts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Repeate Shift id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $repeateShift = $this->RepeateShifts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $repeateShift = $this->RepeateShifts->patchEntity($repeateShift, $this->request->getData());
            if ($this->RepeateShifts->save($repeateShift)) {
                $this->Flash->success(__('The repeate shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The repeate shift could not be saved. Please, try again.'));
        }
        $shifts = $this->RepeateShifts->Shifts->find('list', ['limit' => 200]);
        $this->set(compact('repeateShift', 'shifts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Repeate Shift id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $repeateShift = $this->RepeateShifts->get($id);
        if ($this->RepeateShifts->delete($repeateShift)) {
            $this->Flash->success(__('The repeate shift has been deleted.'));
        } else {
            $this->Flash->error(__('The repeate shift could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
