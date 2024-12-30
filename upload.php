<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Upload</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/upload.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <!-- Button Home -->
  <div class="home-button">
    <a href="berandaMahasiswa.php">
      <i class="fas fa-home"></i>
    </a>
  </div>
  <div class="container">
    <!-- Kotak hijau pertama -->
    <div class="upload-box">
      <!-- Skripsi -->
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Laporan Tugas Akhir/Skripsi<br>(Bebas Tanggungan Skripsi/TA)</p>
        <button onclick="showPopup('Laporan Tugas Akhir/Skripsi', 'Bebas Tanggungan Skripsi/TA')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Program/Aplikasi Tugas Akhir/Skripsi<br>(Bebas Tanggungan Skripsi/TA)</p>
        <button onclick="showPopup('Program/Aplikasi Tugas Akhir/Skripsi', 'Bebas Tanggungan Skripsi/TA')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Surat Pernyataan Publikasi Skripsi<br>(Bebas Tanggungan Skripsi/TA)</p>
        <button onclick="showPopup('Surat Pernyataan Publikasi', 'Bebas Tanggungan Skripsi/TA')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Jurnal/Paper/Conference/Seminar/HAKI<br>(Bebas Tanggungan Skripsi/TA)</p>
        <button onclick="showPopup('Jurnal/Paper/Conference/Seminar/HAKI', 'Bebas Tanggungan Skripsi/TA')">Upload</button>
      </div>
      <!-- Prodi -->
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi<br>(Bebas Tanggungan Program Studi)</p>
        <button onclick="showPopup('Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi', 'Bebas Tanggungan Program Studi')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Tanda Terima Penyerahan Laporan PKL/Magang<br>(Bebas Tanggungan Program Studi)</p>
        <button onclick="showPopup('Tanda Terima Penyerahan Laporan PKL/Magang', 'Bebas Tanggungan Program Studi')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Surat Bebas Kompen<br>(Bebas Tanggungan Program Studi)</p>
        <button onclick="showPopup('Surat Bebas Kompen', 'Bebas Tanggungan Program Studi')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Scan TOEIC<br>(Bebas Tanggungan Program Studi)</p>
        <button onclick="showPopup('Scan TOEIC', 'Bebas Tanggungan Program Studi')">Upload</button>
      </div>
    </div>

    <!-- Kotak hijau kedua -->
    <div class="upload-box">
      <!-- Akademik -->
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Surat Pelunasan UKT Semester 1-Lulus<br>(Bebas Tanggungan Akademik)</p>
        <button onclick="showPopup('Surat Pelunasan UKT Semester 1 - Lulus', 'Bebas Tanggungan Akademik')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload foto diri untuk Ijazah<br>(Bebas Tanggungan Akademik)</p>
        <button onclick="showPopup('Foto Diri untuk Ijazah', 'Bebas Tanggungan Akademik')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Surat Lulus SKKM<br>(Bebas Tanggungan Akademik)</p>
        <button onclick="showPopup('Surat Lulus SKKM', 'Bebas Tanggungan Akademik')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Screenshot pengisian data alumni<br>(Bebas Tanggungan Akademik)</p>
        <button onclick="showPopup('Pengisian Data Alumni', 'Bebas Tanggungan Akademik')">Upload</button>
      </div>
      <!-- Perpus -->
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Surat Bebas Perpustakaan<br>(Bebas Tanggungan Perpustakaan)</p>
        <button onclick="showPopup('Surat Bebas Perpustakaan', 'Bebas Tanggungan Perpustakaan')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Dokumen Abstrak<br>(Bebas Tanggungan Perpustakaan)</p>
        <button onclick="showPopup('Dokumen Abstrak', 'Bebas Tanggungan Perpustakaan')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Laporan Jurnal<br>(Bebas Tanggungan Perpustakaan)</p>
        <button onclick="showPopup('Laporan Jurnal', 'Bebas Tanggungan Perpustakaan')">Upload</button>
      </div>
      <div class="upload-item">
        <i class="fas fa-file"></i>
        <p>Upload Link Publikasi Jurnal (dalam bentuk file)<br>(Bebas Tanggungan Perpustakaan)</p>
        <button onclick="showPopup('Link Publikasi Jurnal', 'Bebas Tanggungan Perpustakaan')">Upload</button>
      </div>
    </div>
  </div>

  <!-- Pop-up -->
  <div class="popup-overlay" id="popupOverlay" onclick="closePopup()"></div>
  <div class="popup" id="popup">
    <form id="uploadForm" enctype="multipart/form-data">
      <input type="hidden" name="kategori" id="kategori" value="Laporan Tugas Akhir/Skripsi">
      <input type="hidden" name="jenis_dokumen" id="jenis_dokumen" value="Bebas Tanggungan Skripsi/TA">
      <label for="fileInput" id="fileInputLabel">Choose a file</label>
      <input type="file" id="fileInput" name="file" required>
      <input type="text" name="token" value="<?php echo $_SESSION['token']; ?>" hidden>
      <div>
        <button type="button" class="cancel" onclick="closePopup()">Cancel</button>
        <button type="button" onclick="submitForm()">Upload</button>
      </div>
    </form>
  </div>
  <script>
    let uploading = false;
    // Function to show the popup
    function showPopup(kategori, jenis_dokumen) {
      document.getElementById('popup').style.display = 'block';
      document.getElementById('popupOverlay').style.display = 'block';

      $('#kategori').val(kategori);
      $('#jenis_dokumen').val(jenis_dokumen);
      $('#fileInputLabel').text('Choose a file for ' + kategori);

      document.getElementById('fileInput').value = null;
    }

    // Function to close the popup
    function closePopup() {
      document.getElementById('popup').style.display = 'none';
      document.getElementById('popupOverlay').style.display = 'none';
      document.getElementById('fileInput').value = null;
    }

    // Function to submit the form using AJAX
    function submitForm() {
      if(document.getElementById("fileInput").files.length === 0) {
        alert('Please choose a file');
        return;
      }

      if(uploading) {
        return;
      }
      const form = document.getElementById('uploadForm');
      const formData = new FormData(form);

      document.getElementById('fileInput').display = 'none';
      document.getElementById('fileInputLabel').text = 'Uploading...';

      uploading = true;
      try {
        $.ajax({
          url: 'BackEnd/ProcessUpload.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            response = JSON.parse(response);
            if(response.status === 'success') {
              alert('File berhasil diupload');
              // Restore Document Info
              document.getElementById('fileInput').display = 'block';
              document.getElementById('fileInputLabel').text = 'Choose a file';
              uploading = false;
              closePopup();
            } else {
              document.getElementById('fileInput').display = 'block';
              document.getElementById('fileInputLabel').text = 'Choose a file'; 
              uploading = false;
              alert(response.message);
            }
          },
          error: function(xhr) {
            let response = JSON.parse(xhr.responseText);
            let message = 'Failed to upload file';
            if(response.message) {
              message = response.message;
            }
            document.getElementById('fileInput').display = 'block';
            document.getElementById('fileInputLabel').text = 'Choose a file';
            uploading = false;
            alert(message);
          }
        });
      } catch (e) {
        document.getElementById('fileInput').display = 'block';
        document.getElementById('fileInputLabel').text = 'Choose a file';
        uploading = false;
        alert('Failed to upload file');
      }
    }
  </script>
</body>

</html>
