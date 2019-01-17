<?php
/*-----------------------------------------------------------
Class: Feed
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: June 2, 2012
Modified: July 18, 2012

Feed Model
------------------------------------------------------------*/

class Application_Model_Feed
{
   protected $feed_id;
   protected $user_id;        // who does this feed belong to?
   protected $media_id;       // what media does this feed describe?
   protected $referential_id; // id of media (should some be curious)
   protected $feed;           // feed text
   protected $date;           // when did this happen?

   private $db;
   private $valid_contstuct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate; feed text cannot be adequately validated, must be sanitized
      // (likely already sanitized via a controller, but err on the side of
      // caution and refactor as necessary
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      if ($values['user_id'] == '' || $values['feed'] == '' ||
          $values['date'] == '') {
         $this->valid_construct = false;
         return;
      }

      if ((!empty($values['media_id']) && !is_numeric($values['media_id'])) ||
          (!empty($values['referential_id']) && !is_numeric($values['referential_id'])) ||
          !is_numeric($values['user_id']) || !strtotime($values['date']) ||
          strlen($values['feed']) > 1000) {
         $this->valid_construct = false;
         return;
      }

      // values ok, but still need to sanitize feed text
      // todo: research other sanitization methods
      $this->feed           = htmlspecialchars($values['feed']);
      $this->user_id        = $values['user_id'];
      $this->media_id       = $values['media_id'];
      $this->referential_id = $values['referential_id'];
      $this->date           = $values['date'];
   }

   /**
    * create a feed item and write to db
    *
    * @return: (int) last insert id on success;
    *          (bool) false on error;
    */
   public function createFeed() {
      $data = array('user_id'        => $this->user_id,
                    'media_id'       => $this->media_id,
                    'referential_id' => $this->referential_id,
                    'feed'           => $this->feed,
                    'date'           => $this->date);

      try {
         $n = $this->db->insert(TBL_FEED, $data);
         return $this->db->lastInsertId();
      } catch (Exception $e) {
         return false;
      }
   }

   /**
    * get feed data for friends of this user
    *
    * @param: (int) user_id - optional
    * @return: (array) friendFeed - feed rows
    */
   public function getFriendFeed($user_id = '') {
      if (empty($user_id))
         $user_id = $this->user_id;

      // get friend_ids for this guy
      $friendObj = new Application_Model_Friend();
      $friends = $friendObj->getFriendsIds($user_id);

      foreach ($friends as $friend_id) {
         $queryparams .= ' OR ' . TBL_FEED . '.user_id = ?';
      }
      $queryparams = substr($queryparams, 3); // remove initial 'OR'
      $query = "SELECT * FROM " . TBL_FEED . " JOIN " . TBL_USER . " ON " .
               TBL_FEED . ".user_id = " . TBL_USER . ".user_id WHERE $queryparams " .
               "ORDER BY " . TBL_FEED . ".date DESC";

      if (count($friends) <= 0 || $friends == '') {
         return false;
      }

      $friendFeed = $this->db->fetchAll($query, $friends);

      $profileObj = new Application_Model_Profile();

      for ($x = 0; $x < count($friendFeed); $x++) {
         $profileimage = $profileObj->getProfileImageLocation($friendFeed[$x]['user_id']);
         $friendFeed[$x]['thumb'] = $profileimage['thumb'];
      }

      return $friendFeed;
   }

   /**
    * get feed data for friends of this user in this network
    *
    * @param: (int) user_id - optional
    * @param: (int) network_id
    * @return: (array) networkFeed - feed rows
    *          (bool) false on error
    */
   public function getNetworkFeed($user_id = '', $network_id) {
      if (empty($user_id))
         $user_id = $this->user_id;

      // get friend_ids for this user
      $friendObj = new Application_Model_Friend();
      $friends = $friendObj->getFriendsIds($user_id);

      foreach ($friends as $friend_id) {
         $queryparams .= ' OR ' . TBL_FEED . '.user_id = ?';
      }
      $queryparams = substr($queryparams, 3); // remove initial 'OR'

      // todo: (post-beta) check following query; improper results being returned
      $query = "SELECT * FROM " . TBL_FEED . " JOIN " . TBL_USER . " ON " .
               TBL_FEED . ".user_id = " . TBL_USER . ".user_id JOIN " . 
               TBL_PROFILE . " ON " . TBL_PROFILE . ".network_id = ? WHERE ($queryparams)";

      // push network_id onto friends array
      array_unshift($friends, $network_id);               

      try {
         $networkFeed = $this->db->fetchAll($query, $friends);

         for ($x = 0; $x < count($networkFeed); $x++) {
            $networkFeed[$x]['thumb'] = USER_IMAGES_DIR . str_replace(array('@', '.'), '_', $networkFeed[$x]['email']) . '/profile_thumb.png';
         }
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }

      return $networkFeed;
   }

   /**
    * get notifications (feed)
    */
   public function getNotifications($user_id) {
      if (!is_numeric($user_id))
         return false;

      try {
         $query = "SELECT * FROM " . TBL_FEED . " WHERE user_id = ? ORDER BY date DESC";
         $result = $this->db->fetchAll($query, $user_id);

         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }
}
