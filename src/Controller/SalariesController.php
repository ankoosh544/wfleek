<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\I18n\Number;

/**
 * Salaries Controller
 *
 * @property \App\Model\Table\SalariesTable $Salaries
 *
 * @method \App\Model\Entity\Salary[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalariesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Companies']
        ];
        $salaries = $this->paginate($this->Salaries);

        $this->set(compact('salaries'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salary = $this->Salaries->get($id, [
            'contain' => ['Users', 'Companies']
        ]);

        $this->set('salary', $salary);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salary = $this->Salaries->newEntity();
        if ($this->request->is('post')) {
            $salary = $this->Salaries->patchEntity($salary, $this->request->getData());
            if ($this->Salaries->save($salary)) {
                $this->Flash->success(__('The salary has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }
        $users = $this->Salaries->Users->find('list', ['limit' => 200]);
        $companies = $this->Salaries->Companies->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'users', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salary = $this->Salaries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salary = $this->Salaries->patchEntity($salary, $this->request->getData());
            if ($this->Salaries->save($salary)) {
                $this->Flash->success(__('The salary has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }
        $users = $this->Salaries->Users->find('list', ['limit' => 200]);
        $companies = $this->Salaries->Companies->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'users', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salary = $this->Salaries->get($id);
        if ($this->Salaries->delete($salary)) {
            $this->Flash->success(__('The salary has been deleted.'));
        } else {
            $this->Flash->error(__('The salary could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function addsalary()
    {

        $userid = $this->request->getData('userid');
        $companyId = $this->request->getData('companyId');
        $net_salary = $this->request->getData('net_salary');
        $da = $this->request->getData('da');
        $hra = $this->request->getData('hra');
        $tds = $this->request->getData('tds');
        $esi = $this->request->getData('esi');
        $pf = $this->request->getData('pf');
        $tax = $this->request->getData('tax');
        $month = $this->request->getData('month');

        $salary = $this->Salaries->newEntity();
        $salary->user_id = $userid;
        $salary->company_id = $companyId;
        $salary->net_salary = $net_salary;
        $salary->hra = $hra;
        $salary->da = $da;
        $salary->tds = $tds;
        $salary->esi = $esi;
        $salary->pf = $pf;
        $salary->tax = $tax;
        $salary->month = $month;
        $salary->year =   $year = date("Y");
        $this->Salaries->save($salary);

        return $this->redirect(['controller' => 'companiesuser', 'action' => 'salary', $companyId]);
    }

    public function viewpayslip()
    {
        $userid = $this->request->getQuery('empid');
        $companyId = $this->request->getQuery('companyId');

        $employeepayslip = $this->Salaries->find('all', [
            'conditions' => [
                'Salaries.user_id' => $userid,
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Usercompanies'])->first();


        $this->loadModel('CompaniesUser');

        $employee = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.company_id' => $companyId,
                'CompaniesUser.user_id' => $userid
            ]
        ])->contain(['User', 'Usercompanies'])->first();


        //  debug($salary);exit;

        $this->set(compact('employeepayslip', 'employee'));
    }

    public function downloadpdf($id = null)
    {
        $employeepayslip = $this->Salaries->find('all', [
            'conditions' => [
                'Salaries.id in' => $id
            ]
        ])->contain(['User', 'Usercompanies'])->first();
        $this->loadModel('CompaniesUser');
        $employee = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id' => $employeepayslip->user_id,
                'CompaniesUser.company_id' => $employeepayslip->company_id
            ]
        ])->contain(['User', 'Usercompanies'])->first();
        //This is Engine for pdf
        Configure::write('CakePdf', [
            'engine' => [
                'className' => 'CakePdf.Dompdf',
                'options' => [
                    'isRemoteEnabled' => true
                ]
            ],
            'margin' => [
                'bottom' => 15,
                'left' => 50,
                'right' => 30,
                'top' => 45
            ],
            'orientation' => 'landscape',
            'download' => true
        ]);
        //This is cakepdf code for pdf
        $CakePdf = new \CakePdf\Pdf\CakePdf();
        $CakePdf->template('payslip', 'default');
        $CakePdf->viewVars(['employeepayslip' => $employeepayslip, 'employee' => $employee]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $this->autoRender = false;
        //download
        $response = $this->response;
        $response = $response->withStringBody($pdf);
        $response = $response->withType('pdf');
        $response = $response->withDownload('payslip.pdf');
        return $response;
    }


    public function downloadcsv($id= null){
        $employeepayslip = $this->Salaries->find('all', [
            'conditions' => [
                'Salaries.id in' => $id
            ]
        ])->contain(['User', 'Usercompanies'])->first();
        $this->loadModel('CompaniesUser');
        $employee = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.user_id' => $employeepayslip->user_id,
                'CompaniesUser.company_id' => $employeepayslip->company_id
            ]
        ])->contain(['User', 'Usercompanies'])->first();


        $csvString = "";

        $csvString .= 'Payslip for the month of ' . $employeepayslip->month . ', ' . $employeepayslip->year .

            ',Company Name' . $employeepayslip->usercompany->name .
            ',Address:' . $employeepayslip->usercompany->address .
            ',Country:' . $employeepayslip->usercompany->country . ',State' . $employeepayslip->usercompany->state . ', Postal Code: ' . $employeepayslip->usercompany->postal_code .
            ',Payslip #' . $employeepayslip->id .

            ',Salary Month: ' . $employeepayslip->month . ' ,' . $employeepayslip->year .
            ',EmployeeFirst Name' . $employeepayslip->user->firstname . 'Employee LastName ' . $employeepayslip->user->lastname ;

        if ($employee->member_role == 'Y') {
            $csvString .=     'Administrator';
        } elseif ($employee->member_role == 'X') {
            $csvString .=   'Developer';
        } elseif ($employee->member_role == 'Z') {
            $csvString .=   'Project Manager';
        } elseif ($employee->member_role == 'H') {
            $csvString .=  'HR';
        } elseif ($employee->member_role == 'C') {
            $csvString .=  'Customer';
        }

        $csvString .=   'Employee ID: ' . $employeepayslip->user->id .
            'Joining Date: ' . $employeepayslip->user->registrationDate .
            'Basic Salary'  . Number::currency($employeepayslip->net_salary, 'EUR', ['locale' => 'it_IT']) .
            'HRA' . $employeepayslip->hra .
            'TDS' . $employeepayslip->tds .
            'PF' . $employeepayslip->pf .
            'Tax' . $employeepayslip->tax .
        $response = $this->response;

        // Inject string content into response body (3.4.0.)
        $response = $response->withStringBody($csvString);

        $response = $response->withType('csv');

        // Optionally force file download
        $response = $response->withDownload('payslip.csv');

        // Return response object to prevent controller from trying to render
        // a view.
        return $response;
    }

    public function filtersalaryemps(){

        $this->loadModel('CompaniesUser');

        $empid = $this->request->getData('empid');
        $empname = $this->request->getData('name');
        $role = $this->request->getData('role');
        $joindate = $this->request->getData('joindate');
        $companyId = $this->request->getData('companyId');

        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain('User')->toArray();


        if (!empty($empid) || !empty($empname) || !empty($role) || !empty($joindate) || !empty($companyId)) {
            $matchedemps = array();
            foreach ($companymembers as $member) {
                if (!empty($empid)) {
                    if ($empid == $member->user->id) {
                        array_push($matchedemps, $member);
                    }
                }
                if (!empty($empname)) {
                    if ((preg_match("/{$empname}/i", $member->user->firstname)) || (preg_match("/{$empname}/i", $member->user->lastname))) {

                        array_push(
                            $matchedemps,
                            $member
                        );
                    }
                }
                if (!empty($role)) {
                    if ($role == $member->member_role) {
                        array_push($matchedemps, $member);
                    }
                }
                if (!empty($joindate)) {
                    if ($joindate == $member->user->registrationDate) {
                        array_push(
                            $matchedemps,
                            $member
                        );
                    }
                }
            }
        }



        $this->set(compact('companyId','matchedemps'));

    }

    public function payroll($companyId = null){

    }

    public function salarySettings($companyId = null){

        $this->set(compact('companyId'));

    }
}
