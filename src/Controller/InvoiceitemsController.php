<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Invoiceitems Controller
 *
 * @property \App\Model\Table\InvoiceitemsTable $Invoiceitems
 *
 * @method \App\Model\Entity\Invoiceitem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoiceitemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $invoiceitems = $this->paginate($this->Invoiceitems);

        $this->set(compact('invoiceitems'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id Invoiceitem id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceitem = $this->Invoiceitems->get($id, [
            'contain' => []
        ]);

        $this->set('invoiceitem', $invoiceitem);
    }
    public function updateitem(){
        $id = $this->request->getQuery('id');
        $item = $this->Invoiceitems->find('all',[
            'conditions' => [
                'id' => $id
            ]
        ])->first();
        $name = $this->request->getData('itemname');
        $description = $this->request->getData('itemdescription');
        $price = $this->request->getData('itemprice');
        $quantity = $this->request->getData('itemqty');

        $item->name = $name;
        $item->description = $description;
        $item->price = $price;
        $item->quantity = $quantity;
        $this->Invoiceitems->save($item);
        return $this->redirect(['controller' => 'invoices',
        'action' => 'invoiceItemview',
        'id' => $id
        ]);



    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoiceitem = $this->Invoiceitems->newEntity();
        if ($this->request->is('post')) {
            $invoiceitem = $this->Invoiceitems->patchEntity($invoiceitem, $this->request->getData());
            if ($this->Invoiceitems->save($invoiceitem)) {
                $this->Flash->success(__('The invoiceitem has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoiceitem could not be saved. Please, try again.'));
        }
        $this->set(compact('invoiceitem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoiceitem id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoiceitem = $this->Invoiceitems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoiceitem = $this->Invoiceitems->patchEntity($invoiceitem, $this->request->getData());
            if ($this->Invoiceitems->save($invoiceitem)) {
                $this->Flash->success(__('The invoiceitem has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoiceitem could not be saved. Please, try again.'));
        }
        $this->set(compact('invoiceitem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoiceitem id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function delete()
    {
        $this->loadModel('User');
        $id = $this->request->getQuery('id');

        $invoiceId = $this->request->getQuery('invoiceId');
        $user_id = $this->Auth->user('id');
        $authuser = $this->User->find('all',[
            'conditions' => [
                'id' => $user_id
            ]
        ])->first();

        $this->request->allowMethod(['post', 'delete', 'get']);
        $invoiceitem = $this->Invoiceitems->find('all',[
            'conditions' => [
                'id in' => $id
            ]
        ])->first();


        if ($this->Invoiceitems->delete($invoiceitem)) {
            $this->Flash->success(__('The invoiceItem has been deleted.'));
        } else {
            $this->Flash->error(__('The invoiceItem could not be deleted. Please, try again.'));
        }
        if(!empty($invoiceId)){
            return $this->redirect(['controller' => 'invoices','action' => 'editInvoice','invoiceId' => $invoiceId]);

        }else{
            return $this->redirect(['controller' => 'invoices','action' => 'invoices',$authuser->choosen_companyId]);

        }


    }
}
