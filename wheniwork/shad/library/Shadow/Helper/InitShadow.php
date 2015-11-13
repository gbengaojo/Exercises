<?php
/*-----------------------------------------------------------
Class: InitShadow
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 22, 2012
Modified Date: February 21, 2012

Basic Action Helper to consolidate duplicate code
------------------------------------------------------------*/

class Shadow_Helper_InitShadow extends Zend_Controller_Action_Helper_Abstract
{
   protected $auth;
   protected $identity;
   protected $logger;

   /**
    * construct
    */
   public function __construct() {
   }

   public function initObjects($options = null) {
      // authentication
      $this->auth = Zend_Auth::getInstance();

      if (!$this->auth->hasIdentity()) {
         $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
         $redirector->gotoUrl('/');
      }

      $userObj = new Application_Model_User();
      $this->identity = $this->auth->getIdentity();

      $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
      $viewRenderer->initView();

      // get user's name
      $userObj = new Application_Model_User();
      $viewRenderer->view->firstname = $userObj->getName($this->identity['user_id']);

      $flashHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');

      // flash messages
      $messages = $flashHelper->getMessages();
      if (count($messages > 0) && $messages != false)
         $viewRenderer->view->messages = $flashHelper->getMessages();
      else
         $viewRenderer->view->messages = false;

      // Zend Logger
      $this->logger = Zend_Log::factory(array(
         'timestampFormat' => 'Y-m-d H:i:s',
         array(
            'writerName'       => 'Stream',
            'writerParams'     => array('stream' => PATH . 'zend.log'),
            // 'formatterName'    => 'Simple',
            // 'formatterParams'  => array('format' => '%timestamp%: %message% -- %info%'),
            // 'filterName'       => 'Priority',
            // 'filterParams'     => array('priority' => Zend_Log::WARN)
         ),  
         array(
            'writerName'   => 'Firebug',
            'filterName'   => 'Priority',
            'filterParams' => array('priority' => Zend_Log::INFO)
         )   
      ));
   }

   /**
    * Strategy pattern: call helper broker method
    *
    * @param: (array) options - optional key => value pairs
    * @return: (array) authentication info
    */
   public function direct($options = null) {
      $this->initObjects($options);

      return array('identity' => $this->identity,
                   'logger'   => $this->logger);
   }
}
