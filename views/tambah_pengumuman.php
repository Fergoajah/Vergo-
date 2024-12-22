<?php
session_start();
require 'koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) exit("Database connection failed.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!$title || !$message) {
        echo "<script>alert('Title and message cannot be empty.');</script>";
    }

    $fileNameClean = null;
    $destPath = null;

    if (!empty($_FILES['file']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $fileNameClean = $_FILES['file']['name']; 
        $destPath = $uploadDir . $fileNameClean;
        move_uploaded_file($_FILES['file']['tmp_name'], $destPath);
    }

    $query = "INSERT INTO announcements (title, message, file_name, file_path) VALUES ('$title', '$message', '$fileNameClean', '$destPath')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Announcement created!'); window.location.href='dash_admin.php';</script>";
    } else {
        echo "<script>alert('Error saving data.');</script>";
    }
}

$conn->close();
?>
