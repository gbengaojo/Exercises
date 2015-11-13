<?php

namespace utils;

class Database {
    protected $conn;

    public function __construct() {
        $host = 'localhost';
        $user = 'test';
        $password = '_!p@ssw0rd!@';
        $database = 'wheniwork';
        $this->conn = mysqli_connect("$host", "$user", "$password", "$database");

        if (!$this->conn) {
           // ...
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
    }
}
