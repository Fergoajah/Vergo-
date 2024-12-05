<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Memasukan pesan ke database
    $sender = $_SESSION['username'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

    $query = "INSERT INTO messages (sender, receiver, message) VALUES ('$sender', '$receiver', '$message')";
    if ($mysqli->query($query)) {
        echo "Message sent!";
    } else {
        echo "Error: " . $mysqli->error;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // mengambil pesandari database
    $username = $_SESSION['username'];
    $receiver = isset($_GET['receiver']) ? $_GET['receiver'] : '';

    // Filter messages between the logged-in user and the selected receiver
    if ($receiver) {
        $query = "SELECT * FROM messages WHERE 
                  (sender = '$username' AND receiver = '$receiver') 
                  OR (sender = '$receiver' AND receiver = '$username') 
                  ORDER BY timestamp ASC";
    } else {
        // If no receiver is selected, fetch all messages for the logged-in user
        $query = "SELECT * FROM messages WHERE sender = '$username' OR receiver = '$username' ORDER BY timestamp ASC";
    }

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        echo json_encode($messages);
    } else {
        echo json_encode([]);
    }
}
?>
