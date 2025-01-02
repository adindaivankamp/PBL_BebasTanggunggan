<?php

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

include "BackEnd/Extra/Redirect.php";

if (isset($_SESSION['role'])) {
  if ($_SESSION['gRole'] == "admin") {
    Redirect::RedirectAdmin($_SESSION['role']);
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Informasi Bebas Tanggungan - Home</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/berandaMahasiswa.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
    <div class="profile-picture"></div>
    <div class="profile-name"><?= $_SESSION['username'] ?></div>
    <div class="profile-id"><?= $_SESSION['nim'] ?></div>
    <div class="profile-menu"><?= $_SESSION['prodi'] ?? null ?></div>
    <button class="profile-menu-item" id="changePassButton"
      onclick="location.href='pemulihan_password_mahasiswa.php'">CHANGE PASS</button>
    <button class="logout-btn" id="logoutButton">LOGOUT</button>
  </div>

  <main class="main-content">
    <!-- Notification Section with existing modals -->
    <section class="notification-section">
      <h1>Notifikasi</h1>
      <div class="notification-item">
        <div class="notification-icon">
          <i class="fas fa-file"></i>
        </div>
        <div>
          <p>Skripsi/TA</p>
          <small>admin has approved the request</small>
        </div>
      </div>
      <div class="notification-item">
        <div class="notification-icon">
          <i class="fas fa-book"></i>
        </div>
        <div>
          <p>Perpustakaan</p>
          <small>admin has approved the request</small>
        </div>
      </div>
      <div class="notification-item">
        <div class="notification-icon">
          <i class="fas fa-folder"></i>
        </div>
        <div>
          <p>Berkas</p>
          <small>admin has approved the request</small>
        </div>
      </div>
      <div class="notification-item">
        <div class="notification-icon">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
          <p>Akademik</p>
          <small>admin has approved the request</small>
        </div>
      </div>

      <!-- Announcement Modal
      <div class="modal" id="">
        <div class="modal-content">
          <button class="close-button">&times;</button>
          <div class="modal-header">
            <h1>Pengumuman</h1>
          </div>
          <div class="modal-body">
            <div class="announcement-container">
              <div class="announcement-item">
                <div class="announcement-icon">
                  <img src="Assets/logoPolinema.png" alt="Form Laporan Tugas Akhir">
                </div>
                <div class="announcement-details">
                  <h3>Pengumuman</h3>
                  <a href="#" class="learn-more-btn">View</a>
                </div>
              </div>
              <div class="announcement-item">
                <div class="announcement-icon">
                  <img src="Assets/logoPolinema.png" alt="Form Pernyataan Bebas Kompen">
                </div>
                <div class="announcement-details">
                  <h3>Pengumuman</h3>
                  <a href="#" class="learn-more-btn">View</a>
                </div>
              </div>
              <div class="announcement-item">
                <div class="announcement-icon">
                  <img src="Assets/logoPolinema.png" alt="Form Surat Pernyataan Publikasi">
                </div>
                <div class="announcement-details">
                  <h3>Pengumuman</h3>
                  <a href="#" class="learn-more-btn">View</a>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="modal-button confirm-button">OK</button>
          </div>
        </div>
      </div> -->

      <!-- Announcement Modal -->
      <div class="modal" id="AnnouncementModal">
        <div class="modal-content">
          <button class="close-button">&times;</button>
          <div class="modal-header">
            <h2 id="AnnouncementTitle">Announcement Details</h2>
          </div>
          <div class="modal-body">
            <div id="AnnouncementContainer">
              <!-- Dynamic content will be injected here -->

            </div>
          </div>
          <div class="modal-footer">
            <button class="modal-button confirm-button">Close</button>
          </div>
        </div>
      </div>

      <!-- Status Modal -->
      <div class="modal" id="statusModal">
        <div class="modal-content">
          <button class="close-button">&times;</button>
          <div class="modal-header">
            <h2 id="statusTitle">Status Details</h2>
          </div>
          <div class="modal-body">
            <div id="statusContainer" class="announcement-container">
              <!-- Dynamic content will be injected here -->

            </div>
          </div>
          <div class="modal-footer">
            <button class="modal-button confirm-button">Close</button>
          </div>
        </div>
      </div>

    </section>

    <!-- Center Section -->
    <section class="center-section">
      <!-- Old Version -->
      <!-- 
      <div class="features">
        <a href="form.php" class="feature-card" id="formFeature">
          <h1>Form</h1>
          <img src="Assets/request.png" alt="Form">
        </a>
        <a href="upload.php" class="feature-card" id="uploadFeature">
          <h1>Upload</h1>
          <img src="Assets/upload.png" alt="Upload">
        </a>
      </div> 
      -->
      <!-- New Version -->
      <div class="announcement-card">
        <img src="Assets/upload.png" alt="Upload">
        <div>
          <h1>Upload</h1>
          <a href="upload.php" class="learn-more-btn" id="uploadFeature">Upload Your File</a>
        </div>
      </div>
      <div class="announcement-card">
        <img src="Assets/pengumuman.png" alt="Pengumuman">
        <div>
          <h1>Pengumuman</h1>
          <a href="#" class="learn-more-btn" id="learnMoreButton">Learn More</a>
        </div>
      </div>
    </section>

    <!-- Status Section -->
    <section class="status-section">
      <h1>Status</h1>
      <div class="status-item">
        <span>Bebas tanggungan "Skripsi/TA"</span>
        <a href="#" class="status-button" onclick="onDetail('Bebas Tanggungan Skripsi/TA')"
          data-title="Bebas Tanggungan Skripsi/TA" data-files='[
             {"name": "Laporan tugas akhir", "status": "Approved", "notes": "Proposal telah disetujui."},
             {"name": "Program/Aplikasi tugas akhir", "status": "Pending", "notes": "Masih dalam proses pengecekan."},
             {"name": "Surat Pernyataan Publikasi Jurnal/Paper/Conference/Seminar/HAKI", "status": "Rejected", "notes": "Format file tidak sesuai."},
             {"name": "Jurnal/Paper/Conference/Seminar/HAKI", "status": "Rejected", "notes": "Format file tidak sesuai."}
           ]'>View</a>
      </div>
      <div class="status-item">
        <span>Bebas tanggungan "Program Studi"</span>
        <a href="#" class="status-button" onclick="onDetail('Bebas Tanggungan Program Studi')"
          data-title="Bebas Tanggungan Program Studi" data-files='[
             {"name": "Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi", "status": "Approved", "notes": "Semua buku telah dikembalikan."},
             {"name": "Tanda Terima Penyerahan Laporan PKL/Magang", "status": "Approved", "notes": "Valid."},
             {"name": "Surat Bebas Kompen", "status": "Approved", "notes": "Semua buku telah dikembalikan."},
             {"name": "Scan TOEIC", "status": "Approved", "notes": "Valid."}
           ]'>View</a>
      </div>
      <div class="status-item">
        <span>Bebas tanggungan "Perpustakaan"</span>
        <a href="#" class="status-button" onclick="onDetail('Bebas Tanggungan Perpustakaan')"
          data-title="Bebas Tanggungan Perpustakaan" data-files='[
             {"name": "Surat Bebas Perpustakaan", "status": "Approved", "notes": "Semua buku telah dikembalikan."},
             {"name": "Dokumen Abstrak", "status": "Approved", "notes": "Valid."},
             {"name": "Laporan Jurnal", "status": "Pending", "notes": "Masih dalam proses pengecekan."},
             {"name": "Link Publikasi", "status": "Rejected", "notes": "Format file tidak sesuai."}
           ]'>View</a>
      </div>
      <div class="status-item">
        <span>Bebas tanggungan "Akademik"</span>
        <a href="#" class="status-button" onclick="onDetail('Bebas Tanggungan Akademik')"
          data-title="Bebas Tanggungan Akademik" data-files='[
             {"name": "Surat Pelunasan UKT Semester 1 - Lulus", "status": "Approved", "notes": "Semua buku telah dikembalikan."},
             {"name": "foto diri untuk Ijazah", "status": "Approved", "notes": "Valid."},
             {"name": "Surat Lulus SKKM", "status": "Pending", "notes": "Masih dalam proses pengecekan."},
             {"name": "Screenshot pengisian data alumni ", "status": "Rejected", "notes": "Format file tidak sesuai."}
           ]'>View</a>
      </div>
    </section>
  </main>

  <script>
    $(() => {

    })

    onDetail = (jenis_dokumen) => {
      $.ajax({
        url: "BackEnd/GetUpload.php",
        method: 'POST',
        data: {
          jenis_dokumen: jenis_dokumen
        },
        success: ((res) => {
          res = JSON.parse(res);
          res = res.data;

          var html = '';

          $.each(res, (i, v) => {
            html += `
            <div class="status-item">

              <div class="status-icon">
                <img src="Assets/logoPolinema.png" alt="${v.name}">
              </div>
              <div class="status-details">
                <h3>${v.kategori}</h3>
                <p><strong>Status:</strong> ${(v.status_validasi == 1) ? "Disetujui" : "Ditolak / Under Review"}</p>
                <p><strong>Notes:</strong> ${v.notes}</p>
                <a href="BackEnd/${v.file_path}" target="blank">file </a>
              </div>
              </div>
            `;
          })

          if(html == ''){
            html = '<h3>No Data Available</h3>';
          }

          $('#statusContainer').html(html);
          $('#statusModal').addClass('show');
        })
      })
    }
  </script>

  <script>
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

    // Modal Functionality
    const modals = {
      request: document.getElementById('requestModal'),
      upload: document.getElementById('uploadModal'),
      announcement: document.getElementById('AnnouncementModal'),
      status: document.getElementById('statusModal'),
    };

    // Close buttons for all modals
    document.querySelectorAll('.close-button').forEach(button => {
      button.addEventListener('click', () => {
        button.closest('.modal').classList.remove('show');
      });
    });

    // Cancel buttons for all modals
    document.querySelectorAll('.cancel-button').forEach(button => {
      button.addEventListener('click', () => {
        button.closest('.modal').classList.remove('show');
      });
    });

    // OK/Confirm buttons
    document.querySelectorAll('.confirm-button').forEach(button => {
      button.addEventListener('click', () => {
        button.closest('.modal').classList.remove('show');
      });
    });

    // Feature card interactions
    // document.getElementById('formFeature').addEventListener('click', (e) => {
    //   window.location.href = 'form.php'; // Berpindah halaman ke form.html
    // });

    document.getElementById('uploadFeature').addEventListener('click', (e) => {
      window.location.href = 'upload.php';
    });

    document.getElementById('learnMoreButton').addEventListener('click', (e) => {
      e.preventDefault();
      $.ajax({
        url: "BackEnd/GetAnnouncement.php",
        method: 'GET',
        success: ((res) => {
          res = JSON.parse(res);
          if (res.status === 'error') {
            alert(res.message);
            return;
          }

          res = res.data;

          console.log(res);

          var html = '';

          $.each(res, (i, v) => {
            html += `
          <div class="announcement-item mb-3" style="margin-bottom : 20px">
              <div class="announcement-icon">
                <img src="Assets/logoPolinema.png" alt="Form Laporan Tugas Akhir">
              </div>
              <div class="announcement-details">
                <h3>${v.file_name}</h3>
                <a href="BackEnd/${v.file_path.includes("Upload/") ? v.file_path : "Upload/" + v.file_path}" target="blank" class="learn-more-btn">View</a>
              </div>
            </div>
          `;
          })


          $('#AnnouncementContainer').html(html);
          $('#AnnouncementModal').addClass('show');
        })
      })
      modals.announcement.classList.add('show');
    });

    // Logout button redirection
    const logoutButton = document.getElementById('logoutButton');
    logoutButton.addEventListener('click', () => {
      window.location.href = 'logout.php';
    });

    // Handle status button click
    document.querySelectorAll('.status-button').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();

        // Fetch content from data attributes
        const title = button.getAttribute('data-title');
        const files = JSON.parse(button.getAttribute('data-files'));

        // Update modal title
        document.getElementById('statusTitle').textContent = title;

        // Show the modal
        modals.status.classList.add('show');
      });
    });

    // Profile popup additional interactions
    document.getElementById('changePassButton').addEventListener('click', () => {
      alert('Change Password functionality to be implemented');
    });

    document.getElementById('logoutButton').addEventListener('click', () => {});
  </script>
</body>

</html>