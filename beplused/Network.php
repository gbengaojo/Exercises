<?php
/*-----------------------------------------------------------
Class: Network
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: June 14, 2012
Modified: September 24, 2012

Network Model

construct
array getNetwork(int)

------------------------------------------------------------*/

class Application_Model_Network
{
   protected $network_id;
   protected $network;
   protected $bp_image;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($network_id = '', $user_id = '') {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      if (!is_numeric($network_id) || !is_numeric($user_id)) { 
         $this->valid_construct = false;
         return;
      }

      $this->setNetwork($network_id, $user_id);
   }

   /**
    * get a user's network_id
    *
    * @param: (int) user_id
    * @return: (int) network_id
    *          (bool) false on error
    */
   public function getUserNetwork($user_id) {
      if (!is_numeric($user_id))
         return false;

      try {
         $query  = "SELECT network_id FROM " . TBL_PROFILE . " WHERE user_id = ?";
         $network_id = $this->db->fetchOne($query, $user_id);
         return $network_id;
      } catch (Exception $e) {
         // LOG
         return false;
      }
   }

   /**
    * get the network a user is currently browsing (held in the session)
    *
    * @return: (array) [(int) network_id, (string) networkname]
    *          (bool) false on error
    */
   public function getBrowsingNetwork() {
      $networkNamespace = new Zend_Session_Namespace('Network');

      if (!empty($networkNamespace->network_id) && !empty($networkNamespace->networkname)) {
         return array('network_id'  => $networkNamespace->network_id,
                      'networkname' => $networkNamespace->networkname);
      } else {
         return false;
      }  
   }

   /**
    * get a user's network name
    */
   public function getUserNetworkName($user_id) {
      if (!is_numeric($user_id))
         return false;

      try {
         $network_id = $this->getUserNetwork($user_id);
         $result = $this->getNetworkName($network_id);
         return $result;
      } catch (Exception $e) {
         // LOG
         return false;
      }
   }

   /**
    * get a network record
    *
    * @param: (int) network_id - (optional) retrieved from UI and sent via controller
    * @return: (array) network data
    */
   public function getNetwork($network_id = '') {
      if (!is_numeric($network_id))
         $network_id = $this->network_id;

      $query = "SELECT * FROM " . TBL_NETWORK . " WHERE id = ?";
      $network = $this->db->fetchRow($query, array($network_id));

      return $network;
   }

   /**
    * get network name by id
    *
    * @param: (int) network_id
    * @return: (string) network name
    *          (bool) false on error
    */
   public function getNetworkName($network_id = '') {
      if (!is_numeric($network_id) || $network_id == '')
         $network_id = $this->network_id;

      if ($network_id == '')
         return false;

      $query = "SELECT network FROM " . TBL_NETWORK . " WHERE id = ?";
      return $this->db->fetchOne($query, array($network_id));
   }

   /**
    * get all networks
    *
    * @return: (array) all networks
    */
   public function getAllNetworks() {
      $query = "SELECT * FROM " . TBL_NETWORK;

      $networks = $this->db->fetchAll($query);
      return $networks;
   }

   /**
    * get newscred guid for this network
    *
    * todo (post-beta) - move this method to more appropriate place?
    *                    re-eval database schema, as perhaps field should
    *                    be in another place; probably a seperate table
    *                    then implemented with a join
    * @param: (int) network_id
    * @return: (string) guid for newscred
    */
   public function getNewscredGuid($network_id) {
      if (!is_numeric($network_id))
         $network_id = $this->network_id;

      try {
         $query = "SELECT `news_provider` FROM bp_network WHERE id = ?"; // todo: change id to network_id in db and here
         $guid = $this->db->fetchOne($query, array($network_id));

         return $guid;
      } catch (Exception $e) {
         return false; // todo (post-beta): implement error logging
      }
   }
   

   /**
    * set bg image for this network
    *
    * @param: (int) network_id
    */
   public function setNetworkBgImage($network_id = '') {
      if (!is_numeric($network_id))
         $network_id = $this->network_id;

      $query = "SELECT bg_image FROM " . TBL_NETWORK . " WHERE id = ?";
      $image = $this->db->fetchOne($query, array($network_id));

      $networkNamespace = new Zend_Session_Namespace('Network');
      $networkNamespace->bg_image = "/images/networks/$image";
      return $networkNamespace->bg_image;
   }

   /**
    * set network
    *
    * @param: (int) network_id
    * @param: (int) user_id
    * @param: (bool) updateProfile - update profile network id in db if true
    */
   public function setNetwork($network_id, $user_id, $updateProfile = false) {
      $networkname      = $this->getNetworkName($network_id);
      $networkNamespace = new Zend_Session_Namespace('Network');
      $networkNamespace->networkname = $networkname;
      $networkNamespace->network_id  = $network_id;
      $this->network_id              = $network_id;

      // UPDATE database
      if ($updateProfile)
         $n = $this->db->update(TBL_PROFILE, array('network_id' => $network_id), "user_id = $user_id");
   }

   /**
    * get users by network
    *
    * @param: (int) network_id
    * @return: (array:int) user_ids
    *          (bool) false on error
    */
   public function getUsersByNetwork($network_id) {
      if (!is_numeric($network_id) || $network_id <= 0)
         return;
      
      $query = "SELECT `user_id` FROM " . TBL_PROFILE . " WHERE network_id = ?";
      $users = $this->db->fetchCol($query, array($network_id));

      return $users;
   }
}
