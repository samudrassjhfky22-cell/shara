<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$query = mysqli_query($conn, "
SELECT * FROM tbarang
WHERE 
nama_barang LIKE '%$keyword%'
ORDER BY id_barang DESC
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link rel="stylesheet" href="../assets/style.css?v=2">
</head>

<body class="dashboard">

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-left">
        <i class="fa-solid fa-screwdriver-wrench"></i> SarprasKuTIP
    </div>

    <div class="nav-right">

    <a href="dashboard.php">
        <i class="fa-solid fa-house"></i> Dashboard
    </a>

    <a href="barang.php">
        <i class="fa-solid fa-boxes-stacked"></i> Barang
    </a>

    <a href="peminjaman.php">
        <i class="fa-solid fa-hand-holding"></i> Peminjaman
    </a>

    <a href="riwayat.php">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat
    </a>

    <a href="../auth/logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

</div>
</div>

<!-- CONTENT -->
<div class="dashboard-wrapper">

    <h1>Data Barang</h1>

    <p>Kelola data barang di sistem</p>

    <!-- BUTTON OPEN MODAL -->
    <a href="#" class="btn" onclick="openModalTambah()">+ Tambah Barang</a>
        <form method="GET" class="search-box">

            <input type="text" name="keyword" placeholder=" Nama Barang">

            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>

        </form>

    <!-- TABLE -->
    <div class="table-container">

        <table class="table-status">

            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            <?php $no = 1; while($row = mysqli_fetch_assoc($query)) : ?>

            <tr>
                <td><?= $no++; ?></td>

                <td>
                    <img src="../assets/img/<?= $row['gambar']; ?>" class="barang-img">
                </td>

                <td><?= $row['nama_barang']; ?></td>

                <td><?= $row['stok']; ?></td>

                <td class="aksi">
                    <a href="#" class="btn-edit" 
                    onclick="openEditModal(
                    '<?= $row['id_barang']; ?>',
                    '<?= $row['nama_barang']; ?>',
                    '<?= $row['stok']; ?>'
                    )">Edit</a>
                    <a href="hapus_barang.php?id=<?= $row['id_barang']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>


<!-- MODAL TAMBAH -->
<div id="modal" class="modal">

    <div class="modal-content">

        <span class="close" onclick="closeModalTambah()">&times;</span>

        <h2>Tambah Barang</h2>

        <form action="tambah_barang.php" method="POST" enctype="multipart/form-data">

            <input type="text" name="nama_barang" required>
            <input type="number" name="stok" required>
            <input type="file" name="gambar" required>

            <button type="submit">Simpan</button>

        </form>

    </div>
</div>

<!--  MODAL EDIT -->
<div id="modalEdit" class="modal">

    <div class="modal-content">

        <span class="close" onclick="closeEditModal()">&times;</span>

        <h2>Edit Barang</h2>

        <form action="proses_edit.php" method="POST">

            <input type="hidden" name="id_barang" id="edit_id">

            <input type="text" name="nama_barang" id="edit_nama" required>

            <input type="number" name="stok" id="edit_stok" required>

            <button type="submit">Update</button>

        </form>

    </div>

</div>
</div>
<script src="../assets/script.js"></script>
</body>
</html>