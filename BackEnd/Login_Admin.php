<?php
session_start();

include "Connection.php";
include "user_admin.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $NIP = $_POST['NIP'];
    $password = $_POST['password'];

    $db = new Database();
    $user = new User($db);

    $loginResult = $user->login_admin($NIP, $password);

    if ($loginResult === true) {
        header("Location: ../FrontEnd/HTML/beranda_admin.html"); // Redirect to dashboard
        exit;
    } elseif ($loginResult === false) {
        header("Location: ../FrontEnd/HTML/login_admin.html?error=wrong_password");
        exit;
    } else {
        echo "User not found";
    }
}
?>