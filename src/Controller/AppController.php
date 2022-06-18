<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Number;
use Cake\I18n\Time;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public function beforeFilter(Event $event)
    {
        $this->getEventManager()->off($this->Security);
        if($this->request->is('post')) {
            $this->getEventManager()->off($this->Csrf);
        }
        $this->Auth->allow(['index', 'view', 'display']);
    }
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Csrf');
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent(
            'Auth',
            [
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'email',
                            'password' => 'password'
                        ],
                        'userModel' => 'User'
                    ]
                ],
                'loginAction' => [
                    'controller' => 'User',
                    'action' => 'login'
                ],
                'unauthorizedRedirect' => $this->referer(),
                'authorize' => 'Controller',
            ]
        );
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');
        if (
            ($controller == 'User' && $action == 'login') ||
            ($controller == 'User' && $action == 'forgotPassword') ||
            ($controller == 'Registrations' && $action == 'verifymail') ||
            ($controller == 'Registrations' && $action == 'register') ||
            ($controller == 'Registrations' && $action == 'registerCompany') ||
            ($controller == 'Registrations' && $action == 'resendverification') ||
            ($controller == 'Registrations' && $action == 'validate') ||
            ($controller == 'User' && $action == 'saveregistrationuser') ||
            ($controller == 'User' && $action == 'setnewpassword') ||
            ($controller == 'User' && $action == 'generateresend')
        ) {
            $this->viewBuilder()->setLayout('login_layout');
        } else {
            $this->viewBuilder()->setLayout('new_default');
        }

        $this->loadModel('User');
        $this->loadModel('Chats');
        $this->loadModel('Chatcontacts');
        $user_id = $this->Auth->user('id');

        if(!empty($user_id)){
            $authorizeduser = $this->User->find('all',[
                'conditions' => [
                    'id in' => $user_id
                ]
            ])->first();
            $company_id = $authorizeduser->choosen_companyId;

            $lastchat = $this->Chats->find('all', [
                'conditions' => [
                    'fromuser_id' => $user_id,
                ]
            ])->order(['creation_date' => 'DESC'])->first();

            if (!empty($lastchat)) {
                $lastchat_touser = $lastchat->touser_id;
            } else {
                $contacts = $this->Chatcontacts->find('all', [
                    'conditions' => [
                        'Chatcontacts.isDeleted' => false,
                        'fromuser_id' => $user_id
                    ]
                ])->order(['creation_date' => 'DESC'])->first();

                if (!empty($contacts)) {
                    $lastchat_touser = $contacts->touser_id;
                } else {
                    $lastchat_touser = $user_id;
                }
            }

            $this->set(compact('user_id', 'authorizeduser','company_id', 'lastchat_touser'));
        }




        //  $this->sendToIA('proviamo');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
    }

    /**
     * Method that sends data to IA server via socket
     *
     * @param string|null $message The message that has to be sent
     *
     * @return void
     */
    public function sendToIA($msg)
    {
        // implement $host and $port in the database /*TEMP*/
        $host = "127.0.0.1";
        $port = 12345;
        $f = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $len = strlen($msg);
        socket_sendto($f, $msg, $len, 0, $host, $port);
        socket_close($f);
    }

    /**
     * Method that retrieves the user's informations from the id
     *
     * @param int|null $id The user's id
     *
     * @return void
     */
    public function getUser($id)
    {
        // retrieves informations form the main DB, temp infos now /*TEMP*/
        // $user = x.getUser($id)
        // if(role == null)
        //  checkRoleAccountantOrNotary($id)
        // ok
    }
}
