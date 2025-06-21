<?php
require_once '../auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO category (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $desc);
    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
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
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 28px;
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
            font-size: 14px;
            font-weight: 600;
            color: #333333;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea {
            font-family: 'Noto Serif', serif;
            font-size: 16px;
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #666666;
            background-color: #ffffff;
            color: #000000;
            margin-bottom: 20px;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #326891;
            background-color: #ffffff;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"] {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #000000;
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #326891;
        }

        p {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #999999;
        }

        a {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 14px;
            color: #326891;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-weight: 600;
        }

        a:hover {
            color: #000000;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 15px;
            }

            h2 {
                font-size: 24px;
            }

            form {
                padding: 20px;
            }

            button[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <h2>Tambah Kategori</h2>
    <form method="POST">
        <label>Nama Kategori:</label>
        <input type="text" name="name" required>

        <label>Deskripsi:</label>
        <textarea name="description" rows="4" cols="50"></textarea>

        <button type="submit">Simpan</button>
    </form>
    <p><a href="list.php">← Kembali</a></p>
</body>

</html>