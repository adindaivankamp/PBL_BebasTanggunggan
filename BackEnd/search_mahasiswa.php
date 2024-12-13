<?php
$host = 'localhost';
$user = 'root'; // Ubah sesuai konfigurasi
$password = '';
$dbname = 'nama_database'; // Ganti dengan nama database

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['query'];
$sql = "SELECT * FROM mahasiswa WHERE nama LIKE ? OR nim LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
