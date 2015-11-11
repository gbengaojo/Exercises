<?php

namespace utils;

class Database {
    protected $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = mysqli_connect("$host", "$user", "$password", "$database");

        if (!$this->conn) {
            echo "<pre>no available database connection. :(</pre>";
        }
    }

    /**
     * set the query for this db object - note that these queries
     * are not parameterized
     *
     * @param: (string) sql
     * @throws:
     * @returns: (mixed) {result set | false on error}
     */
    public function query($sql) {
        return mysqli_query($this->conn, $sql);
            // $row = mysqli_fetch_array($result);
    }
}