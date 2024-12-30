<?php

require_once "Connection.php";
require_once "JSONResponse.php";
require_once "DataProcessing.php";
require_once "ProcessData/DataMahasiswa.php";

class UploadFile
{
    private $db;
    private $conn;
    private $dataProcessing;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
        $this->dataProcessing = new DataProcessing();
    }

    private function IsFileAllowed($file)
    {
        //$file can be string and file array
        $file_type = $file;
        if (is_array($file)) {
            $file_type = $file['type'];
        }

        if($file_type != "application/pdf") {
            return false;
        }

        return true;
    }

    public function ProcessUpload($id_user, $nama_user, $kategori, $jenis_dokumen, $file)
    {
        $nama_file = basename($file['name']);
        $ukuran_file = $file['size'];

        $tipe_file = $file['type'];

        if(!$this->IsFileAllowed($tipe_file)) {
            return JSONResponse::Error("File type not allowed");
        }

        $tmp_file = $file['tmp_name'];

        $upload_dir = 'Upload/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $dokumen = "Dokumen/";
        if (!is_dir($upload_dir . $dokumen))
            mkdir($upload_dir . $dokumen, 0777, true);

        $upload_dir = $upload_dir . $dokumen;

        $nama_file = $id_user . "_" . $nama_file;

        $file_path = $upload_dir . $nama_file;

        if (move_uploaded_file($tmp_file, $file_path)) {

            $sql = "SELECT * FROM dbo.upload_dokumen WHERE nama_file = ?;";
            $params = [$nama_file];
            $stmt = sqlsrv_query($this->conn, $sql, $params);

            if ($stmt === false) {
                die(JSONResponse::Error("Query failed: " . print_r(sqlsrv_errors(), true)));
            }

            if (sqlsrv_has_rows($stmt)) {
                // Replace Existing File and Update Database
                $sql = "UPDATE dbo.upload_dokumen SET ukuran_file = ?, tipe_file = ?, file_path = ? WHERE nama_file = ?;";
                $params = [$ukuran_file, $tipe_file, $file_path, $nama_file];
                $stmt = sqlsrv_query($this->conn, $sql, $params);

                if ($stmt === false) {
                    die(JSONResponse::Error("Query failed: " . print_r(sqlsrv_errors(), true)));
                }

                return JSONResponse::Success("File updated successfully");
            }

            $sql = "INSERT INTO dbo.upload_dokumen (id, nama, kategori, jenis_dokumen, nama_file, ukuran_file, tipe_file, file_path, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $params = [$id_user, $nama_user, $kategori, $jenis_dokumen, $nama_file, $ukuran_file, $tipe_file, $file_path, "Masih dalam proses pengecekan"];
            $stmt = sqlsrv_query($this->conn, $sql, $params);

            if ($stmt === false) {
                die(JSONResponse::Error("Query failed: " . print_r(sqlsrv_errors(), true)));
            }

            return JSONResponse::Success("File uploaded successfully");
        } else {
            return JSONResponse::Error("Failed to upload file");
        }
    }

    public function UploadFileQueryOnly($kategori, $nama_file, $file_path, $extra_parameter = [])
    {
        $sql = "";
        switch ($kategori) {
            case "TA": {
                    if (!isset($extra_parameter['link']) || !isset($extra_parameter['number'])) {
                        return JSONResponse::Error("Missing extra parameter");
                    }

                    // Cek di database apakah user dengan nim tersebut sudah mengupload file TA
                    $nim = $extra_parameter['nim'];
                    $sql = "SELECT * FROM dbo.surat_pernyataan_publikasi WHERE nim = '" . $nim . "';";
                    $res = $this->dataProcessing->ExecuteQuery($sql);
                    $res = json_decode($res, true);

                    if ($res['status'] == "success") {
                        if (count($res['data']) > 0) {
                            // File Already exist, so we change the query to update the file
                            $sql = "UPDATE dbo.form_tugas_akhir SET file_laporan_name = '$nama_file', file_laporan_path = '$file_path' WHERE nim = '" . $nim . "';";
                            $this->dataProcessing->ExecuteQuery($sql);
                            // Unlink the old file
                            $old_file_path = $res['data'][0]['file_laporan_path'];
                            if (file_exists($old_file_path))
                                unlink($old_file_path);
                            return JSONResponse::Success("File updated successfully");
                        }
                    }

                    $name = $extra_parameter['name'];
                    $email = $extra_parameter['email'];
                    $prodi = $extra_parameter['prodi'];

                    $no_whatsapp = $extra_parameter['number'];
                    $link_program_tugas_akhir = $extra_parameter['link'];

                    $sql = "INSERT INTO dbo.form_tugas_akhir (nim, nama, email_address, no_whatsapp, link_program_tugas_akhir, file_laporan_name, file_laporan_path, program_studi) VALUES ('$nim', '$name', '$email', '$no_whatsapp', '$link_program_tugas_akhir', '$nama_file', '$file_path', '$prodi');";

                    break;
                }

            case "PUBLIKASI": {
                    if (!isset($extra_parameter['nim']) || !isset($extra_parameter['number']) || !isset($extra_parameter['prodi']) || !isset($extra_parameter['name'])) {
                        return JSONResponse::Error("Missing extra parameter");
                    }

                    // Cek di database apakah user dengan nim tersebut sudah mengupload file PUBLIKASI
                    $nim = $extra_parameter['nim'];
                    $sql = "SELECT * FROM dbo.surat_pernyataan_publikasi WHERE nim = '" . $nim . "';";
                    $res = $this->dataProcessing->ExecuteQuery($sql);
                    $res = json_decode($res, true);

                    if ($res['status'] == "success") {
                        if (count($res['data']) > 0) {
                            // File Already exist, so we change the query to update the file
                            $sql = "UPDATE dbo.surat_pernyataan_publikasi SET file_surat_name = '$nama_file', file_surat_path = '$file_path' WHERE nim = '" . $nim . "';";
                            $this->dataProcessing->ExecuteQuery($sql);
                            // Unlink the old file
                            $old_file_path = $res['data'][0]['file_surat_path'];
                            if (file_exists($old_file_path))
                                unlink($old_file_path);
                            return JSONResponse::Success("File updated successfully");
                        }
                    }

                    $name = $extra_parameter['name'];
                    $nim = $extra_parameter['nim'];
                    $no_whatsapp = $extra_parameter['number'];
                    $prodi = $extra_parameter['prodi'];

                    $sql = "INSERT INTO dbo.surat_pernyataan_publikasi (nim, nama, no_whatsapp, program_studi, file_surat_name, file_surat_path) VALUES ('$nim', '$name', '$no_whatsapp', '$prodi', '$nama_file', '$file_path');";

                    break;
                }

            case "BEBASKOMPEN": {
                    if (!isset($extra_parameter['nim']) || !isset($extra_parameter['number']) || !isset($extra_parameter['prodi']) || !isset($extra_parameter['name'])) {
                        return JSONResponse::Error("Missing extra parameter");
                    }

                    $name = $extra_parameter['name'];
                    $nim = $extra_parameter['nim'];
                    $no_whatsapp = $extra_parameter['number'];
                    $prodi = $extra_parameter['prodi'];

                    $sql = "INSERT INTO dbo.surat_keterangan_bebas_kompen (nim, nama, no_whatsapp, program_studi, surat_bebas_kompen_name, surat_bebas_kompen_path) VALUES ('$nim', '$name', '$no_whatsapp', '$prodi', '$nama_file', '$file_path');";

                    break;
                }
            case "UKT": {
                    if (!isset($extra_parameter['nim']) || !isset($extra_parameter['number']) || !isset($extra_parameter['prodi']) || !isset($extra_parameter['name'])) {
                        return JSONResponse::Error("Missing extra parameter");
                    }

                    $name = $extra_parameter['name'];
                    $nim = $extra_parameter['nim'];
                    $no_whatsapp = $extra_parameter['number'];
                    $prodi = $extra_parameter['prodi'];

                    $sql = "INSERT INTO dbo.surat_keterangan_ukt (nim, nama, no_whatsapp, program_studi, file_surat_pelunasan_ukt_name, file_surat_pelunasan_ukt_path) VALUES ('$nim', '$name', '$no_whatsapp', '$prodi', '$nama_file', '$file_path');";

                    break;
                }
        }

        if ($sql == "") {
            return JSONResponse::Error("Invalid category");
        }

        return $this->dataProcessing->ExecuteQuery($sql);
    }
}
