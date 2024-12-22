<?php
session_start();
require 'koneksi.php';

// Validasi role dan session
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

// Validasi dan ambil user_id berdasarkan username dari session
$username = $_SESSION['username'];
$queryUser = "SELECT id FROM users WHERE username = ?";
$stmtUser = $mysqli->prepare($queryUser);
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser && $resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
    $user_id = $user['id'];
} else {
    echo "User not found.";
    exit();
}

// Validasi ID pengumuman dari parameter GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid announcement ID.";
    exit();
}
$announcement_id = intval($_GET['id']);

// Fetch detail pengumuman
$queryDetail = "SELECT * FROM announcements WHERE id = ?";
$stmtDetail = $mysqli->prepare($queryDetail);
$stmtDetail->bind_param("i", $announcement_id);
$stmtDetail->execute();
$resultDetail = $stmtDetail->get_result();
$announcement = $resultDetail->fetch_assoc();

if (!$announcement) {
    echo "Announcement not found.";
    exit();
}

// Tandai pengumuman sebagai dibaca jika belum
$checkRead = "
    SELECT * FROM announcement_reads 
    WHERE user_id = ? AND announcement_id = ?
";
$stmtCheck = $mysqli->prepare($checkRead);
$stmtCheck->bind_param("ii", $user_id, $announcement_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows === 0) {
    $insertRead = "INSERT INTO announcement_reads (user_id, announcement_id) VALUES (?, ?)";
    $stmtInsert = $mysqli->prepare($insertRead);
    $stmtInsert->bind_param("ii", $user_id, $announcement_id);
    $stmtInsert->execute();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Announcement Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="announcement-detail">
        <h1><?= $announcement['title']; ?></h1>
        <p><strong>Posted on:</strong> <?= $announcement['created_at']; ?></p>
        <hr>
        <div class="message">
        <p><?= $announcement['message']; ?></p>
        </div>
        <?php if (!empty($announcement['file_path'])): ?>
            <p>
                <strong>Attachment:</strong>
                <a href="<?= $announcement['file_path']; ?>" target="_blank">Download/View File</a>
            </p>
        <?php endif; ?>
        <div class="btnannoun">
        <a class="logout" href="dash_user.php">Back</a>
        </div>
    </div>
</body>

</html>
