<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Admin</title>
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
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .login-header {
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

        .login-subtitle {
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

        .login-form {
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

        .login-btn {
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

        .login-btn:hover {
            background-color: #2a5578;
        }

        .login-btn:active {
            background-color: #1e3f5c;
        }

        .form-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #cccccc;
            text-align: center;
        }

        .register-link {
            font-family: 'Noto Serif', serif;
            color: #326891;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .register-link:hover {
            text-decoration: underline;
            color: #2a5578;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 0 15px;
            }

            .site-title {
                font-size: 1.6rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .login-form {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="site-title">Admin Portal</div>
            <div class="login-subtitle">Content Management System</div>
        </div>

        <h2>Login Admin</h2>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>

            <div class="form-footer">
                <a href="registrasi.php" class="register-link">Need an account? Register here</a>
            </div>
        </form>
    </div>
</body>

</html>