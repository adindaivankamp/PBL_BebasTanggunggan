<?php
session_start();

include_once 'Class/Connection.php';
include_once 'Class/DataProcessing.php';
include_once 'Class/JSONResponse.php';

$dataProcess = new DataProcessing();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['announcement_id'])) {
        $announcement_id = $_GET['announcement_id'];
        $data = $dataProcess->GetData('dbo.pdf_files', '*', "id = $announcement_id");
        echo $data;
    } else {
        $data = $dataProcess->GetData('dbo.pdf_files', '*');
        echo $data;
    }
} else {
    echo JSONResponse::Error("Invalid request method");
}