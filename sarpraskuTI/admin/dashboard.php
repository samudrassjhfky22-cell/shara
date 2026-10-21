<?php
session_start();
include '../config/koneksi.php';

// CEK LOGIN + ROLE ADMIN
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['username'];

// COUNT DATA

// TOTAL BARANG
$qBarang = mysqli_query($conn, "SELECT * FROM tbarang");
$barang = mysqli_num_rows($qBarang);

// MENUNGGU
$qMenunggu = mysqli_query($conn, "SELECT * FROM tpeminjaman WHERE status='menunggu'");
$menunggu = mysqli_num_rows($qMenunggu);

// DIPINJAM
$qDipinjam = mysqli_query($conn, "SELECT * FROM tpeminjaman WHERE status='dipinjam'");
$dipinjam = mysqli_num_rows($qDipinjam);

// DIKEMBALIKAN
$dikembalikan = mysqli_num_rows(mysqli_query($conn, "
SELECT * FROM triwayat WHERE status='selesai'
"));

$qHabis = mysqli_query($conn, "
SELECT * FROM tbarang 
WHERE stok <= 3
ORDER BY stok ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
<div class="container">

    <h1>Selamat datang, <?= htmlspecialchars($username) ?> </h1>
    <p>Kelola semua data peminjaman dan barang di sistem ini</p>

    <!-- CARD -->
    <div class="card-container">

        <div class="card">
            <i class="fa-solid fa-boxes-stacked"></i>
            <h3><?= $barang ?></h3>
            <p>Total Barang</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-hourglass-half"></i>
            <h3><?= $menunggu ?></h3>
            <p>Menunggu Persetujuan</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-hand-holding"></i>
            <h3><?= $dipinjam ?></h3>
            <p>Sedang Dipinjam</p>
        </div>
    </div>
<br>
    <h2>Stok Hampir Habis</h2>
    <p>segera tambahkan stok!!!</p>
    <div class="table-container">

    <table class="table-status">

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>

        <?php $no = 1; while($row = mysqli_fetch_assoc($qHabis)) : ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama_barang']; ?></td>

            <td>
                <span style="color:red; font-weight:bold;">
                    <?= $row['stok']; ?>
                </span>
            </td>

            <td>

                <?php if($row['stok'] == 0) : ?>

                    <span style="color:red; font-weight:bold;">
                        Stok Habis
                    </span>

                <?php else : ?>

                    <span style="color:orange; font-weight:bold;">
                        Hampir Habis
                    </span>

                <?php endif; ?>

            </td>
            
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</div>

</body>
</html>