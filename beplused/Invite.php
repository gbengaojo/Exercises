<?php
/*-----------------------------------------------------------
Class: Invite
Author: Nikhil Redij <nikhil@beplused.com>
Origin Date: July 11, 2012
Modified By: Nikhil Redij <nikhil@beplused.com>
Modified: July 23, 2012

Invite Model

void init()
void setInvite()

------------------------------------------------------------*/

class Application_Model_Invite
{
   protected $user_id;        // who does this user id belong to?
      
   private $db;
   private $valid_construct = true;
   
   /**
    * constructor
    * @param: $db: Adapter to the given table in the database
    * @param: $user_id: user id of current user
	
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
	  $this->user_id = $values['$user_id'];
   }   

   /**
    * fetch data from InviteController and send email id to new users to invite to BePlused
    *
    * @return: (boolean) 
	*/
   public function setInvite($emailid, $user_id) {
      if ($user_id == '')
         $user_id = $this->view->user_id;
	  	  
	  $query = "SELECT firstname, lastname FROM " . TBL_USER . " WHERE user_id = ?";
	  $name = $this->db->fetchRow($query, array($user_id));
	  $firstname = $name['firstname'];
	  $lastname = $name['lastname'];
	  $subject = "Hi!";
	  $body = "Hi,\nHow are you? This is " . $firstname . " " . $lastname . " inviting you to join BePlused Social Network";
	  
	  if (mail($emailid, $subject, $body)) {
	  	 return true;
	  }
	  else {
	  return false;
	  }
  }  

}