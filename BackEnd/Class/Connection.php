<?php
class Database {
    private $servername = "SOUPYAN\\BDL2024"; // Gunakan alamat yang sesuai
    //private $servername = "YourServerName"; // Use the appropriate address
    private $connectionInfo = ["Database" => "Sistem Bebas Tanggungan"];
    private $conn;
    private static $instance = null;

    private function __construct() {
        $this->conn = sqlsrv_connect($this->servername, $this->connectionInfo);
        if ($this->conn === false) {
            die(json_encode(array("status" => "error", "message" => "Connection failed: " . print_r(sqlsrv_errors(), true))));
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            sqlsrv_close($this->conn);
            self::$instance = null;
        }
    }
}
?>