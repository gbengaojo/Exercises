<?php
/*-----------------------------------------------------------
Class: Application_Model_Status
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: June 12, 2012
Modified: June 13, 2012

Status Model
------------------------------------------------------------*/

class Application_Model_Status
{
   protected $user_id;
   protected $status;
   protected $date;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate todo: with rigor post-beta
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      // todo: rigorously post-beta
      $this->user_id = htmlspecialchars($values['user_id']);
      $this->status  = htmlspecialchars($values['status']);
      $this->date    = ($values['date'] == '') ? date('Y-m-d H:i:s') : htmlspecialchars($values['date']);
   }

   /**
    * create a status update and write to db
    *
    * @return: (int) last insert id on success
    *          (bool) false on error
    */
   public function createStatus() {
      $data = array('user_id' => $this->user_id,
                    'status'  => $this->status,
                    'date'    => $this->date);

      try {
         $n = $this->db->insert(TBL_STATUS, $data);
         return $this->db->lastInsertId();
      } catch (Exception $e) {
         // todo (post-beta): implement logging post-beta
print_r($e);
         return false;  
      }
   }

   /**
    * get status for a user
    *
    * @param: (int) user_id (optional)
    * @return: (array) status record
    */
   public function getStatus($user_id = '') {
      if (empty($user_id))
         $user_id = $this->user_id;

      $query = "SELECT * FROM " . TBL_STATUS . " WHERE user_id = ? ORDER BY date DESC LIMIT 10";
      $statusdata = $this->db->fetchAll($query, array($user_id));

      return $statusdata;
   }
}
