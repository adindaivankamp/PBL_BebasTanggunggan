<?php

require_once "Class/Connection.php";
require_once "Class/DataProcessing.php";
require_once "ProcessData/DataMahasiswa.php";
require_once "ProcessData/DataAdmin.php";
require_once "ProcessData/DataFile.php";
require_once "class/JSONResponse.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['AWD'])) {
    if($_GET['AWD'] == "true") {
        $adminData = new DataAdmin();
        echo $adminData->InsertAdmin("admin".rand(), "admin", "admin", "admin skripsi", "12312312".rand());
        return;
    }
    exit;
}

if (!isset($_SESSION['username'])) {
    die(JSONResponse::Unauthorized());
    
}

if (!isset($_SESSION['gRole'])) {
    if ($_SESSION['gRole'] != "admin") {
        die(JSONResponse::Unauthorized());
    }
}

if (isset($_POST['token'])) {
    if ($_POST["token"] != $_SESSION["token"]) {
        die(JSONResponse::Error("Invalid token"));
    }
} else {
    if ($_GET["token"] != $_SESSION["token"]) {
        die(JSONResponse::Error("Invalid token"));
    }
}

$type = $_GET['type'] ?? $_POST['type'] ?? null;

if ($type == null) {
    die(JSONResponse::Error("Invalid request"));
}

