<?php
session_start();

// Include file Connection.php untuk koneksi ke database
include_once 'Connection.php';

$db = new Database();
$conn = $db->connect();

// Pastikan koneksi tersedia
if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Fungsi untuk memproses upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari session
    $id_user = $_SESSION['user_id'] ?? null;
    $nama_user = $_SESSION['user_name'] ?? null;

    if (!$id_user || !$nama_user) {
        $_SESSION['alert_message'] = "Session tidak valid.";
        header("Location: ../FrontEnd/HTML/upload.html");
        exit;
    }

    // Ambil kategori dari inputan hidden atau request
    $kategori = $_POST['kategori'] ?? null;
    $jenis_dokumen = $_POST['jenis_dokumen'] ?? null;

    if (!$kategori) {
        $_SESSION['alert_message'] = "Kategori tidak ditemukan.";
        header("Location: ../FrontEnd/HTML/upload.html");
        exit;
    }

    // Proses file upload
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        $nama_file = basename($file['name']);
        $ukuran_file = $file['size'];
        $tipe_file = $file['type'];
        $tmp_file = $file['tmp_name'];

        // Tentukan folder untuk menyimpan file
        $upload_dir = 'Upload/'; // Pastikan folder ini memiliki izin tulis
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . $nama_file;

        // Simpan file ke server
        if (move_uploaded_file($tmp_file, $file_path)) {
            // Simpan informasi ke database
            $tanggal_upload = date('Y-m-d H:i:s');
            $sql = "INSERT INTO dbo.upload_dokumen (id, nama, kategori, jenis_dokumen,file_path, nama_file, ukuran_file, tipe_file, tanggal_upload, notes)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $params = [
                $id_user, $nama_user, $kategori, $jenis_dokumen,$file_path, $nama_file, $ukuran_file, $tipe_file, $tanggal_upload, "Masih dalam proses pengecekan"
            ];

            $stmt = sqlsrv_prepare($conn, $sql, $params);

            if ($stmt && sqlsrv_execute($stmt)) {
                $_SESSION['alert_message'] = "File berhasil diunggah!";
                header("Location: ../FrontEnd/HTML/upload.html");
                exit;
            } else {
                $_SESSION['alert_message'] = "Gagal menyimpan data ke database.";
                header("Location: ../FrontEnd/HTML/upload.html");
                exit;
            }
        } else {
            $_SESSION['alert_message'] = "Gagal mengunggah file.";
            header("Location: ../FrontEnd/HTML/upload.html");
            exit;
        }
    } else {
        $_SESSION['alert_message'] = "Tidak ada file yang diunggah.";
        header("Location: ../FrontEnd/HTML/upload.html");
        exit;
    }
} else {
    $_SESSION['alert_message'] = "Metode request tidak valid.";
    header("Location: ../FrontEnd/HTML/upload.html");
    exit;
}
