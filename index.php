<?php
session_start();
require_once 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi';
    } else {
        // Query untuk mencari user
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header('Location: admin/index.php');
                } else {
                    header('Location: public/index.php');
                }
                exit();
            } else {
                $error = 'Username atau password salah';
            }
        } else {
            $error = 'Username atau password salah';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Content Management System</title>
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

        .form-label {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 1px solid #000000;
            background-color: #ffffff;
            font-family: 'Noto Serif', serif;
            font-size: 1rem;
            color: #000000;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #326891;
            border-width: 2px;
            background-color: #fafafa;
        }

        .form-input:hover {
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

        .demo-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #cccccc;
            text-align: center;
        }

        .demo-title {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #000000;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .demo-credentials {
            font-family: 'Noto Serif', serif;
            font-size: 0.95rem;
            color: #666666;
            line-height: 1.6;
        }

        .demo-credentials strong {
            color: #000000;
            font-weight: 700;
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

        @media (max-width: 480px) {
            .site-title {
                font-size: 1.4rem;
            }

            h2 {
                font-size: 1.3rem;
            }

            .login-subtitle {
                font-size: 0.8rem;
                letter-spacing: 1.5px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .login-header {
                margin-bottom: 30px;
                padding-bottom: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="site-title">InfoUpdate</div>
            <div class="login-subtitle">Content Management System</div>
        </div>

        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="login-form">
            <div class="form-group">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-input"
                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-input"
                    required>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

    </div>
</body>

</html>