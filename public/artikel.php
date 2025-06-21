<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM article WHERE id = ? AND status = 'published'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) die("Artikel tidak ditemukan");

$authors = [];
$auth = $conn->query("SELECT a.nickname FROM article_author aa JOIN author a ON aa.author_id = a.id WHERE aa.article_id = $id");
while ($a = $auth->fetch_assoc()) $authors[] = $a['nickname'];

$categories = [];
$cat = $conn->query("SELECT c.name FROM article_category ac JOIN category c ON ac.category_id = c.id WHERE ac.article_id = $id");
while ($c = $cat->fetch_assoc()) $categories[] = $c['name'];
?>

<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;600;700&family=Helvetica:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Noto Serif', Georgia, serif;
        background-color: #ffffff;
        color: #121212;
        line-height: 1.625;
        font-size: 18px;
    }

    .article-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 0;
        border-radius: 0;
        box-shadow: none;
        overflow: hidden;
        border-left: 1px solid #e2e2e2;
        border-right: 1px solid #e2e2e2;
    }

    .article-header {
        margin-bottom: 40px;
        padding: 40px 40px 0;
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 30px;
    }

    .article-title {
        font-family: 'Noto Serif', Georgia, serif;
        font-size: 2.75rem;
        font-weight: 700;
        color: #121212;
        line-height: 1.1;
        margin-bottom: 24px;
        word-wrap: break-word;
        letter-spacing: -0.02em;
    }

    .article-meta {
        font-family: 'Helvetica', Arial, sans-serif;
        font-size: 0.8125rem;
        color: #666666;
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        font-weight: 400;
        padding: 0;
        background-color: transparent;
        border-radius: 0;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .meta-item strong {
        color: #666666;
        margin-right: 4px;
        font-weight: 400;
    }

    .article-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        margin-bottom: 16px;
        border-radius: 0;
        border-top: 1px solid #e2e2e2;
        border-bottom: 1px solid #e2e2e2;
    }

    .article-content {
        font-size: 1.125rem;
        line-height: 1.75;
        color: #121212;
        margin-bottom: 40px;
        padding: 0 40px;
        font-family: 'Noto Serif', Georgia, serif;
    }

    .article-content p {
        margin-bottom: 20px;
        text-align: justify;
    }

    .article-content h2 {
        font-family: 'Noto Serif', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #121212;
        margin: 32px 0 16px 0;
        letter-spacing: -0.01em;
        line-height: 1.3;
    }

    .article-content h3 {
        font-family: 'Noto Serif', Georgia, serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #121212;
        margin: 24px 0 12px 0;
        letter-spacing: -0.01em;
        line-height: 1.3;
    }

    .article-content ul,
    .article-content ol {
        margin: 16px 0;
        padding-left: 24px;
    }

    .article-content li {
        margin-bottom: 6px;
    }

    .article-content blockquote {
        border-left: 3px solid #121212;
        padding-left: 24px;
        margin: 24px 0;
        font-style: italic;
        color: #333333;
        background-color: transparent;
        padding: 24px 0 24px 24px;
        border-radius: 0;
        font-size: 1.1875rem;
        line-height: 1.6;
    }

    .article-navigation {
        padding: 32px 40px;
        border-top: 2px solid #121212;
        margin-top: 40px;
        background-color: #f8f8f8;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #121212;
        text-decoration: underline;
        font-weight: 500;
        font-size: 0.875rem;
        font-family: 'Helvetica', Arial, sans-serif;
        padding: 0;
        background-color: transparent;
        border-radius: 0;
        transition: color 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .back-link:hover {
        background-color: transparent;
        color: #666666;
        text-decoration: underline;
        transform: none;
    }

    .back-link::before {
        content: "←";
        margin-right: 6px;
        font-size: 1rem;
    }

    .main-container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        gap: 40px;
        padding: 32px 20px;
        background-color: #ffffff;
    }

    .main-content {
        flex: 2;
    }

    .sidebar-container {
        flex: 1;
        min-width: 300px;
    }

    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            gap: 24px;
            padding: 20px;
        }

        .article-title {
            font-size: 2.25rem;
        }

        .article-header,
        .article-content,
        .article-navigation {
            padding-left: 24px;
            padding-right: 24px;
        }

        .article-meta {
            flex-direction: column;
            gap: 6px;
        }
    }
</style>

<div class="main-container">
    <div class="main-content">
        <article class="article-container">
            <header class="article-header">
                <h1 class="article-title"><?= htmlspecialchars($data['title']) ?></h1>

                <div class="article-meta">
                    <span class="meta-item">
                        <strong></strong> <?= date('F j, Y', strtotime($data['created_at'])) ?>
                    </span>
                    <?php if (!empty($authors)): ?>
                        <span class="meta-item">
                            <strong>By</strong> <?= implode(', ', $authors) ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($categories)): ?>
                        <span class="meta-item">
                            <strong></strong> <?= implode(', ', $categories) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if ($data['picture']): ?>
                <div style="padding: 0 40px;">
                    <img src="../assets/images/<?= htmlspecialchars($data['picture']) ?>"
                        alt="<?= htmlspecialchars($data['title']) ?>"
                        class="article-image">
                </div>
            <?php endif; ?>

            <div class="article-content">
                <?= $data['content'] ?>
            </div>

            <nav class="article-navigation">
                <a href="index.php" class="back-link">Back to Home</a>
            </nav>
        </article>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>