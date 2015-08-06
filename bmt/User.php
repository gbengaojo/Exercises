<?php
/*-----------------------------------------------------------
Class: User
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: November 8, 2012
Modified: March 26, 2014
Modified: August 21, 2014

User model

construct
array getUserFromEmail(string)
bool emailConfirmation(string, string)
int addUser(array)
int addUserPromo(array, string)
mixed getField(mixed, int)
string getName(int)
string getEmail(int)
bool setPassword(int, string, string)
string resetPassword(string)
array getNewRegistrations(string, string)
------------------------------------------------------------*/

class Application_Model_User
{
   public $user_id;
   public $email;
   public $password;
   public $firstname;
   public $lastname;
   public $created;

   /**
    * construct
    */
   public function __construct($user = null) {
      $this->db = Zend_Db_Table::getDefaultAdapter();
      $this->logger = Zend_Registry::get('log');
   }

   /**
    * get user from email
    *
    * @param: (string) email
    * @return: (array) user obj
    */
   public function getUserFromEmail($email) {
      $query = "SELECT * FROM user WHERE email = ?";
      try {
         $result = $this->db->fetchRow($query, $email);
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * send confirmation email for new users and users who reset
    * their password
    *
    * @param: (string) email - email address to send message to
    * @param: (string) unencrypted_pwd
    * @return: (bool) true on success
    */
   public function emailConfirmation($email, $unencrypted_pwd = null, $rcode = null) {
      // set domain name and redemption code model
      $domain_name = DOMAIN_NAME;
      $redemptionCodeObj = new Application_Model_RedemptionCode();

      // get user_id
      $user = $this->getUserFromEmail($email);
      $user_id = $user['user_id'];

      // determine whether or not this player already has one free code
      $message_intro = '';
      if (!$redemptionCodeObj->hasPromoAlready($user_id)) {
         $message_intro = "<p>Since you are a first-time player, you can play the next trivia game free.";
         $message_intro .= "Your new password is: <b>$unencrypted_pwd</b> and your free redemption code is: <b>$rcode</b>";
/*
         $message_intro = "<p>Since you are a first-time player, you can play the next trivia game free.
<a href='http://$domain_name/index/promo-registration'>Get your free redemption code</a> to be eligible to win the cash prize for the
next trivia game.</p>";
*/
      } else {
         $message_intro = "Your new password is: <b>$unencrypted_pwd</b>";
      }

      try {
         // email confirmation
         $to = $email;
         $subject = "Welcome to Black Movie Trivia";
         $headers = 'From: no-reply@blackmovietrivia.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() .
                    'BCC: ' . DEV_EMAIL . "\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/html; charset=ISO-8859-1\r\n";

         $message = <<<EOT
$message_intro

<p>Follow these basic instructions to play:</p>
<ul>
<li>Check the home page for the date and time of the next trivia game.</li>
<li>Log in with your password a few minutes before game time and enter your redemption code.</li>
<li>Go to the home page after logging in.</li>
<li>You'll be playing against other players who are logged in for the same game.</li>
<li>You have 3 minutes to answer 3 multiple choice questions and 1 optional bonus question that has 3 clues and is not multiple choice.</li>
<li>Each multiple choice question is worth 100 points if you answer it correctly.</li>
<li>The bonus question is worth 200 points if answered correctly using no clues;</li>
<ul>
    <li>150 points if answered correctly using 1 of the clues;</li>
    <li>100 points if answered correctly using 2 of the clues and</li>
    <li>50 points if answered correctly using all 3 clues.</li>
</ul>
<li>If you get the bonus question wrong, 200 points will be deducted from your score.</li>
<li>The player with the highest score at the end of the game is the winner.</li>
<li>In the event 2 or more players are tied at the end of 3 minutes, a tie-breaking question is introduced.</li> 
<li>The tie-breaking question is worth 100 points and is not multiple choice.</li> 
<li>If needed, the game has 3 tie-breaking questions.</li>
<li>If 2 or more players are still tied after the 3rd tie-breaking round, they split the $500 cash prize.</li>
</ul>

<p>When you enter your redemption code, <b><u>you are automatically awarded 5 reward points</u></b>.
Reward points can be used to qualify for trivia games with cash prizes of $1,000, $5,000 and $10,000.</p>

<p>For more detailed information, refer to our <a href="http://blackmovietrivia.com/index/rules">Official Rules</a>.
If you have any problems or questions, email us at <a href="mailto:info@cei-media-partners.com">info@cei-media-partners.com</a>.</p>

<p>
Thanks,<br>
Black Movie Trivia Team
</p>
EOT;
         $result = mail($to, $subject, $message, $headers);
         if (!$result) {
            $this->logger->log('User::emailConfirmation() - ERROR sending email', Zend_Log::ERR);
            return false;
         }
      } catch (Exception $e) {
         // log
         $this->logger->log('User::emailConfirmation() - ERROR sending email', Zend_Log::ERR);
         return false;
      }

      return true;
   }

   /**
    * send twilio auto-response for a Referrer (this is sent when the Referred
    * player enters a redemption code & plays a game. They have to actually
    * play the game, using the free redemption code obtained duruing registration,
    * (having enterred the referring player_id))
    */
   public function twilioAutoResponse() {
      // consider method name; there will be another
      // or, parameterize to handle both and any subsequent twilio messaging
   }

   /**
    * add user
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addUser($data, $unencrypted_pwd = null) {
      try {
         $n = $this->db->insert(TBL_USER, $data);
         $id = $this->db->lastInsertId();

         // email confirmation
         $result = $this->emailConfirmation($data['email'], $unencrypted_pwd);

         if (!$result) {
            $this->logger->log('User::addUser() - ERROR sending email', Zend_Log::ERR);
         }

         return $id;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * add user from new landing page (ui/FBlandingpage.html)
    *
    * @param: (array) data
    * @return: (int) last insert id
    */
   public function addUserPromo($data, $unencrypted_pwd = null, $rcode = null) {
      try {
         $n = $this->db->insert(TBL_USER, $data);
         $id = $this->db->lastInsertId();

         /* todo: see local system /home/gbenga/bmt_notes_20140818 */
         // todo: add email autoresponse
         // email confirmation
         $result = $this->emailConfirmation($data['email'], $unencrypted_pwd, $rcode);

         if (!$result) {
            $this->logger->log('User::addUser() - ERROR sending email', Zend_Log::ERR);
         }

         return $id;
      } catch (Exception $e) {
         /* handle exception */
         $message = $e->getMessage();
         $message = 'User::addUserPromo() - ERROR writing to db: ' . $message;
         $this->logger->log($message, Zend_Log::ERR);
         return false;
      }
   }

   /**
    * get generic single field
    *
    * @param: (mixed) field
    * @param: (int) user_id
    * @return: (mixed) field
    */
   public function getField($field, $user_id) {
      $query = "SELECT $field FROM " . TBL_USER . " WHERE user_id = ?";
      try {
         $result = $this->db->fetchOne($query, $user_id);
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get first name
    *
    * @param: (int) user_id
    * @return: (string) firstname
    */
   public function getName($user_id) {
      $query = "SELECT firstname FROM " . TBL_USER . " WHERE user_id = ?";
      try {
         $result = $this->db->fetchOne($query, $user_id);
         return $result;
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * get email address
    *
    * @param: (int) user_id
    * @return: (string) email
    */
   public function getEmail($user_id) {
      $email = $this->getField('email', $user_id);
      return $email;
   }

   /**
    * set password
    *
    * @param: (int) user_id
    * @param: (string) password
    * @param: (string) unencrypted_pwd
    * @return: (bool)
    */
   public function setPassword($user_id, $password, $unencrypted_pwd) {
      try {
         $n = $this->db->update(TBL_USER, array('password' => $password), "user_id = $user_id");

         // get email address
         $email = $this->getField('email', $user_id);

         // email confirmation
         $this->emailConfirmation($email, $unencrypted_pwd);

         return $n;
      } catch (Exception $e) {
         // log
         $this->logger->log('Error setting password', Zend_Log::ERR);
         return false;
      }
   }

   /**
    * reset temp password
    *
    * @param: (string) email
    * @return: (string) temp password
    */
   public function resetPassword($email) {
      $time = time();
      $uniqid = uniqid();
      $tmp_pwd = md5("{$email}{$time}{$uniqid}");
      $tmp_pwd = substr($tmp_pwd, 0, 8);
 
      $data = array('password' => md5($tmp_pwd));

      try {
         $n = $this->db->update(TBL_USER, $data, "email = '$email'");

         // email user with pwd
         $to = $email;
         $subject = "Black Movie Trivia Password Reset";
         $headers = 'From: no-reply@blackmovietrivia.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() .
                    'BCC: ' . DEV_EMAIL . "\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/html; charset=ISO-8859-1\r\n";
         $message  = "<p>Your temporary password has been reset to: <b>$tmp_pwd</b>";
         $message .= "<p>Enter this temporary password and create a new password at <a href='http://" . DOMAIN_NAME . "/login/reset?email=$email&ignore=1'>http://" . DOMAIN_NAME . "/login/reset?email=$email&ignore=1</a></p>";

         $message_cont = <<<EOT
<p>Follow these basic instructions to play:</p>
<ul>
<li>Check the home page for the date and time of the next trivia game.</li>
<li>Log in with your password a few minutes before game time and enter your redemption code.</li>
<li>Go to the home page after logging in.</li>
<li>You'll be playing against other players who are logged in for the same game.</li>
<li>You have 3 minutes to answer 3 multiple choice questions and 1 optional bonus question that has 3 clues and is not multiple choice.</li>
<li>Each multiple choice question is worth 100 points if you answer it correctly.</li>
<li>The bonus question is worth 200 points if answered correctly using no clues;</li>
<ul>
    <li>150 points if answered correctly using 1 of the clues;</li>
    <li>100 points if answered correctly using 2 of the clues and</li>
    <li>50 points if answered correctly using all 3 clues.</li>
</ul>
<li>If you get the bonus question wrong, 200 points will be deducted from your score.</li>
<li>The player with the highest score at the end of the game is the winner.</li>
<li>In the event 2 or more players are tied at the end of 3 minutes, a tie-breaking question is introduced.</li> 
<li>The tie-breaking question is worth 100 points and is not multiple choice.</li> 
<li>If needed, the game has 3 tie-breaking questions.</li>
<li>If 2 or more players are still tied after the 3rd tie-breaking round, they split the $500 cash prize.</li>
</ul>

<p>When you enter your redemption code, <b><u>you are automatically awarded 5 reward points</u></b>.
Reward points can be used to qualify for trivia games with cash prizes of $1,000, $5,000 and $10,000.</p>

<p>For more detailed information, refer to our <a href="http://blackmovietrivia.com/index/rules">Official Rules</a>.
If you have any problems or questions, email us at <a href="mailto:info@cei-media-partners.com">info@cei-media-partners.com</a>.</p>

<p>
Thanks,<br>
Black Movie Trivia Team
</p>
EOT;
         $message = $message . $message_cont;
         $result = mail($to, $subject, $message, $headers);

         if (!$n) {
            // log
            $this->logger->log('Error sending email for password reset', Zend_Log::ERR);
         }

         return $n;
      } catch (Exception $e) {
         // log
         $this->logger->log('Error re-setting password', Zend_Log::ERR);
         return false;
      }
   }

   /**
    * get new registrations
    *
    * @param: (string) startdate
    * @param: (string) enddate
    * @return: (array) records set from user table
    */
   public function getNewRegistrations($startdate, $enddate) {
      $startdate = new DateTime($startdate);
      $enddate   = new DateTime($enddate);

      $start = $startdate->format('Y-m-d H:i:s');
      $end   = $enddate->format('Y-m-d H:i:s');

      $query = "SELECT email, firstname, lastname, created FROM user WHERE created >= '$start' AND created <= '$end'";

      try {
         $result = $this->db->fetchAll($query, array($start, $end));
         return $result;
      } catch (Exception $e) {
         // log
         $this->logger->log('User::getNewRegistrations() -- DB ERROR', Zend_Log::ERR);
         return false;
      }
   }
}
