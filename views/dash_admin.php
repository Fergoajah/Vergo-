<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Query untuk mendapatkan semua user
$query = "SELECT * FROM users WHERE role = 'user'";
$result = $mysqli->query($query);

// Ambil data pengguna dalam bentuk array asosiatif
$users = [];
if ($result && $result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $users[] = $user;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Style/admin.css">
</head>

<body>
    <div class="admindiv">
        <h2 class="adminh2">DASHBOARD ADMIN</h2>
        <table>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Role</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['nama'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['alamat'] ?></td>
                    <td><?= $user['role'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="btnlogout">
            <a class="logout" href="logout.php">Logout</a>
            <a class="logout" href="pengumuman.php">Create Announcement</a>
        </div>
    </div>
</body>

</html>