<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function uploadFile($file, $uploadDir = 'uploads/', $maxSize = 20 * 1024 * 1024) {
    if ($file['error'] !== UPLOAD_ERR_OK) return [null, null];
    if ($file['size'] > $maxSize) die("File size exceeds 20MB.");

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileNameClean = uniqid('file_', true) . '.' . $fileExtension;
    $destPath = $uploadDir . $fileNameClean;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        die("Error moving uploaded file.");
    }

    return [$fileNameClean, $destPath];
}

$message = ""; // Variabel untuk notifikasi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $messageContent = trim($_POST['message'] ?? '');

    if (empty($title) || empty($messageContent)) {
        $message = "Title and message cannot be empty.";
    } else {
        [$fileNameClean, $destPath] = uploadFile($_FILES['file'] ?? []);

        $stmt = $conn->prepare("INSERT INTO announcements (title, message, file_name, file_path) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $title, $messageContent, $fileNameClean, $destPath);
            if ($stmt->execute()) {
                $message = "Announcement created successfully!";
            } else {
                $message = "Failed to create announcement.";
            }
            $stmt->close();
        } else {
            $message = "Failed to prepare statement: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Create Announcement</title>
</head>
<body>
    <div class="announcement-container">
        <h2 class="announcement-title">Create Announcement</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="announcement-form">
            <div class="form-group">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="message" class="form-label">Message:</label>
                <textarea name="message" id="message" rows="5" class="form-textarea" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="file" class="form-label">Attach File (optional):</label>
                <input type="file" name="file" id="file" class="form-file">
            </div>
            
            <div class="btnchat">
                <a class="btnbackuser" href="dash_admin.php">Back</a>
                <button class="btnsubuser" type="submit">Send</button>
            </div>        
        </form>
    </div>
    <script>
        window.onload = function() {
            const message = "<?= isset($message) ? addslashes($message) : ''; ?>";
            if (message) {
                alert(message);
            }
        }
    </script>
</body>
</html>
