<?php

require_once "Class/DataProcessing.php";

class DataFile extends DataProcessing
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetAllFile()
    {
        return $this->GetData("dbo.upload_dokumen", "*");
    }

    public function GetFileById($id)
    {
        return $this->GetData("dbo.upload_dokumen", "*", "id = '$id'");
    }

    public function GetAllFileByNim($name)
    {
        return $this->GetData("dbo.upload_dokumen", "*", "nama = '$name'");
    }

    public function GetFileByCategory($category)
    {
        return $this->GetData("dbo.upload_dokumen", "*", "kategori = '$category'");
    }

    public function GetFileByCategoryAndNim($category, $name)
    {
        return $this->GetData("dbo.upload_dokumen", "*", "kategori = '$category' AND nama = '$name'");
    }

    public function GetFileByJenisDokumen($jenis_dokumen)
    {
        return $this->GetData("dbo.upload_dokumen", "*", "jenis_dokumen = '$jenis_dokumen'");
    }

    public function GetFileByJenisDokumenAndNim($jenis_dokumen, $name)
    {
        return $this->GetData("dbo.upload_dokumen", "*", "jenis_dokumen = '$jenis_dokumen' AND nama = '$name'");
    }
    
    public function TolakFile($id, $alasan)
    {
        return $this->UpdateData("dbo.upload_dokumen", "status_validasi = '0', notes = '$alasan'", "id_upload = '$id'");
    }

    public function TerimaFile($id)
    {
        return $this->UpdateData("dbo.upload_dokumen", "status_validasi = '1', notes = 'SIP'", "id_upload = '$id'");
    }

    public function DeleteFile($id)
    {
        if (is_array($id)) {

            // Get ALL file path

            $sql = "SELECT * FROM dbo.upload_dokumen WHERE id_upload IN (";
            $isq = implode(",", $id);
            $sql .= $isq . ");";

            $query = $this->ExecuteQuery($sql);
            $query = json_decode($query, true);
            $data = $query['data'];

            for($i = 0; $i < count($data); $i++) {
                $file_path = $data[$i]['file_path'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $sql = "DELETE FROM dbo.upload_dokumen WHERE id_upload IN (";
            $id = implode(",", $id);
            $sql .= $id . ");";

            return $this->ExecuteQuery($sql);
        }

        $sql = "SELECT * FROM dbo.upload_dokumen WHERE id_upload = '$id';";
        $query = $this->ExecuteQuery($sql);
        $query = json_decode($query, true);
        $data = $query['data'];

        $file_path = $data[0]['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        return $this->DeleteData("dbo.upload_dokumen", "id_upload = '$id'");
    }

    public function EditFile($id, $nama, $kategori, $jenis_dokumen, $status_validasi, $notes)
    {
        return $this->UpdateData("dbo.upload_dokumen", "nama = '$nama', kategori = '$kategori', jenis_dokumen = '$jenis_dokumen', status_validasi = '$status_validasi', notes = '$notes'", "id_upload = '$id'");
    }

    public function GetAllAnnouncement()
    {
        return $this->GetData("dbo.pdf_files", "*");
    }

    public function GetAnnouncementById($id)
    {
        return $this->GetData("dbo.pdf_files", "*", "id = '$id'");
    }

    public function InsertAnnouncement($judul, $file)
    {
        // $file is base64 encoded file
        $file = base64_decode($file);
        $file_name = uniqid() . ".pdf";
        $upload = "Upload/";
        if (!file_exists($upload)) {
            mkdir($upload, 0777, true);
        }

        $announcement = "Announcement/";
        $upload = $upload . $announcement;

        if (!file_exists($upload)) {
            mkdir($upload, 0777, true);
        }

        $file_path = $upload . $file_name;
        if(file_put_contents($file_path, $file)) {
            return $this->InsertData("dbo.pdf_files", "file_name, file_path", "'$judul', '$file_path'");
        }

        return JSONResponse::Error("Failed to upload file");
    }

    public function DeleteAnnouncement($id)
    {
        if (is_array($id)) {

            // Get ALL file path

            $sql = "SELECT * FROM dbo.pdf_files WHERE id IN (";
            $isq = implode(",", $id);
            $sql .= $isq . ");";

            $query = $this->ExecuteQuery($sql);
            $query = json_decode($query, true);
            $data = $query['data'];

            for($i = 0; $i < count($data); $i++) {
                $file_path = $data[$i]['file_path'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $sql = "DELETE FROM dbo.pdf_files WHERE id IN (";
            $id = implode(",", $id);
            $sql .= $id . ");";

            return $this->ExecuteQuery($sql);
        }

        $sql = "SELECT * FROM dbo.pdf_files WHERE id = '$id';";
        $query = $this->ExecuteQuery($sql);
        $query = json_decode($query, true);
        $data = $query['data'];

        $file_path = $data[0]['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        return $this->DeleteData("dbo.pdf_files", "id = '$id'");
    }

    public function EditAnnouncement($id, $judul)
    {
        return $this->UpdateData("dbo.pdf_files", "file_name = '$judul'", "id = '$id'");
    }

}
