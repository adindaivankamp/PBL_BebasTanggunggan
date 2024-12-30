<?php

require_once "Connection.php";

class User {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    protected function GetConnection() {
        return $this->conn;
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>