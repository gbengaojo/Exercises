<?php

class DashboardController extends Zend_Controller_Action
{
   public $initObj;

   public function init() {
      /* Initialize action controller here */
      $this->initObj = $this->_helper->initShadow();

      // echo '<pre>'; print_r($initObj); echo $initObj['identity']['user_id']; die;
   }

   public function indexAction() {
      $gameObj           = new Application_Model_Game();
      $games             = $gameObj->getGames();
      $this->view->games = $games;
   }

   public function playAction() {
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      $game_id = htmlspecialchars($this->getRequest()->getParam('game_id'));

      $data = array('user_id'  => $this->initObj['identity']['user_id'],
                    'game_id'  => $game_id,
                    'score'    => 0,
                    'playing'  => 1,
                    'enrolled' => 1);

      $playerObj = new Application_Model_Player();
      $player = $playerObj->addPlayer($data);

      if (!$player)
         $this->_helper->flashMessenger->addMessage('There was an error joining the game. Please contact us');

      $this->_redirect('/game');
   }   
}
