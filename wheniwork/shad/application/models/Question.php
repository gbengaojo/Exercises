<?php
/*-----------------------------------------------------------
Class: Question
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 22, 2012
Modified: October 22, 2012

Question model
------------------------------------------------------------*/

class Application_Model_Question
{
   public $question_id;
   public $question;
   public $question_type_id;
   public $img_filename;

   public $question_record; // this question if provided to construct
   public $answers;         // object containing several answers
   public $clues;

   /**
    * construct
    */
   public function __construct($question_id = null) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      if (!is_null($question_id)) {
         $this->question_id      = $question_id;
         $this->question_record  = $this->getQuestions($question_id, true);
         $this->question         = $this->question_record['question'];
         $this->question_type_id = $this->question_record['question_type_id'];
         $this->img_filename     = $this->question_record['img_filename'];
         $this->answers          = $this->getQuestionAnswers($question_id);
         $this->clues            = $this->getClues($question_id);
      }
   }

   /**
    * get all answers for this question
    *
    * @param: (int) question_id
    * @return: (array) answers
    */
   public function getQuestionAnswers($question_id) {
      $query = "SELECT * FROM " . TBL_ANSWER . " WHERE question_id = ?";
      try {
         $answers = $this->db->fetchAll($query, $question_id);
         $this->answers = $answers;
         return $answers;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get questions
    *
    * @param: (int) question_id
    * @return: (array) game or several games
    */
   public function getQuestions($question_id = null, $onedimension = false) {
      if (!$question_id) {
         $query = "SELECT * FROM " . TBL_QUESTION;
         $result = $this->db->fetchAll($query);
      } else {
         $query = "SELECT * FROM " . TBL_QUESTION . " WHERE question_id = ?";
         if ($onedimension)
            $result = $this->db->fetchRow($query, $question_id);
         else
            $result = $this->db->fetchAll($query, $question_id);
      }

      return $result;
   }

   /**   
    * get all clues for this question
    * 
    * @param: (int) answer_id
    * @return: (array) clues
    */
   public function getClues($question_id) {
      $query = "SELECT * FROM " . TBL_CLUE . " WHERE question_id = ?";
      try {
         $this->clues = $this->db->fetchAll($query, $question_id);
         return $this->clues;
      } catch (Exception $e) {
         // log
         return false;
      }
   }  


   /**
    * insert question
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addQuestion($data) {
      try {
         $n = $this->db->insert(TBL_QUESTION, $data);
         $id = $this->db->lastInsertId();

         return $id;
      } catch (Exception $e) {
         // log
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
   public function editQuestion($data, $id) {
      try {
         $n = $this->db->update(TBL_QUESTION, $data, "where question_id = $id");
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
   public function deleteQuestion($id) {
      try {
         $n = $this->db->delete(TBL_QUESTION, "question_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

}
