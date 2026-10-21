<?php
session_start();
include '../config/koneksi.php';

$id_barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];

$nama = $_SESSION['username'];
$email = $_SESSION['email'];

$tanggal_pinjam = date('Y-m-d');
$tanggal_kembali = date('Y-m-d', strtotime('+5 days'));

$status = "menunggu";

// 🔥 CEK STOK DULU
$cek = mysqli_query($conn, "SELECT stok FROM tbarang WHERE id_barang='$id_barang'");
$data = mysqli_fetch_assoc($cek);

$stok = $data['stok'];

if ($jumlah > $stok) {
    echo "<script>alert('Stok tidak cukup!'); window.location='katalog.php';</script>";
    exit;
}

// simpan peminjaman
mysqli_query($conn, "
INSERT INTO tpeminjaman 
(nama_user,email,id_barang,jumlah,tanggal_pinjam,tanggal_kembali,status)
VALUES
('$nama','$email','$id_barang','$jumlah','$tanggal_pinjam','$tanggal_kembali','$status')
");

// kurangi stok
mysqli_query($conn, "
UPDATE tbarang 
SET stok = stok - $jumlah 
WHERE id_barang = $id_barang
");

header("Location: katalog.php");
?>