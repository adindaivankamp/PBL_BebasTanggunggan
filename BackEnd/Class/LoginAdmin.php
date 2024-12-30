<?php

require_once "Connection.php";
require_once "User.php";
require_once "JSONResponse.php";
require_once "Extra/Redirect.php";

class Login_Admin extends User {

    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {
        if(empty($username) || empty($password)) {
            return JSONResponse::Error("Username or Password is empty");
        }

        if($this->GetConnection() === null) {
            return JSONResponse::Error("Database connection error");
        }

        // Check if Session is already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sql = "SELECT * FROM dbo.admin WHERE username = ?;";
        $params = [$username];
        $stmt = sqlsrv_query($this->GetConnection(), $sql, $params);

        if ($stmt === false) {
            return JSONResponse::Error("Query error : ".print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row) {
            if ($password == $row['password']) {
                // Set session data
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['nama'];
                $_SESSION['nip'] = $row['NIP'];
                // So... admin have their own role, with that role we can determite where they can go

                $_SESSION['role'] = $row['role'];
                $_SESSION['gRole'] = "admin";

                $redir = "unknown.php";

                switch($row['role'])
                {
                    // admin prodi
                    // perpus
                    // teknisi
                    // admin skripsi
                    // maintenance

                    case "admin prodi":
                        $redir = "beranda_admin_prodi.php";
                        break;
                    case "perpus":
                        $redir = "beranda_admin_perpustakaan.php";
                        break;
                    case "teknisi":
                        $redir = "beranda_admin_akademik.php";
                        break;
                    case "admin skripsi":
                        $redir = "beranda_admin_skripsi.php";
                        break;
                    case "maintenance":
                        $redir = "maintain_admin.php";
                        break;
                    default:
                        $redir = "unknown.php";
                        break;
                }

                return JSONResponse::Redirect($redir);
            }
        }
        return JSONResponse::Error("Username or Password is incorrect"); // Username or Password is incorrect
    }
}