<?php
/*-----------------------------------------------------------
Class: Privacy
Author: Nikhil Redij <nikhil@beplused.com>
Modified By: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: July 11, 2012
Modified: September 2, 2012

Privacy Model

void init()
void setPrivacy()

------------------------------------------------------------*/

class Application_Model_Privacy
{
   protected $user_id;        // who does this feed belong to?
   protected $visibility;
   protected $messaging;
 
   private $db;
   private $valid_construct = true;
   
  /**
   * constructor
   * @param: $db: Adapter to the given table in the database
   * @param: $user_id: user id of current user
   * @param: $setting_see: who can see you
   * @param: $setting_friend: who can friend you
   * @param: $setting_message: who can message you
   */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
   }   

  /**
   * fetch data from PrivacyController and update bp_privacy table depending upon the condition
   *
   * @param: (array) data
   * @param: (int) user_id
   * @return: (bool) true on success
   */
   public function setPrivacy($data, $user_id) {
      if (!is_array($data) || !is_numeric($user_id))
         return false;

      try {
         $query = "SELECT * FROM " . TBL_PRIVACY . " WHERE user_id = ?";
         $result = $this->db->fetchRow($query, $user_id);

         if (count($result == 0)) {
            $data['user_id'] = $user_id;
            $n = $this->db->insert(TBL_PRIVACY, $data);
         } else {
            $n = $this->db->update(TBL_PRIVACY, $data, "user_id = $user_id");
         }
         return true;
      } catch (Exception $e) {
         // LOG
         return false;
      }
   }

   /**
    * get privacy for a user
    *
    * @param: (int) user_id
    * @return: (array) privacy record
    */
   public function getPrivacy($user_id) {
      if (!is_numeric($user_id)) {
         return array('visibility' => PRIVACY_EVERYONE,
                      'messaging'  => PRIVACY_EVERYONE);
      }

      try {
         $query = "SELECT * FROM " . TBL_PRIVACY . " WHERE user_id = ?";
         $result = $this->db->fetchRow($query, $user_id);
         return $result;
      } catch (Exception $e) {
         // LOG
         return array('visibility' => PRIVACY_EVERYONE,
                      'messaging'  => PRIVACY_EVERYONE);
      }
   }
}
