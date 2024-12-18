<?php
session_start();
require 'koneksi.php';

$username = $_SESSION['username'];
$query = "SELECT username, role FROM users WHERE role = 'user' AND username != '$username'";

$result = $mysqli->query($query);

$users = [];
if ($result && $result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $users[] = $user;
    }
}
echo json_encode($users);

?>
