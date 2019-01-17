<?php
/*-----------------------------------------------------------
Class: Plus
Original Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: May 21, 2012
Modified: July 11, 2012


Plus model

construct
getPlusTotals
createPlus
getDailyPlusCount
createDigest
consumeDigest
------------------------------------------------------------*/

class Application_Model_Plus
{
   protected $plus_id;
   protected $donor;          // user_id
   protected $recipient;      // user_id
   protected $media_id;       // comment?, message?, etc.
   protected $referential_id; // type specific id
   protected $plus_date;
   protected $quantity;       // default = 1

   protected $plusObj;        // subclass of superclass PlusableItem

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      if ($values['donor'] == '' || $values['recipient'] == '' ||
          $values['media_id'] == '' || $values['plus_date'] == '' ||
          $values['referential_id'] == '') {
         $this->valid_construct = false;
         return;
      }

      if (!is_numeric($values['donor']) || !is_numeric($values['recipient']) ||
          !is_numeric($values['media_id']) || !is_numeric($values['quantity']) ||
          !strtotime($values['plus_date']) || !is_numeric($values['referential_id'])) {
         $this->valid_construct = false;
         return;
      }

      if (!empty($values['quantity']) && !is_numeric($values['quantity'])) {
         $this->valid_construct = false;
         return;
      }

      // values ok
      $this->donor          = $values['donor'];
      $this->recipient      = $values['recipient'];
      $this->media_id       = $values['media_id'];
      $this->referential_id = $values['referential_id'];
      $this->plus_date      = $values['plus_date'];
      $this->quantity       = empty($values['quantity']) ? 1 : $values['quantity'];
   }

   /**
    * get plus totals
    * // todo (post-beta) flesh out flower garden
    *                     implement parameters better
    * // todo 20120626: Consider PlusableItem::getPluses()
    */
   public function getPlusTotals($user_id, $user = 'recipient', $duration = 'month', $media_id = '', $referential_id = '') {
      if (!is_numeric($user_id))
         return false;

      // year or month
      if ($duration == 'month') {
         $min_plus_date = date('Y-m') . '-01';
         $max_plus_date = date('Y-m') . '-31';
      } else {
         $min_plus_date = date('Y') . '-01-01';
         $max_plus_date = date('Y') . '-12-31';
      }

      $where  = "$user = ? AND plus_date >= ? AND plus_date <= ?";
      $params = array($user_id, $min_plus_date, $max_plus_date);

      // media_id and referential_id
      if (is_numeric($media_id)) {
         $where .= " AND media_id = ?";
         $params[] = $media_id;
      }
      if (is_numeric($referential_id)) {
         $where .= " AND referential_id = ?";
         $params[] = $referential_id;
      }

      try {
         $query = "SELECT SUM(quantity) FROM " . TBL_PLUS . " WHERE $where";
         $result = $this->db->fetchOne($query, $params);

         if (!$result)
            $result = 0;
      } catch (Exception $e) {
         // log
         return false;
      }

      return $result;
   }

   /**
    * get all pluses for this item within the given timeframe; create
    *    an array of the plus objects
    *
    * @param: (date) start_date
    * @param: (date) end_date
    * @param: (int) - user_id
    * @param: (string) - user ('recipient' or 'donor')
    * @return: (object array) - Plus objects; (bool) false on error
    */
   public function getPlusData($user_id = '', $user = 'recipient', $start_date = '', $end_date = '') {
      if (!is_numeric($user_id))
         return false;

      try {
         if ($start_date == '' && $end_date == '') {
            $query = "SELECT * FROM " . TBL_PLUS . " WHERE `$user` = ? ORDER BY `plus_date` DESC";
            $result = $this->db->fetchAll($query, $user_id);
         } else {
            $query = "SELECT * FROM " . TBL_PLUS . " WHERE `plus_date` >= ? AND `plus_date` <= ? AND `$user` = ? ORDER BY `plus_date` DESC";
            $result = $this->db->fetchAll($query, array($start_date, $end_date, $user_id));
         }

         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }

      // use referential_ids and media_ids to get object data
   }


   /**
    * creates a new plusable item and writes to db
    *
    * @param: (array) data - optional, plus data
    * @return: (bool) false on error
    */
   public function createPlus($data) {
      if (!is_array($data)) {
         $data = array('donor'          => $this->donor,
                       'recipient'      => $this->recipient,
                       'media_id'       => $this->media_id,
                       'referential_id' => $this->referential_id,
                       'plus_date'      => $this->plus_date,
                       'quantity'       => $this->quantity);
      }

      try {
         // get daily total
         $daily_count = $this->getDailyPlusCount($data['donor']);

         if ($daily_count >= PLUS_DAILY_ALLOTMENT)
            return false;

         // persist plus
         $n = $this->db->insert(TBL_PLUS, $data);

         // increment counter in db
         $daily_count += 1;
         $counter_data = array('daily_count' => $daily_count);

         $m = $this->db->update(TBL_PLUS_COUNTER, $counter_data, "user_id = " . $data['donor']);
         return $n;
      } catch (Exception $e) {
         return false;
      }
   }

   /**
    * get daily pluses given
    *
    * @param: (int) user_id
    * @return: (int)
    */
   public function getDailyPlusCount($user_id) {
      if (!is_numeric($user_id))
         return false;

      try {
         $query = "SELECT `daily_count` FROM " . TBL_PLUS_COUNTER . " WHERE user_id = ?";
         $daily_count = $this->db->fetchOne($query, $user_id);

         if (!$daily_count) { // create a record for this user
            $data = array('user_id'      => $user_id,
                          'daily_count'  => 0);
            $this->db->insert(TBL_PLUS_COUNTER, $data);
            $daily_count = 0;
         }

         return $daily_count;
      } catch (Exception $e) {
         return false;
      }
   }

   /**
    * create hashed digest for values that must exist on client
    *
    * @param: (array) plus - optional; values corresponding to plus 
    * @return: (string) plusdigest - md5 hash // todo: implement stronger encryption post beta
    */
   public function createDigest($plusdata = '') {
      // todo: (post-beta) - scrutinize input and/or return error on invalid
      if (!is_array($plusdata)) {
         $plusdata = array('donor'         => $this->donor,           // authenticated user
                           'recipient'     => $this->recipient,       // user whose profile is being viewed
                           'plus_date'     => $this->plus_date,
                           'quantity'      => $this->quantity);
                         //'media_id'      => $this->media_id,        // the digest to be displayed on the client
                                                                      // cannot know the media_id at the controller

      }

      $plus_string = implode('|', $plusdata);

      // $plus_digest = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
      // $digest = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(ENCRYPTION_KEY), $plus_string, MCRYPT_MODE_CBC, md5(md5(ENCRYPTION_KEY))));
      $digest = base64_encode($plus_string); // todo (post-beta) - sweet flyin' potatoes! implement some better encryption

      return $digest;
   }

   /**
    * consume digest and extract individual data pieces
    *
    * @param: (string) md5 digest // todo (post-beta) implement stronger encryption
    * @return: (array) plus data array that can be used to write to db
    */
   public function consumeDigest($digest) {
      // $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
      // $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(ENCRYPTION_KEY), base64_decode($digest), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
      $decrypted = base64_decode($digest); // todo (post-beta) - jumpin' jellybeans! implement some better decryption
      $data = explode('|', $decrypted);

      $plusdata = array('donor'     => $data[0],
                        'recipient' => $data[1],
                        'plus_date' => $data[2],
                        'quantity'  => $data[3]);

      return $plusdata;
   }
}
