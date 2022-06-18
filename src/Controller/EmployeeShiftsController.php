<?php
namespace App\Controller;
use Cake\I18n\Time;

use App\Controller\AppController;

/**
 * EmployeeShifts Controller
 *
 * @property \App\Model\Table\EmployeeShiftsTable $EmployeeShifts
 *
 * @method \App\Model\Entity\EmployeeShift[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeShiftsController extends AppController
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
        $employeeShifts = $this->paginate($this->EmployeeShifts);

        $this->set(compact('employeeShifts'));
    }
    public function isAuthorized() {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Employee Shift id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeShift = $this->EmployeeShifts->get($id, [
            'contain' => ['Companies']
        ]);

        $this->set('employeeShift', $employeeShift);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeShift = $this->EmployeeShifts->newEntity();
        if ($this->request->is('post')) {
            $employeeShift = $this->EmployeeShifts->patchEntity($employeeShift, $this->request->getData());
            if ($this->EmployeeShifts->save($employeeShift)) {
                $this->Flash->success(__('The employee shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee shift could not be saved. Please, try again.'));
        }
        $companies = $this->EmployeeShifts->Companies->find('list', ['limit' => 200]);
        $this->set(compact('employeeShift', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Shift id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeShift = $this->EmployeeShifts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeShift = $this->EmployeeShifts->patchEntity($employeeShift, $this->request->getData());
            if ($this->EmployeeShifts->save($employeeShift)) {
                $this->Flash->success(__('The employee shift has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee shift could not be saved. Please, try again.'));
        }
        $companies = $this->EmployeeShifts->Companies->find('list', ['limit' => 200]);
        $this->set(compact('employeeShift', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Shift id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeShift = $this->EmployeeShifts->get($id);
        if ($this->EmployeeShifts->delete($employeeShift)) {
            $this->Flash->success(__('The employee shift has been deleted.'));
        } else {
            $this->Flash->error(__('The employee shift could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function shifts($companyId = null){
        $this->loadModel('Departments');
        $departments = $this->Departments->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain([
            'Companiesuser.Designations',
            'Companiesuser.User'
        ])->toArray();

        $shifts = $this->EmployeeShifts->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain('RepeateShifts')->toArray();


        $this->set(compact('companyId', 'shifts', 'departments'));

    }

    public function addShift(){
        $companyId = $this->request->getData('companyId');
        $shift_name = $this->request->getData('shift_name');
        $starttime = $this->request->getData('starttime');
        $starttime = Time::createFromFormat(
            'd/m/Y H:i:s',
            $starttime,
            'Europe/Paris'
        );
        $endtime = $this->request->getData('endtime');
        $endtime = Time::createFromFormat(
            'd/m/Y H:i:s',
            $endtime,
            'Europe/Paris'
        );

        $repeate = $this->request->getData('repeate');
        $note = $this->request->getData('note');

        $employeeShift = $this->EmployeeShifts->newEntity();
        $employeeShift->company_id = $companyId;
        $employeeShift->name = $shift_name;
        $employeeShift->start_time = $starttime;



        $employeeShift->end_time = $endtime;
        $employeeShift->isRepeated = $this->request->getData('repeate') === null ? false : true;
        $employeeShift->isIndefinite = $this->request->getData('indefinitetime') === null ? false : true;
        $employeeShift->note = $note;
        $this->EmployeeShifts->save($employeeShift);

        if($employeeShift->isRepeated == true){
            $repeateweeks = $this->request->getData('repeateweeks');
            $daynames = $this->request->getData()['dayname'];
            $shift_enddate = $this->request->getData('shift_enddate');
            for ($i = 0; $i < count($daynames); $i++) {
                $this->loadModel('RepeateShifts');
                $repeateShift = $this->RepeateShifts->newEntity();
                $repeateShift->shift_id = $employeeShift->id;
                $repeateShift->weeks_of_repeat = $repeateweeks;
                $repeateShift->dayname = $daynames[$i];
                $repeateShift->endof_repeating_shift =  $shift_enddate;
                $this->RepeateShifts->save($repeateShift);
            }
        }
        $this->Flash->success(__('Il turno è creato !'));
        return $this->redirect(['action' => 'shifts', $companyId]);

    }
    public function filteremployees(){
        $this->loadModel('CompaniesUser');
        $departmentId = $this->request->getData('departmentId');
        $companyId = $this->request->getData('companyId');


        $departmentemployees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId,
                'department_id' => $departmentId
            ]
        ])->contain([
            'User',
           'Usercompanies'
        ])->toArray();
        //debug($departmentemployees);exit;
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($departmentemployees));
    }
}
