<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = md5($password);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed_password'";
    $result = $mysqli->query($query); 
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

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
    <link rel="stylesheet" href="/views/Style/login.css">
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
        <div class="register">
            <a href="/views/registrasi.php">Registrasi</a>
        </div>
    </form>
</body>
</html>
