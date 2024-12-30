<?php

session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(64)); // Generate token
    setcookie("token", $_SESSION['token'], 0, "/");
}

include "BackEnd/Extra/Redirect.php";

if (isset($_SESSION['gRole']) && isset($_SESSION['role'])) {
    if ($_SESSION['gRole'] == "admin") {
        Redirect::RedirectAdmin($_SESSION['role']);
    } elseif ($_SESSION['role'] == "mahasiswa") {
        header("Location: berandaMahasiswa.php"); // Redirect ke halaman mahasiswa jika sudah login
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Bebas Tanggungan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/loginMahasiswa.css">
</head>
<body>
    <div class="logo">
        <img src="Assets/logoPolinema.png">
    </div>
    <div class="login-container">
        <h2>Welcome Back!</h2>
        <p>Enter to access your account</p>
        <form id="form-login" action="BackEnd/Login_Mahasiswa.php" method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="text" name="nim" placeholder="Masukkan NIM anda" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input type="hidden" name="role" value="mahasiswa">
            <button type="submit">Sign In</button>
        </form>
        <div class="forgot-password">
            Forgot your password? <a href="forgotPass.php">Reset Password</a>
        </div>        
    </div>
    <script>
        // Fungsi untuk mendapatkan nilai parameter dari URL
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
    
        // Cek jika ada parameter "error"
        const error = getQueryParam('error');
        if (error === 'wrong_password') {
            alert("Password yang Anda masukkan salah. Silakan coba lagi.");
        }

        document.getElementById("form-login").addEventListener("submit", function(event) {
            event.preventDefault();

            const nim = document.querySelector("input[name=nim]").value;
            const password = document.querySelector("input[name=password]").value;
            const token = document.querySelector("input[name=token]").value;
            const role = document.querySelector("input[name=role]").value;

            if (nim === "" || password === "") {
                alert("NIM dan password harus diisi.");
                return;
            }

            const formData = new FormData();
            formData.append("username", nim);
            formData.append("password", password);
            formData.append("token", token);
            formData.append("role", role);

            fetch("BackEnd/ProcessLogin.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status != "error") {
                    window.location.href = data.redirect;
                } else {
                    console.log(data.message);
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    </script>
</body>
</html>