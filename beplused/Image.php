<?php
/*-----------------------------------------------------------
Class: Application_Model_Image
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: June 13, 2012
Modified: June 25, 2012

Image Model
------------------------------------------------------------*/

class Application_Model_Image
{
   protected $user_id;
   protected $album_id;
   protected $filename;
   protected $thumbnail;
   protected $thumbnail1;
   protected $thumbnail2;
   protected $thumbnail3;
   protected $thumbnail4;
   protected $caption;
   protected $media_id;
   protected $referential_id;
   protected $date;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate - todo (post-beta): with rigor
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      // todo (post-beta): validate with rigor
      $this->user_id    = $values['user_id'];
      $this->album_id   = $values['album_id'];
      $this->filename   = $values['filename'];
      $this->thumbnail1 = $values['thumbnail1'];
      $this->thumbnail2 = $values['thumbnail2'];
      $this->thumbnail3 = $values['thumbnail3'];
      $this->caption    = $values['caption'];
      $this->date       = date('Y-m-d H:i:s');
   }

   /**
    * creates a new image record and writes to db
    *
    * @param: (array) data - (optional) image data for table
    * @param: (bool) isProfile - (optional) true if this image if for a profile
    * @return: (bool) false on error 
    *          (int) image_id on success
    */
   public function createImage($data = array(), $isProfile = false) {
      // todo: check, (in general all models) if required member data is empty also 
      if (empty($data)) { 
         $data = array('user_id'    => $this->user_id,
                       'album_id'   => $this->album_id,
                       'filename'   => $this->filename,
                       'thumbnail1' => $this->thumbnail1,
                       'thumbnail2' => $this->thumbnail2,
                       'thumbnail3' => $this->thumbnail3,
                       'caption'    => $this->caption,
                       'date'       => $this->date);
      }

      try {
         // write to db
         $n = $this->db->insert(TBL_IMAGE, $data);
         $image_id = $this->db->lastInsertId();

         // update profile image if necessary
         if ($isProfile) {
            $user_id = $data['user_id'];
            $data = array('image_id' => $image_id);
            $this->db->update(TBL_PROFILE, $data, "user_id = " . $user_id);
         }
         return $image_id;
      } catch (Exception $e) {
         return false;
      }
   }

   /**
    * edit image
    */
   public function editImage($image_id, $data) {
      if (!is_numeric($image_id))
         return false;

      try {
         $n = $this->db->update(TBL_IMAGE, $data, "image_id = $image_id");
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get profile image
    *
    * @param: (int) user_id - optional
    * @return: (array) image
    */
   public function getProfileImage($user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      // get profile and image object for this user
      $profileObj = new Application_Model_Profile();
      $imageObj   = new Application_Model_Image();
      $image_id   = $profileObj->getProfileImage($user_id);

      $query = "SELECT * FROM " . TBL_IMAGE . " WHERE image_id = ?";
      $image = $this->db->fetchRow($query, array($image_id));

      return $image;
   }

   /**
    * get album images
    *
    * @param: (int) album_id
    * @param: (int) user_id - optional
    * @retun: (array) all images for a given album
    *         (bool) false on error
    */
   public function getAlbumImages($album_id, $user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($album_id))
         return false;

      try {
         $query = "SELECT * FROM " . TBL_IMAGE . " WHERE user_id = ? AND album_id = ?";
         $images = $this->db->fetchAll($query, array($user_id, $album_id));
         return $images;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }

   /**
    * get a set of images images
    *
    * @param: (array int) image_ids
    * @return: (array) images
    *          (bool) false on error
    */
   public function getImagesByIds($image_ids) {
      foreach ($image_ids as $image_id) {
         $where .= "image_id = ? OR ";
      }
      $where = substr($where, 0, -4);
      $query = "SELECT * FROM " . TBL_IMAGE . " WHERE $where";

      try {
         $result = $this->db->fetchAll($query, $image_ids);
         return $result;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }

   /**
    * get image by id
    */
   public function getImageById($image_id) {
      $query = "SELECT * FROM " .TBL_IMAGE ." WHERE image_id = ?";
      $image = $this->db->fetchRow($query, $image_id);

      // get comments for this image
      $profileObj = new Application_Model_Profile();
      $commentObj = new Application_Model_Comment();
      $userObj    = new Application_Model_User();

      $comments = $commentObj->getComments($image_id, MEDIA_IMAGE);

      // TODO: there's GOT to be a better implementation for this
      //       (see the audacity (the TODO) in the Wall model too :()
      if (!empty($comments) && $comments != false) {
         for ($i = 0; $i < count($comments); $i++) {
            $profileimage = $profileObj->getProfileImageLocation($comments[$i]['commenter']);
            $user         = $userObj->getUserData($comments[$i]['commenter'], false);
            $comments[$i]['thumb']     = $profileimage['thumb'];
            $comments[$i]['firstname'] = $user['firstname'];
            $comments[$i]['lastname']  = $user['lastname'];
         }
         $image['comments'] = $comments;
      }

      return $image;
   }

   /**
    * get image filename by image_id
    */
   public function getFilenameById($image_id, $type = IMG_SQ_THUMB_FIELD) {
      if (!is_numeric($image_id))
         return false;
    
      try {
         $query = "SELECT * FROM " . TBL_IMAGE . " WHERE `image_id` = ?";
         $result = $this->db->fetchRow($query, $image_id);

         if (empty($result[$type]))
            return false;

         $userObj  = new Application_Model_User();
         $mediadir = $userObj->getMediaDir($result['user_id']);
         $filename = $mediadir . DIRECTORY_SEPARATOR . $result[$type];

         return $filename;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * delete an image
    */
   public function deleteImage($image_id) {
      if (!is_numeric($image_id))
         return false;

      try {
         $n = $this->db->delete(TBL_IMAGE, "image_id = $image_id");
         return $n;
      } catch (Exception $e) {
         return false;
      }
   }
}
