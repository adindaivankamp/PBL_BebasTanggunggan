<?php
class User {
    private $db;
    private $conn;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->conn = $this->db->connect();
    }

    public function login_admin($NIP, $password) {
        $sql = "SELECT * FROM dbo.admin WHERE NIP = ?";
        $params = [$NIP];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            if ($password == $row['password']) {
                // Set session data
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['nama'];
                return true; // Login successful
            } else {
                return false; // Wrong password
            }
        }
        return null; // User not found
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>