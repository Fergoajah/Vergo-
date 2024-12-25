<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'koneksi.php';

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $alamat = $_POST['alamat'];
    $role = 'user'; // Default role untuk user biasa

    // Validasi input
    if (empty($nama) || empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($alamat)) {
        $error = "Semua kolom wajib diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        // Hash password dengan MD5
        $hashed_password = md5($password);

        // Query untuk menyimpan data user baru
        $query = "INSERT INTO users (nama, username, email, password, alamat, role) VALUES ('$nama', '$username', '$email', '$hashed_password', '$alamat', '$role')";

        if ($mysqli->query($query)) {
            $success = "Registrasi berhasil!";
        } else {
            $error = "Gagal melakukan registrasi: " . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <link rel="stylesheet" href="/views/Style/registrasi.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <a href="login.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Kembali ke Login
    </a>

    <form class="formlog" method="POST">
        <h2 class="logh2">Registrasi</h2>
        <?php
        if (isset($error)) echo "<p style='color: red;'>$error</p>";
        if (isset($success)) echo "<p style='color: green;'>$success</p>";
        ?>
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <label>Konfirmasi Password:</label><br>
        <input type="password" name="confirm_password" required><br>
        <label>Alamat:</label><br>
        <input type="text" name="alamat" required><br>
        <button class="logbtn" type="submit">Registrasi</button>
    </form>
</body>
</html>

