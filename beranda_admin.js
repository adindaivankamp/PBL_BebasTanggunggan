document.querySelector(".search-bar button").addEventListener("click", function () {
    const query = document.querySelector(".search-bar input").value;

    // Kirim permintaan ke server
    fetch(`BackEnd/ProcessData.php?type=mahasiswa&func=GetMahasiswa&nim=${query}&token=${document.cookie.split("token=")[1].split(";")[0]}`)
        .then(response => response.json())
        .then(response => {
            if(response.status == "error") {
                alert(response.message);
                return;
            }
            const studentSection = document.getElementById("studentList");
            studentSection.innerHTML = response.data.map(student => `
                <div class="student-item">
                    <div class="student-info">
                        <img src="${student.foto}" alt="Profile">
                        <div class="student-details">
                            <p>Nama: ${student.nama}</p>
                            <small>NIM: ${student.nim}</small>
                        </div>
                    </div>
                    <button class="view-btn btn-ijo" data-target="#student-modal" data-student='${JSON.stringify(student)}'">View</button>
                </div>
            `).join("");
        })
        .catch(error => console.error('Error:', error));
});