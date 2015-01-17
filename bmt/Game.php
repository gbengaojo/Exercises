<?php
/*-----------------------------------------------------------
Class: Game
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 22, 2012
Modified: November 15, 2014

Game model

construct
bool initGame()
array getGameQuestions(int)
bool hasGameStarted()
mixed getActiveGame()
array getNextActiveGame()
string getCountdown(int)
mixed getGames(int)
mixed getPublishedGames()
array getPlayers(int)
int addGame(array)
bool editGame(array, int)
bool deleteGame(int)
int deactivateGame(int)
bool isTieBreaker(int, int)
bool isActive(int)
bool setTieBreaker(int)
int getRound(int)
datetime getRoundEndTime(int, int)
int|datetime getDbTime(bool)
int getHiatus(int, int)

// TODO: db schema: `start` -> time game starts
//                  `tieN`  -> time tie breaker round ends
//       consolidate so `tieN` columns indicate when tie
//       breaker rounds en
------------------------------------------------------------*/

class Application_Model_Game
{
   public $game_id;
   public $title;
   public $start;
   public $prize;
   public $duration;

   public $game;      // this game if provided to construct
   public $questions; // object containing several answers


   /**
    * construct
    */
   public function __construct($playing = false, $game_id = null) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
      $this->logger = Zend_Registry::get('log');

