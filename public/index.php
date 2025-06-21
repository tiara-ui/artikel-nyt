<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$stmt = $conn->prepare("SELECT * FROM article WHERE status = 'published' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$articles = $result->fetch_all(MYSQLI_ASSOC);

$headline = array_shift($articles);
$otherArticles = $articles;

function getAuthors($conn, $articleId)
{
    $authors = [];
    $auth = $conn->query("SELECT a.nickname FROM article_author aa JOIN author a ON aa.author_id = a.id WHERE aa.article_id = $articleId");
    while ($a = $auth->fetch_assoc()) $authors[] = $a['nickname'];
    return $authors;
}

function getCategories($conn, $articleId)
{
    $categories = [];
    $cat = $conn->query("SELECT c.name FROM article_category ac JOIN category c ON ac.category_id = c.id WHERE ac.article_id = $articleId");
    while ($c = $cat->fetch_assoc()) $categories[] = $c['name'];
    return $categories;
}
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
        font-size: 16px;
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
        border-left: 1px solid #e2e2e2;
        padding-left: 40px;
    }

    .headline-article {
        background-color: #ffffff;
        border-radius: 0;
        margin-bottom: 48px;
        overflow: hidden;
        box-shadow: none;
        border-bottom: 2px solid #121212;
        padding-bottom: 32px;
        transition: none;
    }

    .headline-article:hover {
        transform: none;
        box-shadow: none;
    }

    .headline-article img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        display: block;
        border: 1px solid #e2e2e2;
    }

    .headline-content {
        padding: 24px 0 0 0;
    }

    .headline-title {
        font-family: 'Noto Serif', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #121212;
        line-height: 1.1;
        margin-bottom: 16px;
        text-decoration: none;
        transition: color 0.2s ease;
        letter-spacing: -0.02em;
    }

    .headline-title:hover {
        color: #666666;
        text-decoration: none;
    }

    .headline-meta {
        font-family: 'Helvetica', Arial, sans-serif;
        font-size: 0.8125rem;
        color: #666666;
        margin-bottom: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .headline-meta span {
        display: flex;
        align-items: center;
        padding: 0;
        background-color: transparent;
        border-radius: 0;
        font-weight: 400;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .headline-excerpt {
        font-size: 1rem;
        color: #333333;
        line-height: 1.6;
        margin-bottom: 0;
        text-align: justify;
        font-family: 'Noto Serif', Georgia, serif;
    }

    .article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
        margin-top: 48px;
        border-top: 1px solid #e2e2e2;
        padding-top: 32px;
    }

    .article-card {
        background-color: #ffffff;
        border-radius: 0;
        overflow: hidden;
        box-shadow: none;
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 24px;
        transition: none;
    }

    .article-card:hover {
        transform: none;
        box-shadow: none;
    }

    .article-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        border: 1px solid #e2e2e2;
    }

    .article-card-content {
        padding: 16px 0 0 0;
    }

    .article-title {
        font-family: 'Noto Serif', Georgia, serif;
        font-size: 1.1875rem;
        font-weight: 600;
        color: #121212;
        line-height: 1.3;
        margin-bottom: 12px;
        text-decoration: none;
        display: block;
        transition: color 0.2s ease;
        letter-spacing: -0.01em;
    }

    .article-title:hover {
        color: #666666;
        text-decoration: none;
    }

    .article-meta {
        font-family: 'Helvetica', Arial, sans-serif;
        font-size: 0.75rem;
        color: #666666;
        margin-bottom: 12px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .article-meta span {
        padding: 0;
        background-color: transparent;
        border-radius: 0;
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .article-excerpt {
        font-size: 0.875rem;
        color: #333333;
        line-height: 1.6;
        font-family: 'Noto Serif', Georgia, serif;
        text-align: justify;
    }

    .no-articles {
        text-align: center;
        padding: 80px 24px;
        background-color: #ffffff;
        border-radius: 0;
        box-shadow: none;
        border: 1px solid #e2e2e2;
    }

    .no-articles p {
        font-size: 1.125rem;
        color: #666666;
        font-weight: 400;
        font-family: 'Noto Serif', Georgia, serif;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            gap: 24px;
            padding: 20px;
        }

        .sidebar-container {
            border-left: none;
            border-top: 1px solid #e2e2e2;
            padding-left: 0;
            padding-top: 24px;
        }

        .headline-title {
            font-size: 2rem;
        }

        .headline-content {
            padding: 16px 0 0 0;
        }

        .article-grid {
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 32px;
        }

        .headline-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
    }

    /* Content section title styling */
    .content-section-title {
        font-family: 'Noto Serif', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #121212;
        margin-bottom: 32px;
        padding-bottom: 8px;
        border-bottom: 2px solid #121212;
        display: inline-block;
        letter-spacing: -0.01em;
        text-transform: none;
    }
</style>

<div class="main-container">
    <div class="main-content">
        <?php if (empty($articles) && !$headline): ?>
            <div class="no-articles">
                <p>Belum ada artikel yang tersedia.</p>
            </div>
        <?php else: ?>

            <?php if ($headline): ?>
                <article class="headline-article">
                    <?php if ($headline['picture']): ?>
                        <img src="../assets/images/<?= htmlspecialchars($headline['picture']) ?>" alt="<?= htmlspecialchars($headline['title']) ?>">
                    <?php endif; ?>

                    <div class="headline-content">
                        <h1><a href="artikel.php?id=<?= $headline['id'] ?>" class="headline-title">
                                <?= htmlspecialchars($headline['title']) ?>
                            </a></h1>

                        <div class="headline-meta">
                            <span><?= date('F j, Y', strtotime($headline['created_at'])) ?></span>
                            <?php
                            $headlineAuthors = getAuthors($conn, $headline['id']);
                            if (!empty($headlineAuthors)):
                            ?>
                                <span>By <?= implode(', ', $headlineAuthors) ?></span>
                            <?php endif; ?>
                            <?php
                            $headlineCategories = getCategories($conn, $headline['id']);
                            if (!empty($headlineCategories)):
                            ?>
                                <span><?= implode(', ', $headlineCategories) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="headline-excerpt">
                            <?= substr(strip_tags($headline['content']), 0, 200) ?>...
                        </div>
                    </div>
                </article>
            <?php endif; ?>

            <?php if (!empty($otherArticles)): ?>
                <h2 class="content-section-title">More Articles</h2>
                <div class="article-grid">
                    <?php foreach ($otherArticles as $article): ?>
                        <article class="article-card">
                            <?php if ($article['picture']): ?>
                                <img src="../assets/images/<?= htmlspecialchars($article['picture']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                            <?php endif; ?>

                            <div class="article-card-content">
                                <h3><a href="artikel.php?id=<?= $article['id'] ?>" class="article-title">
                                        <?= htmlspecialchars($article['title']) ?>
                                    </a></h3>

                                <div class="article-meta">
                                    <span><?= date('M j, Y', strtotime($article['created_at'])) ?></span>
                                    <?php
                                    $articleAuthors = getAuthors($conn, $article['id']);
                                    if (!empty($articleAuthors)):
                                    ?>
                                        <span>By <?= implode(', ', $articleAuthors) ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="article-excerpt">
                                    <?= substr(strip_tags($article['content']), 0, 150) ?>...
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>