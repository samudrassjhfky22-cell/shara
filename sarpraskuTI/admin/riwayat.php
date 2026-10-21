<?php
session_start();
include '../config/koneksi.php';

// proteksi admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// ambil data dari TABEL RIWAYAT (INI PENTING)
$query = mysqli_query($conn, "
    SELECT * FROM triwayat
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>
    <link rel="stylesheet" href="../assets/style.css?v=1">
</head>

<body class="dashboard">

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-left">
       <i class="fa-solid fa-screwdriver-wrench"></i> SarprasKuTIP
        <small>Riwayat Peminjaman Barang</small>
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

    <h1>Riwayat Peminjaman</h1>
    <p>Data barang yang sudah dikembalikan atau ditolak</p>

    <div class="table-container">

        <table class="table-status">

            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>ID Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>status</th>
            </tr>

            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($query)) : 
            ?>

            <tr>
                <td><?= $no++; ?></td>

                <td><?= $row['nama_user']; ?></td>

                <td><?= $row['id_barang']; ?></td>

                <td><?= $row['jumlah']; ?></td>

                <td><?= $row['tanggal_pinjam']; ?></td>

                <td><?= $row['tanggal_kembali']; ?></td>

                <td>

                    <?php if($row['status'] == 'ditolak') : ?>

                        <span class="status-ditolak">Ditolak</span>

                    <?php else : ?>

                        <span class="status-selesai">Selesai</span>

                    <?php endif; ?>

                </td>

            </tr>

            <?php endwhile; ?>

            <?php if(mysqli_num_rows($query) == 0) : ?>
            <tr>
                <td colspan="7" style="text-align:center; padding:20px;">
                    Belum ada data riwayat
                </td>
            </tr>
            <?php endif; ?>

        </table>

    </div>

</div>

</body>
</html>