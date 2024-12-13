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
    $jenis_dokumen = $_POST['jenis_dokumen'];
    $sql = "SELECT * FROM dbo.upload_dokumen WHERE id = $id_user AND jenis_dokumen = '$jenis_dokumen'";

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $sql);
    $data = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }


    echo json_encode($data);
}
