<?php

require_once "Class/Connection.php";
require_once "Class/LoginMahasiswa.php";
require_once "Class/LoginAdmin.php";

function ProcessLogin($username, $password, $role) {
    if ($role == "mahasiswa") {
        $login = new Login_Mahasiswa();
        return $login->login($username, $password);
    } elseif ($role == "admin") {
        $login = new Login_Admin();
        return $login->login($username, $password);
    }
    return json_encode(array("status" => "error", "message" => "Invalid role"));
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if($_POST["token"] != $_SESSION["token"]){
        die(json_encode(array("status" => "error", "message" => "Invalid token")));
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    $role = htmlspecialchars($role);

    $result = ProcessLogin($username, $password, $role);
    echo $result;
}

?>