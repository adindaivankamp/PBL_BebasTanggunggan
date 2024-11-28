<?php
session_start();

include "Connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM dbo.mahasiswa_login WHERE nim = ?";
    $params = array($nim);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row > 0)  {
        // Verify password
        if (($password== $row['password'])) {
            // Successful login
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nama'];
            // ... other session data
            header("Location: ../berandaMahasiswa.html"); // Redirect to dashboard
            exit;
        } else {
            // Incorrect password
            echo "Incorrect password";
        }
    } else {
        // User not found
        echo "User not found";
    }

    sqlsrv_free_stmt($stmt);
}
?>