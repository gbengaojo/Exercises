<?php
/*-----------------------------------------------------------
Class: Answer
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 22, 2012
Modified: October 22, 2012

Answer model
------------------------------------------------------------*/

class Application_Model_Answer
{
   public $question_id;
   public $answer;
   public $correct;

   public $answer_record; // this answer if provided to construct
   /**
    * construct
    */
   public function __construct($answer_id = null) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      if (!is_null($answer_id)) {
         $this->answer_record = $this->getAnswers($answer_id, true);
         $this->question_id   = $this->answer_record['question_id'];
         $this->answer        = $this->answer_record['answer'];
         $this->correct       = $this->answer_record['correct'];
      }
   }

   /**
    * get answers
    *
    * @param: (int) answer_id
    * @return: (array) answers
    */
   public function getAnswers($answer_id = null, $onedimension = false) {
      if (!$answer_id) {
         $query = "SELECT * FROM " . TBL_ANSWER;
         $result = $this->db->fetchAll($query);
      } else {
         $query = "SELECT * FROM " . TBL_ANSWER . " WHERE answer_id = ?";
         if ($onedimension)
            $result = $this->db->fetchRow($query, $answer_id);
         else
            $result = $this->db->fetchAll($query, $answer_id);
      }

      return $result;
   }

   /**
    * insert answer
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addAnswer($data) {
      try {
         $n = $this->db->insert(TBL_ANSWER, $data);
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
   public function editAnswer($data, $id) {
      try {
         $n = $this->db->update(TBL_ANSWER, $data, "answer_id = $id");
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
   public function deleteAnswer($id) {
      try {
         $n = $this->db->delete(TBL_ANSWER, "answer_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * check for correct answer
    *
    * @param: (int) question_id
    * @param: (int) answer
    * @return: (bool) true if correct
    */
   public function isCorrect($question_id, $answer) {
// echo "<pre>qid: $question_id, answer: $answer\n\n\n"; die;
      $query = "SELECT `correct` FROM " . TBL_ANSWER . " WHERE question_id = ? AND correct = 1";
      $result = $this->db->fetchOne($query, $question_id);

      if ($result == $answer)
         return true;

      return false;
   }
}
