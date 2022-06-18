<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Holidays Controller
 *
 * @property \App\Model\Table\HolidaysTable $Holidays
 *
 * @method \App\Model\Entity\Holiday[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HolidaysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $holidays = $this->paginate($this->Holidays);

        $this->set(compact('holidays'));
    }
    public function isAuthorized($user)
    {
        return true;
    }

      /*-------------------------Holidays--------------------*/
      public function holidays()
      {
          $this->loadModel('ProjectMember');
          $employees = $this->ProjectMember->find('all', [
              'conditions' => [
                  'type !='  => 'C'
              ]
          ])->toArray();

        $allholidays = $this->Holidays->find('all',[
            'conditions' => [
                'isDeleted' => false
            ]
        ])->toArray();


          $this->set(compact('employees','allholidays'));
      }




      public function addholiday(){

       $name = $this->request->getData('name');
        $holidaydate = $this->request->getData('holidaydate');
        $holiday = $this->Holidays->newEntity();
        $holiday->holiday_name = $name;
       $holiday_date = $holidaydate;
       $holiday_date = Time::createFromFormat(
            'd/m/Y',
            $holiday_date,
            'Europe/Paris'
        );
        $holiday->holiday_date = $holiday_date;
        $holiday->creation_date = Time::now();
        $this->Holidays->save($holiday);


        return $this->redirect([
            'controller' => 'Holidays',
            'action' => 'holidays',

        ]);
      }

      //update holiday

      public function updateholiday(){
          $id = $this->request->getData('id');
        $updateholiday =  $this->Holidays->find('all',[
              'conditions' => [
                  'id' => $id
              ]
          ])->first();
        $updateholiday->holiday_name = $this->request->getData('holiday_name');

        $holiday_date =  $this->request->getData('holiday_date');
        $holiday_date = Time::createFromFormat(
            'd/m/Y',
            $holiday_date,
            'Europe/Paris'
        );
        $updateholiday->holiday_date = $holiday_date;


        $updateholiday->holiday_date =
        $this->Holidays->save($updateholiday);

        return $this->redirect([
            'controller' => 'Holidays',
            'action' => 'holidays'

        ]);

      }
    /**
     * View method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $holiday = $this->Holidays->get($id, [
            'contain' => []
        ]);

        $this->set('holiday', $holiday);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $holiday = $this->Holidays->newEntity();
        if ($this->request->is('post')) {
            $holiday = $this->Holidays->patchEntity($holiday, $this->request->getData());
            if ($this->Holidays->save($holiday)) {
                $this->Flash->success(__('The holiday has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The holiday could not be saved. Please, try again.'));
        }
        $this->set(compact('holiday'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $holiday = $this->Holidays->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $holiday = $this->Holidays->patchEntity($holiday, $this->request->getData());
            if ($this->Holidays->save($holiday)) {
                $this->Flash->success(__('The holiday has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The holiday could not be saved. Please, try again.'));
        }
        $this->set(compact('holiday'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Holiday id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    //DELETE Holiday
     public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete', 'get']);
        $holiday = $this->Holidays->get($id);
        $holiday->isDeleted = true;
        $this->Holidays->save($holiday);

        if ($holiday->isDeleted == true ) {
            $this->Flash->success(__('The holiday has been deleted.'));
        } else {
            $this->Flash->error(__('The holiday could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'holidays']);
    }
}
