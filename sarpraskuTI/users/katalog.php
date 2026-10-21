<?php
session_start();
include '../config/koneksi.php';

$today = date('Y-m-d');
$max = date('Y-m-d', strtotime('+7 days'));
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit;
}

// SEARCH
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$keyword = mysqli_real_escape_string($conn, $keyword);

//  QUERY
if ($keyword != "") {
    $query = mysqli_query($conn, "
        SELECT * FROM tbarang 
        WHERE nama_barang LIKE '%$keyword%'
        ORDER BY id_barang DESC
    ");
} else {
    $query = mysqli_query($conn, "
        SELECT * FROM tbarang 
        ORDER BY id_barang DESC
    ");

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang</title>

    <link rel="stylesheet" href="../assets/style.css?v=2">
</head>

<body class="dashboard">

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-left">
        <i class="fa-solid fa-screwdriver-wrench"></i> SarprasKuTIP
        <small>Sistem Peminjaman Barang</small>
    </div>

    <div class="nav-right">
        <a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="katalog.php" class="active"><i class="fa-solid fa-box-archive"></i> Katalog</a>
        <a href="status.php"><i class="fa-solid fa-clock-rotate-left"></i> Status Saya</a>
        <a href="../auth/logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="katalog-wrapper">

    <h1>Daftar Barang</h1>

    <p class="subjudul">
        Silahkan pinjam barang yang anda butuhkan dengan mudah dan cepat.
    </p>

    <!-- SEARCH -->
    <form method="GET" class="search-box">

        <input type="text" name="keyword" placeholder="Nama Barang"
            value="<?php echo $keyword; ?>">

        <button type="submit">
            <i class="fa-solid fa-magnifying-glass"></i> Cari
        </button>

    </form>

    <!-- KATALOG -->
    <div class="katalog-container">

        <?php while($row = mysqli_fetch_assoc($query)) : ?>

        <div class="katalog-card">

            <div class="katalog-img">
                <?php if(!empty($row['gambar'])) : ?>
                    <img src="../assets/img/<?= $row['gambar']; ?>">
                <?php else : ?>
                    No Image
                <?php endif; ?>
            </div>

            <h3 class="nama-barang">
                <?= $row['nama_barang']; ?>
            </h3>

            <p class="stok">
                Stok tersedia : <?= $row['stok']; ?>
            </p>

            <button class="btn-pinjam"
                onclick="openModalPinjam(
                    <?= $row['id_barang']; ?>,
                    '<?= $row['nama_barang']; ?>'
                )">
                Pinjam
            </button>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<!-- MODAL PINJAM -->
<div id="modalPinjam" class="modal">
    <div class="modal-content">

        <span class="close" onclick="closeModalPinjam()">&times;</span>

        <h2 id="judulBarang">Pinjam Barang</h2>

        <div class="rules-box">
            <h3>RULES</h3>
            <p>
                Barang wajib dikembalikan sesuai tanggal yang dipilih.<br>
                Keterlambatan denda Rp20.000.<br>
                Kerusakan/hilang ditentukan admin.
            </p>
        </div>

        <form action="../users/pinjam.php" method="POST">

            <input type="hidden" name="id_barang" id="id_barang">

            <label>Jumlah Pinjam</label>
            <input type="number" name="jumlah" min="1" required>

            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" min="<?= $today ?>" max="<?= $max ?>" required>

            <button type="submit">Pinjam</button>

        </form>

    </div>
</div>

<script src="../assets/script.js?v=2"></script>

</body>
</html>