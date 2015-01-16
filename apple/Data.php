<?php
/*-----------------------------------------------------------
Class: Data
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: December 9, 2014
Modified: December 9, 2014

*note properties were removed from the pseudocode in this
actual implementation as the lack of a true database object
was causing interpreter warnings

construct(db)
db.begin beginTran()
db.commit commitTran()
db.rollback rollback()
db.insert insert(string, object)
------------------------------------------------------------*/

class Data {
   protected $db;

   /**
    * construct
    *
    * @param: the assumption is made that the $database param
    *    is an object with all necessary connection and
    *    transaction attributes.
    *    call_user_func_array is another possibility, or the
    *    use of the MySQLi class.
    */
   public function __construct($database) {
      // suppress error messages
      $this->db = @mysql_connect($database);
   }

   /**
    * begin a database transaction
    *
    * @return: (object) db.begin
    */
   public function beginTran() {
      echo "Beginning a transaction\n";
      return $this->db;
   }

   /**
    * commit a database transaction 
    *
    * @return: (object) db.commit
    */
   public function commit() {
      echo "Committing transaction\n";
      return $this->db;
   }

   /**
    * rollback a database transaction
    *
    * @return: (object) db.rollback
    */
   public function rollback() {
      echo "Rolling back transaction\n";
      return $this->db;
   }

   /**
    * execute a generic SQL statement
    *
    * @param: (string) sql
    */
   public function execute($sql) {
      echo "Executing query\n";
      return true;
   }

   /**
    * insert a record into a database table
    *
    * @param: (string) table
    * @param: (object) object
    * @return: (object) db.insert
    */
   public function insert($table, $object) {
      $query = "INSERT INTO `$table` VALUES ('" . $object->getName() . "')";
      // can't actually execute the following w/o a db object
      // $this->db->execute($query);

      echo "Inserting " . $object->getName() . " into table $table\n";
      // return $this->db.insert; causing warnings
      return $this->db;
   }

   /**
    * check database for persistence of records
    * this is for item 2d from Part 2, and assumes
    * we're checking for persistence based on some
    * field/value pair
    */
   public function isPersisted($table, $object) {
      $name = $object->getName();
      $id   = $object->getId();

      if (!empty($name)) {
         $query = "SELECT * FROM `$table` WHERE `name` = '" . $object->getName() . "'";
      } else if (!empty($id)) {
         $query = "SELECT * FROM `$table` WHERE `id` = '" . $object->getId() . "'";
      } else {
         // using -1 as a sentinel to return an empty set
         // assumning no negative #s for primary key
         $query = "SELECT * FROM `$table` WHERE `id` = -1";
      }
      // can't actually execute the following w/o a db object
      // $result = $this->db->execute($query);
      $result = array();

      // assuming $result is an array...
      if (count($result) > 0)
         return true;

      return false;
   }
}
