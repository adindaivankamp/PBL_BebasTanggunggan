<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Password</title>
    <!-- Import font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/resetPass.css">
</head>

<body>
    <div class="container">
        <h1>Pemulihan Password</h1>
        <p>SISTEM INFORMASI BEBAS TANGGUNGAN<br>POLINEMA</p>
        <form action="BackEnd/PasswordRecovery.php" method="POST">
            <div class="form-group">
                <label for="password">Set Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password baru" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm-password"
                    placeholder="Konfirmasi password baru" required>
                <div class="button-container">
                    <button type="submit">PROSES</button>
                </div>
            </div>
        </form>
        <div class="link-footer">
            Klik <a href="login.php">disini</a> untuk kembali ke Halaman Utama
        </div>
    </div>
</body>

</html>