<?php

namespace utils;

class Database {
    protected $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = mysqli_connect("$host", "$user", "$password", "$database");

        if (!$this->conn) {
            echo "<pre>no available database connection. :(</pre>";
        } else {
            $query = "SELECT * FROM user";
            $result = mysqli_query($this->conn, $query);
            $row = mysqli_fetch_array($result);

            echo "<pre>";
            print_r($row);
echo "hello?";
exit;
        }
    }
}