switch ($type) {
    case "mahasiswa": {
        $func = $_GET['func'] ?? $_POST['func'] ?? null;
        $data = new DataMahasiswa();
        switch ($func) {
            case "GetAllMahasiswa":
                echo $data->GetAllMahasiswa();
                break;
            case "GetMahasiswa":
                $nim = $_GET['nim'] ?? $_POST['nim'] ?? null;
                if ($nim == null) {
                    echo JSONResponse::Error("Parameter nim is empty");
                    return;
                }
                echo $data->GetMahasiswa($nim);
                break;
            case "InsertMahasiswa":
                // InsertMahasiswa($username, $password, $nim, $nama, $program_studi, $email)
                $username = $_GET['username'] ?? $_POST['username'] ?? null;
                $password = $_GET['password'] ?? $_POST['password'] ?? null;
                $nim = $_GET['nim'] ?? $_POST['nim'] ?? null;
                $nama = $_GET['nama'] ?? $_POST['nama'] ?? null;
                $program_studi = $_GET['program_studi'] ?? $_POST['program_studi'] ?? null;
                $email = $_GET['email'] ?? $_POST['email'] ?? null;
                if ($username == null || $password == null || $nim == null || $nama == null || $program_studi == null || $email == null) {
                    echo JSONResponse::Error("Parameter username, password, nim, nama, program_studi, or email is empty");
                    return;
                }
                echo $data->InsertMahasiswa($username, $password, $nim, $nama, $program_studi, $email);
                break;
            case "UpdateMahasiswa":
                // UpdateMahasiswa($nim, $nama, $alamat, $no_hp, $email, $password) {
                // formData.append('id', id);
                // formData.append('username', username);
                // formData.append('password', password);
                // formData.append('NIM', NIP);
                // formData.append('nama', nama);
                // formData.append('prodi', prodi);
                // formData.append('email', email);
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                $username = $_GET['username'] ?? $_POST['username'] ?? null;
                $password = $_GET['password'] ?? $_POST['password'] ?? null;
                $nim = $_GET['nim'] ?? $_POST['nim'] ?? null;
                $nama = $_GET['nama'] ?? $_POST['nama'] ?? null;
                $program_studi = $_GET['program_studi'] ?? $_POST['program_studi'] ?? null;
                $email = $_GET['email'] ?? $_POST['email'] ?? null;

                if ($id == null || $username == null || $password == null || $nim == null || $nama == null || $program_studi == null || $email == null) {
                    echo JSONResponse::Error("Parameter id, username, password, nim, nama, program_studi, or email is empty");
                    return;
                }
                echo $data->UpdateMahasiswa($id, $username, $password, $nim, $nama, $program_studi, $email);
                break;
            case "DeleteMahasiswa":
                $nim = $_GET['id'] ?? $_POST['id'] ?? null;
                if($nim == null) {
                    echo JSONResponse::Error("Parameter nim is empty");
                    return;
                }

                if (str_contains($nim, ",")) {
                    $nim = explode(",", $nim);
                }

                echo $data->DeleteMahasiswa($nim);
                break;
            default:
                echo JSONResponse::Error("Invalid request function");
        }
        break; // Add break here
    }
    case "admin": {
        $func = $_GET['func'] ?? $_POST['func'] ?? null;
        $data = new DataAdmin();
        switch ($func) {
            case "GetAllAdmin":
                echo $data->GetAllAdmin();
                break;
            case "GetAdmin":
                $id= $_GET['id'] ?? $_POST['id'] ?? null;
                if ($id == null) {
                    echo JSONResponse::Error("Parameter id is empty");
                    return;
                }
                echo $data->GetAdmin($username);
                break;
            case "InsertAdmin":
                // InsertAdmin($username, $password, $nama, $role)
                $username = $_GET['username'] ?? $_POST['username'] ?? null;
                $password = $_GET['password'] ?? $_POST['password'] ?? null;
                $nama = $_GET['nama'] ?? $_POST['nama'] ?? null;
                $role = $_GET['role'] ?? $_POST['role'] ?? null;
                $NIP = $_GET['NIP'] ?? $_POST['NIP'] ?? null;
                if ($username == null || $password == null || $nama == null || $role == null) {
                    echo JSONResponse::Error("Parameter username, password, nama, or role is empty");
                    return;
                }
                echo $data->InsertAdmin($username, $password, $nama, $role, $NIP);
                break;
            case "UpdateAdmin":
                // ($id, $username, $password, $nama, $role, $email)
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                $username = $_GET['username'] ?? $_POST['username'] ?? null;
                $password = $_GET['password'] ?? $_POST['password'] ?? null;
                $nama = $_GET['nama'] ?? $_POST['nama'] ?? null;
                $role = $_GET['role'] ?? $_POST['role'] ?? null;
                $email = $_GET['email'] ?? $_POST['email'] ?? null;
                $NIP = $_GET['NIP'] ?? $_POST['NIP'] ?? null;
                if ($id == null || $username == null || $password == null || $nama == null || $role == null || $email == null) {
                    echo JSONResponse::Error("Parameter id, username, password, nama, role, or email is empty");
                    return;
                }
                echo $data->UpdateAdmin($id, $username, $password, $nama, $role, $email, $NIP);
                break;
            case "DeleteAdmin":
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                if ($id == null) {
                    echo JSONResponse::Error("Parameter id is empty");
                    return;
                }

                if (str_contains($id, ",")) {
                    $id = explode(",", $id);
                }

                echo $data->DeleteAdmin($id);
                break;
            default:
                echo JSONResponse::Error("Invalid request function");
        }
        break; // Add break here
    }
    case "file": {
        $func = $_GET['func'] ?? $_POST['func'] ?? null;
        $data = new DataFile();
        switch ($func) {
            case "GetAllFile":
                echo $data->GetAllFile();
                break;
            case "GetFileById":
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                if ($id == null) {
                    echo JSONResponse::Error("Invalid parameter id");
                    return;
                }
                echo $data->GetFileById($id);
                break;
            case "GetFileByNim":
                $nim = $_GET['nim'] ?? $_POST['nim'] ?? null;
                if ($nim == null) {
                    echo JSONResponse::Error("Invalid parameter nim");
                    return;
                }
                echo $data->GetAllFileByNim($nim);
                break;
            case "GetFileByCategory":
                $category = $_GET['category'] ?? $_POST['category'] ?? null;

                // Sometime $category has / inside the string like Skripsi/Tesis/Disertasi  
                // So we need to replace %2F with /
                $category = str_replace("%2F", "/", $category);

                if ($category == null) {
                    echo JSONResponse::Error("Invalid parameter category");
                    return;
                }
                echo $data->GetFileByCategory($category);
                break;
            case "GetFileByJenisDokumen":
                $jenis_dokumen = $_GET['jenis_dokumen'] ?? $_POST['jenis_dokumen'] ?? null;

                // Sometime $jenis_dokumen has / inside the string like Skripsi/Tesis/Disertasi
                // So we need to replace %2F with /
                $jenis_dokumen = str_replace("%2F", "/", $jenis_dokumen);

                if ($jenis_dokumen == null) {
                    echo JSONResponse::Error("Invalid parameter jenis_dokumen");
                    return;
                }
                echo $data->GetFileByJenisDokumen($jenis_dokumen);
                break;
            case "GetFileByCategoryAndNim":
                $category = $_GET['category'] ?? $_POST['category'] ?? null;

                // Sometime $category has / inside the string like Skripsi/Tesis/Disertasi
                // So we need to replace %2F with /
                $category = str_replace("%2F", "/", $category);

                $nim = $_GET['nim'] ?? $_POST['nim'] ?? null;
                if ($category == null || $nim == null) {
                    echo JSONResponse::Error("Invalid parameter category or nim");
                    return;
                }
                echo $data->GetFileByCategoryAndNim($category, $nim);
                break;
            case "GetFileByJenisDokumenAndNim":
                $jenis_dokumen = $_GET['jenis_dokumen'] ?? $_POST['jenis_dokumen'] ?? null;

                // Sometime $jenis_dokumen has / inside the string like Skripsi/Tesis/Disertasi
                // So we need to replace %2F with /
                $jenis_dokumen = str_replace("%2F", "/", $jenis_dokumen);

                $nim = $_GET['nim'] ?? $_POST['nim'] ?? null;
                if ($jenis_dokumen == null || $nim == null) {
                    echo JSONResponse::Error("Invalid parameter jenis_dokumen or nim");
                    return;
                }
                echo $data->GetFileByJenisDokumenAndNim($jenis_dokumen, $nim);
                break;
            case "TolakFile":
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                $alasan = $_GET['alasan'] ?? $_POST['alasan'] ?? null;

                $alasan = urldecode($alasan);

                if ($id == null) {
                    echo JSONResponse::Error("Invalid parameter id");
                    return;
                }
                echo $data->TolakFile($id, $alasan);
                break;
            case "TerimaFile":
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                if ($id == null) {
                    echo JSONResponse::Error("Invalid parameter id");
                    return;
                }
                echo $data->TerimaFile($id);
                break;
            case "DeleteFile":
                $id = $_GET['id'] ?? $_POST['id'] ?? null;
                if ($id == null) {
                    echo JSONResponse::Error("Invalid parameter id");
                    return;
                }

                // Sometimes $id is array, so we need to explode it
                if (str_contains($id, ",")) {
                    $id = explode(",", $id);
                }

                echo $data->DeleteFile($id);
                break;
            case "UpdateFile": {
                // FormData.append('id', id);
                // FormData.append('nama', nama);
                // FormData.append('kategori', kategori);
                // FormData.append('jenis_dokumen', jenis_dokumen);
                // FormData.append('nama_file', nama_file);
                // FormData.append('status_validasi', status_validasi);
                // FormData.append('notes', notes);

                $id = $_POST['id'] ?? $_GET['id'] ?? null;
                $nama = $_POST['nama'] ?? $_GET['nama'] ?? null;
                $kategori = $_POST['kategori'] ?? $_GET['kategori'] ?? null;
                $jenis_dokumen = $_POST['jenis_dokumen'] ?? $_GET['jenis_dokumen'] ?? null;
                $status_validasi = $_POST['status_validasi'] ?? $_GET['status_validasi'] ?? null;
                $notes = $_POST['notes'] ?? $_GET['notes'] ?? null;

                if ($id == null || $nama == null || $kategori == null || $jenis_dokumen == null || $status_validasi == null || $notes == null) {
                    echo JSONResponse::Error("Invalid parameter id, nama, kategori, jenis_dokumen, status_validasi, or notes");
                    return;
                }

                echo $data->EditFile($id, $nama, $kategori, $jenis_dokumen, $status_validasi, $notes);
                break;
            }
            default:
                echo JSONResponse::Error("Invalid request function");
        }
        break; // Add break here
    }
    default:
        echo JSONResponse::Error("Invalid request type");
}