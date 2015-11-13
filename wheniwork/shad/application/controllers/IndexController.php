<?php

class IndexController extends Zend_Controller_Action
{
   protected $auth;

   public function init() {
      /* Initialize action controller here */

      // authentication
      $this->view->authenticated = false;
   
      $this->auth = Zend_Auth::getInstance();
      if ($this->auth->hasIdentity()) {
         $userObj = new Application_Model_User();
         $identity = $this->auth->getIdentity();
         $this->view->authenticated = true;
         $this->view->firstname = $userObj->getName($identity['user_id']);
      }

      // flash messages
      $flashHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
      $messages = $flashHelper->getMessages();
      if (count($messages > 0) && $messages != false)
         $this->view->messages = $flashHelper->getMessages();
      else
         $this->view->messages = false;
   }

   public function indexAction() {
      $gameObj  = new Application_Model_Game();
      $games    = $gameObj->getGames();
      $nextgame = $gameObj->getNextActiveGame();
      $this->view->games            = $games;
      $this->view->nextgame         = $nextgame;
      $this->view->seconds_to_start = $gameObj->getSecondsToStart($nextgame['game_id']);
      $this->view->isActive         = $gameObj->isActive($nextgame['game_id']);
   }

   public function howToPlayAction() {
   }
}
