<?php
require_once '../auth.php';
require_once '../../config/database.php';

$sql = "SELECT * FROM article ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Artikel</title>
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
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 2.5em;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000000;
            border-bottom: 3px solid #000000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .add-button {
            display: inline-block;
            font-family: 'Franklin Gothic Medium', sans-serif;
            background-color: #326891;
            color: #ffffff;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
            font-weight: 500;
            margin-bottom: 25px;
            transition: background-color 0.2s ease;
            border: none;
        }

        .add-button:hover {
            background-color: #2a5a7a;
        }

        .table-container {
            border: 1px solid #000000;
            background-color: #ffffff;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Noto Serif', serif;
        }

        th {
            font-family: 'Franklin Gothic Medium', sans-serif;
            background-color: #000000;
            color: #ffffff;
            padding: 15px 12px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85em;
            font-weight: 500;
            border-right: 1px solid #333333;
        }

        th:last-child {
            border-right: none;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            vertical-align: top;
        }

        td:last-child {
            border-right: none;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .article-title {
            font-weight: 600;
            color: #000000;
            max-width: 300px;
            word-wrap: break-word;
        }

        .article-image img {
            border: 1px solid #cccccc;
            display: block;
        }

        .no-image {
            font-family: 'Franklin Gothic Medium', sans-serif;
            color: #666666;
            font-size: 0.8em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.8em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 8px;
            color: #ffffff;
        }

        .status.published {
            background-color: #2d5016;
        }

        .status.draft {
            background-color: #b8860b;
        }

        .actions {
            white-space: nowrap;
        }

        .actions a {
            font-family: 'Franklin Gothic Medium', sans-serif;
            color: #326891;
            text-decoration: none;
            font-size: 0.85em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid transparent;
            transition: border-bottom-color 0.2s ease;
        }

        .actions a:hover {
            border-bottom-color: #326891;
        }

        .actions a.delete {
            color: #cc0000;
        }

        .actions a.delete:hover {
            border-bottom-color: #cc0000;
        }

        .separator {
            color: #666666;
            margin: 0 8px;
        }

        .back-link {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .back-link a {
            font-family: 'Franklin Gothic Medium', sans-serif;
            color: #326891;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9em;
            border-bottom: 1px solid transparent;
            transition: border-bottom-color 0.2s ease;
        }

        .back-link a:hover {
            border-bottom-color: #326891;
        }

        .article-date {
            font-family: 'Franklin Gothic Medium', sans-serif;
            color: #666666;
            font-size: 0.9em;
        }

        .row-number {
            font-family: 'Franklin Gothic Medium', sans-serif;
            color: #666666;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .table-container {
                font-size: 0.9em;
            }

            th,
            td {
                padding: 10px 8px;
            }

            .article-title {
                max-width: 200px;
            }
        }
    </style>
</head>

<body>
    <h2>Data Artikel</h2>
    <a href="create.php" class="add-button">+ Tambah Artikel</a>

    <div class="table-container">
        <table>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php $no = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="row-number"><?= $no++ ?></td>
                    <td class="article-title"><?= htmlspecialchars($row['title']) ?></td>
                    <td class="article-image">
                        <?php if ($row['picture']): ?>
                            <img src="../../assets/images/<?= $row['picture'] ?>" width="80">
                        <?php else: ?>
                            <span class="no-image">(Tidak ada)</span>
                        <?php endif; ?>
                    </td>
                    <td class="article-date"><?= $row['date'] ?></td>
                    <td>
                        <span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span>
                    </td>
                    <td class="actions">
                        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                        <span class="separator">|</span>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="back-link">
        <a href="../index.php">← Kembali ke Dashboard</a>
    </div>
</body>

</html>