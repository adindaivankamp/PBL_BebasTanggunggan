<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Password</title>
    <!-- Import font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/forgotPass.css">
</head>
<body>
    <div class="container">
        <h1>Pemulihan Password</h1>
        <p>SISTEM INFORMASI BEBAS TANGGUNGAN<br>POLINEMA</p>
        <form action="BackEnd/PasswordRecovery.php" method="POST">
            <div class="form-group">
                <label for="email">Email Pemulihan</label>
                <input type="email" name="email" id="email" placeholder="Masukkan email Anda" required>
                <div class="button-container">
                    <button type="submit">PROSES</button>
                </div>
            </div>
        </form>        
        <div class="link-footer">
            Klik <a href="login.php">disini</a> untuk kembali ke Halaman Akun
        </div>
    </div>
</body>
</html>
