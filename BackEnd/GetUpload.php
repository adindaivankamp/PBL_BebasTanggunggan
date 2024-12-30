<?php
session_start();

// Include file Connection.php untuk koneksi ke database
require_once "ProcessData/DataFile.php";
require_once "Class/JSONResponse.php";

// Fungsi untuk memproses upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari session
    $nama = $_SESSION['username'];
    $jenis_dokumen = $_POST['jenis_dokumen'];
    
    // Anti SQL Injection
    $nama = htmlspecialchars($nama);
    $jenis_dokumen = htmlspecialchars($jenis_dokumen);

    $dataFile = new DataFile();
    $files = $dataFile->GetFileByJenisDokumenAndNim($jenis_dokumen, $nama);
    echo $files;
}
