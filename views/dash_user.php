<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Fetch user data
$queryUser = "SELECT * FROM users WHERE username = ?";
$stmtUser = $mysqli->prepare($queryUser);
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$user_id = $user['id'];

// Fetch unread announcements count
$queryNew = "
    SELECT COUNT(*) AS unread_count
    FROM announcements a
    LEFT JOIN announcement_reads ar 
    ON a.id = ar.announcement_id AND ar.user_id = ?
    WHERE ar.announcement_id IS NULL
";
$stmtNew = $mysqli->prepare($queryNew);
$stmtNew->bind_param("i", $user_id);
$stmtNew->execute();
$resultNew = $stmtNew->get_result();
$unreadCount = $resultNew->fetch_assoc()['unread_count'];

// Fetch all announcements
$queryAll = "
    SELECT a.*, 
           CASE WHEN ar.announcement_id IS NULL THEN 0 ELSE 1 END AS is_read 
    FROM announcements a
    LEFT JOIN announcement_reads ar 
    ON a.id = ar.announcement_id AND ar.user_id = ?
    ORDER BY a.created_at DESC
";
$stmtAll = $mysqli->prepare($queryAll);
$stmtAll->bind_param("i", $user_id);
$stmtAll->execute();
$resultAll = $stmtAll->get_result();

?>
<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Style/user.css">
</head>

<body>
    <div class="abc">
        <h1>Welcome, <?= ($user['nama']); ?>!</h1>
        <img class="orang" src="/views/img/orang.jpeg" alt="John" style="width:50%">
        <hr>
        <p><span class="label">Username:</span> <?= ($user['username']); ?></p>
        <p><span class="label">Email:</span> <?= ($user['email']); ?></p>
        <p><span class="label">Alamat:</span> <?= ($user['alamat']); ?></p>
        <a class='logout' href="logout.php">Logout</a>
    </div>
    <!-- Notification Icon -->
    <div class="notification-container">
        <i class="fas fa-bell notification-icon" id="notifIcon">
            <?php if ($unreadCount > 0): ?>
                <span class="badge"><?= $unreadCount; ?></span>
            <?php endif; ?>
        </i>
        <div class="notification-dropdown" id="notifDropdown">
            <h3>Announcements</h3>
            <?php while ($announcement = $resultAll->fetch_assoc()): ?>
                <?php $isReadClass = $announcement['is_read'] ? 'read' : 'unread'; ?>
                <div class="notification-item <?= $isReadClass; ?>">
                    <h4><?= $announcement['title']; ?></h4>
                    <p>
                        <?php
                        // Memotong pesan jika lebih panjang dari 100 karakter
                        $message = $announcement['message'];
                        $shortMessage = strlen($message) > 100 ? substr($message, 0, 100) . '...' : $message;
                        echo nl2br($shortMessage);
                        ?>
                    </p>  
                    <small>Posted on: <?= $announcement['created_at']; ?></small>
                    <p>
                        <a href="announcement_detail.php?id=<?= $announcement['id']; ?>">View Details</a>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <a href="chat.html" class="chat-icon">
        <i class="fas fa-comment-alt"></i>
    </a>
    <script>
        // Toggle Dropdown
        document.getElementById('notifIcon').addEventListener('click', function () {
            const dropdown = document.getElementById('notifDropdown');
            dropdown.classList.toggle('active');
        });

        window.addEventListener('click', function (e) {
            const notifIcon = document.getElementById('notifIcon');
            const dropdown = document.getElementById('notifDropdown');
            if (!notifIcon.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

    </script>
</body>

</html>