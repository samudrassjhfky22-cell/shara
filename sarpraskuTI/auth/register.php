<?php
session_start();
include '../config/koneksi.php';

$message = "";

if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // cek email sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {

        $message = "Email sudah terdaftar!";

    } else {

        // hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // insert user
        mysqli_query($conn, "INSERT INTO users (username, email, password, role)
        VALUES ('$username', '$email', '$passwordHash', '$role')");

        // 🔥 AUTO LOGIN SESSION (INI YANG PENTING)
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // redirect sesuai role
        if ($role == "admin") {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../users/dashboard.php");
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body class="auth">
<div class="container">

    <h2>Register</h2>

    <p><?php echo $message; ?></p>

    <form method="POST">
        <input type="text" name="username" placeholder="username" required>

        <input type="email" name="email" placeholder="email" required>

        <input type="password" name="password" placeholder="password" required>

        <select name="role" required>
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
        </select>

        <button type="submit" name="register">Daftar</button>
    </form>

    <a href="login.php">Sudah punya akun? Login</a>

</div>

</body>
</html>