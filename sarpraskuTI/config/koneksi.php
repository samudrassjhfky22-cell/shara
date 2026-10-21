<?php
$conn = mysqli_connect("localhost", "root", "","sarpasti");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>