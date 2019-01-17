<?php
/*-----------------------------------------------------------
Class: Friend
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: June 1, 2012
Modified: August 23, 2012

Friend model

construct
bool addFriendRequest(int, int)
bool isFriend(int, int)
array getRequests(int)
bool confirmRequest(int, int)
array getFriends(int)
array getFriendsIds(int)

------------------------------------------------------------*/

class Application_Model_Friend
{
   protected $user_id;
   protected $friend_id;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
   }

   /**
    * send friend request
    *
    * @param: (int) friend_id
    * @param: (int) user_id - optional
    * @return: (bool) false on error; true on success
    */
   public function addFriendRequest($friend_id, $user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($friend_id))
         return false;

      if (!$this->isFriend($friend_id, $user_id)) {
         $data = array('user_id'   => $user_id,
                       'friend_id' => $friend_id,
                       'date'      => date('Y-m-d H:i:s'));

         try {
            // insert into friend, keep approved default at false
            $n = $this->db->insert(TBL_FRIEND, $data);
            return $n;
         } catch (Exception $e) {
            return false;
         }
      }

      return false;
   }

   /**
    * is a user a friend?
    *
    * @param: (int) test_id - the id of the friend we're testing for
    * @param: (int) user_id - optional
    * @return: (bool) true if friends
    * @throws: (Exception)
    */
   public function isFriend($test_id, $user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($test_id)) {
         throw new Exception('bad arguments: Friend::isFriend()');
      }

      $query = "SELECT * FROM " . TBL_FRIEND . " WHERE user_id = ? AND friend_id = ?";
      $result = $this->db->fetchRow($query, array($user_id, $test_id));

      if (is_array($result))
         return true;

      return false;
   }

   /**
    * get pending requests (requests made by others for this user)
    *
    * @param: (int) user_id
    * @return: (int array) user_ids of requests made by other users
    *          (bool) false on error
    */
   public function getPending($user_id) {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      try {
         $query = "SELECT user_id FROM " . TBL_FRIEND . " WHERE friend_id = ? AND approved = 0";
         $result = $this->db->fetchCol($query, array($user_id));
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get all friend requests for this user
    *
    * @param: (int) user_id - optional
    * @return: (int array) user_ids of users to whom this user made a friend request 
    *          (bool) false on error
    */
   public function getRequests($user_id) {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      try {
         $query = "SELECT friend_id FROM " . TBL_FRIEND . " WHERE user_id = ? AND approved = 0";
         $result = $this->db->fetchCol($query, array($user_id));
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * delete a friend :(
    *
    * @param: (int) user_id - optional
    * @param: (int) friend_id
    * @return: (bool) true on success, false on error
    */
   public function deleteFriend($friend_id, $user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($friend_id))
         return false;

      try {
         $n = $this->db->delete(TBL_FRIEND, "user_id = $user_id AND friend_id = $friend_id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * confirm friend request
    *
    * @param: (int) friend_id
    * @param: (int) user_id - optional
    * @return: (bool) true on success; false on error
    */
   public function confirmRequest($friend_id, $user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($friend_id))
         return false;

      try {
         // update existing request record
         $data = array('approved' => 1);
         $n = $this->db->update(TBL_FRIEND, $data, "user_id = $friend_id AND friend_id = $user_id");

         // insert reciprical record
         $data = array('user_id'   => $user_id,
                       'friend_id' => $friend_id,
                       'date'      => date('Y-m-d H:i:s'),
                       'approved'  => 1);
         $n = $this->db->insert(TBL_FRIEND, $data);
         return true; 
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get all friends for the authenticated user
    *
    * @param: (int) user_id - optional
    * @return: (array) array of friends or (bool) false
    */
   public function getFriends($user_id = '') {
      if (empty($user_id))
         $user_id = $this->user_id;

      $query = "SELECT * FROM " . TBL_FRIEND . " WHERE user_id = ? AND approved = 1";
      $friends = $this->db->fetchAll($query, $user_id);

      return $friends;
   }

   /**
    * get all friends _ids for this user
    *
    * @param: (int) user_id - optional
    * @param: (bool) filter - filter by network id?
    * @return: (int array) array of friend_ids | (bool) false on error
    */
   public function getFriendsIds($user_id = '', $filter = false, $network_id = 0) {
      if (empty($user_id))
         $user_id = $this->user_id;

      if (empty($user_id) || !is_bool($filter) || !is_numeric($network_id))
         return false;

      try {
         if (!$filter) {
            $query = "SELECT friend_id FROM " . TBL_FRIEND . " WHERE user_id = ? AND approved = 1";
            $friends = $this->db->fetchCol($query, $user_id);
         } else {
            $query = "SELECT friend_id, network_id FROM " . TBL_FRIEND . " LEFT JOIN " . TBL_PROFILE .
                     " ON friend_id = " . TBL_PROFILE . ".user_id WHERE " . TBL_FRIEND . ".user_id = ? " .
                     "AND network_id = ?";
            $friends = $this->db->fetchCol($query, array($user_id, $network_id));
         }
      } catch (Exception $e) {
         // log
         return false;
      }

      return $friends;
   }

   /**
    * delete (withdraw) a friend request
    *
    * @param: (int) user_id - optional
    * @param: (int) friend_id - who get the kabosh?
    */
   public function withdrawRequest($friend_id, $user_id) {
      return $this->deleteFriend($friend_id, $user_id);
   }
}
