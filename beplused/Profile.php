<?php
/*-----------------------------------------------------------
Class: Profle
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: May 17, 2012
Modified: August 9, 2012

Profile model for db manipulation and profile specific
functions

construct
(int) createProfile()
(bool) editProfile (array, int)
(array) getProfile(int)
(int) getProfileImage(int)
(mixed) getProfileImageLocation(int)
------------------------------------------------------------*/

class Application_Model_Profile
{
   protected $profile_id;
   protected $user_id;
   protected $network_id;
   protected $language_id;
   protected $timezone_id;
   protected $gender;
   protected $birthdate;
   protected $email;

   protected $highschool;
   protected $university;
   protected $employer;
   protected $interests;
   protected $languages;
   protected $about_me;
   protected $music;
   protected $books;
   protected $television;
   protected $games;
   protected $activities;
   protected $websites;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate these values
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      /* todo (post-beta) - re-implement input validation; causing registration to fail :(
      if ($values['network_id'] == '' || $values['language_id'] == '' ||
          $values['timezone_id'] == '' || $values['gender'] == '' ||
          $values['birthdate'] == '' || $values['user_id'] == '') {
         $this->valid_construct = false;
         return;
      }
      if (!is_numeric($values['network_id']) || !is_numeric($values['language_id']) ||
          !is_numeric($values['user_id']) || !is_numeric($values['timezone_id']) ||
          !preg_match('/^(m|f)$/i', $values['gender']) || !strtotime($values['birthdate'])) {
         $this->valid_construct = false;
         return;
      } */

      // values ok
      $this->user_id     = $values['user_id'];
      $this->network_id  = $values['network_id'];
      $this->language_id = $values['language_id'];
      $this->timezone_id = $values['timezone_id'];
      $this->gender      = $values['gender'];
      $this->birthdate   = $values['birthdate'];
   }

   /**
    * creates a new profile and writes to db
    *
    * @return: (bool) false on error
    */
   public function createProfile() {
      $data = array('user_id'     => $this->user_id,
                    'network_id'  => $this->network_id,
                    'language_id' => $this->language_id,
                    'timezone_id' => $this->timezone_id,
                    'gender'      => $this->gender,
                    'birthdate'   => $this->birthdate);
	

      try {
         // write to db
         $n = $this->db->insert(TBL_PROFILE, $data);
		 return $n;
	  } 
	  catch (Exception $e) {
         return false;
      }
   }

   /**
    * updates a profile with edits
    *
    * @param: (array) fields in db to update
    * @param: (int) user_id - optional
    *
    * @return: (bool) false on error; true on success
    */
   public function editProfile($data, $user_id) {
      // todo: (post-beta) determine need for further data validation
      if (!is_array($data))
         return false; 

      if ($user_id == '')
         $user_id = $this->user_id;

      try {
         $n = $this->db->update(TBL_PROFILE, $data, "user_id = $user_id");
         return $n;
      } catch (Exception $e) {
         // todo: (post-beta) implement logging
         return false;
      }
   }

   /**
    * get profile data
    *
    * @param: (int) $user_id
    * todo (post-beta) handle/catch/log errors
    */
   public function getProfile($user_id = '') {
      if ($user_id == '')
         $user_id = $this->user_id;

      if (!is_numeric($user_id) && !is_array($user_id))
         return false;

      try {
         if (is_numeric($user_id)) {
            $query = "SELECT * FROM " . TBL_PROFILE . " WHERE user_id = ?";
            $profile = $this->db->fetchRow($query, array($user_id));
         }

         if (is_array($user_id)) {
            $x = -1;
            foreach ($user_id as $_id) {
               $x++;
               $profile[$x] = $this->db->fetchRow($query, array($user_id));
            }
         }
      } catch (Exception $e) {
         // log error
         return false;
      } 

      return $profile;
   }

   /**
    * get profile image
    *
    * @param: (int) user_id - optional
    * @return: (int) image_id
    */
   public function getProfileImage($user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      $query = "SELECT image_id FROM " . TBL_PROFILE . " WHERE user_id = ?";
      $image_id = $this->db->fetchOne($query, array($user_id));

      return $image_id;
   }

   /**
    * get profile image & thumbnail URI or filename
    *
    * @param: (int) user_id - optional
    * @return: (array) [profile image location, thumbnail location]
    *          (bool) false on error
    */
   public function getProfileImageLocation($user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if ($user_id == '')
         return false;

      // we'll need the email address for now
      $userObj = new Application_Model_User();
      $user = $userObj->getUserData($user_id, false);

      $imageObj = new Application_Model_Image();
      $image = $imageObj->getProfileImage($user_id);

      // set base image path
      $imagepath = USER_IMAGES_DIR . str_replace(array('@', '.'), '_', $user['email']);
      $location['image'] = $imagepath;
      $location['thumb'] = $imagepath;

      // concatenate location (remove initial "/" when testing for file existence)
      if (empty($image['filename']) || !file_exists(substr($location['image'] . DIRECTORY_SEPARATOR . $image['filename'], 1))) {
         $location['image'] = '/images/defaultprofileimg.png';
         $location['thumb'] = '/images/defaultprofileimg.png';
      } elseif (empty($image[IMG_PROFILE_FIELD]) && !empty($image['filename'])) {
         $location['image'] .= DIRECTORY_SEPARATOR . $image['filename'];
         $location['thumb'] .= DIRECTORY_SEPARATOR . $image['filename'];
      } else { 
         $location['image'] .= DIRECTORY_SEPARATOR . $image[IMG_PROFILE_FIELD];
         $location['thumb'] .= DIRECTORY_SEPARATOR . $image[IMG_THUMB_FIELD];
      }

      return $location;
   }
}
