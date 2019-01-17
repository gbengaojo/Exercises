<?php
/*-----------------------------------------------------------
Class: Groups
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: September 3, 2012
Modified: September 11, 2012

Groups Model
------------------------------------------------------------*/

class Application_Model_Groups
{
   protected $creator;
   protected $group_category_id;
   protected $title;
   protected $description;
   protected $date_created;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // TODO: handle $values
   }

   /**
    * create a group
    * // TODO: sanitize parameters
    * // user_id so one can only edit their own group they've created
    */
   public function createGroup($data = '', $edit = false, $group_id = '', $user_id = '') {
      if (!is_array($data))
         return false;

      try {
         if (!$edit) {
            // insert
            $n        = $this->db->insert(TBL_GROUP, $data);
            $group_id = $this->db->lastInsertId();

            // create mediadir
            
            $dirname  = md5($group_id . rand());
            $groupdir = $_SERVER['DOCUMENT_ROOT'] . GROUPS_DIR . $dirname;

            mkdir($groupdir, 0777);
            chmod($groupdir, 0777);

            // update db
            $this->db->update(TBL_GROUP, array('groupdir' => $dirname), "group_id = $group_id");
         } else {
            // update
            if (!is_numeric($group_id) || !is_numeric($user_id))
               return false;
            // check onwership
            $query = "SELECT `creator` FROM " . TBL_GROUP . " WHERE creator = ? AND group_id = ?"; 
            $isOwner = $this->db->fetchOne($query, array($user_id, $group_id));

            if ($isOwner)
               $n = $this->db->update(TBL_GROUP, $data, "group_id = $group_id");
            else
               return false;
         }

         if ($n) {
            // feed monitor
            $userObj = new Application_Model_user();
            $user    = $userObj->getFirstName($data['user_id']);

            if ($edit)
               $feedtext = "has edited a group";
            else
               $feedtext = "has created a group";

            $feedObj = new Application_Model_Feed($feed);
            $feedObj->createFeed();
         }

         if (!$edit)
            return $this->db->lastInsertId();
         else
            return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }


   /**
    * create an event
    * // TODO: sanitize parameters
    * // user_id so one can only edit their own event they've created
    */
   public function createEvent($data = '', $edit = false, $event_id = '', $user_id = '') {
      if (!is_array($data))
         return false;

      try {
         if (!$edit) {
            // insert
            $n        = $this->db->insert(TBL_EVENT, $data);
            $event_id = $this->db->lastInsertId();
         } else {
            // update
            if (!is_numeric($event_id) || !is_numeric($user_id))
               return false;

            // check onwership
            $query = "SELECT * FROM " . TBL_EVENT . " WHERE event_id = ?";
            $group = $this->db->fetchRow($query, $event_id);

            $query = "SELECT `creator` FROM " . TBL_GROUP . " WHERE creator = ? AND group_id = ?";
            $isOwner = $this->db->fetchOne($query, array($user_id, $group['group_id']));

            if ($isOwner)
               $n = $this->db->update(TBL_EVENT, $data, "event_id = $event_id");
            else
               return false;
         }

         if ($n) {
            // feed monitor
            $userObj = new Application_Model_user();
            $user    = $userObj->getFirstName($data['user_id']);

            if ($edit)
               $feedtext = "has edited an event";
            else
               $feedtext = "has created an event";

            $feedObj = new Application_Model_Feed($feed);
            $feedObj->createFeed();
         }

         if (!$edit)
            return $this->db->lastInsertId();
         else
            return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get groups by user id
    */
   public function getGroupsByUserId($user_id = '') {
   }

   /**
    * get events for this group
    */
   public function getEvents($group_id, $upcoming = true) {
      if (!is_numeric($group_id) || !is_bool($upcoming))
         return false;

      try {
         if ($upcoming)
            $query = "SELECT * FROM " . TBL_EVENT . " WHERE group_id = ? AND date >= now() ORDER BY date DESC";
         else
            $query = "SELECT * FROM " . TBL_EVENT . " WHERE group_id = ? ORDER BY date DESC";

         $events = $this->db->fetchAll($query, $group_id);

         return $events;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get group(s)
    */
   public function getGroup($group_id = '') {
      if (!is_numeric($group_id))
         return false;

      try {
         $query = "SELECT * FROM " . TBL_GROUP . " WHERE group_id = ?";
         $group = $this->db->fetchRow($query, $group_id);

         return $group;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get latest groups
    */
   public function getLatestGroups() {
      $tempdate = date('Y-m-d');
      $date     = strtotime('-30 day', strtotime($tempdate));
      $date     = date('Y-m-d', $date);
 

      try {
         $query = "SELECT * FROM " . TBL_GROUP . " WHERE date_created > ? LIMIT 10";
         $latestgroups = $this->db->fetchAll($query, $date);

         if (!latestgroups) {
            $query = "SELECT * FROM " . TBL_GROUP . " WHERE LIMIT 10";
            $latestgroups = $this->db->fetchAll($query);
         }

         return $latestgroups;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get groups image
    */
   public function getImage($image_id) {
      if (!is_numeric($image_id))
         return "/images/album.gif";

      try {
         $imageObj = new Application_Model_Image();
         $filename = $imageObj->getFilenameById($image_id, IMG_SQ_THUMB_FIELD);

         $imgpath  = GROUPS_DIR . DIRECTORY_SEPARATOR . $filename;

         if (file_exists($imgpath))
            return $imgpath;
         else
            return "/images/album.gif"; // TODO: create and set default groups image
      } catch (Exception $e) {
         return false;
      }
   }
}
