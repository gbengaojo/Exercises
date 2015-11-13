<?php

class GameController extends Zend_Controller_Action
{
   protected $initObj;
   protected $round;
   protected $tie_breaker;
   protected $user_id;
   protected $active_game_id;
   protected $logger;

   public function init() {
      /*  Initialize action controller here */
      $this->initObj = $this->_helper->initShadow();

      $gameNamespace = new Zend_Session_Namespace('Game');
      $gameObj       = new Application_Model_Game(true, $gameNamespace->active_game_id);
      $playerObj     = new Application_Model_Player();

      // some protected values
      $this->logger         = $this->initObj['logger'];
      $this->user_id        = $this->initObj['identity']['user_id'];
      $this->active_game_id = $gameNamespace->active_game_id;

      // check if any games are currently playing (active)
      if (!$gameObj->isActive($gameNamespace->active_game_id)) {
         $this->_redirect('/');
      }

      $this->tie_breaker = $gameObj->isTieBreaker($this->active_game_id, $this->user_id);
      $this->round       = $gameObj->getRound($gameNamespace->active_game_id);

      if ($this->tie_breaker) {
         $this->round = $gameObj->getRound($gameNamespace->active_game_id);
      }

      $this->view->tie_breaker  = $this->tie_breaker;
      $this->view->round        = $this->round;

      $gameNamespace->tie_breaker = $this->tie_breaker;
      $gameNamespace->round       = $this->round;

      // init tie breaker question answered state
      if (!$gameNamespace->isTie1Answered && !$gameNamespace->isTie2Answered && !$gameNamespace->isTie3Answered) {
         $gameNamespace->isTie1Answered = false;
         $gameNamespace->isTie2Answered = false;
         $gameNamespace->isTie3Answered = false;
      }

      // init game state
      $gameNamespace->game_state = GAME_STATE_PLAY;

      // determine game state
      if ($this->round < 0) {
         $gameNamespace->game_state = GAME_STATE_OVER;
      }
      if ($gameNamespace->round > ROUND_INIT && $gameNamespace->tie_breaker) {
         $gameNamespace->game_state = GAME_STATE_TIE;
      }
      if ($gameNamespace->round > ROUND_INIT && !$gameNamespace->tie_breaker) {
         $gameNamespace->game_state = GAME_STATE_PLAY_NO_TIE;
      }
      if ($gameNamespace->round > ROUND_INIT && $playerObj->isWinner($this->active_game_id, $this->user_id)) {
         $gameNamespace->game_state = GAME_STATE_WON;
      }
      if ($gameNamespace->round == ROUND_INIT && $gameNamespace->current_question < 0) {
         $gameNamespace->game_state = GAME_STATE_WAIT;
      }
      if ($gameNamespace->round == ROUND_INIT && $gameNamespace->current_question >= 0) {
         $gameNamespace->game_state = GAME_STATE_PLAY;
      }
      if ($gameNamespace->round == ROUND_TIE_ONE && $this->tie_breaker &&
         ($gameObj->getDbTime() < $gameObj->getRoundEndTime($gameNamespace->active_game_id, ROUND_TIE_ONE))) {
         $gameNamespace->game_state = GAME_STATE_TIE;
      }
      if ($gameNamespace->round == ROUND_TIE_TWO && $this->tie_breaker &&
         ($gameObj->getDbTime() < $gameObj->getRoundEndTime($gameNamespace->active_game_id, ROUND_TIE_TWO))) {
         $gameNamespace->game_state = GAME_STATE_TIE;
      }
      if ($gameNamespace->round == ROUND_TIE_THREE && $this->tie_breaker &&
         ($gameObj->getDbTime() < $gameObj->getRoundEndTime($gameNamespace->active_game_id, ROUND_TIE_THREE))) {
         $gameNamespace->game_state = GAME_STATE_TIE;
      }

      // determine game state during tie
      if ($gameNamespace->round > ROUND_INIT) {
         // if following is true, cannot be in tied status
         if ($playerObj->isWinner($this->active_game_id, $this->user_id)) {
            $gameNamespace->game_state = GAME_STATE_WON;
         } else if ($playerObj->getTiedStatus($this->active_game_id, $this->user_id)) {
            $gameNamespace->game_state = GAME_STATE_TIE;
         } else {
            $gameNamespace->game_state = GAME_STATE_OVER;
         }

         if ($this->round == ROUND_TIE_ONE && $gameNamespace->isTie1Answered) {
            $gameNamespace->game_state = GAME_STATE_WAIT;
         }
         if ($this->round == ROUND_TIE_TWO && $gameNamespace->isTie2Answered) {
            $gameNamespace->game_state = GAME_STATE_WAIT;
         }
         if ($this->round == ROUND_TIE_THREE && $gameNamespace->isTie3Answered) {
            $gameNamespace->game_state = GAME_STATE_WAIT;
         }
      }

      // debug -- remove
      $this->view->game_state = $gameNamespace->game_state;
      $this->view->current_question = $gameNamespace->current_question;

      $this->view->logger = $this->logger;

      $ajaxContext = $this->_helper->getHelper('AjaxContext');
      $ajaxContext->addActionContext('players', 'html')
                  ->initContext();
   }

