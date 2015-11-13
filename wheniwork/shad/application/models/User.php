<?php
/*-----------------------------------------------------------
Class: User
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: November 8, 2012
Modified: November 8, 2012

User model

construct
------------------------------------------------------------*/

class Application_Model_User
{
   public $user_id;
   public $email;
   public $password;
   public $firstname;
   public $lastname;
   public $created;

   /**
    * construct
    */
   public function __construct($user = null) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
   }

   /**
    * add user
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addUser($data) {
      try {
         $n = $this->db->insert(TBL_USER, $data);
         $id = $this->db->lastInsertId();

         return $id;
      } catch (Exception $e) {
         // log
         return false;
      }
   }


   /**
    * get first name
    *
    * @param: (int) user_id
    * @return: (string) firstname
    */
   public function getName($user_id) {
      $query = "SELECT firstname FROM " . TBL_USER . " WHERE user_id = ?";
      try {
         $result = $this->db->fetchOne($query, $user_id);
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }
}
