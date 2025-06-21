<?php
require_once '../auth.php';
require_once '../../config/database.php';

$result = $conn->query("SELECT * FROM author ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Penulis</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }

        h2 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 2.5em;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000000;
        }

        .add-button {
            display: inline-block;
            background-color: #326891;
            color: #ffffff;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.8em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 20px;
            text-decoration: none;
            margin-bottom: 25px;
            transition: background-color 0.2s ease;
            font-weight: bold;
            border: 2px solid #326891;
        }

        .add-button:hover {
            background-color: #1f4a5f;
            border-color: #1f4a5f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #ffffff;
            border: 1px solid #333333;
        }

        th {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 15px 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #333333;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #999999;
            font-family: 'Noto Serif', serif;
            font-size: 1em;
            color: #000000;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .action-links a {
            color: #326891;
            text-decoration: none;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.8em;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            border-bottom: 1px solid transparent;
            transition: border-bottom 0.2s ease;
            margin-right: 8px;
        }

        .action-links a:hover {
            border-bottom: 1px solid #326891;
        }

        .action-links a.delete {
            color: #d32f2f;
        }

        .action-links a.delete:hover {
            border-bottom: 1px solid #d32f2f;
        }

        .back-link {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #999999;
        }

        .back-link a {
            color: #326891;
            text-decoration: none;
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 1px solid transparent;
            transition: border-bottom 0.2s ease;
        }

        .back-link a:hover {
            border-bottom: 1px solid #326891;
        }

        /* ID column styling */
        td:first-child {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-weight: bold;
            color: #666666;
            width: 60px;
        }
    </style>
</head>

<body>
    <h2>Data Penulis</h2>
    <a href="create.php" class="add-button">+ Tambah Penulis</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nickname']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td class="action-links">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Hapus penulis ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <p class="back-link"><a href="../index.php">← Kembali ke Dashboard</a></p>
</body>

</html>