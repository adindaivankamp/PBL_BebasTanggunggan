<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include "BackEnd/Extra/Redirect.php";

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "admin prodi") {
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
    <title>Sistem Informasi Bebas Tanggungan-Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/beranda_admin_akademik.css">
</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="Assets/logoPolinema.png" alt="Logo Polinema">
        </div>
        <div class="nav-icons">
            <a href="#" id="profileButton"><i class="fas fa-user"></i></a>
        </div>
    </header>

    <div class="profile-popup" id="profilePopup">
        <div class="profile-picture">
            <img src="Assets/prabowo.png" alt="Profile Picture">
        </div>
        <div class="profile-name">Your Name</div>
        <div class="profile-id">012345678</div>
        <div class="profil-status">Admin</div>
        <button class="profile-menu-item" id="changePassButton">CHANGE PASS</button>
        <button class="profile-menu-item" id="studyProgramButton">Admin</button>
        <button class="logout-btn" id="logoutButton">LOGOUT</button>
    </div>

    <main class="main-content">
        <!-- <section class="notification-section">
            <h1>Notifikasi</h1>
            <div class="notification-item">
                <div class="notification-icon"><i class="fas fa-file"></i></div>
                <div>
                    <p>Skripsi/TA</p>
                    <small>admin has approved the request</small>
                </div>
                <button class="view-btn">View</button>
                <span class="notification-time">9:41 AM</span>
            </div>
            <div class="notification-item">
                <div class="notification-icon"><i class="fas fa-book"></i></div>
                <div>
                    <p>Perpustakaan</p>
                    <small>admin has approved the request</small>
                </div>
                <button class="view-btn">View</button>
                <span class="notification-time">9:41 AM</span>
            </div>
            <div class="notification-item">
                <div class="notification-icon"><i class="fas fa-folder"></i></div>
                <div>
                    <p>Berkas</p>
                    <small>admin has approved the request</small>
                </div>
                <button class="view-btn">View</button>
                <span class="notification-time">9:41 AM</span>
            </div>
            <div class="notification-item">
                <div class="notification-icon"><i class="fas fa-graduation-cap"></i></div>
                <div>
                    <p>Akademik</p>
                    <small>admin has approved the request</small>
                </div>
                <button class="view-btn">View</button>
                <span class="notification-time">9:41 AM</span>
            </div>
        </section> -->

        <!-- Kolom Mahasiswa -->
        <section class="student-search-section">
            <h1>Mahasiswa</h1>
            <div class="search-bar">
                <input type="text" placeholder="Ketik Nama atau NIM">
                <button>Search</button>
            </div>
            <div id="studentList">
                <!-- List of students will be displayed here -->
            </div>
        </section>

        <!-- Modal untuk menampilkan detail mahasiswa -->
        <div id="student-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <div class="student-modal-info">
                    <img src="Assets/tes.jpg" alt="Profile">
                    <div class="student-details">
                        <p>Nama: Name</p>
                        <p>NIM: 2341760189</p>
                        <p>Program Studi : D-IV Sistem Informasi Bisnis</p>
                    </div>
                </div>
                <div class="student-modal-buttons">
                    <div class="student-modal-item">
                        <p>Surat Bebas Perpustakaan</p>
                        <button class="btn-tolak">View</button>
                    </div>
                    <div class="student-modal-item">
                        <p>Dokumen Abstrak</p>
                        <button class="btn-tolak">View</button>
                    </div>
                    <div class="student-modal-item">
                        <p>Laporan Jurnal</p>
                        <button class="btn-tolak">View</button>
                    </div>
                    <div class="student-modal-item">
                        <p>Link Publikasi Jurnal (dalam bentuk file)</p>
                        <button class="btn-tolak">View</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menampilkan PDF -->
        <div id="pdfModal" class="modal">
            <div class="modal-content-notification">
                <embed id="pdfViewer" src="" width="100%" height="600px" type="application/pdf">
                <!-- Responsive Image -->
                <img src="" alt="IMG" style="width: auto; height: auto; max-width: 100%; max-height: 600px; display: block; margin: 0 auto;">
                <div class="modal-footer modal-center">
                    <button class="btn-tolak tolak">Tolak</button>
                    <button class="btn-terima terima">Terima</button>
                </div>
            </div>
        </div>

        <div id="modalTolak" class="modal2">
            <div class="modal2-content">
                <span class="close-btn">&times;</span>
                <div class="modal2-header">
                    <h2>Informasi Penolakan</h2>
                </div>
                <div class="modal2-body">
                    <form class="form-control">
                        <label for="alasan">Alasan Penolakan</label>
                        <textarea name="alasan" id="alasan" cols="30" rows="10"></textarea>
                    </form>
                </div>
                <div class="modal2-footer">
                    <button class="btn-tolak meta">Tolak</button>
                    <button class="btn-batal">Batal</button>
                </div>
            </div>
        </div>
    </main>

    <script src="beranda_admin.js"></script>
    <script>
        let pending = false;

        // Profile Popup Functionality
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

        document.querySelector(".search-bar button").addEventListener("click", function() {
            // Reset student list and modal
            document.getElementById("studentList").innerHTML = "";
            document.getElementById("student-modal").style.display = "none";
            document.querySelectorAll('.student-modal-item button').forEach(button => {
                button.classList.remove('btn-ijo');
                button.classList.add('btn-tolak');
            });
        })

        const studentModal = document.getElementById("student-modal");
        document.querySelectorAll('.student-item .btn-ijo').forEach(button => {
            button.addEventListener('click', function() {
                studentModal.style.display = "block";
            });
        });

        // Logout button redirection
        const logoutButton = document.getElementById('logoutButton');
        logoutButton.addEventListener('click', () => {
            window.location.href = 'logout.php';
        });

        // Close buttons for all modals
        document.querySelectorAll('.close-btn').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.modal').style.display = 'none';
            });
        });

        // Profile popup additional interactions
        document.getElementById('changePassButton').addEventListener('click', () => {
            alert('Change Password functionality to be implemented');
        });

        document.getElementById('studyProgramButton').addEventListener('click', () => {
            alert('Study Program details to be implemented');
        });

        document.getElementById("studentList").addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-ijo')) {
                const targetModal = e.target.getAttribute('data-target');
                if (targetModal) {
                    if (pending) return;
                    pending = true;
                    const data = JSON.parse(e.target.getAttribute('data-student'));
                    // document.querySelector(targetModal + ' img').src = data.image;
                    // Due my Bad Code, NIM = Name (Major Changes)
                    fetch(`BackEnd/ProcessData.php?type=file&func=GetFileByJenisDokumenAndNim&nim=${data.nama}&jenis_dokumen=Bebas Tanggungan Skripsi%2FTA&token=${document.cookie.split("token=")[1].split(";")[0]}`)
                        .then(response => response.json())
                        .then(response => {

                            document.querySelector(targetModal + ' .student-details p:nth-child(1)').textContent = 'Nama: ' + data.nama;
                            document.querySelector(targetModal + ' .student-details p:nth-child(2)').textContent = 'NIM: ' + data.nim;
                            document.querySelector(targetModal + ' .student-details p:nth-child(3)').textContent = 'Program Studi: ' + data.program_studi;
                            let JSONData = response.data;

                            for (let i = 0; i < JSONData.length; i++) {
                                if (JSONData[i].kategori == "Surat Bebas Perpustakaan") {
                                    if (JSONData[i].status_validasi == 0)
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(1) button').classList.add('btn-ijo', 'view-btn-notification');
                                    else
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(1) button').classList.add('btn-kuning', 'view-btn-notification');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(1) button').classList.remove('btn-tolak');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(1) button').setAttribute('data-item', JSON.stringify(JSONData[i]));
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(1) button').setAttribute('data-pdf', "BackEnd/" + JSONData[i].file_path);
                                } else if (JSONData[i].kategori == "Dokumen Abstrak") {
                                    if (JSONData[i].status_validasi == 0)
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(2) button').classList.add('btn-ijo', 'view-btn-notification');
                                    else
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(2) button').classList.add('btn-kuning', 'view-btn-notification');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(2) button').classList.remove('btn-tolak');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(2) button').setAttribute('data-item', JSON.stringify(JSONData[i]));
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(2) button').setAttribute('data-pdf', "BackEnd/" + JSONData[i].file_path);
                                } else if (JSONData[i].kategori == "Laporan Jurnal") {
                                    if (JSONData[i].status_validasi == 0)
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(3) button').classList.add('btn-ijo', 'view-btn-notification');
                                    else
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(3) button').classList.add('btn-kuning', 'view-btn-notification');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(3) button').classList.remove('btn-tolak');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(3) button').setAttribute('data-item', JSON.stringify(JSONData[i]));
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(3) button').setAttribute('data-pdf', "BackEnd/" + JSONData[i].file_path);
                                } else if (JSONData[i].kategori == "Link Publikasi Jurnal") {
                                    if (JSONData[i].status_validasi == 0)
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(4) button').classList.add('btn-ijo', 'view-btn-notification');
                                    else
                                        document.querySelector(targetModal + ' .student-modal-item:nth-child(4) button').classList.add('btn-kuning', 'view-btn-notification');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(4) button').classList.remove('btn-tolak');
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(4) button').setAttribute('data-item', JSON.stringify(JSONData[i]));
                                    document.querySelector(targetModal + ' .student-modal-item:nth-child(4) button').setAttribute('data-pdf', "BackEnd/" + JSONData[i].file_path);
                                }
                            }
                            document.querySelector(targetModal).style.display = 'block';
                            pending = false;
                        }).catch(err => {
                            alert(err);
                            pending = false;
                        });
                }
            }
        });

        // Student modal functionality
        var span = document.getElementsByClassName("close-btn")[0];

        window.onclick = function(event) {

            if (event.target.classList.contains('modal') || event.target.classList.contains('modal2')) {
                event.target.style.display = 'none';
                // remove data from data-item
                document.querySelector('#pdfModal .terima').removeAttribute('data-item');
                document.querySelector('#pdfModal .tolak').removeAttribute('data-item');
                document.querySelector('#modalTolak .meta').removeAttribute('data-item');
            }

            if (event.target.classList.contains('view-btn-notification')) {
                // Close all modals
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.style.display = 'none';
                });

                const pdfUrl = event.target.getAttribute('data-pdf');
                const data = JSON.parse(event.target.getAttribute('data-item'));

                document.querySelector('#pdfModal .terima').setAttribute('data-item', JSON.stringify(data));
                document.querySelector('#pdfModal .tolak').setAttribute('data-item', JSON.stringify(data));

                if (data.tipe_file != "application/pdf") {
                    pdfViewer.setAttribute('hidden', true);
                    document.querySelector('#pdfViewer + img').style.display = 'block';
                    document.querySelector('#pdfViewer + img').setAttribute('src', pdfUrl);
                } else {
                    pdfViewer.removeAttribute('hidden');
                    document.querySelector('#pdfViewer + img').style.display = 'none';
                }
                pdfViewer.setAttribute('type', data.tipe_file);
                pdfViewer.setAttribute('src', pdfUrl); // Update PDF source
                pdfModal.style.display = "block";
            }

            if (event.target.classList.contains('meta')) {
                // 
                const data = JSON.parse(event.target.getAttribute('data-item'));
                const alasan = document.getElementById('alasan').value;
                if (alasan == "") {
                    alert("Alasan tidak boleh kosong");
                    return;
                }

                alasan = encodeURIComponent(alasan);

                if (pending) return;
                fetch(`BackEnd/ProcessData.php?type=file&func=TolakFile&id=${data.id_upload}&alasan=${alasan}&token=${document.cookie.split("token=")[1].split(";")[0]}`)
                    .then(response => response.json())
                    .then(response => {
                        if (response.status === 'success') {
                            alert('File berhasil ditolak');
                            document.getElementById('modalTolak').style.display = 'none';
                            document.getElementById('pdfModal').style.display = 'none';
                            document.getElementById('alasan').value = "";
                            pending = false;
                        } else {
                            alert(response.message);
                            pending = false;
                        }
                    }).catch(err => {
                        alert(err);
                        pending = false;
                    });
            }

            if (event.target.classList.contains('btn-terima')) {
                // Do something
                const data = JSON.parse(event.target.getAttribute('data-item'));
                if (pending) return;
                pending = true;
                fetch(`BackEnd/ProcessData.php?type=file&func=TerimaFile&id=${data.id_upload}&token=${document.cookie.split("token=")[1].split(";")[0]}`)
                    .then(response => response.json())
                    .then(response => {
                        if (response.status === 'success') {
                            alert('File berhasil diterima');
                            document.getElementById('pdfModal').style.display = 'none';
                            pending = false;
                        } else {
                            alert(response.message);
                            pending = false;
                        }
                    });
            }

            if (event.target.classList.contains('btn-batal')) {
                document.getElementById('modalTolak').style.display = 'none';
                // Remove data from data-item
                document.querySelector('#pdfModal .terima').removeAttribute('data-item');
                document.querySelector('#pdfModal .tolak').removeAttribute('data-item');
                document.querySelector('#modalTolak .meta').removeAttribute('data-item');
            }
        }

        document.querySelector('.tolak').addEventListener('click', function() {
            const data = JSON.parse(document.querySelector('#pdfModal .tolak').getAttribute('data-item'));
            document.querySelector('#modalTolak .meta').setAttribute('data-item', JSON.stringify(data));
            document.getElementById('pdfModal').style.display = 'none';
            document.getElementById('modalTolak').style.display = 'flex';
        });
    </script>
</body>

</html>