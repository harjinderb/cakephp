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
use Cake\Core\Configure;

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

        $this->loadComponent('Flash');
         //parent::initialize();

        // $this->loadComponent('Auth', [
        //     'authorize' => ['Controller'], // Added this line
        //     'Form' => array(
        //         //'fields' => array('username' => 'email')
        //         'fields' => [
        //                 'email' => 'email',
        //                 'password' => 'password'
        //             ]
        //     ),
        //     'loginRedirect' => [
        //         'controller' => 'Users',
        //         'action' => 'index'
        //     ],
        //     'logoutRedirect' => [
        //         'controller' => 'Users',
        //         'action' => 'login',
        //         'home'
        //     ]
        // ]);
       // old

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false
        ]);

        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
             'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'home'
            ],
         
           
             // If unauthorized, return them to page they were just on
            'unauthorizedRedirect' => $this->referer()
        ]);

       // Rakesh

        $this->Auth->allow(['add']);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }
    public function beforeFilter(Event $event )
    {
       // $this->RequestHandler->renderAs($this, 'json');
       // $this->response->type('application/json');
        //$this->set('_serialize', true);

        //$this->Auth->allow('*');
        
    
        

        // Load the Collection using the 'Mongo' provider.
        //$this->loadModel('Users', 'Mongo');
    }

    public function isAuthorized($user)
    {
       // pr($user['role']);die;
        if($user['role'] == "superadmin") {
            if ($this->request->getParam('prefix') === 'admin') {
                return true;
            } else {
                return $this->redirect(['controller' => 'users', 'action' => 'index','prefix' => 'admin']);
            }
        } elseif ($user['role'] == "admin") {
            if ($this->request->getParam('prefix') === 'admin') {
                return $this->redirect(['controller' => 'users', 'action' => 'index','prefix' => false]);
            } else {
                return true;
            }
        } else {
            return false;
        }
        return false;
    }

     
}
