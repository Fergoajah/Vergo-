<?php
$host = 'localhost';
$dbname = 'data';
$username = 'tugas';
$password = '12345'; 

// koneksi ke database
$mysqli = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi ke database gagal: " . $mysqli->connect_error);
}
?>
