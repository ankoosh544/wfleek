<?php

namespace App\Controller;

use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Mailer\Email;


use App\Controller\AppController;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 *
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoicesController extends AppController
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
        $invoices = $this->paginate($this->Invoices);

        $this->set(compact('invoices'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceId = $this->request->getQuery('invoiceId');

        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.id in' => $invoiceId
            ]
        ])->contain(['Clients', 'Projectobject', 'Usercompanies', 'Invoiceitems.Taskgroups'])->first();



        $this->set(compact('invoice'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoice = $this->Invoices->newEntity();
        if ($this->request->is('post')) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $companies = $this->Invoices->Companies->find('list', ['limit' => 200]);
        $this->set(compact('invoice', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $companies = $this->Invoices->Companies->find('list', ['limit' => 200]);
        $this->set(compact('invoice', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteInvoice()
    {
        $invoiceId = $this->request->getQuery('invoiceId');
        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'id in' => $invoiceId
            ]
        ])->first();
        $companyId = $invoice->company_id;

        $this->Invoices->delete($invoice);

        return $this->redirect(['action' => 'invoices', $companyId]);
    }
    public function invoices($companyId)
    {
        $user_id = $this->Auth->user('id');

        $this->loadModel('CompaniesUser');
        $authcompanymember = $this->CompaniesUser->find('all',[
            'conditions' => [
                'user_id' => $user_id,
                'company_id' => $companyId
            ]
        ])->contain(['User','Designations'])->first();

    if($authcompanymember->designation->name == 'Administrator'){
        $companyinvoices = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.company_id' => $companyId,

            ]
        ])->contain(['Clients', 'Projectobject', 'Invoiceitems.Taskgroups'])->toArray();

    }elseif($authcompanymember->designation->name == 'Customer'){
        $companyinvoices = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.company_id' => $companyId,
                'client_id' => $user_id
            ]
        ])->contain(['Clients', 'Projectobject', 'Invoiceitems.Taskgroups'])->toArray();
    }else{

        $this->Flash->success(__('Invalid Designation'));

    }


       // debug($companyinvoices);exit;

        $this->set(compact('companyId', 'companyinvoices'));
    }
    public function createInvoice()
    {
        $this->loadModel('CompaniesUser');
        $user_id = $this->Auth->user('id');

        $companyId = $this->request->getQuery('companyId');

        $authuser = $this->CompaniesUser->find('all',[
            'conditions' => [
                'CompaniesUser.company_id' => $companyId,
                'CompaniesUser.user_id' => $user_id
            ]
        ])->contain(['Usercompanies', 'Designations','User'])->first();
        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'CompaniesUser.company_id' => $companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();

      //debug($companymembers);exit;

        $this->set(compact('companymembers', 'companyId', 'authuser'));
    }
    public function filterprojectsofclient()
    {
        $this->loadModel('ProjectMember');
        $this->loadModel('ProjectObject');
        $clientId =  $this->request->getData('clientId');
        $companyId = $this->request->getData('companyId');

        $clientprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $clientId
            ]
        ])->contain([
            'Projectobject' => function ($q) use ($companyId) {
                return $q->where([
                    'company_id' => $companyId,
                    'isDeleted' => false
                ]);
            },
            'Projectobject.Taskgroups',

            'User'
        ])->toArray();


        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($clientprojects));
    }
    public function saveinvoice()
    {
        $companyId = $this->request->getQuery('companyId');
        $clientid = $this->request->getData('clientid');
        $client_project = $this->request->getData('client_project');
        $client_email = $this->request->getData('client_email');
        $client_address = $this->request->getData('client_address');
        $billing_address = $this->request->getData('billing_address');
        $invoice_date = $this->request->getData('invoice_date');
        $invoice_date = Time::createFromFormat(
            'd/m/Y',
            $invoice_date,
            'Europe/Paris'
        );
        $due_date = $this->request->getData('due_date');
        $due_date = Time::createFromFormat(
            'd/m/Y',
            $due_date,
            'Europe/Paris'
        );
        $description = $this->request->getData('description');
        $discount = $this->request->getData('discountamount');

        $newinvoice = $this->Invoices->newEntity();
        $newinvoice->company_id = $companyId;
        $newinvoice->projectId = $client_project;
        $newinvoice->client_id = $clientid;
        $newinvoice->invoice_date = $invoice_date;

        $newinvoice->due_date = $due_date;
        $newinvoice->description = $description;
        $newinvoice->billing_address = $billing_address;
        $newinvoice->discount_percentage = $discount;
        $this->Invoices->save($newinvoice);

        //save invoice external group item
        $this->loadModel('Invoiceitems');

        $items = $this->request->getData()['items'];
        $itemnames = $this->request->getData()['itemnames'];
        $unique = array_unique($items);
        $duplicates = array_diff_assoc($items, $unique);
        $description = $this->request->getData()['itemdescription'];
        $price = $this->request->getData()['price'];
        $qty = $this->request->getData()['qty'];


        for ($i = 0; $i < count($items); $i++) {
            if (!empty($duplicates)) {
                foreach ($duplicates as $index => $duplicate) {
                    if ($i != $index) {
                        $invoiceitem = $this->Invoiceitems->newEntity();
                        $invoiceitem->itemId = $items[$i];
                        $invoiceitem->name = $itemnames[$i];
                        $invoiceitem->invoiceId = $newinvoice->id;
                        $invoiceitem->description = $description[$i];
                        $invoiceitem->quantity = $qty[$i];
                        $invoiceitem->price = $price[$i];
                        $this->Invoiceitems->save($invoiceitem);
                    }
                }
            } else {
                $invoiceitem = $this->Invoiceitems->newEntity();
                $invoiceitem->itemId = $items[$i];
                $invoiceitem->name = $itemnames[$i];
                $invoiceitem->invoiceId = $newinvoice->id;
                $invoiceitem->description = $description[$i];
                $invoiceitem->quantity = $qty[$i];
                $invoiceitem->price = $price[$i];
                $this->Invoiceitems->save($invoiceitem);
            }
        }

        $this->Flash->success(__('Invoice is Created !'));

        $this->sendInvoice($newinvoice->id);





        return $this->redirect([
            'action' => 'createInvoice',
            'companyId' => $companyId
        ]);
    }


    private function sendInvoice($invoiceId = null)
    {

        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.id in' => $invoiceId
            ]
        ])->contain([
            'Clients',
            'Projectobject.Taskgroups',
            'Usercompanies'
        ])->first();


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
        $CakePdf->template('invoice', 'default');
        $CakePdf->viewVars(['invoice' => $invoice]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();

        $destinationFolder = WWW_ROOT . "assets" . DS . "invoice" . DS . "No" .  $invoice->id;
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder);
        }
        $file = "clientId_" . $invoice->client->id . "invoice" . $invoice->id . ".pdf";
        $filename = $destinationFolder . DS . "clientId_" . $invoice->client->id . "invoice" . $invoice->id . ".pdf";
        file_put_contents($filename, $pdf);



        //External Mail
        $email = new Email();
        $emailSent = $email->setFrom(['welcome@epebook.it' => 'EPEBOOK'])
            ->setTo($invoice->client->email)
            ->setEmailFormat('html')
            ->setSubject('Invoice')
            ->setTemplate('invoice', 'default')
            ->setAttachments([
                'invoice.pdf' => [
                    'file' =>   $filename,
                    'mimetype' => 'pdf'
                ]
            ])
            ->setViewVars(['invoice' => $invoice]);
        $email->send();
        if ($emailSent) {
            $this->Flash->success(__('E-mail sent.'));
        } else {
            $this->Flash->error(__('Error message'));
        }
    }


    public function invoiceItemview()
    {
        $this->loadModel('Invoiceitems');
        $id = $this->request->getQuery('id');
        $item = $this->Invoiceitems->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();

        $this->set(compact('item'));
    }



    public function editInvoice()
    {
        $this->loadModel('ProjectMember');
        $invoiceId = $this->request->getQuery('invoiceId');

        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.id in' => $invoiceId
            ]
        ])->contain(['Clients', 'Projectobject', 'Invoiceitems.Taskgroups.Projecttasks'])->first();

       // debug($invoice);exit;


        $companyId = $invoice->company_id;
        $clientprojects = $this->ProjectMember->find('all', [
            'conditions' => [
                'memberId' => $invoice->client_id
            ]
        ])->contain([
            'Projectobject' => function ($q) use ($companyId) {
                return $q->where([
                    'company_id' =>  $companyId,
                    'isDeleted' => false
                ]);
            },
            'Projectobject.Taskgroups',
            'User'
        ])->toArray();
        // debug($clientprojects);exit;



        $companymembers = $this->CompaniesUser->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->contain(['User', 'Designations'])->toArray();
        $this->set(compact('companymembers', 'companyId', 'invoice', 'clientprojects'));
    }

    public function updateinvoice()
    {
        $invoiceId = $this->request->getQuery('invoiceId');

        $clientid = $this->request->getData('clientid');
        $client_project = $this->request->getData('client_project');
        $client_email = $this->request->getData('client_email');
        $taxtype = $this->request->getData('taxtype');
        $client_address = $this->request->getData('client_address');
        $billing_address = $this->request->getData('billing_address');
        $invoice_date = $this->request->getData('invoice_date');
        $invoice_date = Time::createFromFormat(
            'd/m/Y',
            $invoice_date,
            'Europe/Paris'
        );
        $due_date = $this->request->getData('due_date');
        $due_date = Time::createFromFormat(
            'd/m/Y',
            $due_date,
            'Europe/Paris'
        );
        $description = $this->request->getData('description');
        $discount = $this->request->getData('discountamount');


        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'id in' => $invoiceId

            ]
        ])->first();
        $invoice->projectId = $client_project;
        $invoice->client_id = $clientid;
        $invoice->invoice_date = $invoice_date;
        $invoice->due_date = $due_date;
        $invoice->description = $description;
        $invoice->billing_address = $billing_address;
        $invoice->discount_percentage = $discount;
        $this->Invoices->save($invoice);


        $this->loadModel('Invoiceitems');

        $existingitems = $this->Invoiceitems->find('all',[
            'conditions' => [
                'invoiceId' => $invoice->id
            ]
        ])->toArray();

        $existingids =array();
        foreach($existingitems as $existingitem){
            array_push($existingids, $existingitem->itemId);
        }
        $ids = $this->request->getData()['invoicesitemids'];
        //debug($ids);exit;

        $items = $this->request->getData()['items'];

        $itemnames = $this->request->getData()['itemnames'];
        $unique = array_unique($items);
        $duplicates = array_diff_assoc($items, $unique);
        $description = $this->request->getData()['itemdescription'];
        $price = $this->request->getData()['price'];
        $qty = $this->request->getData()['qty'];


        for ($i = 0; $i < count($items); $i++) {
            if(in_array($items[$i], $existingids)){
                $updateitem = $this->Invoiceitems->find('all',[
                    'conditions' => [
                        'itemId in' => $items[$i]
                    ]
                ])->first();
                $updateitem->name = $itemnames[$i];
                $updateitem->description = $description[$i];
                $updateitem->price = $price[$i];
                $updateitem->quantity = $qty[$i];
                $this->Invoiceitems->save($updateitem);
            } else {
                if (!empty($duplicates)) {
                    foreach ($duplicates as $index => $duplicate) {
                        if ($i != $index) {
                            $invoiceitem = $this->Invoiceitems->newEntity();
                            $invoiceitem->itemId = $items[$i];
                            $invoiceitem->name = $itemnames[$i];
                            $invoiceitem->invoiceId = $invoice->id;
                            $invoiceitem->description = $description[$i];
                            $invoiceitem->quantity = $qty[$i];
                            $invoiceitem->price = $price[$i];
                            $this->Invoiceitems->save($invoiceitem);
                        }
                    }
                } else {
                    $invoiceitem = $this->Invoiceitems->newEntity();
                    $invoiceitem->itemId = $items[$i];
                    $invoiceitem->name = $itemnames[$i];
                    $invoiceitem->invoiceId = $invoice->id;
                    $invoiceitem->description = $description[$i];
                    $invoiceitem->quantity = $qty[$i];
                    $invoiceitem->price = $price[$i];
                    $this->Invoiceitems->save($invoiceitem);
                }
            }
        }
        return $this->redirect(['action' => 'editInvoice', 'invoiceId' =>$invoice->id ]);
    }

    public function createpdfdownload()
    {
        $invoiceId = $this->request->getQuery('invoiceId');

        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.id in' => $invoiceId
            ]
        ])->contain([
            'Clients',
            'Projectobject.Taskgroups',
            'Usercompanies'
        ])->first();


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
        $CakePdf->template('invoice', 'default');
        $CakePdf->viewVars(['invoice' => $invoice]);
        // Get the PDF string returned
        $pdf = $CakePdf->output();
        $response = $this->response;
        // Inject string content into response body
        $response = $response->withStringBody($pdf);
        $response = $response->withType('pdf');
        // Optionally force file download
        $response = $response->withDownload('invoice.pdf');
        return $response;
    }
    public function updatestatus()
    {
        $invoiceId = $this->request->getData('invoiceId');
        $status = $this->request->getData('status');
        $invoice = $this->Invoices->find('all', [
            'conditions' => [
                'id in' => $invoiceId
            ]
        ])->first();

        $invoice->status = $status;
        $this->Invoices->save($invoice);
        $this->Flash->success(__('Status Updated!'));
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($invoice));
    }

    public function invoiceReports($companyId = null)
    {
        $allcompanyinvoices = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.company_id' => $companyId
            ]
        ])->contain([
            'Clients',
            'Projectobject.Taskgroups',
            'Usercompanies'
        ])->toArray();
        $this->set(compact('allcompanyinvoices', 'companyId'));
    }
    public function invoicecategoryview()
    {
        $companyId = $this->request->getQuery('companyId');
        $status = $this->request->getQuery('status');
        $allcompanyinvoices = $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.company_id' => $companyId,
                'Invoices.status' => $status
            ]
        ])->contain([
            'Clients',
            'Projectobject.Taskgroups',
            'Usercompanies'
        ])->toArray();
        $this->set(compact('allcompanyinvoices', 'companyId'));
    }

    public function createcsvdownload()
    {
        $id = $this->request->getQuery('invoiceId');
        $part = $this->request->getQuery('part');


        $invoice =  $this->Invoices->find('all', [
            'conditions' => [
                'Invoices.id' => $id
            ]
        ])->contain([
            'Clients',
            'Projectobject.Taskgroups.Projecttasks',
            'Usercompanies',
            'Invoiceitems'
        ])->first();


        if ($part == 'header') {
            $csvString = "";
            $csvString .= 'Company Name,' . $invoice->usercompany->name . '/n Address' . $invoice->usercompany->address;
        } else {
            $csvString = "Item Name, Description, Price,Quantity,";

            foreach ($invoice->projectobject->taskgroups as $group) {
                $csvString .=  $group->title . ',' . $group->description . ',';
            }
            foreach ($invoice->invoicegroups as $item) {
                $csvString .=  $item->name . ',' . $group->description . ',' . $item->price . ',' . $item->quantity;
            }
        }

        $response = $this->response;

        // Inject string content into response body (3.4.0.)
      //  debug( $response->withType('application/json')->withStringBody(json_encode($resultarray)));exit;
        $response = $response->withStringBody($csvString);

        $response = $response->withType('csv');

        // Optionally force file download
        if ($part == 'header') {
            $response = $response->withDownload('invoice_header.csv');
        } else {
            $response = $response->withDownload('invoice_body.csv');
        }

        // Return response object to prevent controller from trying to render
        // a view.
        return $response;
    }

    public function invoiceSearch()
    {
        $companyId = $this->request->getQuery('companyId');
        $status = $this->request->getQuery('status');
        $invoices = $this->Invoices->find('all', [
            'conditions' => [
                'company_id' => $companyId
            ]
        ])->toArray();
        $fromdate = $this->request->getQuery('fromdate');
        $todate = $this->request->getQuery('todate');
        if ((!empty($fromdate) && !empty($todate)) && (strtotime($todate) >= strtotime($fromdate))) {
            $fromdate = Time::createFromFormat(
                'd/m/Y',
                $fromdate,
                'Europe/Paris'
            );
            $todate = Time::createFromFormat(
                'd/m/Y',
                $todate,
                'Europe/Paris'
            );

            $filteredinvoiceids = array();
            foreach($invoices as $invoice){
                if(($invoice->invoice_date >= $fromdate && $invoice->invoice_date <= $todate) && (!empty($status) && $invoice->status == $status)){
                    array_push($filteredinvoiceids, $invoice->id);
                }elseif(($invoice->invoice_date >= $fromdate && $invoice->invoice_date <= $todate) && (empty($status))){
                    array_push($filteredinvoiceids, $invoice->id);
                }
            }

        } elseif ((!empty($fromdate) && empty($todate)) || (empty($fromdate) && !empty($todate))) {
            $this->Flash->error(__('Invalid Date !'));
            return $this->redirect([
                'controller' => 'invoices',
                'action' => 'invoices',
                $companyId
            ]);
        }elseif(empty($fromdate) && empty($todate) && !empty($status)){
            $filteredinvoiceids = array();
            foreach($invoices as $invoice){
                if($invoice->status == $status){
                    array_push($filteredinvoiceids, $invoice->id);

                }
            }
        }
        if(!empty($filteredinvoiceids)){
            $companyinvoices = $this->Invoices->find('all', [
                'conditions' => [
                    'Invoices.id in' => $filteredinvoiceids
                ]
            ])->contain(['Clients', 'Projectobject', 'Invoiceitems.Taskgroups'])->toArray();

        }else{
            $this->Flash->error(__('No Results Found !'));
            $companyinvoices = null;


        }

        $this->set(compact('companyId', 'companyinvoices','fromdate','todate','status'));

    }

    public function invoiceSettings($companyId=null){

        $this->set(compact('companyId'));

    }
}
