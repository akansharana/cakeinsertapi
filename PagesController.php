<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
   public $helpers = array('Html', 'Form');
    public $components = array('RequestHandler');
    public $uses = array("contact_detail");

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
    
      public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
        $this->loadModel('contact');
          date_default_timezone_set('asia/kolkata');
    }
    public function index() {

//        $this->request->is('post');
        $this->contact->create();
	$data = $this->request->data;
//        print_r($data);
//        die;
            $ProjectArr1['contact']['fname'] =$data['contact']['fname'];
            $ProjectArr1['contact']['lname'] = $data['contact']['lname'];
            $ProjectArr1['contact']['email'] = $data['contact']['email']; 
            $ProjectArr1['contact']['password'] = $data['contact']['password'];
           
            if( $this->contact->save($ProjectArr1)){
               echo $message = 'Saved'; 
            }else {
           echo  $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
//        die;
    }
    

        

}
