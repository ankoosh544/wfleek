<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 *
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function isAuthorized($user)
    {
        return true;
    }
    public function index()
    {
        $events = $this->paginate($this->Events);

        $this->set(compact('events'));
    }

    public function addevent(){
       // debug('hhhhhh');exit;
        $this->loadModel('Events');
        $user_id =  $this->Auth->user('id');
        $events = $this->Events->newEntity();
        $events->event_name = $this->request->getData('name');
        $eventstartdate = $this->request->getData('eventstartdate');

        //debug($eventstartdate);exit;
        $eventstartdate= Time::createFromFormat(
            'd/m/Y',
            $eventstartdate,
            'Europe/Paris'
        );
        $events->event_startdate = $eventstartdate;

        $eventenddate = $this->request->getData('eventenddate');


            $eventenddate = Time::createFromFormat(
                'd/m/Y',
                $eventenddate,
                'Europe/Paris'
            );
            $events->event_enddate =  $eventenddate;

        $events->category =$this->request->getData('category');
        $events->creation_date = Time::now();
        $events->created_by = $user_id;
       $this->Events->save($events);
       return $this->redirect(['action' => 'index']);


    }

    public function addsingleevent(){



        $this->loadModel('Events');
        $user_id =  $this->Auth->user('id');
        $events = $this->Events->newEntity();
        $events->event_name = $this->request->getData('name');
        $eventstartdate = $this->request->getData('date');
       $category = $this->request->getData('category');
       /* debug($eventstartdate);exit;

         $eventstartdate= Time::createFromFormat(
             'd/m/Y',
             $date,
             'Europe/Paris'
         ); */
        // debug($eventstartdate);exit;
         $events->event_startdate = $eventstartdate;
         $events->event_enddate = $eventstartdate;;
        $events->category =$category;
         $events->creation_date = Time::now();
         $events->created_by = $user_id;

        $this->Events->save($events);
        $this->autoRender = false;
        // send JSON response
        return $this->response->withType('application/json')->withStringBody(json_encode($events));

    }



    public function getevents(){

    $allevents = $this->Events->find('all')->toArray();

    $this->autoRender = false;
    // send JSON response
    return $this->response->withType('application/json')->withStringBody(json_encode($allevents));
    }
    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);

        $this->set('event', $event);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }
        $this->set(compact('event'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }
        $this->set(compact('event'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
