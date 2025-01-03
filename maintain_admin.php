<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include "BackEnd/Extra/Redirect.php";

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "maintenance") {
        Redirect::RedirectAdmin($_SESSION['role']);
        exit();
    } elseif ($_SESSION['role'] == "mahasiswa") {
        header("Location: berandaMahasiswa.php"); // Redirect ke halaman mahasiswa jika sudah login
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Maintainance</title>
    <link rel="stylesheet" href="CSS/admin_maintain.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="sidebar">
        <img src="Assets/logoPolinema.png" alt="Logo">
        <a href="table_mhs.php" class="tooltip nav-link" data-title="Informasi Mahasiswa">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-user-graduate"></i>
                </button>
            </div>
        </a>
        <a href="table_admin.php" class="tooltip nav-link" data-title="Informasi Admin">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-user-shield"></i>
                </button>
            </div>
        </a>
        <a href="table_tugas_akhir.php" class="tooltip nav-link" data-title="Program Tugas Akhir">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-file-archive"></i>
                </button>
            </div>
        </a>
        <a href="table_publikasi.php" class="tooltip nav-link" data-title="Keterangan Publikasi">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-file-alt"></i>
                </button>
            </div>
        </a>
        <a href="table_bebaskompen.php" class="tooltip nav-link" data-title="Keterangan Bebas Kompen">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-print"></i>
                </button>
            </div>
        </a>
        <a href="table_ukt.php" class="tooltip nav-link" data-title="Keterangan Pelunasan UKT">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-window-maximize"></i>
                </button>
            </div>
        </a>
        <a href="table_file-upload.php" class="tooltip nav-link" data-title="Uploaded File by Mahasiswa">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-upload"></i>
                </button>
            </div>
        </a>
        <a href="table_pengumuman.php" class="tooltip nav-link" data-title="Announcement">
            <div class="menu-item">
                <button class="icon-only-button">
                    <i class="fa fa-bell"></i>
                </button>
            </div>
        </a>
    </div>

    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" placeholder="Search">
            <button>Cari</button>
        </div>
        <div class="profile-icon">
            <div class="nav-icons">
                <a href="#" id="profileButton"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </div>
    <div class="profile-popup" id="profilePopup">
        <div class="profile-picture"></div>
        <div class="profile-name">NAMA LENGKAP</div>
        <div class="profile-id">NIP</div>
        <div class="profile-menu">ADMIN MAINTAINANCE</div>
        <button class="profile-menu-item" id="changePassButton">CHANGE PASS</button>
        <button class="logout-btn" id="logoutButton">LOGOUT</button>
    </div>

    <div class="container">
        <div class="controls">
            <div class="sort-by">
                <select id="sort-by">
                    <option value="">Sort By</option>
                    <option value="name">Name</option>
                    <option value="date">Date Added</option>
                </select>
                <select id="sort-order">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
                <button class="sort-button" onclick="sortTable()">Sort</button>
                <button class="trash-button">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="show-entries">
                <span>Show</span>
                <input type="number" value="10" min="1" max="100">
                <span>Entries</span>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>Created At</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>1</td>
                    <td>1234567788</td>
                    <td>1234567788</td>
                    <td>Nama siapa</td>
                    <td>Sistem Informasi Bisnis</td>
                    <td>2024-11-01 22:50:49.347</td>
                    <td>iniemail@gmail.com</td>
                    <td><button class="edit-button">Edit</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>2</td>
                    <td>1234567788</td>
                    <td>1234567788</td>
                    <td>Nama siapa</td>
                    <td>Sistem Informasi Bisnis</td>
                    <td>2024-11-01 22:50:49.347</td>
                    <td>iniemail@gmail.com</td>
                    <td><button class="edit-button">Edit</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        //profile button
        const profileButton = document.getElementById('profileButton');
        const profilePopup = document.getElementById('profilePopup');

        profileButton.addEventListener('click', (e) => {
            e.stopPropagation();
            profilePopup.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!profilePopup.contains(e.target) && e.target !== profileButton) {
                profilePopup.classList.remove('show');
            }
        });

        //sort button
        const sortTable = () => {
            const sortBy = document.getElementById('sort-by').value;
            const sortOrder = document.getElementById('sort-order').value;
            const table = document.querySelector('table tbody');
            const rows = Array.from(table.rows);

            rows.sort((a, b) => {
                let valA = a.cells[1].textContent.trim();
                let valB = b.cells[1].textContent.trim();

                if (sortBy === 'name' || sortBy === 'date') {
                    if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                    if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                }
                return 0;
            });

            rows.forEach(row => table.appendChild(row));
        };

        // Function to delete rows where checkboxes are selected
        document.querySelector('.trash-button').addEventListener('click', function() {
            const tableRows = document.querySelectorAll('table tbody tr'); // Ambil semua baris tabel

            tableRows.forEach(row => {
                const checkbox = row.querySelector('td:first-child input[type="checkbox"]'); // Checkbox di kolom pertama
                if (checkbox && checkbox.checked) {
                    row.remove(); // Hapus baris jika checkbox dipilih
                }
            });
        });

        // Function to search names in the table
        document.querySelector('.search-bar button').addEventListener('click', function() {
            const searchInput = document.querySelector('.search-bar input').value.toLowerCase(); // Ambil teks dari input
            const tableRows = document.querySelectorAll('table tbody tr'); // Ambil semua baris dalam tabel

            tableRows.forEach(row => {
                const nameCell = row.cells[4]; // Kolom "Nama" ada di indeks ke-4
                if (nameCell && nameCell.textContent.toLowerCase().includes(searchInput)) {
                    row.style.display = ''; // Tampilkan baris jika cocok
                } else {
                    row.style.display = 'none'; // Sembunyikan baris jika tidak cocok
                }
            });
        });
        const logoutButton = document.getElementById('logoutButton');
        logoutButton.addEventListener('click', () => {
            window.location.href = 'logout.php';
        });
    </script>
</body>

</html>