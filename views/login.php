<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // hash password input user dengan MD5
    $hashed_password = md5($password);

    // Query untuk mengambil data user/admin dengan celah SQL Injection
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed_password'";
    $result = $mysqli->query($query); // Menggunakan query langsung

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location: /views/dash_admin.php');
            exit();
        } else {
            header('Location: /views/dash_user.php');
            exit();
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/views/style.css">
</head>
<body>
    <form class="formlog" method="POST">
        <h2 class="logh2">Login</h2>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <button class="logbtn" type="submit">Login</button>
    </form>
</body>
</html>
