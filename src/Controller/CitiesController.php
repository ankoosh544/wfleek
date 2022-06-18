<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $cities = $this->paginate($this->Cities);

        $this->set(compact('cities'));
    }
    public function isAuthorized()
    {
        return true;
    }

    /**
     * View method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $city = $this->Cities->get($id, [
            'contain' => []
        ]);

        $this->set('city', $city);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $city = $this->Cities->newEntity();
        if ($this->request->is('post')) {
            $file = $this->request->getData('file');

            $contentOfFile = json_decode(file_get_contents($file['tmp_name']), true);

            foreach($contentOfFile as $content){

                $cities = $this->Cities->newEntity();
                $cities->name =$content['nome'];
                $cities->region =$content['regione']['nome'];
                $cities->province =$content['provincia']['nome'];
                $cities->province =$content['provincia']['nome'];
                $cities->province_code =$content['sigla'];
                $cities->cadastral_code =$content['codiceCatastale'];
                $caps = "";
                foreach($content['cap'] as $capcode){
                    $caps =';'.$capcode;
                }
                $caps = trim($caps, ";");

               // debug($caps);exit;
                $cities->postcodes = $caps;
                $cities->country = 'Italia';
                $this->Cities->save($cities);
            }

        }
        $this->set(compact('city'));
    }


    public function checkpostalcode(){
        $city = $this->request->getData('city');
        $postalcode = $this->request->getData('postalcode');


        $citydata = $this->Cities->find('all',[
            'conditions' => [
                'name' => $city
            ]
        ])->first();


        $result = array();
        if($citydata->postcodes != $postalcode){
            $result = array(
                'RESULT' => "ERROR",
                'MESSAGE' => "Invalid Code",
                'CHECKTASK' => null
            );
        }else{
            $result = array(
                'RESULT' => "SUCCESS",
                'MESSAGE' => "",
                'CHECKTASK' =>  $citydata
            );
        }
        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($result));
    }

    public function filtercities()
    {
        $province = $this->request->getData('province');
        $companyId = $this->request->getData('companyId');
        if(!empty($companyId)){
            $this->loadModel('Usercompanies');

            $company = $this->Usercompanies->find('all',[
                'conditions' => [
                    'id in' => $companyId
                ]
            ])->first();

            $cities = $this->Cities->find('all', [
                'conditions' => [
                    'province' => $province
                ]
            ])->toArray();
            $result = array(
                'company' => $company,
                'cities' => $cities
            );
        } else {

            $cities = $this->Cities->find('all', [
                'conditions' => [
                    'province' => $province
                ]
            ])->toArray();
            $result = array(
                'company' => null,
                'cities' => $cities
            );
        }

        $this->autoRender = false;
        return $this->response->withType('application/json')->withStringBody(json_encode($result));
    }

    /**
     * Edit method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $city = $this->Cities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $this->set(compact('city'));
    }

    /**
     * Delete method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $city = $this->Cities->get($id);
        if ($this->Cities->delete($city)) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
