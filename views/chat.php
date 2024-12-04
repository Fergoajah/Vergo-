<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil daftar pengguna lain
$users_stmt = $pdo->prepare("SELECT id, username FROM users WHERE id != :id");
$users_stmt->execute(['id' => $user_id]);
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil pesan dengan pengguna tertentu
$receiver_id = $_GET['receiver_id'] ?? null;
$messages = [];
if ($receiver_id) {
    $messages_stmt = $pdo->prepare("
        SELECT m.message, m.created_at, u.username AS sender
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE (m.sender_id = :user_id AND m.receiver_id = :receiver_id)
           OR (m.sender_id = :receiver_id AND m.receiver_id = :user_id)
        ORDER BY m.created_at
    ");
    $messages_stmt->execute(['user_id' => $user_id, 'receiver_id' => $receiver_id]);
    $messages = $messages_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Kirim pesan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $receiver_id) {
    $message = $_POST['message'];
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
    $stmt->execute(['sender_id' => $user_id, 'receiver_id' => $receiver_id, 'message' => $message]);
    header("Location: chat.php?receiver_id=$receiver_id");
    exit();
}
?>
<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
<a href="logout.php">Logout</a>

<h3>Daftar Pengguna</h3>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <a href="chat.php?receiver_id=<?= $user['id'] ?>">
                <?= htmlspecialchars($user['username']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php if ($receiver_id): ?>
    <h3>Chat dengan <?= htmlspecialchars($receiver_id) ?></h3>
    <div>
        <?php foreach ($messages as $msg): ?>
            <p><strong><?= htmlspecialchars($msg['sender']) ?>:</strong> <?= htmlspecialchars($msg['message']) ?> <small><?= $msg['created_at'] ?></small></p>
        <?php endforeach; ?>
    </div>
    <form method="POST">
        <textarea name="message" placeholder="Tulis pesan..." required></textarea>
        <button type="submit">Kirim</button>
    </form>
<?php endif; ?>
