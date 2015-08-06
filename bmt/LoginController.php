<?php
/*-----------------------------------------------------------
Class LoginController 
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 21, 2012
Modified Date: March 19, 2014
      
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
      /* commented out after implementing logging after registration
         and password renewal
      if (!$this->getRequest()->isPost())
         return;
      */

      $code = htmlspecialchars($this->getRequest()->getParam('redemption_code'));
      $username = $this->getRequest()->getParam('username');
      $password = $this->getRequest()->getParam('password');
      $password = md5($password);

      $gameObj           = new Application_Model_Game();
      $playerObj         = new Application_Model_Player();
      $redemptionCodeObj = new Application_Model_RedemptionCode();

      if (true) { // validate
         $authAdapter = new AuthAdapter($username, $password);
         $auth        = Zend_Auth::getInstance();
         $result      = $auth->authenticate($authAdapter);
         $identity    = $auth->getIdentity();

         if ($result->isValid()) {
            // register user in player table
            $nextgame_id = htmlspecialchars($this->getRequest()->getParam('game_id'));

            // redemption code
            $valid_code = $redemptionCodeObj->redeemCode($identity['user_id'], $nextgame_id, $code);

            if ($nextgame_id > 0) {
               $data = array('user_id'  => $identity['user_id'],
                             'game_id'  => $nextgame_id,
                             'score'    => 0,
                             'playing'  => 1,
                             'enrolled' => 1);
               if ($valid_code) {
                  $data['paid'] = 1;
               }

               $player = $playerObj->addPlayer($data);
            }
            if ($playerObj->hasPaid($identity['user_id'], $nextgame_id)) {
               $playerObj->setPaid($identity['user_id']);
            }

/*
            if (!$player) {
               // fixme: message displaying whenever user is redirected to login after clicking to start the game
               // $this->_helper->flashMessenger->addMessage('There was an error joining the game. Please contact us');
            }
*/

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
      $nextgame_id  = is_numeric($nextgame['game_id']) ? $nextgame['game_id'] : 0;

      $this->view->game_id = $nextgame_id;
   }

   public function resetAction() {
      $this->_helper->layout()->enableLayout();
      $this->_helper->viewRenderer->setNoRender(false);

      $email = htmlspecialchars($_POST['username']);
      $ignore = htmlspecialchars($_GET['ignore']);

      if ($ignore != 1) {
         $userObj = new Application_Model_User();
         $n = $userObj->resetPassword($email);

         if ($n == false) {
            $this->_helper->flashMessenger->addMessage("An error occurred while attempting to reset your password. Please contact us for support.");
         }
      }
   }

   public function setpasswordAction() {
      $email    = htmlspecialchars($_POST['username']);
      $tmp_pwd  = md5($_POST['tmp_password']);
      $password = md5($_POST['password']);
      $unencrypted_pwd = $_POST['password'];

      $userObj = new Application_Model_User();
      $user = $userObj->getUserFromEmail($email);

      if ($user['password'] == $tmp_pwd) {
         $result = $userObj->setPassword($user['user_id'], $password, $unencrypted_pwd);

         if ($result) {
            $this->_helper->flashMessenger->addMessage('Your password has been reset');
            $this->_redirect("/login?username=$email&password=$unencrypted_pwd");
         } else {
            $this->_helper->flashMessenger->addMessage("An error occurred while attempting to reset your password. Please contact us for support.");
         }
      } else {
        $this->_helper->flashMessenger->addMessage("The temporary password is incorrect. Please try again or contact us for support."); 
      }

      $this->_redirect('/');
   }

   public function logoutAction() {
      $auth = Zend_Auth::getInstance();
      $auth->clearIdentity();

      Zend_Session::destroy(true);
      // session_destroy();

      $this->_redirect('/');
   }
}
