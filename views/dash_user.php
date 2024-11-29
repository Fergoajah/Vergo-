<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Query untuk mengambil data user yang sedang login
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body{
            font-size: 20px;
            justify-content: center;
            align-items: center;
            display: flex;
            height: 80vh;
        }
        li{
            display: flex; /* Gunakan flexbox untuk membuat elemen sejajar */
            justify-content: space-between; /* Jarak antara label dan nilai */
            padding: 10px 0; /* Tambahkan spasi vertikal antara item */
            border-bottom: 1px solid #ddd; /* Garis bawah untuk setiap item */
            font-size: 20px; /* Ukuran font yang nyaman */
        }
        ul {
            padding: 0;
            margin: 0;
            list-style-type: none; /* Hilangkan bullet list */
        }
        .a {
            text-decoration: none;
            margin-top: 20px; /* Jarak atas */
            display: inline-block;
        }
    </style>
</head>
<body>
    <div>
    <h2>Welcome, <?= $user['username']?>!</h2>
    <form action="">
    <p>PROFILE</p>
    <ul>
        <li>Nama: <?= $user['nama'] ?></li>
        <li>Username: <?= $user['username'] ?></li>
        <li>Email: <?= $user['email'] ?></li>
    </ul>
    </form>
    <a class='a' href="login.php">Logout</a>
    </div>

</body>
</html>
