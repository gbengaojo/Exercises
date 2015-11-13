<?php
/*-----------------------------------------------------------
Class: Player
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 24, 2012
Modified: February 21, 2012

Player model

construct
getPlayers
addPlayer
editPlayer
deletePlayer
getScore
updateScore
score
compareScores
getTiedStatus
isWinner
getWinner
setWinner
leaveGame
------------------------------------------------------------*/

class Application_Model_Player
{
   public $player_id;
   public $user_id;
   public $game_id;
   public $score;
   public $playing;

   /**
    * construct
    */
   public function __construct() {
      $this->db = Zend_Db_Table::getDefaultAdapter();
   }

   /**
    * get players
    *
    * @param: (int) player_id
    * @return: (array) players
    */
   public function getPlayers($player_id = null, $onedimension = false) {
      if (!$player_id) {
         $query = "SELECT * FROM " . TBL_PLAYER;
         $result = $this->db->fetchAll($query);
      } else {
         $query = "SELECT * FROM " . TBL_PLAYER . " WHERE player_id = ?";
         if ($onedimension)
            $result = $this->db->fetchRow($query, $player_id);
         else
            $result = $this->db->fetchAll($query, $player_id);
      }

      return $result;
   }

   /**
    * create player
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addPlayer($data) {
      try {
         $n = $this->db->insert(TBL_PLAYER, $data);
         $id = $this->db->lastInsertId();

         return $id;
      } catch (Exception $e) {
         // log
         echo '<pre>'; print_r($e); die;
         return false;
      }
   }

   /**
    * edit
    *
    * @param: (array) data
    * @param: (int) $id - primary key
    * @return: (bool) true on success
    */
   public function editPlayer($data, $id) {
      try {
         $n = $this->db->update(TBL_PLAYER, $data, "player_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * delete
    *
    * @param: (int) id
    * @return: (bool) true on success
    */
   public function deletePlayer($id) {
      try {
         $n = $this->db->delete(TBL_PLAYER, "player_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get player score
    *
    * @param: (int) user_id
    * @return: (int) score
    */
   public function getScore($user_id) {
      $query = "SELECT `score` FROM " . TBL_PLAYER . " WHERE user_id = ?";
      $result = $this->db->fetchOne($query, $user_id);

      return $result;
   }

   /**
    * update score
    *
    * @param: (int) player_id
    * @return: (int) updated score
    *          (bool) false on error
    */
   public function updateScore($data, $player_id) {
      try {
         $n = $this->db->update(TBL_PLAYER, $data, "player_id = $player_id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }     
   }

   /**
    * increase player score due to correct answer
    *
    * @param: (int) player_id
    * @param: (int) game_id - (not really nec, since cron will truncate after each game)
    * @param: (int) question_type
    * @return: (bool)
    */
   public function score($user_id, $game_id, $deduction = 0, $question_type = QUESTION_STANDARD) {
      $current_score = $this->getScore($user_id);

      switch ($question_type) {
         case QUESTION_BONUS_DEDUCTION :
            $new_score = $current_score - POINTS_BONUS_DEDUCTION - $deduction;
         break;

         case QUESTION_BONUS :
            $new_score = $current_score + POINTS_BONUS - $deduction;
         break;

         case QUESTION_TIE_BREAKER :
            $new_score = $current_score + POINTS_TIE_BREAKER;
         break;

         case QUESTION_STANDARD :
         default :
            $new_score = $current_score + POINTS_STANDARD;
         break;
      }

      $data = array('score' => $new_score);
      try {
         $n = $this->db->update(TBL_PLAYER, $data, "user_id = $user_id AND game_id = $game_id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * compare scores
    *
    * @param: (int) game_id
    * @return: (array) recordset if tie scores found
    *          (bool) false if none found
    */
   public function compareScores($game_id) {
      $query = "SELECT * FROM player WHERE game_id = ? AND score =
                  (SELECT score FROM player GROUP BY score HAVING ( COUNT(score) > 1 ))";

      try {
         $result = $this->db->fetchAll($query, $game_id);
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get tied status
    *
    * @param: (int) game_id
    * @param: (int) user_id
    * @return: (bool) true if this user is tied for high score
    */
   public function getTiedStatus($game_id, $user_id) {
      $query = "SELECT MAX(score) FROM player WHERE user_id != ?";
      $max   = $this->db->fetchOne($query, $user_id);

      if ($max == false)
         return false;

      $query  = "SELECT player_id FROM player WHERE score = ? AND user_id = ? AND game_id = ?";
      $result = $this->db->fetchOne($query, array($max, $user_id, $game_id));

      if ($result != false)
         return true;

      return false;
   }

   /**
    * determine if the authenticated user is a winner (or tied for a high score)
    *
    * @param: (int) game_id
    * @param: (int) user_id
    */
   public function isWinner($game_id, $user_id, $ignore_tied_status = false) {
      if (!is_numeric($user_id) || !is_numeric($game_id))
         return false;

      if ($this->getTiedStatus($game_id, $user_id) && !$ignore_tied_status)
         return false;

      $query = "SELECT MAX(score) FROM player";
      $max   = $this->db->fetchOne($query);

      $query  = "SELECT `score` FROM " . TBL_PLAYER . " WHERE user_id = ? AND game_id = ? AND score = ?";
      $result = $this->db->fetchOne($query, array($user_id, $game_id, $max));

      if ($result != false)
         return true;

      return false;

      /*
      $query = "SELECT user_id FROM winner";
      $result = $this->db->fetchOne($query);

      if ($user_id == $result)
         return true;

      return false;
      */
   }
   

   /**
    * get game winner
    *
    * @param: (int) game_id
    * @return: (int) user_id
    */
   public function getWinners($game_id) {
      $query = "SELECT MAX(score) FROM player";
      $max   = $this->db->fetchOne($query);

      $query  = "SELECT * FROM " . TBL_PLAYER . " JOIN " . TBL_USER . " ON " .
                 TBL_PLAYER . ".user_id = " . TBL_USER . ".user_id WHERE game_id = ? AND score = ?";
      $result = $this->db->fetchAll($query, array($game_id, $max));

      return $result;

      /*
      $query = "SELECT * FROM winner JOIN user ON winner.user_id = user.user_id WHERE game_id = ?";
      $result = $this->db->fetchAll($query, $game_id);

      return $result;
      */
   }

   /**
    * set game winner
    *
    * @param: (int) game_id
    * @param: (int) user_id
    */
   public function setWinner($game_id, $user_id) {
      $data = array('game_id' => $game_id,
                    'user_id' => $user_id);

      try {
         $this->db->insert(TBL_WINNER, $data);
      } catch (Exception $e) {
         // log
      }
   }

   /**
    * leave game
    *
    * @param: (int) game_id
    * @param: (int) user_id
    */
   public function leaveGame($game_id, $user_id) {
      try {
         $n = $this->db->delete(TBL_WINNER, "game_id = $game_id AND user_id = $user_id");
      } catch (Exception $e) {
         // log
      }
   }
}
