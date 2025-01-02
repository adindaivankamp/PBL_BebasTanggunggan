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
    <title>Table Pengumuman</title>
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
                <button class="show-button">Show</button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>File Path</th>
                    <th>Uploaded At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        <table>
            <tbody>
                <tr>
                    <td colspan="6">
                        <button class="add-button">Add New</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">
            <button class="prev-page">Prev</button>
            <div id="page">

            </div>
            <button class="next-page">Next</button>
        </div>
    </div>
    <div class="modal" id="modal-edit">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Announcement</h2>
            <label for="id">ID</label>
            <input type="text" id="id" name="id" readonly>
            <label for="file-name">File Name</label>
            <input type="text" id="file-name" name="file-name">
            <label for="file-path">File Path</label>
            <input type="text" id="file-path" name="file-path" readonly>
            <label for="uploaded-at">Uploaded At</label>
            <input type="date" id="uploaded-at" name="uploaded-at" readonly>
            <button class="edit-button-modal">Edit</button>
            <button class="cancel-button-modal">Cancel</button>
        </div>
    </div>
    <div class="modal" id="modal-add">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Announcement</h2>
            <label for="file-name">Name</label>
            <input type="text" id="file-name-add" name="file-name">
            <label for="file">Announcement File</label>
            <input type="file" id="the-file" name="file">
            <button class="add-button-modal">Add</button>
            <button class="cancel-button-modal">Cancel</button>
        </div>
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

            let DeleteID = [];

            tableRows.forEach(row => {
                const checkbox = row.querySelector('td:first-child input[type="checkbox"]'); // Checkbox di kolom pertama
                if (checkbox && checkbox.checked) {
                    DeleteID.push(row.querySelector('td:nth-child(2)').textContent);
                }
            });

            if (DeleteID.length > 0) {
                if(confirm(`Are you sure you want to delete ${DeleteID.length} data?`)) {
                    let deleteID = DeleteID.join(',');

                    const formData = new FormData();
                    formData.append('id', deleteID);

                    fetch(`BackEnd/ProcessData.php?type=file&func=DeleteAnnouncement&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.status != "error") {
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    });
                }
            }
        });

        const toggleCheckboxes = (checkbox) => {
            const checkboxes = document.querySelectorAll('table tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
        };

        document.querySelector('.show-button').addEventListener('click', function() {
            limit = document.querySelector('.show-entries input').value;
            ManagePage();
            FixData();
        });

        // Function to show the add modal
        document.querySelector('.add-button').addEventListener('click', function() {
            document.getElementById('modal-add').style.display = 'block';
        });

        // Function to close the modal
        document.querySelectorAll('.close').forEach(closeButton => {
            closeButton.addEventListener('click', function() {
                document.getElementById('modal-edit').style.display = 'none';
                document.getElementById('modal-add').style.display = 'none';
            });
        });

        document.querySelectorAll('.cancel-button-modal').forEach(cancelButton => {
            cancelButton.addEventListener('click', function() {
                document.getElementById('modal-edit').style.display = 'none';
                document.getElementById('modal-add').style.display = 'none';
            });
        });

        // Function to close the modal when clicking outside the modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('modal-edit')) {
                document.getElementById('modal-edit').style.display = 'none';
            }
            if (event.target == document.getElementById('modal-add')) {
                document.getElementById('modal-add').style.display = 'none';
            }

            if (event.target.classList.contains('edit-button')) {
                document.getElementById('modal-edit').style.display = 'block';

                const id = event.target.getAttribute('data-id');
                const announce = JSON.parse(sessionStorage.getItem('announce'));
                const data = announce.find(announcement => announcement.id == id);

                document.getElementById('id').value = data.id;
                document.getElementById('file-name').value = data.file_name;
                document.getElementById('file-path').value = data.file_path;
                document.getElementById('uploaded-at').value = data.uploaded_at.date;
            }
        };

        const logoutButton = document.getElementById('logoutButton');
        logoutButton.addEventListener('click', () => {
            window.location.href = 'logout.php';
        });

        window.onload = () => {
            fetch(`BackEnd/ProcessData.php?type=file&func=GetAllAnnouncement&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status != "error") {
                        const table = document.querySelector('table tbody');
                        table.innerHTML = '';
                        sessionStorage.setItem('announcementSize', response.data.length);
                        sessionStorage.setItem('announce', JSON.stringify(response.data));
                        ManagePage();
                        FixData();
                        FixButton();
                    } else {
                        alert(response.message);
                    }
                })
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

            totalPage = Math.ceil(sessionStorage.getItem('announcementSize') / limit);

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
            const announce = JSON.parse(sessionStorage.getItem('announce'));

            // Page 1 : 0 - limit, Page 2 : limit - 2 * limit, Page 3 : 2 * limit - 3 * limit
            document.querySelector('table tbody').innerHTML = '';
            for (let i = (currentPage - 1) * limit; i < currentPage * limit; i++) {
                if (i >= announce.length) break;
                const dataAnnounce = announce[i];
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox"></td>
                    <td>${dataAnnounce.id}</td>
                    <td>${dataAnnounce.file_name}</td>
                    <td>${dataAnnounce.file_path}</td>
                    <td>${dataAnnounce.uploaded_at.date}</td>
                    <td><button class="edit-button" data-id='${dataAnnounce.id}'>Edit</button></td>
                `;
                document.querySelector('table tbody').appendChild(row);
            }
        }

        document.querySelector('.add-button-modal').addEventListener('click', () => {
            const fileName = document.getElementById('file-name-add').value;

            let file = document.getElementById("the-file").files[0];

            console.log(file);

            if(!file) {
                alert('Please choose a file');
                return;
            }
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {

                file = reader.result;
                console.log(file);
                file = file.split(',')[1];
                console.log(file);
    
                let formData = new FormData();
                formData.append('file_name', fileName);
                formData.append('file', file);
    
                fetch(`BackEnd/ProcessData.php?type=file&func=InsertAnnouncement&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.status != "error") {
                            alert(response.data);
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    });
            }
            // Set to base64 file
        });

        document.querySelector('.edit-button-modal').addEventListener('click', () => {
            const fileName = document.getElementById('file-name').value;
            const id = document.getElementById('id').value;

            console.log(id);

            let formData = new FormData();
            formData.append('file_name', fileName);
            formData.append('id', id);

            fetch(`BackEnd/ProcessData.php?type=file&func=UpdateAnnouncement&token=${document.cookie.split('token=')[1].split(';')[0]}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status != "error") {
                        alert(response.data);
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
                });
        });
    </script>
</body>

</html>