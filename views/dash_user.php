<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Query untuk mengambil data user yang sedang login
$query = "SELECT * FROM users WHERE username = '$username'";
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="userh2">
        <h2>Welcome, <?= htmlspecialchars($user['username']) ?>!</h2>
    </div>
    <div class='abc'>
        <p>PROFILE</p>
        <ul>
            <li>Nama: <?= htmlspecialchars($user['nama']) ?></li>
            <li>Username: <?= htmlspecialchars($user['username']) ?></li>
            <li>Email: <?= htmlspecialchars($user['email']) ?></li>
        </ul>
        <a class='logout' href="logout.php">Logout</a>
    </div>
    <a href="chat.html" class="chat-icon">
        <i class="fas fa-comment-alt"></i>
    </a>
</body>
</html>
