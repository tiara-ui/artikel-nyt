<?php
require_once '../config/database.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak sama.";
    } else {
        // Cek apakah username sudah ada
        $stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username sudah terdaftar.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            $insert->bind_param("ss", $username, $hashed);

            if ($insert->execute()) {
                $success = "Registrasi berhasil. Silakan login.";
            } else {
                $error = "Gagal registrasi.";
            }

            $insert->close();
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registrasi Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Franklin+Gothic+Medium&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Serif', serif;
            background-color: #ffffff;
            color: #000000;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .register-container {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #000000;
            padding-bottom: 30px;
        }

        .site-title {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .register-subtitle {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9rem;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h2 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #000000;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .success-message {
            background-color: #f0f9f0;
            border: 1px solid #38a169;
            color: #38a169;
            padding: 20px;
            margin-bottom: 25px;
            font-family: 'Noto Serif', serif;
            font-size: 0.95rem;
            text-align: center;
        }

        .success-message a {
            color: #2d7d32;
            text-decoration: none;
            font-weight: 700;
        }

        .success-message a:hover {
            text-decoration: underline;
        }

        .error-message {
            background-color: #fff5f5;
            border: 1px solid #e53e3e;
            color: #e53e3e;
            padding: 15px;
            margin-bottom: 25px;
            font-family: 'Noto Serif', serif;
            font-size: 0.95rem;
            text-align: center;
        }

        .register-form {
            border: 2px solid #000000;
            background-color: #ffffff;
            padding: 40px 35px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #000000;
            background-color: #ffffff;
            font-family: 'Noto Serif', serif;
            font-size: 1rem;
            color: #000000;
            transition: all 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #326891;
            border-width: 2px;
            background-color: #fafafa;
        }

        .register-btn {
            width: 100%;
            padding: 15px;
            background-color: #326891;
            color: #ffffff;
            border: none;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        .register-btn:hover {
            background-color: #2a5578;
        }

        .register-btn:active {
            background-color: #1e3f5c;
        }

        .form-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #cccccc;
            text-align: center;
        }

        .login-link {
            font-family: 'Noto Serif', serif;
            color: #326891;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .login-link:hover {
            text-decoration: underline;
            color: #2a5578;
        }

        .password-hint {
            font-family: 'Noto Serif', serif;
            font-size: 0.85rem;
            color: #666666;
            margin-top: 8px;
            line-height: 1.4;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 0 15px;
            }

            .site-title {
                font-size: 1.6rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .register-form {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <div class="site-title">Admin Portal</div>
            <div class="register-subtitle">Content Management System</div>
        </div>

        <h2>Registrasi Admin</h2>

        <?php if ($success): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
                <br><br>
                <a href="login.php">Login di sini</a>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!$success): ?>
            <form method="POST" action="" class="register-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    <div class="password-hint">
                        Use a strong password with at least 8 characters including letters, numbers, and special characters.
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm">Ulangi Password:</label>
                    <input type="password" name="confirm" id="confirm" required>
                </div>

                <button type="submit" class="register-btn">Daftar</button>

                <div class="form-footer">
                    <a href="login.php" class="login-link">Already have an account? Login here</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>