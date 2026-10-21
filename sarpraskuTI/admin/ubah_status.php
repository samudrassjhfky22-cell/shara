<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

if ($status == 'dikembalikan' || $status == 'ditolak') {

    // ambil data peminjaman
    $data = mysqli_query($conn, "
        SELECT * FROM tpeminjaman 
        WHERE id_peminjaman='$id'
    ");

    $row = mysqli_fetch_assoc($data);

    // simpan ke riwayat
    mysqli_query($conn, "
        INSERT INTO triwayat 
        (id_barang, nama_user, jumlah, tanggal_pinjam, tanggal_kembali, status)

        VALUES (
            '{$row['id_barang']}',
            '{$row['nama_user']}',
            '{$row['jumlah']}',
            '{$row['tanggal_pinjam']}',
            NOW(),
            '$status'
        )
    ");

    // hapus dari peminjaman
    mysqli_query($conn, "
        DELETE FROM tpeminjaman 
        WHERE id_peminjaman='$id'
    ");

} else {

    // update status biasa
    mysqli_query($conn, "
        UPDATE tpeminjaman 
        SET status='$status' 
        WHERE id_peminjaman='$id'
    ");
}

header("Location: peminjaman.php");
exit;
?>