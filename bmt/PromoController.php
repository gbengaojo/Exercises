<?php
/*-----------------------------------------------------------
Class: PromoController
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 1, 2014
Modified: October 4, 2014
          November 10, 2014

init()
indexAction()
------------------------------------------------------------*/

class PromoController extends Zend_Controller_Action
{
   public function init() {
      /* Initialize action controller here */

      // flash messages
   }

   public function twoForOneAction() {
      if (!$_POST)
         return;

      // in redemption_code table, add field for "opt-in-two-for-one"
      // when purchasing a redemption code, if this field is true, send two redemption codes
      $email = htmlspecialchars($this->getRequest()->getParam('email'));

      if (strlen($email) > 4) { 
         // auth user -- email only
         $email   = htmlspecialchars($this->getRequest()->getParam('email'));
         $userObj = new Application_Model_User();
         $user    = $userObj->getUserFromEmail($email);
         $user_id = $user['user_id'];

         if (is_numeric($user_id)) {
            $userObj           = new Application_Model_User();           // needed? \ seems to be sent after
            $redemptionCodeObj = new Application_Model_RedemptionCode(); // needed?  } check in xmlPostBack
            $creditObj         = new Application_Model_Credits();        // needed? / 
            $promoObj          = new Application_Model_Promo();

            $timestamp = date("Y-m-d H:i:s");

            // todo: opt out after use; UltraCartController::xmlPostBackAction
            $promoObj->optIn($user_id, TBL_PROMO_2_FOR_1);
            /*
               todo:
               - when a purchased redemption_code is written to db, check this table
               - if `opt_in` field is true, send two redemption_codes instead of one
               - set elible = false
            */
            $this->_helper->flashMessenger->addMessage("You have successfully opted into our two-for-one redemption code promotion");
            $this->_redirect('http://secure.ultracart.com/cgi-bin/UCEditor?merchantId=CMP17&ADD=002');
            // $this->_redirect('/');
         } else {
             $this->_helper->flashMessenger->addMessage("1. An error occurred during the opt-in process. Please contact us.");
             $this->_redirect('/');   
         }
      } else {
         $this->_helper->flashMessenger->addMessage("2. An error occurred during the opt-in process. Please contact us.");
         $this->_redirect('/');
      }
   }

      /**
       * make sure the player has registered by checking email address & pwd
       * if they have registered, send an email containing their user_id
       */
   public function referralAction() {
      if (!$_POST)
         return;

      $email      = htmlspecialchars($this->getRequest()->getParam('email'));
      $password   = htmlspecialchars($this->getRequest()->getParam('password'));
      $password   = md5($password);

      // authenticate user
      $authAdapter = new AuthAdapter($email, $password);
      $auth        = Zend_Auth::getInstance();
      $result      = $auth->authenticate($authAdapter);
      $identity    = $auth->getIdentity();
      
      // $user_id =   $this->initObj['identity']['user_id'];  // no $initObj here 
      $userObj = new Application_Model_User();
      $user    = $userObj->getUserFromEmail($email);
      $user_id = $user['user_id'];

      if ($result->isValid()) {
         // send user their user_id for use when referring players
         $userObj   = new Application_Model_User();
         $promoObj  = new Application_Model_Promo();
         $twilioObj = new Application_Model_Twilio();
         $user    = $userObj->getUserFromEmail($email);
         $user_id = $user['user_id'];

         $promoObj->optIn($user_id, TBL_PROMO_REFERRAL);
         $promoObj->emailUserId($user_id, $email);
         $twilioObj->referral($user_id);

         $this->_helper->flashMessenger->addMessage("You have successfully opted into our referral promotion. Please check your email for your user id.");
         $this->_redirect('/');
      }

      $this->_helper->flashMessenger->addMessage("An error occurred during the opt in process. Please contact us");
      $this->_redirect('/');
   }

   public function threeForOneAction() {
      // same as two for one, but perhaps use the UltraCart shopping
      // items for quick turn-around, then update to using user
      // state in application
      if (!$_POST)
         return;

      // in redemption code (or maybe promo or new (opt_in) table) add field for "opt_in_three_for_one"
      // when purchasing a redemption code, send three redemption codes if this field is true
      $email      = htmlspecialchars($this->getRequest()->getParam('email'));
      $password   = htmlspecialchars($this->getRequest()->getParam('password'));
      $password   = md5($password);

      // authenticate user
      $authAdapter = new AuthAdapter($email, $password);
      $auth        = Zend_Auth::getInstance();
      $result      = $auth->authenticate($authAdapter);
      $identity    = $auth->getIdentity();

      if ($result->isValid()) {
         // send user their user_id for use when referring players
         // todo: opt out after use; UltraCartController::xmlPostBackAction
         $userObj = new Application_Model_User();
         $promoObj = new Application_Model_Promo();
         $user    = $userObj->getUserFromEmail($email);
         $user_id = $user['user_id'];
   
         $promoObj->optIn($user_id, TBL_PROMO_3_FOR_1);

         $this->_helper->flashMessenger->addMessage("You have successfully opted into our 3 for 1 promotion. Please check your email for your free redemption codes.");
         
         $this->_redirect('http://secure.ultracart.com/cgi-bin/UCEditor?merchantId=CMP17&ADD=002');
         // $this->_redirect('/');
      }

      $this->_helper->flashMessenger->addMessage("An error occurred during the opt in process. Please contact us");
      $this->_redirect('/');
   }
}
