<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tugas Akhir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/form.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <aside class="sidebar">
        <img src="Assets/logoPolinema.png" alt="Logo">
        <ul>
            <li>
                <a href="berandaMahasiswa.php" class="tooltip" data-title="Beranda"><i class="fas fa-home"></i></a>
            </li>
            <li>
                <a href="#" class="tooltip nav-link" data-page="page1" data-title="Laporan tugas Akhir"><i
                        class="fas fa-file"></i></a>
            </li>
            <li>
                <a href="#" class="tooltip nav-link" data-page="page2" data-title="Surat Pernyataan Publikasi"><i
                        class="fas fa-clipboard-list"></i></a>
            </li>
            <li>
                <a href="#" class="tooltip nav-link" data-page="page3" data-title="Surat Keterangan Bebas Kompen"><i
                        class="fas fa-clock"></i></a>
            </li>
            <li>
                <a href="#" class="tooltip nav-link" data-page="page4" data-title="Surat Keterangan Pelunasan UKT"><i
                        class="fas fa-list-alt"></i></a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="content">
            <!-- Page 1: Laporan Tugas Akhir -->
            <div id="page1" class="page active">
                <div class="form-container">
                    <h1>LAPORAN TUGAS AKHIR</h1>
                    <div class="form-group">
                        <label for="email1">Email</label>
                        <input type="email" id="email1" placeholder="Enter your email">
                        <label for="number1">Number</label>
                        <input type="text" id="number1" placeholder="Enter your number">
                    </div>
                    <div class="form-group">
                        <h2>Laporan Tugas Akhir</h2>
                        <button onclick="showPopup('TA')">Upload</button>
                    </div>
                    <div class="form-group">
                        <label for="name1">Full Name</label>
                        <input type="text" id="name1" placeholder="Enter your full name">
                        <label for="nim1">NIM</label>
                        <input type="text" id="nim1" placeholder="Enter your NIM">
                        <label for="nim1">Program Studi</label>
                        <input type="text" id="prostud1" placeholder="Enter your study program">
                        <label for="Link">Program/Aplikasi Tugas Akhir</label>
                        <input type="text" id="link1" placeholder="Attach Link">
                    </div>
                    <div class="action-buttons">
                        <button onclick="sendToServer()">Send</button>
                        <button>Back</button>
                    </div>
                </div>
            </div>

            <!-- Page 2: Surat Pernyataan Publikasi -->
            <div id="page2" class="page">
                <div class="form-container">
                    <h1>SURAT PERNYATAAN PUBLIKASI</h1>
                    <div class="form-group">
                        <label for="number2">Number</label>
                        <input type="text" id="number2" placeholder="Enter your number">
                        <label for="email2">Email</label>
                        <input type="email" id="email2" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <h2>Surat Pernyataan Publikasi</h2>
                        <button onclick="showPopup()">Upload</button>
                    </div>
                    <div class="form-group">
                        <label for="name2">Full Name</label>
                        <input type="text" id="name2" placeholder="Enter your full name">
                        <label for="nim2">NIM</label>
                        <input type="text" id="nim2" placeholder="Enter your NIM">
                        <label for="nim1">Program Studi</label>
                        <input type="text" id="prostud2" placeholder="Enter your study program">
                    </div>
                    <div class="action-buttons">
                        <button onclick="sendToServer('PUBLIKASI')">Send</button>
                        <button>Back</button>
                    </div>
                </div>
            </div>

            <!-- Page 3: Surat Pernyataan Bebas Kompen -->
            <div id="page3" class="page">
                <div class="form-container">
                    <h1>SURAT PERNYATAAN BEBAS KOMPENSASI</h1>
                    <div class="form-group">
                        <label for="number3">Number</label>
                        <input type="text" id="number3" placeholder="Enter your number">
                        <label for="email3">Email</label>
                        <input type="email" id="email3" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <h2>Surat Pernyataan Bebas Kompen</h2>
                        <button onclick="showPopup('BEBASKOMPEN')">Upload</button>
                    </div>
                    <div class="form-group">
                        <label for="name3">Full Name</label>
                        <input type="text" id="name3" placeholder="Enter your full name">
                        <label for="nim3">NIM</label>
                        <input type="text" id="nim3" placeholder="Enter your NIM">
                        <label for="nim1">Program Studi</label>
                        <input type="text" id="prostud3" placeholder="Enter your study program">
                    </div>
                    <div class="action-buttons">
                        <button onclick="sendToServer()">Send</button>
                        <button>Back</button>
                    </div>
                </div>
            </div>

            <!-- Page 4: Surat Pernyataan Pelunasan UKT -->
            <div id="page4" class="page">
                <div class="form-container">
                    <h1>SURAT PERNYATAAN PELUNASAN UKT</h1>
                    <div class="form-group">
                        <label for="number4">Number</label>
                        <input type="text" id="number4" placeholder="Enter your number">
                        <label for="email4">Email</label>
                        <input type="email" id="email4" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <h2>Surat Pernyataan Pelunasan UKT</h2>
                        <button onclick="showPopup('UKT')">Upload</button>
                    </div>
                    <div class="form-group">
                        <label for="name4"></label>Full Name</label>
                        <input type="text" id="name4" placeholder="Enter your full name">
                        <label for="nim4">NIM</label>
                        <input type="text" id="nim4" placeholder="Enter your NIM">
                        <label for="nim1">Program Studi</label>
                        <input type="text" id="prostud4" placeholder="Enter your study program">
                    </div>
                    <div class="action-buttons">
                        <button onclick="sendToServer()">Send</button>
                        <button>Back</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pop-up -->
        <div class="popup-overlay" id="popupOverlay" onclick="closePopup()"></div>
        <div class="popup" id="popup">
            <input type="file" id="fileInput" name="file">
            <div>
                <button type="button" class="cancel" onclick="closePopup()">Cancel</button>
                <button type="submit" onclick="uploadFile()">Upload</button>
            </div>
    </main>

    <script>
        // Add event listeners to navigation links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                // Get the target page ID from the data attribute
                const pageId = this.getAttribute('data-page');

                // Hide all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('active');
                });

                // Show the selected page
                const selectedPage = document.getElementById(pageId);
                if (selectedPage) {
                    selectedPage.classList.add('active');
                }

                sessionStorage.removeItem('uploadFile'); // Clear the uploaded file
                sessionStorage.removeItem('uploadFileName'); // Clear the uploaded file name
                sessionStorage.removeItem('uploadFileSize'); // Clear the uploaded file size
            });
        });

        // Optional: Add back button functionality to return to the first page
        document.querySelectorAll('.action-buttons button:last-child').forEach(backButton => {
            backButton.addEventListener('click', function() {
                // Hide all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('active');
                });

                // Show the first page (page1)
                document.getElementById('page1').classList.add('active');
                sessionStorage.removeItem('uploadFile'); // Clear the uploaded file
                sessionStorage.removeItem('uploadFileName'); // Clear the uploaded file name
                sessionStorage.removeItem('uploadFileSize'); // Clear the uploaded file size
            });
        });

        function showPopup(currentPage = '') {
            sessionStorage.setItem('currentPage', currentPage);
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popupOverlay').style.display = 'block';
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popupOverlay').style.display = 'none';
        }

        function sendToServer() {
            let currentPage = document.querySelector('.page.active').id;
            let data = {};
            switch(currentPage) {
                case 'page1':
                    data = {
                        email: document.getElementById('email1').value,
                        number: document.getElementById('number1').value,
                        name: document.getElementById('name1').value,
                        nim: document.getElementById('nim1').value,
                        prodi: document.getElementById('prostud1').value,
                        link: document.getElementById('link1').value
                    };
                    break;
                case 'page2':
                    data = {
                        email: document.getElementById('email2').value,
                        number: document.getElementById('number2').value,
                        name: document.getElementById('name2').value,
                        nim: document.getElementById('nim2').value,
                        prodi: document.getElementById('prostud2').value
                    };
                    break;
                case 'page3':
                    data = {
                        email: document.getElementById('email3').value,
                        number: document.getElementById('number3').value,
                        name: document.getElementById('name3').value,
                        nim: document.getElementById('nim3').value,
                        prodi: document.getElementById('prostud3').value
                    };
                    break;
                case 'page4':
                    data = {
                        email: document.getElementById('email4').value,
                        number: document.getElementById('number4').value,
                        name: document.getElementById('name4').value,
                        nim: document.getElementById('nim4').value,
                        prodi: document.getElementById('prostud4').value,
                    };
                    break;
            }

            data.file = sessionStorage.getItem('uploadFile'); // Get the uploaded file (Base64)
            data.fileName = sessionStorage.getItem('uploadFileName'); // Get the uploaded file name
            data.fileSize = sessionStorage.getItem('uploadFileSize'); // Get the uploaded file size
            data.kategori = sessionStorage.getItem('currentPage'); // Get the current page

            data.token = document.cookie.split('token=')[1].split(';')[0]; // Get the token from the cookie

            // Check if all fields are filled
            if (Object.values(data).some(value => value === '')) {
                return alert('Please fill in all fields before sending!');
            }

            if(data.file.length === 0) {
                return alert('Please upload the file before sending!');
            }

            // Send the data to the server
            
            let formData = new FormData();
            for (let key in data) {
                formData.append(key, data[key]);
            }

            fetch('BackEnd/Form.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Data has been sent successfully!');
                } else {
                    alert('Failed to send data. Please try again later.');
                }
            })

        }

        // Function to simulate file upload
        async function uploadFile() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length === 0) {
                alert('Silakan pilih file sebelum mengunggah!');
            } else {
                let file = fileInput.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    sessionStorage.setItem('uploadFile', reader.result);
                    sessionStorage.setItem('uploadFileName', file.name);
                    sessionStorage.setItem('uploadFileSize', file.size);
                    closePopup();
                }
                closePopup();
            }
        }
    </script>
</body>

</html>