<?php

require_once "Connection.php";
require_once "JSONResponse.php";

class DataProcessing {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function GetData($table, $columns, $where = "") {
        $query = "SELECT $columns FROM $table";
        if ($where !== "") {
            $query .= " WHERE $where";
        }
        $query .= ";";
        $stmt = sqlsrv_query($this->conn, $query);
        if($stmt === false) {
            die(JSONResponse::Error("Query failed: " . sqlsrv_errors()[0][2]));
        }
        $data = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
        return JSONResponse::Success($data);
    }

    public function InsertData($table, $columns, $values) {
        $query = "INSERT INTO $table ($columns) VALUES ($values);";
        $stmt = sqlsrv_query($this->conn, $query);
        if ($stmt === false) {
            die(JSONResponse::Error("Query failed: " . sqlsrv_errors()[0][2]));
        }
        return JSONResponse::Success("Data inserted successfully");
    }

    public function UpdateData($table, $set, $where) {
        $query = "UPDATE $table SET $set WHERE $where;";
        $stmt = sqlsrv_query($this->conn, $query);
        if ($stmt === false) {
            die(JSONResponse::Error("Query failed: " . sqlsrv_errors()[0][2]));
        }
        return JSONResponse::Success("Data updated successfully");
    }

    public function DeleteData($table, $where) {
        $query = "DELETE FROM $table WHERE $where;";
        $stmt = sqlsrv_query($this->conn, $query);
        if ($stmt === false) {
            die(JSONResponse::Error("Query failed: " . sqlsrv_errors()[0][2]));
        }
        return JSONResponse::Success("Data deleted successfully");
    }

    public function ExecuteQuery($query) {
        $stmt = sqlsrv_query($this->conn, $query);
        if ($stmt === false) {
            die(JSONResponse::Error("Query failed: " . sqlsrv_errors()[0][2]));
        }
        $data = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
        return JSONResponse::Success($data);
    }
}