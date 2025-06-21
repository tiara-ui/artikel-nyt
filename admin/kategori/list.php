<?php
require_once '../auth.php';
require_once '../../config/database.php';

$result = $conn->query("SELECT * FROM category ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000000;
        }

        .action-buttons {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #999999;
        }

        .btn-add {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            display: inline-block;
            transition: background-color 0.2s ease;
        }

        .btn-add:hover {
            background-color: #326891;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border: 1px solid #333333;
            margin-bottom: 25px;
        }

        th {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background-color: #000000;
            color: #ffffff;
            padding: 15px 12px;
            text-align: left;
            border-bottom: 3px solid #000000;
        }

        td {
            font-family: 'Noto Serif', serif;
            font-size: 15px;
            padding: 12px;
            border-bottom: 1px solid #999999;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .action-links a {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 13px;
            color: #326891;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            font-weight: 600;
            margin-right: 10px;
        }

        .action-links a:hover {
            color: #000000;
            text-decoration: underline;
        }

        .action-links a.delete {
            color: #d32f2f;
        }

        .action-links a.delete:hover {
            color: #000000;
        }

        .back-link {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #999999;
        }

        .back-link a {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 14px;
            color: #326891;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-weight: 600;
        }

        .back-link a:hover {
            color: #000000;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }

            h2 {
                font-size: 24px;
            }

            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 8px 6px;
            }

            .action-links a {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <h2>Data Kategori</h2>

    <div class="action-buttons">
        <a href="create.php" class="btn-add">+ Tambah Kategori</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td class="action-links">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="back-link">
        <a href="../index.php">← Kembali ke Dashboard</a>
    </div>
</body>

</html>