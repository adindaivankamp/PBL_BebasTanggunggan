<?php
session_start();

// Include file Connection.php untuk koneksi ke database
require_once 'Class/Connection.php';
require_once 'Class/JSONResponse.php';
require_once 'Class/UploadFile.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['username'])) {
    echo JSONResponse::Unauthorized();
    return;
}

if(isset($_SESSION['role'])) {
    if($_SESSION['role'] == "admin") {
        echo JSONResponse::Unauthorized();
        return;
    }
}

if(isset($_POST['token'])) {
    if($_POST["token"] != $_SESSION["token"]){
        echo JSONResponse::Error("Invalid token");
        return;
    }
} else {
    if($_GET["token"] != $_SESSION["token"]){
        echo JSONResponse::Error("Invalid token");
        return;
    }
}

// Fungsi untuk memproses upload file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari session
    $id_user = $_SESSION['nim'] ?? null;
    $nama_user = $_SESSION['username'] ?? null;

    if (!$id_user || !$nama_user) {
        echo JSONResponse::Error("User not found");
        return;
    }

    $kategori = $_POST['kategori'] ?? null;

    if (!$kategori) {
        echo JSONResponse::Error("Kategori not found");
        return;
    }

    // Proses file upload
    if (isset($_POST['file'])) {
        // File is base64 encoded
        $file = $_POST['file'];
        // data:application/pdf;base64,JVBERi0xLjcN
        $file = explode(',', $file);
        $fileData = base64_decode($file[1]);

        $fileType = $file[0];
        $fileType = explode(';', $fileType);
        $fileType = explode(':', $fileType[0]);
        $fileType = $fileType[1];

        $fileName = $_POST['fileName'] ?? null;
        $fileSize = $_POST['fileSize'] ?? null;

        if (!$fileName || !$fileSize) {
            echo JSONResponse::Error("File name or file size not found");
            return;
        }

        // Tentukan folder untuk menyimpan file
        $upload_dir = 'Upload/'; // Pastikan folder ini memiliki izin tulis
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $kategori_dir = $upload_dir . $kategori . '/';
        if (!is_dir($kategori_dir)) {
            mkdir($kategori_dir, 0777, true);
        }

        $upload_dir = $kategori_dir;

        $file_path = $upload_dir . $fileName;

        // Simpan file ke server
        if (file_put_contents($file_path, $fileData)) {
            // Insert file data to database
            $upload = new UploadFile();
            // UploadFileQueryOnly($nim, $kategori, $nama_file, $file_path, $extra_parameter = [])
            echo $upload->UploadFileQueryOnly($kategori, $fileName, $file_path, $_POST);
        } else {
            echo JSONResponse::Error("Failed to upload file");
        }
    }
}