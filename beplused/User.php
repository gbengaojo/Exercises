<?php
/*-----------------------------------------------------------
Class: User
Author: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: May 22, 2012
Modified: July 28, 2012

User model

construct
bool createUser()
mixed getUserData(mixed, bool)
string getMediaDir(int)
------------------------------------------------------------*/

class Application_Model_User
{
   protected $user_id;
   protected $email;
   protected $password;    // blowfish encrypted
   protected $firstname;
   protected $lastname;
   protected $signupdate;
   protected $signup_ip;

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

      /* todo (post-beta) - re-implement validation; failing and
               causing registration to fail

      if ($values['email'] == '' || $values['password'] == '' ||
          $values['firstname'] == '' || $values['lastname'] == '' ||
          $values['signupdate'] == '' || $values['signup_ip'] == '') {
         $this->valid_construct = false;
         return;
      }

      #if (!preg_match('/^[A-Za-z0-9\.\/\$]{60}$/', $values['password']) || // Blowfish regexp
      if (!preg_match('/^[a-z0-9]{32}$/', $values['password']) || // md5 regexp
          !preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6}$/', $values['email']) ||
          !preg_match("/^[A-Z]'?[- a-zA-Z]+$/", $values['firstname']) ||
          !preg_match("/^[A-Z]'?[- a-zA-Z]+$/", $values['lastname']) ||
          !preg_match("/^\b(?:\d{1,3}\.){3}\d{1,3}\b$/", $values['signup_ip']) ||
          !strtotime($values['signupdate'])) {
         $this->valid_construct = false;
         return;
      } */

      // values ok
      $this->email      = $values['email'];
      $this->password   = $values['password'];
      $this->firstname  = $values['firstname'];
      $this->lastname   = $values['lastname'];
      $this->signupdate = $values['signupdate'];
      $this->signup_ip  = $values['signup_ip'];
   }

   /**
    * creates a new user and writes to db
    *
    * @return: (bool) false on error
    */
   public function createUser() {
      $data = array('email'      => $this->email,
                    'password'   => $this->password,
                    'firstname'  => $this->firstname,
                    'lastname'   => $this->lastname,
                    'signupdate' => $this->signupdate,
                    'signup_ip'  => $this->signup_ip);

      try {		//sends an email to the user saying that his profile is ready on beplused
         if($this->db->insert(TBL_USER, $data)){
            $subject = "Hi!";
            $body = "Hi, \n You have successfully joined BePlused Social Network. Please login";
            $headers = 'From: Beplused <feedback@beplused.com>' . "\r\n" .
                       'Reply-To: feedback@beplused.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();
            @mail($this->email, $subject, $body, $headers);
            return $this->db->lastInsertId();
			}
      } catch (Exception $e) {
         return false;
      }
   }

   /**
    * get user data using user_id; construct appropriate images dir
    *
    * TODO: allow for optional user_id param
    * TODO: evaluate recursive calls (see 2nd param)
    *
    * @param: (mixed) user_id - (int) user_id | (int array) user_id
    * @param: (bool) instantiateProfile - avoid recursive instantiation when this
    *                   method is called from Profile model, or similar
    *                   when false. If false, image data not returned
    * @return: (mixed) - (2d array) user data | (array) user data | (bool) false on error
    */
   public function getUserData($user_id, $instantiateProfile = true) {
      $query = "SELECT `user_id`, `firstname`, `lastname`, `email`, `signupdate`, `signup_ip` FROM " . TBL_USER . " WHERE user_id = ?";
      $user = false;

      if ($instantiateProfile)
         $profileObj = new Application_Model_Profile();

      if (is_numeric($user_id)) {
         $user = $this->db->fetchRow($query, $user_id);
         if ($instantiateProfile) {
            $profileimage = $profileObj->getProfileImageLocation($user_id);
            $user['thumb']   = $profileimage['thumb'];
            $user['profile'] = $profileimage['image'];
         }
      }

      if (is_array($user_id)) {
         $x = -1;
         foreach ($user_id as $_id) {
            $x++;
            $user[$x] = $this->db->fetchRow($query, $_id);
            if ($instantiateProfile) {
               $profileimage = $profileObj->getProfileImageLocation($_id);
               $user[$x]['thumb']   = $profileimage['thumb'];
               $user[$x]['profile'] = $profileimage['image']; 
            }
         }

         for ($x = 0; $x < count($user); $x++) {
            if (!is_numeric($user[$x]['user_id'])) {
               unset($user[$x]);
            }
         }
      }

      return $user;
   }

   /**
    * get media dir
    *
    * @param: (int) user_id
    * @return: (string) media dir
    */
   public function getMediaDir($user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      $query = "SELECT email FROM " . TBL_USER . " WHERE user_id = ?";

      try {
         $email = $this->db->fetchOne($query, $user_id);
         $mediadir = USER_IMAGES_DIR . str_replace(array('@', '.'), '_', $email);

         return $mediadir;
      } catch (Exception $e) {
         // TODO: log
         return false;
      }
   }

   /**
    * get firstname from id
    *
    * @param: (int) user_id
    * @return: (string) firstname
    */
   public function getFirstName($user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      $query = "SELECT firstname FROM " . TBL_USER . " WHERE user_id = ?";
      $firstname = $this->db->fetchOne($query, $user_id);

      return $firstname;
   }

   /**
    * get lastname from id
    *
    * @param: (int) user_id
    * @return: (string) firstname
    */
   public function getLastName($user_id = '') {
      if (!is_numeric($user_id))
         $user_id = $this->user_id;

      if (!is_numeric($user_id))
         return false;

      $query = "SELECT lastname FROM " . TBL_USER . " WHERE user_id = ?";
      $lastname = $this->db->fetchOne($query, $user_id);

      return $lastname;
   }

   /**
    * get random users
    *
    * @param: (int) number of random users
    * @return: (array:int) user_ids
    */
   public function getRandomUsers($num = 20) {
      if (!is_numeric($num))
         $num = 20;

      $query = "SELECT `user_id` FROM " . TBL_USER;
      $users = $this->db->fetchCol($query);
      shuffle($users);

      for ($i = 0; $i < $num; $i++)
         $return[] = array_pop($users);

      return $return;
   }
}
