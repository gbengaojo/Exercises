<?php
/*-----------------------------------------------------------
Class: Message
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: July 18, 2012
Modified: July 19, 2012

Message Model
------------------------------------------------------------*/

class Application_Model_Message
{
   protected $message_id;
   protected $messenger;
   protected $recipient;
   protected $subject;
   protected $message;
   protected $date;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate TODO: with vigor
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      // values ok
      $this->messenger = htmlspecialchars($values['messenger']);
      $this->recipient = htmlspecialchars($values['recipient']);
      $this->subject   = htmlspecialchars($values['subject']);
      $this->message   = htmlspecialchars($values['message']);
      $this->date      = htmlspecialchars($values['date']);
   }

   /**
    * create a message and write to db
    *
    * @param: (array) $data - optional data to write to db
    * @return: (int) last insert id on success
    *          (bool) false on error
    */
   public function createMessage($data = '') {
      if (!is_array($data)) {
         $data = array('messenger' => $this->messenger,
                       'recipient' => $this->recipient,
                       'subject'   => $this->subject,
                       'message'   => $this->message,
                       'date'      => $this->date);
      }

      try {
         $n = $this->db->insert(TBL_MESSAGE, $data);
         if ($n) {
            // feed monitor
            $feedObj = new Application_Model_Feed();
            $userObj = new Application_Model_User();
            $messenger = $userObj->getFirstName($data['messenger']);
            $recipient = $userObj->getFirstName($data['recipient']);

            $feed = array('user_id'        => $messenger,
                          'feed'           => "$messenger sent a message to $recipient",
                          'media_id'       => MEDIA_MESSAGE,
                          'referential_id' => $n,
                          'date'           => date('Y-m-d H:i:s'));
            $feedObj->createFeed();
         }            
         return $this->db->lastInsertId();
      } catch (Exception $e) {
         // TODO: Log errors
         return false;
      }
   }

   /**
    * getMessages for a given user
    *
    * @param: (int) user_id
    * @return: (array) messages
    *          (bool) false on error
    */
   public function getMessages($user_id) {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      $query = "SELECT * FROM " . TBL_MESSAGE . " WHERE recipient = ? ORDER BY date DESC";
      $query = "SELECT * FROM " . TBL_MESSAGE . " LEFT JOIN " . TBL_USER . " ON " .
               TBL_MESSAGE . ".messenger = " . TBL_USER . ".user_id WHERE recipient = ? " .
               "ORDER BY date DESC";
      try {
         $messages = $this->db->fetchAll($query, $user_id);
         // get profile image
         $profileObj = new Application_Model_Profile();
         for ($x = 0; $x < count($messages); $x++) {
            $image = $profileObj->getProfileImageLocation($messages[$x]['messenger']);
            $messages[$x]['thumb'] = $image['thumb'];
         }
         return $messages;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }
   }

   /**
    * get messages sent by a given user
    *
    * @param: (int) user_id
    * @return: (array) messages
    *          (bool) false on error
    */
   public function getSentMessages($user_id) {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      $query = "SELECT * FROM " . TBL_MESSAGE . " WHERE messenger = ? ORDER BY date DESC";

      try {
         $messages = $this->db->fetchAll($query, $user_id);
         return $messages;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }
   }
}
