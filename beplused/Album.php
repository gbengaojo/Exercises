<?php
/*-----------------------------------------------------------
Class: Application_Model_Album
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: July 26, 2012
Modified July 26, 2012

Album Model
------------------------------------------------------------*/

class Application_Model_Album
{
   protected $album_id;
   protected $user_id;
   protected $title;
   protected $description;
   protected $date;
   protected $media_id;
   protected $referential_id;

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

      // validate
      $this->user_id        = htmlspecialchars($values['user_id']);
      $this->title          = htmlspecialchars($values['title']);
      $this->description    = htmlspecialchars($values['description']);
      $this->media_id       = htmlspecialchars($values['media_id']);
      $this->referential_id = htmlspecialchars($values['referential_id']);
   }

   /**
    * create an album and write to db
    *
    * @param: (array) data - optional data to write
    * @return: (bool) false on error
    *          (int) album_id on success
    */
   public function createAlbum($data = array()) {
      if (empty($data)) {
         $data = array('user_id'        => $this->user_id,
                       'title'          => $this->title,
                       'description'    => $this->description,
                       'date'           => date('Y-m-d H:i:s'),
                       'media_id'       => $this->media_id,
                       'referential_id' => $this->referential_id);
      }

      try {
         // write to db
         $n = $this->db->insert(TBL_ALBUM, $data);
         $album_id = $this->db->lastInsertId();

         return $album_id;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }

   /**
    * edit ablum
    */
   public function editAlbum($album_id, $data) {
      if (!is_numeric($album_id) || !is_array($data))
         return false;

      try {
         // check ownership
         $album = $this->getAlbum($album_id);
         if ($album['user_id'] == $data['user_id']) {
            $n = $this->db->update(TBL_ALBUM, $data, "album_id = $album_id");
            return $n;
         } else {
            return false;
         }
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get album
    *
    * @param: (int) album_id
    * @return: (int) album record
    *          (bool) false on error
    */
   public function getAlbum($album_id = '') {
      if ($album_id == '')
         $album_id = $this->album_id;

      if ($album_id == '')
         return false;

      try {
         $query = "SELECT * FROM " . TBL_ALBUM . " WHERE album_id = ?";
         $result = $this->db->fetchRow($query, $album_id);

         return $result;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }
      

   /**
    * get all albums for a user
    *
    * @param: (int) user_id
    * @param: (bool) getIdsOnly - only return album_ids if true
    * @return (array) album_ids or album data
    */
   public function getUserAlbums($user_id, $getIdsOnly = false, $media_id = null) {
      if (!is_numeric($user_id))
         return false;

      $selection = ($getIdsOnly) ? 'album_id' : '*';

      if (!is_null($media_id)) {
         $query  = "SELECT $selection FROM " . TBL_ALBUM . " WHERE user_id = ? AND media_id = ?";
         $params = array($user_id, $media_id);
      } else {
         $query  = "SELECT $selection FROM " . TBL_ALBUM . " WHERE user_id = ? AND media_id IS NULL";
         $params = $user_id;
      }

      try {
         if (!$getIdsOnly)
            $result = $this->db->fetchAll($query, $params);
         else
            $result = $this->db->fetchCol($query, $params);
         return $result;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }

   /**
    * get album covers for all albums for a user
    *
    * @param: (int) user_id
    * @return: (int array) image_ids, one for each album
    *          (bool) false on error or empty
    */
   public function getAlbumCovers($user_id, $media_id = null) {
      if (!is_numeric($user_id))
         return false;

      if (!is_null($media_id) && !is_numeric($media_id))
         return false;

      try {
         $image_ids = false;
         $album_ids = $this->getUserAlbums($user_id, true, $media_id);

         foreach ($album_ids as $album_id) {
            if (is_numeric($album_id)) {
               // TODO: Album cover is currenlty simply the first image retrieved from this
               //       album for this user; Create an album cover flag in the db
               $query = "SELECT image_id FROM " . TBL_IMAGE . " WHERE album_id = ? AND user_id = ? LIMIT 1";
               $result = $this->db->fetchRow($query, array($album_id, $user_id));
               $image_ids[] = $result['image_id'];
            }
         }
         return $image_ids;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }

   /**
    * delete an album and possibly all associated images
    *
    * @param: (int) user_id
    * @param: (int) album_id
    * @param: (bool) associatedImages - delete all associated images if true
    */
   public function deleteAlbum($album_id = '', $user_id = '', $associatedImages = true) {
      if (!is_numeric($album_id))
         $album_id = $this->album_id;

      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($album_id))
         return false;

      // delete from album table with matching user_id and album_id
      try {
         $n = $this->db->delete(TBL_ALBUM, "user_id = $user_id AND album_id = $album_id");
         // if we're also deleting the images
         if ($n) {
            $m = $this->db->delete(TBL_IMAGE, "user_id = $user_id AND album_id = $album_id");
         }
         return $n;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }
}
