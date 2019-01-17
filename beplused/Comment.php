<?php
/*-----------------------------------------------------------
Class: Comment
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: July 14, 2012
Modified: August 29, 2012

Comment Model
------------------------------------------------------------*/

class Application_Model_Comment
{
   protected $comment_id;
   protected $referential_id;
   protected $media_id;
   protected $commenter;
   protected $recipient;
   protected $comment;
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

      // values ok TODO: remove htmlspecialchars; will be ok after validation
      $this->referential_id = htmlspecialchars($values['referential_id']);
      $this->media_id       = htmlspecialchars($values['media_id']);
      $this->commenter      = htmlspecialchars($values['commenter']);
      $this->recipient      = htmlspecialchars($values['recipient']);
      $this->comment        = htmlspecialchars($values['comment']);
      $this->date           = htmlspecialchars($values['date']);
   }

   /**
    * create a comment and write to db
    *
    * @param: (array) $data - optional data to write to db
    * @return: (int) last insert id on success
    *          (bool) false on error
    */
   public function createComment($data = '') {
      if (!is_array($data)) {
         $data = array('media_id'       => $this->media_id,
                       'referential_id' => $this->referential_id, 
                       'comment'        => $this->comment,
                       'recipient'      => $this->recipient,
                       'commenter'      => $this->commenter,
                       'date'           => $this->date);
      }

      try {
         $n = $this->db->insert(TBL_COMMENT, $data);
         return $this->db->lastInsertId();
      } catch (Exception $e) {
         // TODO: Log errors
         $logger = Zend_Registry::get('log');
         $logger->log('Exception - writing comment to db', Zend_Log::NOTICE);
	     
         return false;
      }
   }

   /**
    * get comments for a given referential_id & media_id
    *
    * @param: (int) user_id - not really necessary; the referential and media _ids should
    *                  be sufficient to isolate any single entity
    * @param: (int) referential_id - _id of an item; primary key 
    * @param: (int) media_id - _id of media type; feed, message, comment, et cetera
    * @return: (array) comments
    *          (bool) false on error
    */
   public function getComments($referential_id, $media_id, $user_id = '') {
      if ((!empty($user_id) && !is_numeric($user_id)) || !is_numeric($referential_id) || !is_numeric($media_id)) {
         // TODO: log
         return false;
      }

      if (is_numeric($user_id)) {
         $query = "SELECT * FROM " . TBL_COMMENT . " WHERE recipient = ? AND " .
                  "referential_id = ? AND media_id = ? ORDER BY date DESC";
         $params = array($user_id, $referential_id, $media_id);
      } else {
         $query = "SELECT * FROM " . TBL_COMMENT . " WHERE " .
                  "referential_id = ? AND media_id = ? ORDER BY date DESC";
         $params = array($referential_id, $media_id);
      }

      try {
         $comments = $this->db->fetchAll($query, $params);
         return $comments;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }
   }
}
