<?php
/*-----------------------------------------------------------
Class: Clue
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: October 22, 2012
Modified: October 22, 2012

Clue Model
------------------------------------------------------------*/

class Application_Model_Clue
{
   protected $question_id;
   protected $clue;

   /**
    * construct
    */
   public function __construct() {
      $this->db = Zend_Db_Table::getDefaultAdapter();
   }

   /**
    * get clues
    *
    * @param: (int) clue_id
    * @return: (array) game or several games
    */
   public function getClues($clue_id = null) {
      if (!$clue_id) {
         $query = "SELECT * FROM " . TBL_CLUE;
         $result = $this->db->fetchAll($query);
      } else {
         $query = "SELECT * FROM " . TBL_CLUE . " WHERE clue_id = ?";
         $result = $this->db->fetchAll($query, $clue_id);
      }

      return $result;
   }

   /**
    * insert clue
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addClue($data) {
      try {
         $n = $this->db->insert(TBL_CLUE, $data);
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
   public function editClue($data, $id) {
      try {
         $n = $this->db->update(TBL_CLUE, $data, "where clue_id = $id");
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
   public function deleteClue($id) {
      try {
         $n = $this->db->delete(TBL_CLUE, "clue_id = $id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }
}
