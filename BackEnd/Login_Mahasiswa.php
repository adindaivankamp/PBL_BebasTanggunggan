<?php
session_start();

include "Connection.php";
include "User.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    $db = new Database();
    $user = new User($db);

    $loginResult = $user->login($nim, $password);

    if ($loginResult === true) {
        header("Location: ../berandaMahasiswa.html"); // Redirect to dashboard
        exit;
    } elseif ($loginResult === false) {
        header("Location: ../Login.html?error=wrong_password");
        exit;
    } else {
        echo "User not found";
    }
}
?>