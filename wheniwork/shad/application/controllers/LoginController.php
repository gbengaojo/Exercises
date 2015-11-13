<?php
/*-----------------------------------------------------------
Class LoginController 
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 21, 2012
Modified Date: October 21, 2012
      
Login Controller
------------------------------------------------------------*/

class LoginController extends Zend_Controller_Action
{
   public function init() {
      /* Initialize controller here */
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);
   }

   public function indexAction() {
      if (!$this->getRequest()->isPost())
         return;

      $username = $this->getRequest()->getParam('username');
      $password = $this->getRequest()->getParam('password');
      $password = md5($password);

      if (true) { // validate
         $authAdapter = new AuthAdapter($username, $password);
         $auth        = Zend_Auth::getInstance();
         $result      = $auth->authenticate($authAdapter);
         $identity    = $auth->getIdentity();

         if ($result->isValid()) {
            // register user in player table
            $game_id = htmlspecialchars($this->getRequest()->getParam('game_id'));

            $data = array('user_id'  => $identity['user_id'],
                          'game_id'  => $game_id,
                          'score'    => 0,
                          'playing'  => 1,
                          'enrolled' => 1);

            $playerObj = new Application_Model_Player();
            $player = $playerObj->addPlayer($data);

            if (!$player)
               $this->_helper->flashMessenger->addMessage('There was an error joining the game. Please contact us');

            $this->_redirect('/game');
         } else {
            $this->_helper->flashMessenger->addMessage("Login was incorrect. Please try again");
            $this->_redirect('/');
         }
      } else {
         $this->_helper->flashMessenger->addMessage("Login was incorrect. Please try again");
         $this->_redirect('/');
      }
   }

   public function displayAction() {
      $this->_helper->layout()->enableLayout();
      $this->_helper->viewRenderer->setNoRender(false);

      $gameObj  = new Application_Model_Game();
      $nextgame = $gameObj->getNextActiveGame();
      $game_id  = is_numeric($nextgame['game_id']) ? $nextgame['game_id'] : 1;

      $this->view->game_id = $game_id;
   }

   public function logoutAction() {
      $auth = Zend_Auth::getInstance();
      $auth->clearIdentity();

      Zend_Session::destroy();
      $this->_redirect('/');
   }
}