   public function indexAction() {
      $gameNamespace = new Zend_Session_Namespace('Game');

      $gameObj     = new Application_Model_Game(true, $gameNamespace->active_game_id);
      $questionObj = new Application_Model_Question();
      $answerObj   = new Application_Model_Answer();
      $clueObj     = new Application_Model_Clue();

      // get questions
      $questions = $gameObj->getGameQuestions($gameNamespace->active_game_id);
      if ($gameNamespace->attempt_bonus) {
         $questions = $gameObj->getGameQuestions($gameNamespace->active_game_id, QUESTION_BONUS);
         $gameNamespace->current_question = 0;
      }
      if ($gameNamespace->tie_breaker) {
         $questions = $gameObj->getGameQuestions($gameNamespace->active_game_id, QUESTION_TIE_BREAKER);
      }

      foreach ($questions as $question) {
         $answers[] = $questionObj->getQuestionAnswers($question['question_id']);
         $clues[]   = $questionObj->getClues($question['question_id']);
      }

      if ($gameObj->isActive() && $gameNamespace->current_question == TOTAL_QUESTIONS + 1) {
         $this->view->attempt_prompt = "<p>do you want to attempt the bonus question?</p>" .
                                       '<a href="/game/bonus?bonus=1">Yes</a> | <a href="/game/bonus?bonus=0">No</a>';
      } else {
         $this->view->question    = $questions[$gameNamespace->current_question];
         $this->view->answer      = $answers[$gameNamespace->current_question];

         if ($gameNamespace->tie_breaker)
            $this->view->tie_breaker_prompt = "TIE BREAKER: ";

         if ($gameNamespace->attempt_bonus) {
            $this->view->clues = $clues[0];
            $this->view->bonus_question = true;
         }
      }

echo '<pre>'; print_r($_SESSION);
      if ($gameNamespace->current_question < 0) {
         $this->_redirect('/game/stats');
      }
   }

   public function checkAnswerAction() {
      $gameNamespace = new Zend_Session_Namespace('Game');

      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      $question_id      = htmlspecialchars($this->getRequest()->getParam('question_id'));
      $question_type_id = htmlspecialchars($this->getRequest()->getParam('question_type_id'));
      $answer           = htmlspecialchars($this->getRequest()->getParam('answer'));
      $clue_deduction   = htmlspecialchars($this->getRequest()->getParam('clue_deduction'));

      $gameObj   = new Application_Model_Game(true, $gameNamespace->active_game_id);
      $answerObj = new Application_Model_Answer();
      $playerObj = new Application_Model_Player();

      /****************************************************************/
      /** SCORE KEEPING **/
      /****************************************************************/
      // TODO: re-implement - perhaps encryption on user side; but some kind of code to check for correct answers
      //       CONSIDER USING the following:
      //          $correct = $answerObj->isCorrect($question_id, $answer);
      if ($gameNamespace->attempt_bonus) {
         $bonus_answer = $answerObj->getAnswers(10, true); // todo: implement better arguments/parameterization -> 10 = answer_id for the single bonus question

         if (strcasecmp($bonus_answer['answer'], $answer) == 0) {
            $playerObj->score($this->initObj['identity']['user_id'], $gameNamespace->active_game_id, $clue_deduction, QUESTION_BONUS);
         } else {
            $playerObj->score($this->initObj['identity']['user_id'], $gameNamespace->active_game_id, $clue_deduction, QUESTION_BONUS_DEDUCTION);
         }
      } else if (strcasecmp($answer, 'Peaches') == 0            ||
                 strcasecmp($answer, 'Death Wish') == 0         ||
                 strcasecmp($answer, 'Parks') == 0              ||
                 strcasecmp($answer, 'Martha\'s Vineyard') == 0 ||
                 strcasecmp($answer, 'Flipper Purify') == 0) {
         $playerObj->score($this->user_id, $gameNamespace->active_game_id, $clue_deduction, QUESTION_TIE_BREAKER);
      } else if ($answer == 1) {
         $playerObj->score($this->user_id, $gameNamespace->active_game_id, $clue_deduction);
      } else {
         // echo 'wrong';
      }

      // go to next question if possible
      if ($gameNamespace->attempt_bonus) {
         $gameNamespace->current_question = -1;
         $gameNamespace->attempt_bonus = 0;
      } else {
         $gameNamespace->current_question = $gameNamespace->current_question + 1;
      }

      /****************************************************************/
      /** END SCORE KEEPING **/
      /****************************************************************/

      if ($this->round > 0) {

         // TODO: re-implement numeric literals
         switch ($gameNamespace->current_question) {
            case 1 :
               $gameNamespace->isTie1Answered = true;
            break;

            case 2 :
               $gameNamespace->isTie2Answered = true;
            break;

            case 3 :
               $gameNamespace->isTie3Answered = true;
            break;
         }

         $this->_redirect('/game/stats');
      }

      // redirect to game
      $this->_redirect('/game');
   }

