<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['username'];

// ambil semua data peminjaman + riwayat user
$query = mysqli_query($conn, "

SELECT 
    tpeminjaman.id_peminjaman AS id,
    tpeminjaman.jumlah,
    tpeminjaman.tanggal_pinjam,
    tpeminjaman.tanggal_kembali,
    tpeminjaman.status,
    tbarang.nama_barang
FROM tpeminjaman
JOIN tbarang
ON tpeminjaman.id_barang = tbarang.id_barang
WHERE tpeminjaman.nama_user = '$username'

UNION

SELECT 
    triwayat.id AS id,
    triwayat.jumlah,
    triwayat.tanggal_pinjam,
    triwayat.tanggal_kembali,
    triwayat.status,
    tbarang.nama_barang
FROM triwayat
JOIN tbarang
ON triwayat.id_barang = tbarang.id_barang
WHERE triwayat.nama_user = '$username'

ORDER BY id DESC

");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Saya</title>

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
<div class="status-wrapper">

    <h1>Status Peminjaman</h1>

    <p class="subjudul">
        Berikut daftar semua riwayat peminjaman anda.
    </p>

    <div class="table-container">

        <table class="table-status">

            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>

            <?php
            $no = 1;
            while($row = mysqli_fetch_assoc($query)) :
            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td><?= $row['nama_barang']; ?></td>

                <td><?= $row['jumlah']; ?></td>

                <td><?= $row['tanggal_pinjam']; ?></td>

                <td><?= $row['tanggal_kembali']; ?></td>

                <td>

                <?php
                if ($row['status'] == 'dipinjam') {

                    echo "<span class='status-dipinjam'>Dipinjam</span>";

                } elseif ($row['status'] == 'menunggu') {

                    echo "<span class='status-menunggu'>Menunggu</span>";

                } elseif ($row['status'] == 'selesai') {

                    echo "<span class='status-dikembalikan'>Selesai</span>";

                } else {

                    echo "<span class='status-ditolak'>Ditolak</span>";

                }
                ?>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>