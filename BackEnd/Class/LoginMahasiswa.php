<?php

require_once "Connection.php";
require_once "User.php";

class Login_Mahasiswa extends User {

    public function __construct() {
        parent::__construct();
    }

    public function login($nim, $password) {
        if(empty($nim) || empty($password)) {
            return json_encode(array("message" => "NIM or Password is empty"));
        }

        if($this->GetConnection() === null) {
            return json_encode(array("message" => "Database connection is null"));
        }

        // Check if Session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sql = "SELECT * FROM dbo.mahasiswa_login WHERE nim = ?;";
        $params = [$nim];
        $stmt = sqlsrv_query($this->GetConnection(), $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            if ($password == $row['password']) {
                // Set session data
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['nama'];
                $_SESSION['nim'] = $row['nim'];
                $_SESSION['prodi'] = $row['program_studi'];
                $_SESSION['role'] = "mahasiswa";
                $_SESSION['gRole'] = "mahasiswa";
                return json_encode(array("status" => "success", "message" => "Login successful", "redirect" => "berandaMahasiswa.php")); // Login successful
            }
        }
        return json_encode(array("status" => "error", "message" => "Wrong Password or User Not Found")); // Login failed
    }
}
?>