<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(64)); // Generate token
    setcookie("token", $_SESSION['token'], 0, "/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Halaman_Awal.css">
</head>

<body>
    <div class="login-container">
        <h1>Selamat datang !</h1>
        <h2>di Sistem Informasi Bebas Tanggungan</h2>
        <form id="roleSelectionForm">
            <label for="role">Login sebagai:</label>
            <select id="role" name="role">
                <option value="student">Mahasiswa</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">OK</button>
        </form>
    </div>
</body>

<script>
    document.getElementById("roleSelectionForm").addEventListener("submit", function (event) {
        event.preventDefault();

        const role = document.getElementById("role").value;

        if (role === "student") {
            window.location.href = 'login.php';
        } else if (role === "admin") {
            window.location.href = 'login_admin.php';
        }
    });

</script>

</html>