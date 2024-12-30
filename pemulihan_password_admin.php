<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('../Assets/BGPBL.png');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .container h1 {
            color: #7AC142;
            font-size: 1.5rem;
        }

        .container p {
            color: #7AC142;
            margin: 10px 0;
            font-size: 1rem;
        }

        .container input[type="email"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container button {
            background-color: #7AC142;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .container button:hover {
            background-color: #68a12e;
        }

        .container a {
            color: #7AC142;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .container a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Pemulihan Password</h1>
        <p>SISTEM INFORMASI BEBAS TANGGUNGAN POLINEMA</p>
        <form action="set_password_admin.php" method="GET">
            <input type="email" placeholder="Email Pemulihan" required>
            <br>
            <button type="submit">PROSES</button>
        </form>
        <br>
        <a href="beranda_admin_skripsi.php">Klik disini untuk kembali ke Halaman Akun</a>
    </div>
</body>

</html>