   public function statsAction() {
echo '<pre>'; print_r($_SESSION);
      $gameNamespace = new Zend_Session_Namespace('Game');

      if ($this->round <= 0) {
         $gameNamespace->current_question = 0;
      }

      $gameObj   = new Application_Model_Game(true, $gameNamespace->active_game_id);
      $playerObj = new Application_Model_Player();
      $this->view->players = $playerObj->getPlayers();
      $this->view->hiatus = $gameObj->getHiatus($gameNamespace->active_game_id, $gameNamespace->current_question);

      // if this player is tied
      if ($playerObj->getTiedStatus($this->active_game_id, $this->user_id)) {
         $this->view->tied = true;
      } else {
         $this->view->tied = false;
      }

      switch ($gameNamespace->game_state) {
         // highest scorer
         case GAME_STATE_WON :
            $this->view->prompt = "<p>Congratulations! You are the top scorer. Click here to claim your prize.</p>";
            $this->view->game_state = GAME_STATE_WON;
         break;

         // play
         case GAME_STATE_PLAY :
            $this->view->prompt = "GAME_STATE_PLAY";
            $this->view->game_state = GAME_STATE_PLAY;
         break;

         // game is in tie breaker mode, but this user is not tied for top score
         case GAME_STATE_PLAY_NO_TIE :
            if ($playerObj->isWinner($gameNamespace->active_game_id, $this->user_id)) {
               $this->view->prompt = "<p>You are tied for the top score. Please click here to claim your prize</p>";
            } else {
               $this->view->prompt = "<p>1.You are not the top scorer, but thanks for playing. Please check back later for more cash prizes</p>";
            }
            $this->view->game_state = GAME_STATE_PLAY_NO_TIE;
         break;

         // wait
         case GAME_STATE_WAIT :
            $this->view->prompt = "<p>You've answered all the questions, but please wait for the clock to expire for the results</p>";
            $this->view->game_state = GAME_STATE_WAIT;
         break;

         // tie
         case GAME_STATE_TIE :
            // if this player is tied
            $this->view->tied   = true;
            $this->view->prompt = '<p>You are tied for the top score. Do not leave this page. You will be asked a tie-breaking question in <span id="countdown"></span>.</p>';
            $this->view->hiatus = $gameObj->getHiatus($gameNamespace->active_game_id, $gameNamespace->current_question);
            $this->view->game_state = GAME_STATE_TIE;
         break;

         // over
         case GAME_STATE_OVER :
            if ($playerObj->isWinner($gameNamespace->active_game_id, $this->user_id, true)) {
               $this->view->prompt = "<p>You are tied for the top score. Please click here to claim your prize</p>";
            } else {
               $this->view->prompt = "<p>2.You are not the top scorer, but thanks for playing. Please check back later for more cash prizes</p>";
            }
            $this->view->winners    = $playerObj->getWinners($gameNamespace->active_game_id);
            $this->view->score      = $playerObj->getScore($this->user_id);
            $this->view->highscore  = 'PLACE_HOLDER';
            $this->view->game_state = GAME_STATE_OVER;
         break;

         default :
         break;
      }
   }

   public function bonusAction() {
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      $bonusattempt  = htmlspecialchars($this->getRequest()->getParam('bonus'));
      $gameNamespace = new Zend_Session_Namespace('Game');

      $gameNamespace->current_question = $gameNamespace->current_question + 1;

      if ($bonusattempt) {
         $gameNamespace->attempt_bonus = true;
      } else {
         $gameNamespace->attempt_bonus = false;
         $gameNamespace->current_question = -1;
      }

      $this->redirect('/game');
   }

   public function playersAction() {
      $userObj   = new Application_Model_User();
      $playerObj = new Application_Model_Player();
      $players   = $playerObj->getPlayers();

      $output = '';
      foreach ($players as $player) {
         $name  = $userObj->getName($player['user_id']);
         $score = $playerObj->getScore($player['user_id']);
         $output .= "<p style=\"width: 100%\"><span>$name</span><span style=\"float: right\">$score pts</span></p><div style=\"clear: both\"></div>\n";
      }

      if (count($players) > 0 && $this->round != -1)
         echo $output;
   }   

   public function syncServerTimeAction() {
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      echo date('M j, Y H:i:s');
   }

   public function getCountdownTimeAction() {
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      $gameNamespace = new Zend_Session_Namespace('Game');

      $seconds = htmlspecialchars($this->getRequest()->getParam('seconds'));  
      if (!is_numeric($seconds))
         $seconds = null;

      $gameObj = new Application_Model_Game(true);
      $time = $gameObj->getCountdown($gameNamespace->round);

      echo $time;
   }

   public function deactivateGameAction() {
      /* could just determine tie_breaker here, but it's already being executed
         via cron - perhaps a todo when refactoring */
      $this->_helper->layout()->disableLayout();
      $this->_helper->viewRenderer->setNoRender(true);

      $gameObj = new Application_Model_Game(true);
      $gameObj->deactivateGame();
   }
}
