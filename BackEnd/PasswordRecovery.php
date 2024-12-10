<?php
// Impor file Connection.php
require_once 'Connection.php';

// Mulai session untuk menyimpan email pengguna
session_start();

// Buat instance dari kelas Database
$db = new Database();
$conn = $db->connect();

if ($conn === false) {
    die("Koneksi database gagal.");
}

// Fungsi untuk memverifikasi email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM dbo.mahasiswa_login WHERE email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Jika email ditemukan, simpan ke session dan alihkan ke halaman resetPass.html
    if (sqlsrv_fetch_array($stmt)) {
        $_SESSION['email'] = $email;
        header("Location: ../FrontEnd/HTML/resetPass.html");
        exit();
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.history.back();</script>";
    }
}

// Fungsi untuk mereset password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Password dan konfirmasi password tidak sama!'); window.history.back();</script>";
        exit();
    }

    // Ambil email dari session
    if (!isset($_SESSION['email'])) {
        echo "<script>alert('Session email tidak ditemukan!'); window.location.href = '../forgetPass.html';</script>";
        exit();
    }

    $email = $_SESSION['email'];

    // Perbarui password di database tanpa enkripsi
    $sql = "UPDATE dbo.mahasiswa_login SET password = ? WHERE email = ?";
    $params = array($password, $email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Hapus session email setelah password berhasil diperbarui
    unset($_SESSION['email']);

    echo "<script>alert('Password berhasil diubah!'); window.location.href = '../FrontEnd/HTML/login.html';</script>";
}

// Tutup koneksi
$db->close();
?>