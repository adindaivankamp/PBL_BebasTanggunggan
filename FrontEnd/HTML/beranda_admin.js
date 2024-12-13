document.querySelector(".search-bar button").addEventListener("click", function () {
    const query = document.querySelector(".search-bar input").value;

    // Kirim permintaan ke server
    fetch(`search_mahasiswa.php?query=${query}`)
        .then(response => response.json())
        .then(data => {
            const studentSection = document.querySelector(".student-search-section");
            const studentItems = data.map(student => `
                <div class="student-item">
                    <div class="student-info">
                        <img src="${student.foto}" alt="Profile">
                        <div class="student-details">
                            <p>Nama: ${student.nama}</p>
                            <small>NIM: ${student.nim}</small>
                        </div>
                    </div>
                    <button class="view-btn btn-ijo">View</button>
                </div>
            `).join("");
            studentSection.innerHTML = `<h1>Mahasiswa</h1><div class="search-bar">
                <input type="text" placeholder="Ketik Nama atau NIM">
                <button>Search</button>
            </div>${studentItems}`;
        })
        .catch(error => console.error('Error:', error));
});
