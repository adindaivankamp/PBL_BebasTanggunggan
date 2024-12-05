<?php
class Database {
    private $servername = "SOUPYAN\\BDL2024";
    private $connectionInfo = ["Database" => "Sistem Bebas Tanggungan"];
    private $conn;

    public function connect() {
        $this->conn = sqlsrv_connect($this->servername, $this->connectionInfo);
        if ($this->conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            sqlsrv_close($this->conn);
        }
    }
}
?>