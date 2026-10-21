<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM tbarang WHERE id_barang='$id'");

header("Location: barang.php");
?>