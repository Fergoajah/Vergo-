    <?php
    session_start();
    require 'koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash password input user dengan MD5
        $hashed_password = md5($password);

        // Query untuk mengambil data user/admin
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute([
            'username' => $username, 
            'password' => $hashed_password
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header('Location: /views/dash_admin.php');
                exit();
            } else {
                header('Location: /views/dash_user.php');
                exit();
            }
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
        <style>
            body {
                font-size: 20px;
                justify-content: center;
                align-items: center;
                display: flex;
                height: 80vh;
            }
            button {
                margin-top: 15px;
                font-size: 15px;
                padding: 10px;
            }
            input[type="text"], input[type="password"] {
                width: 100%; /* Lebar penuh untuk input */
                font-size: 18px; /* Ukuran font lebih besar */
                border: 1px solid #000; /* Tambahkan border dengan warna lembut */
                border-radius: 3px; /* Sudut melengkung */
                margin-top: 10px;
            }

        </style>
    </head>
    <body>
        <form method="POST">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
            <label>Username:</label><br>
            <input type="text" name="username" required><br>
            <label>Password:</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </body>
    </html>
