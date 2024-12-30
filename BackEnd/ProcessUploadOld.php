<?php
session_start();

// Include file Connection.php untuk koneksi ke database
require_once 'Class/Connection.php';

$db = new Database();
$conn = $db->getInstance()->getConnection();

// Pastikan koneksi tersedia
if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Fungsi untuk memproses upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_POST["token"] != $_SESSION["token"]){
        die(json_encode(array("status" => "error", "message" => "Invalid token")));
    }
    // Ambil data dari session
    $id_user = $_SESSION['user_id'] ?? null;
    $nama_user = $_SESSION['user_name'] ?? null;

    if (!$id_user || !$nama_user) {
        die(json_encode(array("status" => "error", "message" => "User not found")));
    }

    // Ambil kategori dari inputan hidden atau request
    $kategori = $_POST['kategori'] ?? null;
    $jenis_dokumen = $_POST['jenis_dokumen'] ?? null;

    if (!$kategori) {
        die(json_encode(array("status" => "error", "message" => "Kategori not found")));
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

            $sql = "SELECT * FROM dbo.upload_dokumen WHERE nama_file = ?;";
            $params = [$nama_file];
            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt === false) {
                die(json_encode(array("status" => "error", "message" => "Failed to check file")));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if (!$row) { // Jika file belum pernah diupload

                // Simpan informasi ke database
                $tanggal_upload = date('Y-m-d H:i:s');
                $sql = "INSERT INTO dbo.upload_dokumen (id, nama, kategori, jenis_dokumen,file_path, nama_file, ukuran_file, tipe_file, tanggal_upload, notes)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

                $params = [
                    $id_user,
                    $nama_user,
                    $kategori,
                    $jenis_dokumen,
                    $file_path,
                    $nama_file,
                    $ukuran_file,
                    $tipe_file,
                    $tanggal_upload,
                    "Masih dalam proses pengecekan"
                ];
                $stmt = sqlsrv_prepare($conn, $sql, $params);
                
                if ($stmt && sqlsrv_execute($stmt)) {
                    die(json_encode(array("status" => "success", "message" => "File uploaded successfully")));
                } else {
                    die(json_encode(array("status" => "error", "message" => "Failed to upload file to database")));
                }
            } else {
                die(json_encode(array("status" => "success", "message" => "File uploaded successfully")));
            }
        } else {
            die(json_encode(array("status" => "error", "message" => "Failed to move file")));
        }
    } else {
        die(json_encode(array("status" => "error", "message" => "File not found")));
    }
} else {
    die(json_encode(array("status" => "error", "message" => "Invalid request method")));
}
