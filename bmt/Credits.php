<?php
/*-----------------------------------------------------------
Class: Credits
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: April 28, 2013
Modified: August 18, 2013

construct()
------------------------------------------------------------*/

class Application_Model_Credits
{
   protected $credit_id;
   protected $user_id;
   protected $redemption_code_id;
   protected $credit;
   protected $date;

   /**
    * construct
    */
   public function __construct($credit_id = null) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
      $this->logger = Zend_Registry::get('log');
   }

   /**
    * get credits by differing filters
    *
    * @param: (array) filters ('user_id'            => (int),
    *                          'credit_id'          => (int),
    *                          'redemption_code_id' => (int),
    *                          'credit'             => (int),
    *                          'date'               => (string) "yyyy-mm-dd hh:mm:ss");
    * @param: (bool) if multi is true, return a record set, otherwise a single record
    * @return: (array)
    */
   public function getCredits($filters, $multi = false) {
      $query  = "SELECT * FROM " . TBL_CREDIT;
      $where  = " WHERE ";
      $params = array();

      if (!is_array($filters)) {
         if ($multi)
            $result = $this->db->fetchAll($query);
         else
            $result = $this->db->fetchRow($query);
      }

      if (is_numeric($filters['user_id'])) {
         $where .= " user_id = ? AND";
         $params[] = $filters['user_id'];
      }

      if (is_numeric($filters['credit_id'])) {
         $where .= " credit_id = ? AND";
         $params[] = $filters['credit_id'];
      }

      if (is_numeric($filters['redemption_code_id'])) {
         $where .= " redemption_code_id = ? AND";
         $params[] = $filters['redemption_code_id'];
      }

      if (is_int($filters['credit'])) {
         $where .= " credit = ? AND";
         $params[] = $filters['credit'];
      }

      if (strtotime($filters['startdate']) && strtotime($filters['enddate'])) {
         // start and end dates; e.g., get all credits between these date
      }

      $where = substr($substr, 0, -4);
      $query .= $where;

      try {
         if ($multi)
            $result = $this->db->fetchAll($query, $params);
         else
            $result = $this->db->fetchRow($query, $params);

         return $result;
      } catch (Exception $e) {
         // log
         include 'includes/db_logger.php';
         $this->logger->log($message, Zend_Log::ERR);
         return false;
      }
   }

   /**
    * write credit to db
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addCredit($data) {
      try {
         $n = $this->db->insert(TBL_CREDIT, $data);
         $id = $this->db->lastInsertId();

         return $id;
      } catch (Exception $e) {
         // log
         include 'includes/db_logger.php';
         $this->logger->log($message, Zend_Log::ERR);
         return false;
      }
   }

   /**
    * edit credit db record
    *
    * @param: (array) data
    * @param: (int) credit_id
    * @return: (bool) true on success
    */
   public function editCredit($data, $credit_id) {
      try {
         $n = $this->db->update(TBL_CREDIT, $data, "credit_id = $credit_id");
         return $n;
      } catch (Exception $e) {
         // log
         include 'includes/db_logger.php';
         $this->logger->log($message, Zend_Log::ERR);
         return false;
      }
   }

   /**
    * delete credit
    *
    * @param: (int) credit_id
    * @retrun: (bool) true on success
    */
   public function deleteCredit($credit_id) {
      try {
         $n = $this->db->delete(TBL_CREDIT, "credit_id = $credit_id");
         return $n;
      } catch (Exception $e) {
         // log
         include 'includes/db_logger.php';
         $this->logger->log($message, Zend_Log::ERR);
         return false;
      }
   }
}
