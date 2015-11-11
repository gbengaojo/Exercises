<?php

namespace utils\Database;

class Database {
    protected $conn;
    protected $host;
    protected $database;
    protected $password;

    public function __construct($host, $database, $password) {

      $conn = mysqli_connect('localhost', 'test', '_!p@ssw0rd!@');
      if (!$conn) {
         echo "<pre>no available database connection. :(</pre>";
      } else {
         mysqli_select_db($conn, 'test');

         $query = "SELECT * FROM user";
         $result = mysqli_query($conn, $query);

         echo '<pre>';
         print_r($result);
      }
    }

}
