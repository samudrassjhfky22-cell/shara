<?php
session_start();
include '../config/koneksi.php';

// cek login
if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit;
}

$email = $_SESSION['email'];

// ambil data user
$user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$data = mysqli_fetch_assoc($user);

// jumlah sedang dipinjam user
$qPinjam = mysqli_query($conn, "
SELECT * FROM tpeminjaman
WHERE email='$email'
");

$dipinjam = mysqli_num_rows($qPinjam);

// total barang tersedia
$qBarang = mysqli_query($conn, "
SELECT * FROM tbarang
");

$barang = mysqli_num_rows($qBarang);

$qMenunggu = mysqli_query($conn, "
SELECT * FROM tpeminjaman
WHERE email='$email' AND status='menunggu'
");

$menunggu = mysqli_num_rows($qMenunggu);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../assets/style.css?v=1">
</head>

<body class="dashboard">

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="nav-left">
            <i class="fa-solid fa-screwdriver-wrench"></i> SarprasKuTIP
        <small>Sistem Peminjaman Barang</small>
        </div>

       <div class="nav-right">
            <a href="dashboard.php" class="active">
                <i class="fa-solid fa-house"></i> Home </a>
            <a href="katalog.php">
                <i class="fa-solid fa-box-archive"></i> Katalog </a>
            <a href="status.php">
                <i class="fa-solid fa-clock-rotate-left"></i> Status Saya </a>
            <a href="../auth/logout.php" class="logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout </a>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="container">

        <div class="hero">
            <div class="hero">

    <div class="hero-box">

        <h1> SELAMAT DATANG DI SISTEM PEMINJAMAN</h1>

        <p class="desc">
            Pinjam barang sekolah dengan mudah, cepat, dan terpantau secara sistem.
        </p>

        <div class="user-info">
            <div class="badge">
                👤 <?= $data['username']; ?>
            </div>

            <div class="badge role">
                 <?= $data['role']; ?>
            </div>
        </div>

    </div>

</div>
        </div>

        <!-- CARD -->
        <div class="cards">

            <div class="card">
                <i class="fa-solid fa-clock"></i>
                <h3><?= $dipinjam; ?></h3>
                <p>Sedang Dipinjam</p>
            </div>

            <div class="card">
                <i class="fa-solid fa-box"></i>
                <h3><?= $barang; ?></h3>
                <p>Total Barang</p>
            </div>

            <div class="card">
                <i class="fa-solid fa-check-circle"></i>
                <h3><?=$menunggu; ?></h3>
                <p>Menunggu Persetujuan</p>
            </div>

        </div>

       <div class="cta">

    <h3>Mau pinjam barang?</h3>

    <a href="katalog.php" class="btn-pinjam">
        Mulai Pinjam Sekarang
    </a>

</div>

    </div>

    <footer>
        2026 project SharaAgustina - sistem peminjaman barang
    </footer>

</body>
</html>