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
    <title>Table Data Admin</title>
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
                    <option value="id">ID</option>
                    <option value="name">Name</option>
                    <option value="date">Date Added</option>
                    <option value="role">Role</option>
                    <option value="nip">NIP</option>
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
                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="pagination">
            <button class="prev-page">Prev</button>
            <div id="page"></div>
            <button class="next-page">Next</button>
        </div>
    </div>
    <div class="modal" id="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Modal</h2>
            <label for="id">ID</label>
            <input type="text" id="id" name="id" readonly>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <label for="NIP">NIP</label>
            <input type="text" id="NIP" name="NIP">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama">
            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="admin prodi">Admin Prodi</option>
                <option value="perpus">Perpustakaan</option>
                <option value="teknisi">Teknisi</option>
                <option value="admin skripsi">Admin Skripsi</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
            <button class="edit-button-modal">Edit</button>
            <button class="cancel-button-modal">Cancel</button>
        </div>
    </div>
    <script>
        let currentPage = 1;
        let limit = 10;
        let totalPage = 0;
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

        const toggleCheckboxes = (checkbox) => {
            const checkboxes = document.querySelectorAll('table tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
        };

        const sortTable = () => {
            const sortBy = document.getElementById('sort-by').value;
            const sortOrder = document.getElementById('sort-order').value;
            const table = document.querySelector('table tbody');
            const rows = Array.from(table.rows);

            rows.sort((a, b) => {
                let valA, valB;
                if (sortBy === 'id') {
                    valA = parseInt(a.cells[1].textContent.trim());
                    valB = parseInt(b.cells[1].textContent.trim());
                } else if (sortBy === 'name') {
                    valA = a.cells[4].textContent.trim();
                    valB = b.cells[4].textContent.trim();
                } else if (sortBy === 'date') {
                    valA = new Date(a.cells[6].textContent.trim());
                    valB = new Date(b.cells[6].textContent.trim());
                } else if (sortBy === 'nip') {
                    valA = parseInt(a.cells[3].textContent.trim());
                    valB = parseInt(b.cells[3].textContent.trim());
                } else if (sortBy === 'role') {
                    valA = a.cells[5].textContent.trim();
                    valB = b.cells[5].textContent.trim();
                }

                // if (sortBy === 'name' || sortBy === 'date') {
                //     if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                //     if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                // } else {
                //     return sortOrder === 'asc' ? valA - valB : valB - valA;
                // }
                if (sortBy === 'id' || sortBy === 'nip') {
                    return sortOrder === 'asc' ? valA - valB : valB - valA;
                } else if (sortBy === 'name' || sortBy === 'role' || sortBy === 'date') {
                    if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                    if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                } else {
                    return 0;
                }
            });

            rows.forEach(row => table.appendChild(row));
        };

        // Function to delete rows where checkboxes are selected
        document.querySelector('.trash-button').addEventListener('click', function() {
            const tableRows = document.querySelectorAll('table tbody tr'); // Ambil semua baris tabel

            let DeleteID = [];

            tableRows.forEach(row => {
                const checkbox = row.querySelector('td:first-child input[type="checkbox"]'); // Checkbox di kolom pertama
                if (checkbox && checkbox.checked) {
                    DeleteID.push(row.querySelector('td:nth-child(2)').textContent);
                }
            });

            if (DeleteID.length > 0) {
                if (confirm(`Are you sure you want to delete ${DeleteID.length} data?`)) {
                    DeleteID = DeleteID.join(',');
                    let formData = new FormData();
                    formData.append('id', DeleteID);
                    fetch(`BackEnd/ProcessData.php?type=admin&func=DeleteAdmin&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                        method: "POST",
                        body: formData
                    }).then((response) => {
                        return response.json();
                    }).then((response) => {
                        if (response.status != "error") {
                            alert(response.data);
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    });
                }
            } else {
                alert('Please select at least one row to delete');
            }
        });

        const logoutButton = document.getElementById('logoutButton');
        logoutButton.addEventListener('click', () => {
            window.location.href = 'logout.php';
        });

        window.onload = (e) => {

            fetch(`BackEnd/ProcessData.php?type=admin&func=GetAllAdmin&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            }).then((response) => {
                return response.json();
            }).then((response) => {
                if (response.status != "error") {
                    const table = document.querySelector('table tbody');
                    table.innerHTML = '';
                    sessionStorage.setItem('adminSize', response.data.length);
                    sessionStorage.setItem('admin', JSON.stringify(response.data));
                    ManagePage();
                    FixData();
                    FixButton();

                    // response.data.forEach((admin) => {

                    //     const row = document.createElement('tr');
                    //     row.innerHTML = `
                    //         <td><input type="checkbox"></td>
                    //         <td>${admin.id}</td>
                    //         <td>${admin.username}</td>
                    //         <td>${admin.NIP}</td>
                    //         <td>${admin.nama}</td>
                    //         <td>${admin.role.toUpperCase()}</td>
                    //         <td>${admin.created_at.date}</td>
                    //         <td>${admin.email}</td>
                    //         <td><button class="edit-button" onclick="editAdmin(${admin.id})">Edit</button></td>
                    //     `;
                    //     table.appendChild(row);
                    // });
                } else {
                    alert(response.message);
                }
            })
        }

        window.onclick = (e) => {
            if (e.target == document.getElementById('modal') || e.target.classList.contains('cancel-button-modal')) {
                document.getElementById('modal').style.display = 'none';
                // Clear all input in modal
                for (let i = 0; i < document.getElementById('modal').getElementsByTagName('input').length; i++) {
                    document.getElementById('modal').getElementsByTagName('input')[i].value = '';
                }
            }

            if (event.target.classList.contains('edit-button')) {
                let admin = JSON.parse(sessionStorage.getItem('admin')).find((admin) => admin.id == event.target.dataset.admin);
                document.getElementById('id').value = admin.id;
                document.getElementById('username').value = admin.username;
                document.getElementById('password').value = admin.password;
                document.getElementById('NIP').value = admin.NIP;
                document.getElementById('nama').value = admin.nama;
                document.getElementById('role').value = admin.role;
                document.getElementById('email').value = admin.email;
                document.getElementById('modal').style.display = 'block';
            }
        }

        function FixButton() {
            const prevPage = document.querySelector('.prev-page');
            const nextPage = document.querySelector('.next-page');

            prevPage.addEventListener('click', () => {
                if (totalPage > 0 && currentPage > 1) {
                    currentPage--;
                    FixData();
                }
            });

            nextPage.addEventListener('click', () => {
                if (totalPage > 0 && currentPage < totalPage) {
                    currentPage++;
                    FixData();
                }
            });
        }

        function ManagePage() {
            const page = document.getElementById('page');

            currentPage = 1;

            totalPage = Math.ceil(sessionStorage.getItem('adminSize') / limit);

            page.innerHTML = '';
            for (let i = 1; i <= totalPage; i++) {
                const button = document.createElement('button');
                button.classList.add('page-number');
                button.textContent = i;
                button.addEventListener('click', () => {
                    currentPage = i;
                    FixData();
                });
                page.appendChild(button);
            }

            document.querySelector('table tbody').innerHTML = '';
            // Start = (currentPage - 1) * limit
            // End = currentPage * limit
        }

        function FixData() {
            const admin = JSON.parse(sessionStorage.getItem('admin'));
            const table = document.querySelector('table tbody');
            const start = (currentPage - 1) * limit;
            const end = currentPage * limit;
            table.innerHTML = '';

            for (let i = start; i < end; i++) {
                if (i >= admin.length) {
                    break;
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox"></td>
                    <td>${admin[i].id}</td>
                    <td>${admin[i].username}</td>
                    <td>${admin[i].NIP}</td>
                    <td>${admin[i].nama}</td>
                    <td>${admin[i].role.toUpperCase()}</td>
                    <td>${admin[i].created_at.date}</td>
                    <td>${admin[i].email}</td>
                    <td><button class="edit-button" data-admin='${admin[i].id}'>Edit</button></td>
                `;
                table.appendChild(row);
            }
        }

        document.querySelector('.edit-button-modal').addEventListener('click', () => {
            const id = document.getElementById('id').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const NIP = document.getElementById('NIP').value;
            const nama = document.getElementById('nama').value;
            const role = document.getElementById('role').value;
            const email = document.getElementById('email').value;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('username', username);
            formData.append('password', password);
            formData.append('NIP', NIP);
            formData.append('nama', nama);
            formData.append('role', role);
            formData.append('email', email);

            fetch(`BackEnd/ProcessData.php?type=admin&func=UpdateAdmin&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                method: "POST",
                body: formData
            }).then((response) => {
                return response.json();
            }).then((response) => {
                if (response.status != "error") {
                    alert(response.data);
                    window.location.reload();
                } else {
                    document.getElementById('modal').style.display = "none";
                    // Clear all input in modal
                    for (let i = 0; i < document.getElementById('modal').getElementsByTagName('input').length; i++) {
                        document.getElementById('modal').getElementsByTagName('input')[i].value = '';
                    }
                    alert(response.message);
                }
            });
        });
    </script>
</body>

</html>