<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Query SQL untuk mengambil data user yang sedang login
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="abc">
    <h2>User Profile Card</h2>
        <img src="/views/img/orang.jpeg" alt="glady" style="width:100%">
        <h1> <?= $user['nama'] ?> </h1>
        <p class="title"><?= $user['username'] ?></p>
        <p><?= $user['email'] ?></p>
        <a class='logout' href="logout.php">Logout</a>

    </div>
    <a href="chat.html" class="chat-icon">
        <i class="fas fa-comment-alt"></i>
    </a>
</body>
</html>
