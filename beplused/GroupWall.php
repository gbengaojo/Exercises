<?php
/*-----------------------------------------------------------
Class: Wall
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: September 4, 2012 
Modified: September 4, 2012
         
Group Wall Model
------------------------------------------------------------*/

class Application_Model_GroupWall
{
   protected $groupwall_id;
   protected $group_id;
   protected $post_user_id;
   protected $image_id;
   protected $youtube_img;
   protected $youtbue_url;
   protected $youtube_iframe;
   protected $post;
   protected $date;

   private $db;
   private $valid_contstruct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate - todo: do so with rigor after beta :(
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      // todo: rigor after beta :(check post, XSS, misc injection, et cetera)
      if (!is_numeric($values['group_id']) || !is_numeric($values['image_id']) ||
          !is_numeric($values['post_user_id'])) {
         $this->valid_construct = false;
         return;
      }

      // values (will be) ok
      $this->group_id      = htmlspecialchars($values['user_id']);
      $this->post_user_id = htmlspecialchars($values['post_user_id']);
      $this->image_id     = htmlspecialchars($values['image_id']);
      $this->post         = htmlspecialchars($values['post']);
      $this->date         = date('Y-m-d H:i:s');
   }

   /**
    * create a wall item and write to db
    *
    * @param: (array) data - optional
    * @return: (int) last insert id on success;
    *          (bool) false on error
    */
   public function createWallPost($data = array()) {
      if (empty($data)) {
         $data = array('group_id'       => $this->user_id,
                       'post_user_id'   => $this->post_user_id,
                       'image_id'       => $this->image_id,
                       'youtube_img'    => $this->youtube_img,
                       'youtube_url'    => $this->youtube_url,
                       'youtbue_iframe' => $this->youtube_iframe,
                       'post'           => $this->post,
                       'date'           => $this->date);
      }

      try {
         $n = $this->db->insert(TBL_WALL_GROUP, $data);
         return $this->db->lastInsertId();
      } catch (Exception $e) {
print_r($e);
         return false;
      }
   }

   /**
    * get wall data for a given group
    *
    * @param: (int) group_id - optional
    * @return: (array) wall data
    *          (bool) false on error or empty
    */
   public function getWallData($group_id = '') {
      if (empty($group_id))
         $group_id = $this->group_id;

      // get wall data for this user
      $query = "SELECT * FROM " . TBL_WALL_GROUP . " LEFT JOIN " . TBL_USER . " ON " . TBL_WALL_GROUP . ".post_user_id = " .
               TBL_USER . ".user_id WHERE " . TBL_WALL_GROUP . ".group_id = ? ORDER BY " . TBL_WALL_GROUP . ".date DESC";

      $result = $this->db->fetchAll($query, $group_id);

      // get profile object
      $profileObj = new Application_Model_Profile();

      // add thumbnail to return result
      for ($x = 0; $x < count($result); $x++) {
         $profileimage = $profileObj->getProfileImageLocation($result[$x]['user_id']);
         $result[$x]['thumb'] = $profileimage['thumb'];
      }

      // get comments  TODO: (runs in O(m*n) with each inner loop executing 2 calls to db; consider a join
      //                in Comment::getComments with user data)
      $commentObj = new Application_Model_Comment();
      $userObj    = new Application_Model_User();

      for ($x = 0; $x < count($result); $x++) {
         $result[$x]['comments'] = $commentObj->getComments($result[$x]['wall_id'], MEDIA_WALL_GROUP, $user_id); 
         for ($y = 0; $y < count($result[$x]['comments']); $y++) {
            $profileimage = $profileObj->getProfileImageLocation($result[$x]['comments'][$y]['commenter']);
            $user         = $userObj->getUserData($result[$x]['comments'][$y]['commenter'], false);
            $result[$x]['comments'][$y]['thumb']     = $profileimage['thumb'];
            $result[$x]['comments'][$y]['firstname'] = $user['firstname'];
            $result[$x]['comments'][$y]['lastname']  = $user['lastname'];
         }
      }

      return $result;
   }
}