      if (is_numeric($game_id)) {
         $this->game_id   = $game_id;
         $this->game      = $this->getGames($game_id, true);
         $this->title     = $this->game['title'];
         $this->prize     = $this->game['prize'];
         $this->start     = $this->game['start'];
         $this->questions = $this->getGameQuestions($game_id);
      } else {
         $this->initGame($playing);
      }
   } 

   /**
    * initialize the game; if no game is currently active, state so to the user
    *
    * @return: (int) game_id of active game
    *          (bool) false if no game active
    */
   public function initGame($playing) {
      $gameNamespace   = new Zend_Session_Namespace('Game');

      $activegame      = $this->getActiveGame();
      $this->game_id   = $activegame;
      $this->game      = $this->getGames($activegame, true);
      $this->title     = $this->game['title'];
      $this->prize     = $this->game['prize'];
      $this->questions = $this->getGameQuestions($activegame);

      if (!$playing) {
         $gameNamespace->active_game_id   = $activegame;
         $gameNamespace->current_question = 0;
         $gameNamespace->game_over = 0;
         $gameNamespace->attempt_bonus = 0;

         $gameNamespace->title = $this->title;
         $gameNamespace->prize = $this->prize;
      }

      return $activegame;
   }

   /**
    * get all questions for a game
    *
    * @param: (int) game_id
    * @param: (int) question_type_id
    * @return: (array) questions
    */
   public function getGameQuestions($game_id, $question_type_id = null) {
      $query = "SELECT * FROM " . TBL_QUESTION . " WHERE game_id = ?";

      if (is_numeric($question_type_id)) {
         $query .= " AND question_type_id = ?";
         $params = array($game_id, $question_type_id);
      } else {
         $params = $game_id;
      }

      try {
         $questions = $this->db->fetchAll($query, $params);
         $this->questions = $questions;

         /* what the heck is this?
         foreach ($questions as $question) {
            $this->questions[] = new Application_Model_Question($question['question_id']);
         }*/

         return $questions;
      } catch (Exception $e) {
         // log
         $trace = $e->getTrace();
         $message = $e->getMessage();
         $message .= "\n" . print_r($trace[2]['args'], true);
         $this->logger->log($message, Zend_Log::ERR); 
         return false;
      }
   }

   /**
    * determine if start time has passed or not
    *
    * @return: (bool)
    */
   public function hasGameStarted() {
      $query = "SELECT `start` FROM game WHERE `active` = 1";
      $result = $this->db->fetchOne($query);

      $gametime = strtotime($result);
      $time = time();

      if ($time >= $gametime)
         return true;

      return false;
   }

   /**
    * get the active game (if any)
    *
    * @return: (int) the active game
    *          (bool) false if none
    */
   public function getActiveGame() {
      $query = "SELECT `game_id` FROM " . TBL_GAME . " WHERE active = 1";
      $result = $this->db->fetchOne($query);

      return $result;
   }

   /**
    * get the next scheduled game
    *
    * @return: (array) game record 
    */
   public function getNextActiveGame() {
      $query = "SELECT * FROM game WHERE `published` = 1 AND `start` = (SELECT min(`start`) FROM game WHERE `published` = 1)";
      $result = $this->db->fetchRow($query);

      return $result;
   }

   /**
    * get active game countdown time
    *
    * @return: date in format "M j, Y H:i:s"
    */
   public function getCountdown($round = ROUND_INIT) {
      $active_game_id = $this->getActiveGame();

      if (!$active_game_id)
         return false;

      try {
         switch ($round) {
            case ROUND_TIE_ONE :
               $query = "SELECT `tie1` FROM " . TBL_GAME . " WHERE game_id = ?";
            break;

            case ROUND_TIE_TWO :
               $query = "SELECT `tie2` FROM " . TBL_GAME . " WHERE game_id = ?";
            break;

            case ROUND_TIE_THREE :
               $query = "SELECT `tie3` FROM " . TBL_GAME . " WHERE game_id = ?";
            break;

            case ROUND_INIT :
            default :
               $query = "SELECT `start` + INTERVAL " . GAME_DURATION . " SECOND FROM " . TBL_GAME . " WHERE game_id = ?";
            break;
         }

         $result = $this->db->fetchOne($query, $active_game_id);

         return date('M j, Y H:i:s', strtotime($result));
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get number of seconds before game starts
    *
    * @param: (int) game_id
    * @return: (int) seconds
    */
   public function getSecondsToStart($game_id) {
      $query = "SELECT TIME_TO_SEC(TIMEDIFF(`start`, now())) FROM " . TBL_GAME . " WHERE game_id = ?";
      $result = $this->db->fetchOne($query, $game_id);

      return $result;
   }

   /**
    * get games
    *
    * @param: (int) game_id
    * @param: (bool) onedimension - return 1d array if only one result
    * @return: (array) game or several games
    */
   public function getGames($game_id = null, $onedimension = false) {
      if (!$game_id) {
         $query = "SELECT * FROM " . TBL_GAME . " ORDER BY `start` ASC";
         $result = $this->db->fetchAll($query);
      } else {
         $query = "SELECT * FROM " . TBL_GAME . " WHERE game_id = ?";
         if ($onedimension)
            $result = $this->db->fetchRow($query, $game_id);
         else
            $result = $this->db->fetchAll($query, $game_id);
      }

      return $result;
   }

   /**
    * get published games
    */
   public function getPublishedGames() {
      $query = "SELECT * FROM game WHERE published = 1 ORDER BY `start` ASC";
      $result = $this->db->fetchAll($query);

      return $result;
   }

   /**
    * get the players for a game
    *
    * @param: (int) game_id
    * @return: (array) players
    */
   public function getPlayers($game_id) {
      $query = "SELECT * FROM " . TBL_PLAYER . " WHERE game_id = ?";
      $result = $this->db->fetchAll($query, $game_id);

      return $result;
   }

   /**
    * construct time from day, hours, minute, meridium
    *
    * @param: (string) date
    * @param: (int) hours
    * @param: (int) minute
    * @param: (string) meridium
    * @return: (string) game start datetime "Y-m-d H:i:s"
    */
   public function constructTime($startdate, $hours, $minute, $meridium) {
      // TODO: meridium calculation; +12
      if ($meridium == 'pm')
         $hours += 12;

      return date('Y-m-d', strtotime($startdate)) . " $hours:$minute:00";
   }

   /**
    * get tie fields from start time
    *
    * @param
    * @return: (array) [tie1, tie2, tie3]
    */
   public function getTieRounds($start) {
      $tie1 = strtotime($start) + GAME_DURATION + TIE_DURATION + TI;
      $tie2 = $tie1 + TIE_DURATION + TI;
      $tie3 = $tie2 + TIE_DURATION + TI;

      $return['tie1'] = date('Y-m-d H:i:s', $tie1);
      $return['tie2'] = date('Y-m-d H:i:s', $tie2);
      $return['tie3'] = date('Y-m-d H:i:s', $tie3);

      return $return;
   }

   /**
    * insert game
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addGame($data) {
      try {
         $n = $this->db->insert(TBL_GAME, $data);
         $id = $this->db->lastInsertId();

         return $id;
      } catch (Exception $e) {
         // log
         $trace = $e->getTrace();
         $message = $e->getMessage();
         $message .= "\n" . print_r($trace[2]['args'], true);
         $this->logger->log($message, Zend_Log::ERR);
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
   public function editGame($data, $id) {
      try {
         $n = $this->db->update(TBL_GAME, $data, "game_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         $trace = $e->getTrace();
         $message = $e->getMessage();
         $message .= "\n" . print_r($trace[2]['args'], true);
         $this->logger->log($message, Zend_Log::ERR);
         return false;
      }
   }

   /**
    * delete
    *
    * @param: (int) id
    * @return: (bool) true on success
    */
   public function deleteGame($id) {
      try {
         $n = $this->db->delete(TBL_GAME, "game_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         include 'includes/db_logger.php';
         return false;
      }
   }

   /**
    * deactivate game
    */
   public function deactivateGame($game_id = null) {
      if (!is_null($game_id)) {
         $n = $this->db->update(TBL_GAME, array('active' => 0), "game_id = $game_id");
      } else {
         $n = $this->db->update(TBL_GAME, array('active' => 0));
      }
      return $n;
   } 

   /**
    * is game active?
    *
    * @param: (int) game_id
    * @return: (bool) true if active
    */
   public function isActive($game_id = null) {
      if (is_null($game_id))
         $game_id = $this->game_id;

      if (!is_numeric($game_id))
         return false;

      $query = "SELECT `round`, `active` FROM " . TBL_GAME . " WHERE game_id = ?";
      $result = $this->db->fetchRow($query, $game_id);

      /*
      $active = false;
      if ($result['round'] != -1 && $result['active'] == 1) {
         $active = true;
      }*/

      return $result['active'];
   }

   /**
    * tie-breaker mode?
    *
    * @param: (int) game_id
    * @return: (bool) true if in tie-breaker mode
    */
   public function isTieBreaker($game_id, $user_id) {
      $playerObj = new Application_Model_Player();
      $tiedstatus = $playerObj->getTiedStatus($game_id, $user_id);

      $query = "SELECT `round`, `tie_breaker` FROM " . TBL_GAME . " WHERE game_id = ?";
      $result = $this->db->fetchRow($query, $game_id);

      if ($result['tie_breaker'] && $result['round'] > 0 && $tiedstatus)
         return true;

      return false;
   }

   /**
    * set tie-breaker mode
    *
    * @param: (int) game_id
    */
   public function setTieBreaker($game_id = null) {
      $n = $this->db->update(TBL_GAME, array('tiebreak' => 1), "game_id = $game_id");
      return $n;
   }

   /**
    * get current round based on server time and time in db
    *
    * @param: (int) game_id
    * @return: (int) round
    */
   public function getRound($game_id) {
      $gameNamespace = new Zend_Session_Namespace('Game');
      $round = -1;

      // get round times
      $query = "SELECT `start`, `tie1`, `tie2`, `tie3`, `round` FROM game WHERE game_id = ?";
      $result = $this->db->fetchRow($query, $game_id);

      $start = strtotime($result['start']);
      $end   = $start + GAME_DURATION;
      $tie1  = strtotime($result['tie1']);
      $tie2  = strtotime($result['tie2']);
      $tie3  = strtotime($result['tie3']);

      if (($start <= time()) && (time() <= $end)) {
         $round = ROUND_INIT;
      } else if (($end < time()) && (time() <= $tie1)) {
         $round = ROUND_TIE_ONE;
      } else if (($tie1 < time()) && (time() <= $tie2)) {
         $round = ROUND_TIE_TWO;
      } else if (($tie2 < time()) && (time() <= $tie3)) {
         $round = ROUND_TIE_THREE;
      }

      $gameNamespace->round = $round;

      return $round;
   }

   /**
    * get round end time
    *
    * @param: (int) game_id
    * @param: (int) round
    * @return: (datetime)
    */
   public function getRoundEndTime($game_id, $round = ROUND_INIT) {
      switch ($round) {
         case ROUND_INIT :
         default :
            $col = 'start';
         break;

         case ROUND_TIE_ONE :
            $col = 'tie1';
         break;

         case ROUND_TIE_TWO :
            $col = 'tie2';
         break;

         case ROUND_TIE_THREE :
            $col = 'tie3';
         break;
      }

      $query = "SELECT TIME_TO_SEC($col) FROM " . TBL_GAME . " WHERE game_id = ?";
      $result = $this->db->fetchOne($query, $game_id);

      if ($col == ROUND_INIT) {
         $result += GAME_DURATION;
      }

      return $result;
   }

   /**
    * get db time (in seconds)
    *
    * @return: (int | datetime)
    */
   public function getDbTime($seconds = true) {
      if ($seconds) {
         $query = "SELECT TIME_TO_SEC(now())";
      } else {
         $query = "SELECT now()";
      }
      $result = $this->db->fetchOne($query);

      return $result;
   }

   /**
    * get the hiatus time befor tie-breaker rounds start
    *
    * @param: (int) game_id
    * @param: (int) tie-breaker round (0, 1, or 2)
    * @return: (int) # of seconds for hiatus
    */
   public function getHiatus($game_id, $tie_round) {
      if (!is_numeric($tie_round) || $tie_round > 2 || $tie_round < 0)
         return false;

      $tie_round += 1;
      $tie_round = 'tie' . $tie_round;

      $query = "SELECT ABS(TIME_TO_SEC(TIMEDIFF(`$tie_round`, now()))) - " . TIE_DURATION .
                  " FROM " . TBL_GAME . " WHERE game_id = ?";
      $result = $this->db->fetchOne($query, $game_id); // time the tie round ends

      if ($result > TIE_HIATUS)
         return TIE_HIATUS;

      return $result;
   }

   /**
    * get title
    */
   public function getTitle($game_id) {
      $query = "SELECT title FROM game WHERE game_id = ?";
      return $this->db->fetchOne($query, $game_id);
   }

  /**
   * get last game (latest game not scheduled for the future)
   */
   public function getLastGame() {
      $query = "SELECT * FROM game WHERE start < now() ORDER BY start DESC LIMIT 1";
      return $this->db->fetchRow($query);
   }
}
