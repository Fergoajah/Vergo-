<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Query untuk mendapatkan semua user
$stmt = $pdo->query("SELECT * FROM users WHERE role = 'user'");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-size: 20px;
            justify-content: center;
            align-items: center;
            display: flex;
            height: 80vh;
        }
        table {
            border-collapse: collapse;
            border: 1px solid black;
            width: 100vh;
        }
        td {
            text-align: center;
        }
        a {
            text-decoration: none;
            margin-top: 20px; /* Jarak atas */
            display: inline-block;
        }
    </style>
</head>
<body>
    <div>
    <h2>DASHBOARD ADMIN</h2>
        <table border="1">
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= ($user['nama']) ?></td>
                    <td><?= ($user['username']) ?></td>
                    <td><?= ($user['email']) ?></td>
                    <td><?= ($user['role']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <a href="login.php">Logout</a>
    </div>
</body>
</html>
