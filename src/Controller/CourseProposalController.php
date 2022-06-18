<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseProposal Controller
 *
 * @property \App\Model\Table\CourseProposalTable $CourseProposal
 *
 * @method \App\Model\Entity\CourseProposal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseProposalController extends AppController
{
    public function sendProposal() {
        if ($this->request->is('post')) {
            $courseProposal = $this->CourseProposal->newEntity();
            // create entity
            $courseProposal->projectId = $this->request->getData('projectId');
            $courseProposal->organizationId = $this->Auth->user('id'); // to check. Is organization.id == user.id?
            $courseProposal->priceMin = $this->request->getData('priceMin'); 
            $courseProposal->priceMax = $this->request->getData('priceMax');
            // save it
            $this->CourseProposal->save($courseProposal);
            $this->Flash->success('Your proposal has been sent');
            // avoid cake redirect
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($courseProposal));
        }
    }

    public function getProposal($projectId = null) {
        if ($this->request->is('ajax')) {
            // get data from request
            $projectId = $this->request->getData('projectId');
            // get user id
            $organizationId = $this->Auth->user('id');
            // pick proposals from the database
            $proposal = $this->CourseProposal->find('all', [
                'conditions' => [
                    'projectId' => $projectId,    // filter by project
                    'organizationId' => $organizationId     // filter by organization
                ]
            ])->select(['priceMin', 'priceMax'])->toArray();
            // avoid cake redirect
            $this->autoRender = false;
            // send JSON response
            return $this->response->withType('application/json')->withStringBody(json_encode($proposal));
        }
    }

    public function isAuthorized($user) {
        return true;
    }

}
