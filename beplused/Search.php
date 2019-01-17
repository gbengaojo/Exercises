<?php
/*-----------------------------------------------------------
Class: Search
Author: Asmita Shinde <asmita@beplused.com>
        Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: July 15, 2012
Modified Date: August 22, 2012
Search model
------------------------------------------------------------*/

class Application_Model_Search
{
   private $db;
   private $valid_construct = true;

   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
   }

   /**
    * get users based on search results
    *
    * @param: (string) search - terms to search for
    * @param: (string) table 
    * @return: (array|int) user_ids matching the search
    *          (bool) false on error
    */
   public function search($search, $table = TBL_USER) {
      // TODO: validate with rigor
      if (empty($search))
         return false;

      $terms = explode(" ", $search);
      $i = 0;

      switch ($table) {
         case TBL_GROUP :
            foreach($terms as $term) {
               $where .= "title LIKE ? OR description LIKE ? OR ";
               for ($i = 0; $i < 2; $i++)
                  $queryparams[] = "%$term%";
            }
            $select  = '*';
            $where   = substr($where, 0, -3); // remove trailing OR
            $orderby = 'title ASC';
         break;

         case TBL_USER :
         default :
            foreach($terms as $term) {
               $where .= "firstname LIKE ? OR lastname LIKE ? OR email LIKE ? OR ";
               for ($i = 0; $i < 3; $i++)
                  $queryparams[] = "%$term%";
            }
            $select  = '`user_id`';
            $where   = substr($where, 0, -3); // remove trailing OR
            $orderby = 'firstname DESC';
         break;
      }

      try {
         $query = "SELECT $select FROM $table WHERE $where ORDER BY $orderby";

         switch ($table) {
            case TBL_USER :
               $result = $this->db->fetchCol($query, $queryparams);
            break;

            case TBL_GROUP :
            default :
               $result = $this->db->fetchAll($query, $queryparams);
            break;
         }

         return $result;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }
   }
}
