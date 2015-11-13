<?php

// Define path to application directory
defined('APPLICATION_PATH')
   || define('APPLICATION_PATH', realpath(dirname(__FILE__) .
      '/../application'));

// Define application environment
defined('APPLICATION_ENV')
   || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?
      getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
   realpath(APPLICATION_PATH . '/../library'),
   get_include_path(),
)));

/** Zend Application **/
require_once APPLICATION_PATH . '/configs/config.php';
require_once 'Zend/Application.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';
require_once 'Zend/Auth/Adapter/Interface.php';
require_once 'Zend/Auth.php';
require_once 'Zend/Session/Namespace.php';
require_once 'Zend/Log.php';
require_once 'classes/AuthAdapter.php';
require_once 'classes/qqUploadFile.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV,
               APPLICATION_PATH . '/configs/application.ini');

// Zend_db
if (LOCALHOST) {
   $db = Zend_db::factory('Pdo_Mysql', array(
      'host'     => 'localhost',
      'username' => '',
      'password' => '',
      'dbname'   => 'shadowandactfilms'
   ));
} else {
   $db = Zend_db::factory('Pdo_Mysql', array(
      'host'     => 'localhost',
      'username' => '',
      'password' => '',
      'dbname'   => 'shadowandactfilms'
   ));
}

Zend_Db_Table::setDefaultAdapter($db);

Zend_Controller_Action_HelperBroker::addPrefix('Shadow_Helper');

$application->bootstrap()->run();
