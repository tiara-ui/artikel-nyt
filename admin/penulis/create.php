<?php
require_once '../auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO author (nickname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nickname, $email, $password);
    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Penulis</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Franklin+Gothic+Medium&display=swap');

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
            padding: 40px 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 2.2em;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000000;
        }

        form {
            background-color: #ffffff;
            border: 1px solid #333333;
            padding: 30px;
            margin-bottom: 25px;
        }

        label {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9em;
            color: #333333;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            border: 1px solid #666666;
            font-family: 'Noto Serif', serif;
            font-size: 1.1em;
            color: #000000;
            background-color: #ffffff;
            margin-bottom: 20px;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #326891;
            border-width: 2px;
        }

        button[type="submit"] {
            background-color: #326891;
            color: #ffffff;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 30px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-weight: bold;
        }

        button[type="submit"]:hover {
            background-color: #1f4a5f;
        }

        p {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #999999;
        }

        a {
            color: #326891;
            text-decoration: none;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 1px solid transparent;
            transition: border-bottom 0.2s ease;
        }

        a:hover {
            border-bottom: 1px solid #326891;
        }
    </style>
</head>

<body>
    <h2>Tambah Penulis</h2>
    <form method="POST">
        <label>Nama Penulis:</label>
        <input type="text" name="nickname" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Simpan</button>
    </form>
    <p><a href="list.php">← Kembali</a></p>
</body>

</html>