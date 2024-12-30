<?php

require_once "Class/DataProcessing.php";
require_once "Class/JSONResponse.php";
require_once "Class/UploadFile.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    echo JSONResponse::Unauthorized();
    return;
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "mahasiswa") {
        echo JSONResponse::Unauthorized();
        return;
    }
}

if (isset($_POST['token'])) {
    if ($_POST["token"] != $_SESSION["token"]) {
        echo JSONResponse::Error("Invalid token");
        return;
    }
} else {
    if ($_GET["token"] != $_SESSION["token"]) {
        echo JSONResponse::Error("Invalid token");
        return;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari session
    $id_user = $_SESSION['user_id'] ?? null;
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

    $jenis_dokumen = $_POST['jenis_dokumen'] ?? null;

    if (!$jenis_dokumen) {
        echo JSONResponse::Error("Jenis dokumen not found");
        return;
    }

    $kategoriValid = array(
        'Laporan Tugas Akhir/Skripsi',
        'Program/Aplikasi Tugas Akhir/Skripsi',
        'Surat Pernyataan Publikasi',
        'Jurnal/Paper/Conference/Seminar/HAKI',
        'Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi',
        'Tanda Terima Penyerahan Laporan PKL/Magang',
        'Surat Bebas Kompen',
        'Scan TOEIC',
        'Surat Pelunasan UKT Semester 1 - Lulus',
        'Foto Diri untuk Ijazah',
        'Surat Lulus SKKM',
        'Pengisian Data Alumni',
        'Surat Bebas Perpustakaan',
        'Dokumen Abstrak',
        'Laporan Jurnal',
        'Link Publikasi Jurnal'
    );

    $jenis_dokumenValid = array(
        'Bebas Tanggungan Skripsi/TA',
        'Bebas Tanggungan Program Studi',
        'Bebas Tanggungan Akademik',
        'Bebas Tanggungan Perpustakaan'
    );

    if (!in_array($kategori, $kategoriValid)) {
        echo JSONResponse::Error("Masnya lo lucu cik, mencoba merubah kategorinya");
        return;
    }

    if (!in_array($jenis_dokumen, $jenis_dokumenValid)) {
        echo JSONResponse::Error("Masnya lo lucu cik, mencoba merubah jenis dokumennya");
        return;
    }

    // Proses file upload
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        $upload = new UploadFile();
        echo $upload->ProcessUpload($id_user, $nama_user, $kategori, $jenis_dokumen, $file);
    } else {
        echo JSONResponse::Error("File not found");
    }
} else {
    echo JSONResponse::Error("Invalid request");
}
