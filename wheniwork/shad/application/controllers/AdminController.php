<?php

class AdminController extends Zend_Controller_Action
{
   public function init() {
      /* Initialize action controller here */
      $this->initObj = $this->_helper->initShadow();
      $layout = $this->_helper->layout();
      $layout->setLayout('adminlayout');
   }

   public function indexAction() {
      $gameObj = new Application_Model_Game();
      echo '<pre>'; print_r($gameObj);
   }

   public function gamesAction() {
      $gameObj           = new Application_Model_Game();
      $games             = $gameObj->getGames();
      $this->view->games = $games;
   }

   public function answersAction() {
      $answerObj           = new Application_Model_Answer();
      $questionObj         = new Application_Model_Question();

      $answers             = $answerObj->getAnswers();
      $this->view->answers = $answers;
   }

   public function questionsAction() {
      $questionObj           = new Application_Model_Question();
      $questions             = $questionObj->getQuestions();
      $this->view->questions = $questions;
   }

   public function cluesAction() {
      $clueObj           = new Application_Model_Clue();
      $clues             = $clueObj->getClues();
      $this->view->clues = $clues;
   }

   public function editAnswersAction() {
      if (!$this->getRequest()->isPost())
         return;

      $game_id  = htmlspecialchars($this->getRequest()->getParam('game_id'));
      $question = htmlspecialchars($this->getRequest()->getParam('question'));
      $question_type_id = htmlspecialchars($this->getRequest()->getParam('question_type_id'));
      
      $data = array('game_id'          => $game_id,
                    'question'         => $question,
                    'question_type_id' => $question_type_id);

      $answerObj = new Application_Model_Answer();
      $result = $answerObj->addAnswer($data);

      if ($result)
         $this->_helper->flashMessenger->addMessage('Your answer has been saved');
      else
         $this->_helper->flashMessenger->addMessage('There was an error saving your question');

      $this->_redirect('/admin/answers');
   }
}
