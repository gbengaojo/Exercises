<?php
/*-----------------------------------------------------------
Class: GameController
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: December 17, 2013
Modified: March 14, 2014

init()
------------------------------------------------------------*/

class ClockController extends Zend_Controller_Action
{
   public function init() {
   }

   public function testAction() {

// **** may need to alter heartbeart to send signal, instead of sending here ****
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      $gameNamespace = new Zend_Session_Namespace('Game');

      $clockObj = new Application_Model_Clock();  // fixme: this is instantiating a new object
                                                  // several times a second

      $start = strtotime($clockObj->start);
      $tie1  = strtotime($clockObj->tie1);
      $tie2  = strtotime($clockObj->tie2);
      $tie3  = strtotime($clockObj->tie3);

      if (empty($gameNamespace->round)) {
         $gameObj = new Application_Model_Game(true);
         $round = $gameObj->getRound($gameObj->getActiveGame());
      } else {
         $round = $gameNamespace->round;
      }

      $time_remaining = 0;

      switch ($round) {
         case ROUND_INIT :
            $time_remaining = ($start + GAME_DURATION) - time();
         break;

         case ROUND_TIE_ONE :
            $time_remaining = $tie1 - time();
         break;

         case ROUND_TIE_TWO :
            $time_remaining = $tie2 - time();
         break;

         case ROUND_TIE_THREE :
            $time_remaining = $tie3 - time();
         break;
      }

      $startedAt = time();
      $server_time = date('H:i:s');

      header('Content-Type: text/event-stream');
      header('Cache-Control: no-cache');


      echo "retry: 500\n";


      if (($round == 0 || $round == 1 || $round == 2) && $time_remaining <= 0) {
         require_once "/home/orion/shadowandactfilms/library/scripts/init.php";

         $query = "UPDATE player SET tied = 0";
         mysql_query($query);

         shell_exec("php -e $path" . "tie_breaker.php");

         $auth = Zend_Auth::getInstance();
         $identity = $auth->getIdentity();
         $user_id = $identity['user_id'];

         sleep(5);
         $query = "SELECT * FROM player WHERE user_id = $user_id AND tied = 1";
         $result = mysql_query($query);
         $row = mysql_fetch_assoc($result); 

         if ($row['user_id'] == 0) {
            ob_clean();
            ob_end_clean();
            $gameNamespace->tie_breaker = false;
            $gameNamespace->tied_status = false;
            echo "data: game_over\n\n";
         }

         if ($row['user_id'] > 0 && $round <= 3 && $round > -1) {
            ob_clean();
            ob_end_clean();
            $gameNamespace->tie_breaker = true;
            $gameNamespace->tied_status = true;
               echo "data: 180 seconds\n\n";
         }
      } else {
         if ($round == -1) {
            ob_clean();
            ob_end_clean();
            $gameNamespace->tie_breaker = false;
            $gameNamespace->tied_status = false;
            echo "data: game_over\n\n";
         } else {
            echo "id: 1000\n";
            if ($time_remaining < 0) {
               echo "data: game_over\n\n";
            } else {
               echo "data: $time_remaining" . "\n";
            }
            // echo "data: round: $round" . "\n";
            // echo "data: start: $start" . "\n";
            // echo "data: tie1: $tie1, tie2: $tie2, tie3: $tie3" . "\n";
            // echo "data: time: " . time() . "\n";
            // echo "data: game_duration: " . GAME_DURATION . "\n";
            // echo "data: session_start: " . $gameNamespace->start . "\n";
            // echo "data: session_tie1:  " . $gameNamespace->tie1 . "\n";
            // echo "data: session_tie2:  " . $gameNamespace->tie2. "\n";
            // echo "data: session_tie3:  " . $gameNamespace->tie3 . "\n";

            echo "\n";
         }
      }
   }
}
