<?php
session_start();

include "Connection.php";
include "User.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim = $_POST['nip'];
    $password = $_POST['password'];

    $db = new Database();
    $user = new User($db);

    $loginResult = $user->login($nip, $password);

    if ($loginResult === true) {
        header("Location: ../beranda_admin.html"); // Redirect to dashboard
        exit;
    } elseif ($loginResult === false) {
        header("Location: ../login_admin.html?error=wrong_password");
        exit;
    } else {
        echo "User not found";
    }
}
?>