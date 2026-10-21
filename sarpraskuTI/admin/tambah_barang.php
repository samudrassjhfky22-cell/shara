<?php
include '../config/koneksi.php';

$nama_barang = $_POST['nama_barang'];
$stok = $_POST['stok'];

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

move_uploaded_file($tmp, "../assets/img/" . $gambar);

mysqli_query($conn, "INSERT INTO tbarang 
(nama_barang, stok, gambar)
VALUES
('$nama_barang', '$stok', '$gambar')");

echo "
<script>
    alert('Barang berhasil ditambahkan!');
    window.location='barang.php';
</script>
";
?>