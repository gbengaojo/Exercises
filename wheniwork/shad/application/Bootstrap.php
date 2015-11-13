<?php
/*-----------------------------------------------------------
Class: Bootstrap
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 10, 2012
Modified Date: February 20, 2012

The Bootstrap
------------------------------------------------------------*/

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
   protected function _initDoctype() {
      $this->bootstrap('view');
      $view = $this->getResource('view');
      $view->doctype('XHTML1_STRICT');
   }

   protected function _initLogging() {
      $this->bootstrap('frontController');
      $logger = new Zend_Log();

      $writer = 'production' == $this->getEnvironment() ?
                 new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log') :
                 // new Zend_Log_Writer_Firebug();
                 new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log');
      $logger->addWriter($writer);
/*
      if ('production' == $this->getEnvironment()) {
         $filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
         $logger->addFilter($filter);
      }
*/
      $this->_logger = $logger;
      Zend_Registry::set('log', $logger);
   }
}
