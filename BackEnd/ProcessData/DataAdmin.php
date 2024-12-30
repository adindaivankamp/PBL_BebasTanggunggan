<?php

require_once "Class/Connection.php";
require_once "Class/DataProcessing.php";

class DataAdmin extends DataProcessing {
    public function __construct() {
        parent::__construct();
    }

    public function GetAllAdmin() {
        // Page 1 : 0 - 10, Page 2 : 10 - 20, Page 3 : 20 - 30
        // GetData($table, $columns, $where = "")
        return $this->GetData("dbo.admin", "*");
    }

    public function GetAdmin($id) {
        return $this->GetData("dbo.admin", "*", "id = '$id'");
    }

    public function InsertAdmin($username, $password, $nama, $role, $nip) {
        return $this->InsertData("dbo.admin", "username, password, nama, role, NIP", "'$username', '$password', '$nama', '$role', $nip");
    }

    public function UpdateAdmin($id, $username, $password, $nama, $role, $email, $nip) {
        return $this->UpdateData("dbo.admin", "username = '$username', password = '$password', nama = '$nama', role = '$role', email = '$email', NIP = $nip", "id = '$id'");
    }

    public function DeleteAdmin($id) {

        if (is_array($id)) {
            $id = implode("','", $id);
            return $this->DeleteData("dbo.admin", "id IN ('$id')");
        }

        return $this->DeleteData("dbo.admin", "id = '$id'");
    }
}