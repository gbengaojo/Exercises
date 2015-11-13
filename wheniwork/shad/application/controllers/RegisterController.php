<?php

class RegisterController extends Zend_Controller_Action
{
   public function init() {
      /* Initialize action controller here */
   }

   public function indexAction() {
   }

   public function processAction() {
      $firstname = htmlspecialchars($this->getRequest()->getParam('firstname'));
      $lastname  = htmlspecialchars($this->getRequest()->getParam('lastname'));
      $email     = htmlspecialchars($this->getRequest()->getParam('email'));
      $password  = htmlspecialchars($this->getRequest()->getParam('password'));

      $password  = md5($password);


      $data = array('firstname' => $firstname,
                    'lastname'  => $lastname,
                    'email'     => $email,
                    'password'  => $password,
                    'created'   => date('Y-m-d H:i:s'));

      $userObj = new Application_Model_User();
      $userObj->addUser($data);

      $this->_redirect('/dashboard');
   }
}
