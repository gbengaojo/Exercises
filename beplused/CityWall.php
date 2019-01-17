<?php
/*-----------------------------------------------------------
Class: CityWall
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: August 27, 2012
Modified: September 4, 2012

// TODO: 20120831 - consider extending the Album Model


CityWall Model
------------------------------------------------------------*/

class Application_Model_CityWall
{
   protected $citywall_id;
   protected $citywall;
   protected $user_id;
   protected $description;
   protected $date;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate TODO: implement regexp validation
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      // values ok
      $this->citywall     = htmlspecialchars($values['citywall']);
      $this->user_id      = htmlspecialchars($values['user_id']);
      $this->description  = htmlspecialchars($values['description']);
      $this->date         = htmlspecialchars($values['date']);
   }

   /**
    * create a city wall and write to db
    *
    *
    * @param: (array) $data - optional data to write
    * @return: (int) last insert id on success
    *          (bool) false on error
    */
   public function createCityWall($data = '', $edit = false, $citywall_id = '', $user_id = '') {
      if (!is_array($data)) {
         $citywall = array('user_id'      => $this->user_id,
                           'date'         => $this->date); 
      } else {
         $citywall['user_id'] = $data['user_id'];
         $citywall['date']    = $data['date'];
      }

      try {
         if (!$edit) {
            // insert
            $n           = $this->db->insert(TBL_WALL_CITY, $citywall);
            $citywall_id = $this->db->lastInsertId();
         } else {
            // update
            if (!is_numeric($citywall_id) || !is_numeric($user_id))
               return false;

            // check ownership
            $query = "SELECT `user_id` FROM " . TBL_ALBUM . " WHERE user_id = ? AND referential_id = ?";
            $isOwner = $this->db->fetchOne($query, array($user_id, $referential_id));

            if ($isOwner)
               $n = $this->db->update(TBL_ALBUM, $data, "referential_id = $citywall_id");
            else
               return false;
         }

         if ($n) {
            if (!$edit) {
               // create a corresponding album for this city wall
               $albumObj = new Application_Model_Album();
               $album = array('user_id'        => $data['user_id'],
                              'title'          => $data['citywall'],
                              'description'    => $data['description'],
                              'date'           => $data['date'],
                              'media_id'       => MEDIA_WALL_CITY,
                              'referential_id' => $citywall_id);
               $album_id = $albumObj->createAlbum($album);

               // update TBL_WALL_CITY with corresponding album_id
               $this->db->update(TBL_WALL_CITY, array('album_id' => $album_id), "citywall_id = $citywall_id");
            }

            // feed monitor
            $userObj = new Application_Model_User();
            $user    = $userObj->getFirstName($data['user_id']);

            if ($edit)
               $feedtext = "has edited a city wall";
            else
               $feedtext = "has created a city wall";

            $feed = array('user_id'        => $data['user_id'],
                          'feed'           => "$user $feedtext",
                          'media_id'       => MEDIA_WALL_CITY,
                          'referential_id' => $n,
                          'date'           => date('Y-m-d H:i:s'));
            $feedObj = new Application_Model_Feed($feed);
            $feedObj->createFeed();
         }
         if (!$edit)
            return $this->db->lastInsertId();
         else
            return $n;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }
   }


   /**
    * get city walls for a given user
    *
    * @param: (int) user_id
    * @return: (array) city wall records for this user
    *          (bool) false on error
    */
   public function getCityWalls($user_id = '') {
      if (!is_numeric($user_id))
         return false;

      try { 
         $albumObj = new Application_Model_Album();
         $albums = $albumObj->getUserAlbums($user_id, false, MEDIA_WALL_CITY);

      } catch (Exception $e) {
         // log
         return false;
      }

      return $albums;

      /*
      if (!is_numeric($user_id)) 
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      $query = "SELECT * FROM " . TBL_WALL_CITY . " WHERE user_id = ? ORDER BY date DESC";

      try {
         $citywalls = $this->db->fetchAll($query, $user_id);
         return $citywalls;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      } */
   }

   /**
    * get a single city wall by id
    *
    * @param: (int) citywall_id
    * @return: (array) a single city wall record
    * // see note above
    */
   public function getCityWall($citywall_id) {
      if (!is_numeric($citywall_id))
         $citywall_id = $this->citywall_id;

      if (!is_numeric($citywall_id))
         return false;

      $query = "SELECT * FROM " . TBL_WALL_CITY . " WHERE citywall_id = ?";

      try {
         $citywall = $this->db->fetchRow($query, $citywall_id);
         return $citywall;
      } catch (Exception $e) {
         // TODO: log errors
         return false;
      }
   }

   /**
    * get city wall covers
    *
    * @param: (int) $user_id
    * @return: (array)
    */
   public function getCityWallCovers($user_id = '') {
      $albumObj = new Application_Model_Album();
      $album_covers = $albumObj->getAlbumCovers($user_id, MEDIA_WALL_CITY);

      return $album_covers;
   }

   /**
    * delete city wall
    *
    * @param: (int) $user_id
    * @param: (int) $citywall_id
    * @return: (bool) true if deleted, false if error
    */
   public function deleteCityWall($citywall_id, $album_id, $user_id = '', $associatedImages = true) {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id) || !is_numeric($album_id) || !is_numeric($citywall_id))
         return false;

      try {
         $n = $this->db->delete(TBL_WALL_CITY, "user_id = $user_id AND citywall_id = $citywall_id");
         // delete album also and possibly associated images
         if ($n) {
            $albumObj = new Application_Model_Album();
            $m = $albumObj->deleteAlbum($album_id, $user_id, $associatedImages);
         }
         return $n;
      } catch (Exception $e) {
         // log
         return false;
      }
   }
}
