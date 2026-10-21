<?php
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id_barang'];
    $nama = $_POST['nama_barang'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "
        UPDATE tbarang 
        SET nama_barang='$nama', stok='$stok' 
        WHERE id_barang='$id'
    ");

    echo "<script>
        alert('Barang berhasil diupdate');
        window.location.href='barang.php';
    </script>";
}
?>