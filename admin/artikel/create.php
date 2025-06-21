<?php
require_once '../auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'];
    $date    = $_POST['date'];
    $content = $_POST['content'];
    $status  = $_POST['status'];
    $slug    = strtolower(str_replace(' ', '-', $title));
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], '../../assets/images/' . $filename);
        $picture = $filename;
    }


    $stmt = $conn->prepare("INSERT INTO article (title, slug, date, content, status, picture) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $slug, $date, $content, $status, $picture);
    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Artikel</title>
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
            max-width: 800px;
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

        form {
            background-color: #ffffff;
            border: 1px solid #000000;
            padding: 30px;
            margin-bottom: 20px;
        }

        label {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #333333;
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea,
        select {
            font-family: 'Noto Serif', serif;
            width: 100%;
            padding: 12px;
            border: 1px solid #666666;
            background-color: #ffffff;
            color: #000000;
            font-size: 1em;
            margin-bottom: 20px;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #326891;
            border-width: 2px;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        select[multiple] {
            height: 120px;
        }

        select option {
            padding: 5px;
            font-family: 'Noto Serif', serif;
        }

        button[type="submit"] {
            font-family: 'Franklin Gothic Medium', sans-serif;
            background-color: #326891;
            color: #ffffff;
            padding: 15px 30px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #2a5a7a;
        }

        .back-link {
            margin-top: 20px;
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

        .form-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .required {
            color: #cc0000;
        }
    </style>
</head>

<body>
    <h2>Tambah Artikel</h2>
    <?php
    $authors = $conn->query("SELECT * FROM author");
    $categories = $conn->query("SELECT * FROM category");
    ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <label>Judul <span class="required">*</span>:</label>
            <input type="text" name="title" maxlength="255" required>
        </div>

        <div class="form-section">
            <label>Upload Gambar:</label>
            <input type="file" name="picture">
        </div>

        <div class="form-section">
            <label>Tanggal <span class="required">*</span>:</label>
            <input type="date" name="date" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-section">
            <label>Isi Artikel <span class="required">*</span>:</label>
            <textarea name="content" rows="8" cols="60" required></textarea>
        </div>

        <div class="form-section">
            <label>Pilih Penulis <span class="required">*</span>:</label>
            <select name="author_ids[]" multiple required>
                <?php while ($a = $authors->fetch_assoc()): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nickname']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-section">
            <label>Pilih Kategori <span class="required">*</span>:</label>
            <select name="category_ids[]" multiple required>
                <?php while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-section">
            <label>Status:</label>
            <select name="status">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>

        <button type="submit">Simpan</button>
        <?php
        $article_id = $conn->insert_id;

        if (!empty($_POST['author_ids'])) {
            foreach ($_POST['author_ids'] as $author_id) {
                $stmt = $conn->prepare("INSERT INTO article_author (article_id, author_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $article_id, $author_id);
                $stmt->execute();
            }
        }

        if (!empty($_POST['category_ids'])) {
            foreach ($_POST['category_ids'] as $cat_id) {
                $stmt = $conn->prepare("INSERT INTO article_category (article_id, category_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $article_id, $cat_id);
                $stmt->execute();
            }
        }

        ?>
    </form>
    <div class="back-link">
        <a href="list.php">← Kembali</a>
    </div>
</body>

</html>