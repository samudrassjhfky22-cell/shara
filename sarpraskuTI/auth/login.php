<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            
            // Simpan data ke session
            $_SESSION['id_user']  = $data['id']; 
            $_SESSION['email']    = $data['email'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role']     = $data['role'];

            // Arah sesuai role
            if ($data['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
                exit;
            } else {
                header("Location: ../users/dashboard.php");
                exit;
            }

        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body class="auth">
<div class="container">

<h2>Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="login">Login</button>
</form>

<br>
<a href="register.php">Belum punya akun? Register</a>

</div>

</body>
</html>