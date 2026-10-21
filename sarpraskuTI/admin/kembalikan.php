<?php
include '../config/koneksi.php';

$id = $_GET['id'];

// ambil data peminjaman
$query = mysqli_query($conn, "
SELECT * FROM tpeminjaman 
WHERE id_peminjaman='$id'
");

$data = mysqli_fetch_assoc($query);

// cek data
if (!$data) {
    echo "
    <script>
    alert('Data tidak ditemukan');
    window.location.href='peminjaman.php';
    </script>
    ";
    exit;
}

// pindahkan ke triwayat
mysqli_query($conn, "
INSERT INTO triwayat
(
    nama_user,
    id_barang,
    jumlah,
    tanggal_pinjam,
    tanggal_kembali,
    status
)
VALUES
(
    '{$data['nama_user']}',
    '{$data['id_barang']}',
    '{$data['jumlah']}',
    '{$data['tanggal_pinjam']}',
    NOW(),
    'selesai'
)
");

// hapus dari tpeminjaman
mysqli_query($conn, "
DELETE FROM tpeminjaman
WHERE id_peminjaman='$id'
");

// notif
echo "
<script>
alert('Barang berhasil dikembalikan');
window.location.href='peminjaman.php';
</script>
";
?>