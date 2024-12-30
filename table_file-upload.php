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
    <title>Table File Uploaded</title>
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
                    <option value="filename">File Name</option>
                    <option value="size">File Size</option>
                    <option value="type">File Type</option>
                    <option value="status">Status</option>
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
                <button class="show-button">Show</button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                    <th>ID Upload</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>File Path</th>
                    <th>Nama File</th>
                    <th>Ukuran File</th>
                    <th>Tipe File</th>
                    <th>Tanggal Upload</th>
                    <th>Status Validasi</th>
                    <th>Notes</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="pagination">
            <button class="prev-page">Prev</button>
            <div id="page">

            </div>
            <button class="next-page">Next</button>
        </div>
    </div>
    <div class="modal" id="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Modal</h2>
            <label for="id">ID</label>
            <input type="text" name="id" id="id" placeholder="ID" readonly>
            <label for="id_upload">ID Upload</label>
            <input type="text" name="id_upload" id="id_upload" placeholder="ID Upload" readonly>
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" placeholder="Nama">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" placeholder="Kategori">
            <label for="jenis_dokumen">Jenis Dokumen</label>
            <input type="text" name="jenis_dokumen" id="jenis_dokumen" placeholder="Jenis Dokumen">
            <label for="file_path">File Path</label>
            <input type="text" name="file_path" id="file_path" placeholder="File Path" readonly>
            <label for="nama_file">Nama File</label>
            <input type="text" name="nama_file" id="nama_file" placeholder="Nama File" readonly>
            <label for="ukuran_file">Ukuran File</label>
            <input type="text" name="ukuran_file" id="ukuran_file" placeholder="Ukuran File" readonly>
            <label for="tipe_file">Tipe File</label>
            <input type="text" name="tipe_file" id="tipe_file" placeholder="Tipe File" readonly>
            <label for="tanggal_upload">Tanggal Upload</label>
            <input type="date" name="tanggal_upload" id="tanggal_upload" placeholder="Tanggal Upload" readonly>
            <label for="status_validasi">Status Validasi</label>
            <select name="status_validasi" id="status_validasi">
                <option value="0">Di Tolak / Pending</option>
                <option value="1">Di Terima</option>
            </select>
            <label for="notes">Notes</label>
            <input type="text" name="notes" id="notes" placeholder="Notes">
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
                    valA = a.cells[2].textContent.trim();
                    valB = b.cells[2].textContent.trim();
                } else if (sortBy === 'filename') {
                    valA = a.cells[6].textContent.trim();
                    valB = b.cells[6].textContent.trim();
                } else if (sortBy === 'size') {
                    valA = parseInt(a.cells[7].textContent.trim());
                    valB = parseInt(b.cells[7].textContent.trim());
                } else if (sortBy === 'type') {
                    valA = a.cells[8].textContent.trim();
                    valB = b.cells[8].textContent.trim();
                } else if (sortBy === 'status') {
                    valA = a.cells[10].textContent.trim();
                    valB = b.cells[10].textContent.trim();
                } else if (sortBy === 'date') {
                    valA = a.cells[9].textContent.trim();
                    valB = b.cells[9].textContent.trim();
                }
                // if (sortBy === 'name' || sortBy === 'date') {
                //     if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                //     if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                // } else {
                //     return sortOrder === 'asc' ? valA - valB : valB - valA;
                // }
                if (sortBy === 'id' || sortBy === 'size') {
                    return sortOrder === 'asc' ? valA - valB : valB - valA;
                } else if (sortBy === 'name' || sortBy === 'filename' || sortBy === 'type' || sortBy === 'status' || sortBy === 'date') {
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

            let deleteID = [];

            tableRows.forEach(row => {
                const checkbox = row.querySelector('td:first-child input[type="checkbox"]'); // Checkbox di kolom pertama
                if (checkbox && checkbox.checked) {
                    deleteID.push(row.querySelector('td:nth-child(2)').textContent);
                }
            });

            if (deleteID.length > 0) {
                if (confirm(`Are you sure you want to delete ${deleteID.length} rows?`)) {

                    deleteID = deleteID.join(',');
                    alert(deleteID);
                    let formData = new FormData();
                    formData.append('id', deleteID);

                    fetch(`BackEnd/ProcessData.php?type=file&func=DeleteFile&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
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
                    }).catch((error) => {
                        console.error("Error:", error);
                    });
                }
            } else {
                alert('Please select at least one row to delete');
            }
        });

        document.querySelector('.show-button').addEventListener('click', function() {
            limit = document.querySelector('.show-entries input').value;
            ManagePage();
            FixData();
        });

        const toggleCheckboxes = (checkbox) => {
            const checkboxes = document.querySelectorAll('table tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
        };


        const logoutButton = document.getElementById('logoutButton');
        logoutButton.addEventListener('click', () => {
            window.location.href = 'logout.php';
        });

        window.onload = (e) => {

            fetch(`BackEnd/ProcessData.php?type=file&func=GetAllFile&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
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
                    sessionStorage.setItem('fileuploadSize', response.data.length);
                    sessionStorage.setItem('fileupload', JSON.stringify(response.data));
                    ManagePage();
                    FixData();
                    FixButton();
                } else {
                    alert(response.message);
                }
            }).catch((error) => {
                console.error("Error:", error);
            });

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

            totalPage = Math.ceil(sessionStorage.getItem('fileuploadSize') / limit);

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
            const fileUpload = JSON.parse(sessionStorage.getItem('fileupload'));

            // Page 1 : 0 - limit, Page 2 : limit - 2 * limit, Page 3 : 2 * limit - 3 * limit
            document.querySelector('table tbody').innerHTML = '';
            for (let i = (currentPage - 1) * limit; i < currentPage * limit; i++) {
                if (i >= fileUpload.length) break;
                const fileData = fileUpload[i];
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox"></td>
                    <td>${fileData.id_upload}</td>
                    <td>${fileData.id}</td>
                    <td>${fileData.nama}</td>
                    <td>${fileData.kategori}</td>
                    <td><a href="BacKend/${fileData.file_path}" target="_blank">BackEnd/${fileData.file_path}</a></td>
                    <td>${fileData.nama_file}</td>
                    <td>${fileData.ukuran_file}</td>
                    <td>${fileData.tipe_file}</td>
                    <td>${new Date(fileData.tanggal_upload.date).toLocaleDateString('id-ID')}</td>
                    <td>${fileData.status_validasi ? 'DiTerima' : 'DiTolak / Pending'}</td>
                    <td>${fileData.notes}</td>
                    <td><button class="edit-button" data-file='${fileData.id_upload}'>Edit</button></td>
                `;
                document.querySelector('table tbody').appendChild(row);
            }
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('modal')) {
                document.getElementById('modal').style.display = "none";
            }

            if (event.target.classList.contains('edit-button')) {
                let fileData = JSON.parse(sessionStorage.getItem('fileupload')).find(file => file.id_upload == event.target.dataset.file);
                document.getElementById('modal').style.display = "block";
                document.getElementById('id').value = fileData.id;
                document.getElementById('id_upload').value = fileData.id_upload;
                document.getElementById('nama').value = fileData.nama;
                document.getElementById('kategori').value = fileData.kategori;
                document.getElementById('jenis_dokumen').value = fileData.jenis_dokumen;
                document.getElementById('file_path').value = fileData.file_path;
                document.getElementById('nama_file').value = fileData.nama_file;
                document.getElementById('ukuran_file').value = fileData.ukuran_file;
                document.getElementById('tipe_file').value = fileData.tipe_file;
                document.getElementById('tanggal_upload').value = new Date(fileData.tanggal_upload.date).toISOString().split('T')[0];
                document.getElementById('status_validasi').value = fileData.status_validasi;
                document.getElementById('notes').value = fileData.notes;
            }
        }

        document.querySelector('.cancel-button-modal').addEventListener('click', function() {
            document.getElementById('modal').style.display = "none";
            // Clear all input in modal
            document.getElementById('id').value = '';
            document.getElementById('id_upload').value = '';
            document.getElementById('nama').value = '';
            document.getElementById('kategori').value = '';
            document.getElementById('jenis_dokumen').value = '';
            document.getElementById('file_path').value = '';
            document.getElementById('nama_file').value = '';
            document.getElementById('ukuran_file').value = '';
            document.getElementById('tipe_file').value = '';
            document.getElementById('tanggal_upload').value = '';
            document.getElementById('status_validasi').value = '';
            document.getElementById('notes').value = '';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('modal').style.display = "none";
            // Clear all input in modal
            document.getElementById('id').value = '';
            document.getElementById('id_upload').value = '';
            document.getElementById('nama').value = '';
            document.getElementById('kategori').value = '';
            document.getElementById('jenis_dokumen').value = '';
            document.getElementById('file_path').value = '';
            document.getElementById('nama_file').value = '';
            document.getElementById('ukuran_file').value = '';
            document.getElementById('tipe_file').value = '';
            document.getElementById('tanggal_upload').value = '';
            document.getElementById('status_validasi').value = '';
            document.getElementById('notes').value = '';
        });

        document.querySelector('.edit-button-modal').addEventListener('click', function() {
            const id = document.getElementById('id_upload').value;
            const nama = document.getElementById('nama').value;
            const kategori = document.getElementById('kategori').value;
            const jenis_dokumen = document.getElementById('jenis_dokumen').value;
            const status_validasi = document.getElementById('status_validasi').value;
            const notes = document.getElementById('notes').value;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('nama', nama);
            formData.append('kategori', kategori);
            formData.append('jenis_dokumen', jenis_dokumen);
            formData.append('status_validasi', status_validasi);
            formData.append('notes', notes);

            fetch(`BackEnd/ProcessData.php?type=file&func=UpdateFile&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
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
                    document.getElementById('id').value = '';
                    document.getElementById('id_upload').value = '';
                    document.getElementById('nama').value = '';
                    document.getElementById('kategori').value = '';
                    document.getElementById('file_path').value = '';
                    document.getElementById('nama_file').value = '';
                    document.getElementById('ukuran_file').value = '';
                    document.getElementById('tipe_file').value = '';
                    document.getElementById('tanggal_upload').value = '';
                    document.getElementById('status_validasi').value = '';
                    document.getElementById('notes').value = '';
                    alert(response.message);
                }
            }).catch((error) => {
                console.error("Error:", error);
            });
        });
    </script>
</body>

</html>