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
        <form action="tambah_pengumuman.php" method="POST" enctype="multipart/form-data" class="announcement-form">
            <div class="form-group">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="message" class="form-label">Message:</label>
                <textarea name="message" id="message" rows="5" class="form-textarea" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="file" class="form-label">Attach File:</label>
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
