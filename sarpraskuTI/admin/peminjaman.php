<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// ambil data peminjaman
$query = mysqli_query($conn, "
SELECT tpeminjaman.*, tbarang.nama_barang
FROM tpeminjaman
JOIN tbarang ON tpeminjaman.id_barang = tbarang.id_barang
ORDER BY tpeminjaman.id_peminjaman DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <title>Peminjaman Admin</title>
    <link rel="stylesheet" href="../assets/style.css?v=1">
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

    <h1>Data Peminjaman</h1>

    <div class="table-container">
        <table class="table-status">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php $no = 1; while($row = mysqli_fetch_assoc($query)) : ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_user']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td><?= $row['tanggal_pinjam']; ?></td>
                <td><?= $row['tanggal_kembali']; ?></td>
                <td><?= $row['status']; ?></td>
                <td>

                    <?php if($row['status'] == 'menunggu') : ?>

                        <a href="ubah_status.php?id=<?= $row['id_peminjaman']; ?>&status=dipinjam">
                            <i class="fa-solid fa-circle-check"></i>
                        </a>

                        <a href="ubah_status.php?id=<?= $row['id_peminjaman']; ?>&status=ditolak">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </a>

                    <?php elseif($row['status'] == 'dipinjam') : ?>

                        <a href="kembalikan.php?id=<?= $row['id_peminjaman']; ?>">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>

                    <?php endif; ?>

                </td>
            </tr>

            <?php endwhile; ?>

        </table>
    </div>

</div>

</body>
</html>