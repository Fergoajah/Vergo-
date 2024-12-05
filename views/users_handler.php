<?php
session_start();
require 'koneksi.php';

// Ambil semua pengguna yang tidak termasuk pengguna yang sedang login
$username = $_SESSION['username'];
$query = "SELECT username, role FROM users WHERE role = 'user' AND username != '$username'";

// Menjalankan query dan mengambil hasilnya
$result = $mysqli->query($query);

// Menyiapkan array untuk menyimpan data pengguna
$users = [];
if ($result && $result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $users[] = $user;
    }
}

// Mengembalikan hasil dalam format JSON
echo json_encode($users);

?>
