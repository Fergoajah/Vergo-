<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Koneksi ke database menggunakan MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil nilai dari form
    $title = isset($_POST['title']) ? trim($_POST['title']) : null;
    $message = isset($_POST['message']) ? trim($_POST['message']) : null;

    // Validasi title dan message
    if (empty($title) || empty($message)) {
        die("Title and message cannot be empty.");
    }

    $fileNameClean = null;
    $destPath = null;

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        // Validasi ukuran file
        if ($fileSize > 10 * 1024 * 1024) { // 10MB
            die("File size exceeds 10MB.");
        }

        // Validasi jenis file
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($fileType, $allowedTypes)) {
            die("Unsupported file type.");
        }

        // Validasi folder
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        if (!is_writable($uploadDir)) {
            die("Upload directory is not writable.");
        }

        // Pindahkan file
        $fileNameClean = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $fileName);
        $destPath = $uploadDir . $fileNameClean;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            die("Error moving uploaded file.");
        }
    }

    // Simpan ke database menggunakan MySQLi
    $stmt = $conn->prepare("INSERT INTO announcements (title, message, file_name, file_path) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $title, $message, $fileNameClean, $destPath);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Announcement created successfully!";
        } else {
            echo "Failed to create announcement.";
        }
        $stmt->close();
    } else {
        die("Failed to prepare statement: " . $conn->error);
    }
}

// Tutup koneksi MySQLi
$conn->close();
?>
