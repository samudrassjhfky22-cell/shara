/* ================= MODAL PINJAM ================= */
function openModalPinjam(id, nama) {
    document.getElementById("modalPinjam").style.display = "flex";

    document.getElementById("id_barang").value = id;
    document.getElementById("judulBarang").innerText = "Pinjam " + nama;
    document.getElementById("jumlahPinjam").value = "";
}

function closeModalPinjam() {
    document.getElementById("modalPinjam").style.display = "none";
}

/* ================= MODAL TAMBAH BARANG ================= */
function openModalTambah() {
    document.getElementById("modal").style.display = "flex";
}

function closeModalTambah() {
    document.getElementById("modal").style.display = "none";
}

/* ================= MODAL EDIT ================= */
function openEditModal(id, nama, stok) {
    document.getElementById("modalEdit").style.display = "flex";

    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nama").value = nama;
    document.getElementById("edit_stok").value = stok;
}

function closeEditModal() {
    document.getElementById("modalEdit").style.display = "none";
}

/*  CLICK OUTSIDE CLOSE  */
window.onclick = function(event) {

    let modalPinjam = document.getElementById("modalPinjam");
    let modalTambah = document.getElementById("modal");
    let modalEdit = document.getElementById("modalEdit");

    if (modalPinjam && event.target == modalPinjam) {
        modalPinjam.style.display = "none";
    }

    if (modalTambah && event.target == modalTambah) {
        modalTambah.style.display = "none";
    }

    if (modalEdit && event.target == modalEdit) {
        modalEdit.style.display = "none";
    }
}

/*  VALIDASI TANGGAL KEMBALI */
document.addEventListener("DOMContentLoaded", function () {

    const inputTanggal = document.getElementById("tanggal_kembali");

    if (!inputTanggal) return;

    // tanggal hari ini
    const today = new Date();

    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, "0");
    const dd = String(today.getDate()).padStart(2, "0");

    const minDate = `${yyyy}-${mm}-${dd}`;

    // blok tanggal mundur
    inputTanggal.setAttribute("min", minDate);

    inputTanggal.addEventListener("input", function () {

        if (this.value < minDate) {

            this.style.border = "2px solid red";
            this.value = "";

        } else {

            this.style.border = "2px solid green";

        }

    });

});

