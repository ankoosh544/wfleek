<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;
use DateTime;
use Cake\Dompdf\DomPdf;

/**
 * Workinghours Controller
 *
 * @property \App\Model\Table\WorkinghoursTable $Workinghours
 *
 * @method \App\Model\Entity\Workinghour[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkinghoursController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $workinghours = $this->paginate($this->Workinghours);

        $this->set(compact('workinghours'));
    }


    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Workinghour id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workinghour = $this->Workinghours->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('workinghour', $workinghour);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workinghour = $this->Workinghours->newEntity();
        if ($this->request->is('post')) {
            $workinghour = $this->Workinghours->patchEntity($workinghour, $this->request->getData());
            if ($this->Workinghours->save($workinghour)) {
                $this->Flash->success(__('The workinghour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The workinghour could not be saved. Please, try again.'));
        }
        $users = $this->Workinghours->Users->find('list', ['limit' => 200]);
        $this->set(compact('workinghour', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Workinghour id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workinghour = $this->Workinghours->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workinghour = $this->Workinghours->patchEntity($workinghour, $this->request->getData());
            if ($this->Workinghours->save($workinghour)) {
                $this->Flash->success(__('The workinghour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The workinghour could not be saved. Please, try again.'));
        }
        $users = $this->Workinghours->Users->find('list', ['limit' => 200]);
        $this->set(compact('workinghour', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Workinghour id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $deletetimesheet = $this->Workinghours->find('all', [
            'conditions' => [
                'id in' => $id
            ]
        ])->first();
        $this->Workinghours->delete($deletetimesheet);


        return $this->redirect(['action' => 'attendance']);
    }

    public function attendance()
    {

        $user_id = $this->request->getQuery('emp_id');

        $companyId = $this->request->getQuery('company_id');



        $attendances = $this->Workinghours->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $companyId
            ]
        ])->contain(['Users'])->order(['start_time' => 'ASC'])->toArray();
        $checkpunchoutemp = $this->Workinghours->find('all', [
            'conditions' => [
                'user_id' => $user_id,
                'company_id' =>  $companyId,
                'end_time is' => null
            ]
        ])->toArray();

        if(!empty($attendances)){
            $todayactivity = array();
            $description = "";
            $todayhrs = 0;
            $weeklyhrs = 0;
            $monthlyhrs = 0;


            foreach ($attendances as $attendance) {
                if (strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) == strtotime(Time::now()->i18nFormat('yyyy-MM-dd'))) {
                    array_push($todayactivity, $attendance);
                    $description = $description . $attendance->description;
                    if ($attendance->end_time != null) {
                        $diff = strtotime($attendance->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));


                        $todayhrs =$todayhrs + round($diff / (60 * 60), 2);
                    } else {
                        $diff = strtotime(Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                        $todayhrs =$todayhrs + round($diff / (60 * 60), 2);
                    }

                }

                if (strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) >= strtotime(Time::now()->modify('-7 days')->i18nFormat('yyyy-MM-dd')) && strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) <= strtotime(Time::now()->i18nFormat('yyyy-MM-dd'))) {
                    if ($attendance->end_time != null) {
                        $diff = strtotime($attendance->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                        $weeklyhrs = $weeklyhrs + round($diff / (60 * 60), 2);
                    } else {
                        $diff = strtotime(Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                        $weeklyhrs = $weeklyhrs + round($diff / (60 * 60), 2);
                    }


                }

                if (strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) >= strtotime(Time::now()->modify('-30 days')->i18nFormat('yyyy-MM-dd')) && strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) <= strtotime(Time::now()->i18nFormat('yyyy-MM-dd'))) {
                    if ($attendance->end_time != null) {
                        $diff = strtotime($attendance->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                        $monthlyhrs = $monthlyhrs + round($diff / (60 * 60), 2);
                    } else {
                        $diff = strtotime(Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                        $monthlyhrs =  $monthlyhrs + round($diff / (60 * 60), 2);
                    }
                }
            }
        } else {
            $todayactivity = null;
            $todayhrs = 0;
            $weeklyhrs = 0;
            $monthlyhrs = 0;
        }






        $this->set(compact('checkpunchoutemp','attendances', 'user_id', 'companyId', 'todayactivity', 'weeklyhrs', 'monthlyhrs', 'todayhrs', 'description'));
    }

    public function updatetimesheet()
    {
        $timesheetId = $this->request->getData('timesheetId');
        $userId = $this->request->getData('userId');
        $companyId = $this->request->getData('companyId');

        $updatetime = $this->Workinghours->find('all', [
            'conditions' => [
                'id in' => $timesheetId
            ]
        ])->first();

        $punchintime = $this->request->getData('punchintime');
        if (!empty($punchintime)) {
            $punchintime = Time::createFromFormat(
                'd/m/Y H:i:s',
                $punchintime,
                'Europe/Paris'
            );
            $updatetime->start_time = $punchintime;
        }
        $punchouttime =  $this->request->getData('punchouttime');

        if (!empty($punchouttime)) {

            $punchouttime = Time::createFromFormat(
                'd/m/Y H:i:s',
                $punchouttime,
                'Europe/Paris'
            );
            $updatetime->end_time = $punchouttime;
        }

        $this->Workinghours->save($updatetime);

        return $this->redirect([
            'controller' => 'workinghours',
            'action' => 'attendance',
            'emp_id' => $userId,
            'company_id' => $companyId
        ]);
    }


    public function searchattendance()
    {
        $user_id = $this->request->getData('user_id');
        $companyId = $this->request->getData('companyId');

        $workinghrsdata =  $this->Workinghours->find('all', [
            'conditions' => [
                'Workinghours.company_id in' => $companyId,
                'Workinghours.user_id in' => $user_id
            ]
        ])->contain(['Users', 'Usercompanies'])->toArray();

        $date = null;
        $month = null;
        // $year = null;


        $date = $this->request->getData('date');
        if ($date != null) {
            $date = Time::createFromFormat(
                'd/m/Y',
                $date,
                'Europe/Paris'
            );
        }

        /* $year = date('Y', strtotime($date));
        $month = date('m',strtotime($date)); */

        $month = $this->request->getData('month');
        $year = $this->request->getData('year');
        $matched_data = array();
        foreach ($workinghrsdata as $workinguser) {
            if ($date != null) {
                if ($date == $workinguser->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome')) {
                    array_push(
                        $matched_data,
                        $workinguser
                    );
                }
            }
            if ($month != null) {
                if ($month == $workinguser->start_time->i18nFormat('MM', 'Europe/Rome')) {
                    array_push(
                        $matched_data,
                        $workinguser
                    );
                }
            }

            if ($year != null) {
                if ($year == $workinguser->start_time->i18nFormat('yy', 'Europe/Rome')) {
                    array_push(
                        $matched_data,
                        $workinguser
                    );
                }
            }
        }

        $this->set(compact('matched_data', 'user_id', 'companyId'));
    }

    public function employeeattendences($companyId = null)
    {

        $this->loadModel('Dailyattendencepdfs');
        $dateValue = Time::now();
        $first_day_this_month =  date('Y-m-01');
        $last_day_this_month =  date('Y-m-t');
        $date1 = new DateTime($first_day_this_month);
        $first_day_this_month = $date1->format('d/m/Y');
        $date2 = new DateTime($last_day_this_month);
        $last_day_this_month = $date2->format('d/m/Y');
        $first_day_this_month = Time::createFromFormat(
            'd/m/Y',
            $first_day_this_month,
            'Europe/Paris'
        );
        $last_day_this_month = Time::createFromFormat(
            'd/m/Y',
            $last_day_this_month,
            'Europe/Paris'
        );
        $attendances = $this->Workinghours->find('all', [
            'conditions' => [
                'start_time >=' => $first_day_this_month,
                'start_time <=' => $last_day_this_month,
                'company_id' => $companyId
            ]
        ])->contain(['Users'])->toArray();

        $time = strtotime($dateValue);
        $month = date("F", $time);
        $user_id = $this->Auth->user('id');
        $this->loadModel('CompaniesUser');
        $allemployees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User'])->toArray();

        if (!empty($attendances)) {

            //This is Engine for pdf
            Configure::write('CakePdf', [
                'engine' => [
                    'className' => 'CakePdf.DomPdf',
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
            $CakePdf = new \CakePdf\Pdf\CakePdf();
            $CakePdf->template('attendencedoc', 'default');
            $CakePdf->viewVars(['attendances' => $attendances]);
            // Get the PDF string returned
            $pdf = $CakePdf->output();

            $destinationFolder = WWW_ROOT . "assets" . DS . "attendences" . DS . "companyId_" . $companyId;
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder);
            }
            $file =  "companyId_" . $companyId . ".pdf";
            $filename = $destinationFolder . DS . "companyId_" . $companyId . ".pdf";
            file_put_contents($filename, $pdf);
            $this->loadModel('Dailyattendencepdfs');
            $dailyreports = $this->Dailyattendencepdfs->newEntity();
            $dailyreports->company_id = $companyId;
            $dailyreports->month = $month;
            $dailyreports->filepath = $destinationFolder;
            $dailyreports->filename = $file;
            $this->Dailyattendencepdfs->save($dailyreports);
            $daily_attendence = $this->Dailyattendencepdfs->find('all', [
                'conditions' => [
                    'company_id' => $companyId,
                    'month' => $month
                ]
            ])->first();
        } else {
            $daily_attendence = null;
            $this->Flash->error(__('No This month Record Found'));
        }
        $this->set(compact('allemployees', 'companyId', 'daily_attendence'));
    }

    public function monthlyattendence($companyId = null)
    {
        $this->loadModel('CompaniesUser');
        $first_day_this_month = date('01-m-Y');
        $last_day_this_month  =  Time::now()->format('d-m-Y');
       $month =  date('m', strtotime(date('Y-m-01'))); //month

        $allemployees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User'])->toArray();
        $this->set(compact('allemployees', 'companyId', 'first_day_this_month','last_day_this_month', 'month'));
    }


    public function searchempattendencepdfs($companyId = null)
    {
        $this->loadModel('CompaniesUser');
        $allemployees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Usercompanies', 'User'])->toArray();

        $month = $this->request->getQuery('month');


        if (!empty($month)) {
            $first_day_this_month = "";
            $last_day_this_month = "";
            if ($month == '01') {
                $firstday = '01-01-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '02') {
                $firstday = '01-02-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '03') {
                $firstday = '01-03-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '04') {
                $firstday = '01-04-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '05') {
                $firstday = '01-05-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '06') {
                $firstday = '01-06-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '07') {
                $firstday = '01-07-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '08') {
                $firstday = '01-08-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '09') {
                $firstday = '01-09-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '10') {
                $firstday = '01-10-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '11') {
                $firstday = '01-11-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            } elseif ($month == '12') {
                $firstday = '01-12-2022';
                $first_day_this_month = date($firstday);
                $last_day_this_month  =  date("t-m-Y", strtotime($first_day_this_month));
            }


            $first_day_this_month = Time::createFromFormat(
                'd-m-Y',
                $first_day_this_month,
                'Europe/Paris'
            );
            $last_day_this_month = Time::createFromFormat(
                'd-m-Y',
                $last_day_this_month,
                'Europe/Paris'
            );





            $fromdate = null;
            $todate= null;

        } else {
            $fromdate = $this->request->getQuery('fromdate');
            $todate = $this->request->getQuery('todate');
            $fromdate = str_replace('/', '-', $fromdate);
            $todate = str_replace('/', '-', $todate);




            if(!empty($fromdate) && !empty($todate)){
                $first_day_this_month = Time::createFromFormat(
                    'd-m-Y',
                    $fromdate,
                    'Europe/Paris'
                );
                $last_day_this_month = Time::createFromFormat(
                    'd-m-Y',
                    $todate,
                    'Europe/Paris'
                );
            }else{
                $this->Flash->error(__('Invalid Dates'));
                return $this->redirect(['controller' => 'workinghours', 'action' => 'searchempattendencepdfs', $companyId]);

            }

        }

        /* if ($first_day_this_month->i18nFormat('yyyy-MM-dd') < Time::now()->i18nFormat('yyyy-MM-dd') && $first_day_this_month->i18nFormat('yyyy-MM-dd') <=   $last_day_this_month->i18nFormat('yyyy-MM-dd')) {



        } else {
            $this->Flash->error(__('Invalid Dates'));
            return $this->redirect(['controller' => 'workinghours', 'action' => 'searchempattendencepdfs', $companyId]);
        } */


        $this->set(compact('month', 'first_day_this_month', 'last_day_this_month', 'allemployees', 'companyId'));
    }


    public function allemployeesattendence($companyId = null){

        $first_day_this_month = date('01-m-Y');
        $last_day_this_month  =  date("t-m-Y");

        $startdatetime = Time::createFromFormat(
            'd-m-Y',
            $first_day_this_month,
            'Europe/Paris'
        );
        $enddatetime = Time::createFromFormat(
            'd-m-Y',
            $last_day_this_month,
            'Europe/Paris'
        );


        $this->loadModel('CompaniesUser');
        $this->loadModel('User');
        $employees = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name !=' => 'Customer'
                ]);
            },
        ])->toArray();

        $empids = array();
        foreach($employees as $employee){
            array_push($empids, $employee->user_id);

        }
       $users =  $this->User->find('all',[
            'conditions' => [
                'id in' => $empids
            ]
        ])->contain(['Workinghours'])->toArray();




        $this->set(compact('users', 'companyId','startdatetime','enddatetime'));

    }

    public function downloadpdf()
    {

        $companyId = $this->request->getQuery('companyId');
        $empid = $this->request->getQuery('empid');
        $fromdate = $this->request->getQuery('fromdate');
        $todate = $this->request->getQuery('todate');


        $newfromdate = Time::createFromFormat(
            'd-m-Y',
            $fromdate,
            'Europe/Rome'
        );
        $newtodate = Time::createFromFormat(
            'd-m-Y',
            $todate,
            'Europe/Paris'
        );
        if(!empty($empid)){
            $attendances =  $this->Workinghours->find('all', [
                'conditions' => [
                    'user_id in' => $empid,
                    'company_id' => $companyId
                ]
            ])->contain(['Users'])->toArray();

        }else{
            $attendances =  $this->Workinghours->find('all', [
                'conditions' => [
                    'company_id' => $companyId
                ]
            ])->contain(['Users'])->toArray();
        }



        $durationtime = array();
        foreach ($attendances as $attendance) {

            if (strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) >= strtotime($newfromdate->i18nFormat('yyyy-MM-dd')) && strtotime($attendance->start_time->i18nFormat('yyyy-MM-dd')) <=  strtotime($newtodate->i18nFormat('yyyy-MM-dd'))) {
                array_push($durationtime, $attendance);
            }
        }

        //This is Engine for pdf
        Configure::write('CakePdf', [
            'engine' => [
                'className' => 'CakePdf.DomPdf',
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
        $CakePdf->template('employeeattendence', 'default');
        $CakePdf->viewVars(['attendances' => $durationtime]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $response = $this->response;
        // Inject string content into response body
        $response = $response->withStringBody($pdf);
        $response = $response->withType('pdf');
        // Optionally force file download
        $response = $response->withDownload('employeeattendence.pdf');
        return $response;
    }

    public function filterattendence($companyId = null){

        $this->loadModel('User');
        $this->loadModel('CompaniesUser');

        $companyemployees =   $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId,
            ]
        ])->contain([
            'Designations' => function ($q) {
                return $q->where([
                    'name !=' => 'Customer'
                ]);
            },
        ])->toArray();
            $empids = array();
        foreach($companyemployees as $employee){
            array_push($empids, $employee->user_id);

        }
        $name = $this->request->getQuery('name');
        $month = $this->request->getQuery('month');
        $year = $this->request->getQuery('year');
        if(!empty($year)){
            if(empty($month)){
                $this->Flash->error(__('Please select the Month'));
                return $this->redirect(['controller' => 'workinghours', 'action' => 'filterattendence', $companyId]);
            }
        }
        $fromdate = $this->request->getQuery('fromdate');
        $todate = $this->request->getQuery('todate');
        if(!empty($fromdate)){
            if(empty($todate)){
                $this->Flash->error(__('Invalid Date Selection'));
                return $this->redirect(['controller' => 'workinghours', 'action' => 'filterattendence', $companyId]);

            }

        }
        if(!empty($todate)){
            if(empty($fromdate)){
                $this->Flash->error(__('Invalid Date Selection'));
                return $this->redirect(['controller' => 'workinghours', 'action' => 'allemployeesattendence', $companyId]);

            }

        }


        if(!empty($name) || !empty($month) || !empty($year) || !empty($fromdate) || !empty($todate)){

            if (!empty($fromdate) && !empty($todate)) {

                $fromdate = str_replace('/', '-', $fromdate);
                $todate = str_replace('/', '-', $todate);

                $newfromdate = Time::createFromFormat(
                    'd-m-Y',
                    $fromdate,
                    'Europe/Rome'
                );

                $newtodate = Time::createFromFormat(
                    'd-m-Y',
                    $todate,
                    'Europe/Rome'
                );


                if (strtotime($newfromdate->i18nFormat('yyyy-MM-dd')) < strtotime(Time::now()->i18nFormat('yyyy-MM-dd')) &&  strtotime($newfromdate->i18nFormat('yyyy-MM-dd')) <=   strtotime($newtodate->i18nFormat('yyyy-MM-dd'))) {

                }else{
                    $this->Flash->error(__('Invalid Date'));

                }
            }

            $workinghrsdata = $this->Workinghours->find('all',[
                'conditions' => [
                    'company_id' => $companyId
                ]
            ])->contain(['Users'])->toArray();

            $matched_data = array();

            foreach ($workinghrsdata as $workinghr) {
                if (!empty($name)) {
                    if (preg_match("/{$name}/i", $workinghr->user->firstname) || preg_match("/{$name}/i", $workinghr->user->lastname)) {
                        array_push($matched_data, $workinghr->id);
                    }
                }
                if (!empty($month)) {

                    if ($month == date("m", strtotime($workinghr->start_time))) {
                        array_push($matched_data, $workinghr->id);
                    }
                }
                if (!empty($year) && $year == date("Y", strtotime($workinghr->start_time))) {

                    array_push($matched_data, $workinghr->id);
                }


                if (!empty($fromdate) && !empty($todate)) {

                    $fromdate = str_replace('/', '-', $fromdate);
                    $todate = str_replace('/', '-', $todate);

                    $newfromdate = Time::createFromFormat(
                        'd-m-Y',
                        $fromdate,
                        'Europe/Rome'
                    );

                    $newtodate = Time::createFromFormat(
                        'd-m-Y',
                        $todate,
                    'Europe/Rome'
                );


                    if (strtotime($newfromdate->i18nFormat('yyyy-MM-dd')) < strtotime(Time::now()->i18nFormat('yyyy-MM-dd')) &&  strtotime($newfromdate->i18nFormat('yyyy-MM-dd')) <=   strtotime($newtodate->i18nFormat('yyyy-MM-dd'))) {
                        if (strtotime($workinghr->start_time->i18nFormat('yyyy-MM-dd')) >= strtotime($newfromdate->i18nFormat('yyyy-MM-dd')) && strtotime($workinghr->start_time->i18nFormat('yyyy-MM-dd')) <= strtotime($newtodate->i18nFormat('yyyy-MM-dd'))) {
                            array_push($matched_data, $workinghr->id);
                        }
                    }
                }


            }

            $uniqueids = array_unique($matched_data);

               if(!empty($uniqueids)){
                $users = $this->User->find('all',[
                    'conditions' => [
                        'id in' => $empids
                    ]
                ])->contain(['Workinghours' => function ($q) use ($uniqueids) {

                    return $q->where([
                        'id in' => $uniqueids

                    ]);
                },
                ])->toArray();
            }else{
                $users = null;
            }


            $this->set(compact('matched_data', 'companyId', 'name', 'month', 'year', 'fromdate', 'todate','users'));

        }else{
            $this->Flash->error(__('Invalid Search'));
            return $this->redirect(['controller' => 'workinghours', 'action' => 'allemployeesattendence', $companyId]);

        }
    }

    public function timesheet($companyId){

        $user_id = $this->Auth->user('id');
        $attendances =  $this->Workinghours->find('all',[
            'conditions' => [
                'company_id' => $companyId,
                'user_id' => $user_id
            ]
        ])->toArray();
        $this->set(compact('attendances'));
    }


    public function attendenceReports($companyId){
        $companymembers = $this->CompaniesUser->find('all',[
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['Workinghours.Users',
         'User',
         'Designations' => function ($q) {
            return $q->where([
                'name !=' => 'Customer'
            ]);
        },
         ])->toArray();

      //  debug($companymembers);exit;


        $this->set(compact('companymembers'));
    }


}
