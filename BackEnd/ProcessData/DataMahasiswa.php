<?php

require_once "Class/DataProcessing.php";

class DataMahasiswa extends DataProcessing {
    public function __construct() {
        parent::__construct();
    }

    public function GetAllMahasiswa() {
        // Page 1 : 0 - 10, Page 2 : 10 - 20, Page 3 : 20 - 30
        // GetData($table, $columns, $where = "")
        return $this->GetData("dbo.mahasiswa_login", "*");
    }

    public function GetMahasiswa($nim) {
        return $this->GetData("dbo.mahasiswa_login", "*", "nim = '$nim' OR nama LIKE '%$nim%'");
    }

    public function InsertMahasiswa($username, $password, $nim, $nama, $program_studi, $email) {
        return $this->InsertData("dbo.mahasiswa_login", "username, password, nim, nama, program_studi, email", "'$username', '$password', '$nim', '$nama', '$program_studi', '$email'");
    }

    public function UpdateMahasiswa($id, $username, $password, $nim, $nama, $program_studi, $email) {
        return $this->UpdateData("dbo.mahasiswa_login", "username = '$username', password = '$password', nim = '$nim', nama = '$nama', program_studi = '$program_studi', email = '$email'", "nim = '$nim'");
        
    }

    public function DeleteMahasiswa($nim) {

        if (is_array($nim)) {
            $nim = implode("','", $nim);
            return $this->DeleteData("dbo.mahasiswa_login", "id IN ('$nim')");
        }

        return $this->DeleteData("dbo.mahasiswa_login", "id = '$nim'");
    }
}