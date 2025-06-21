<?php
require_once '../config/database.php';
require_once '../includes/header.php';

// Get category ID from URL
$categoryId = $_GET['id'] ?? 0;

// Get category information
$stmt = $conn->prepare("SELECT name FROM category WHERE id = ?");
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$categoryResult = $stmt->get_result();
$category = $categoryResult->fetch_assoc();

if (!$category) {
    die("Kategori tidak ditemukan");
}

// Get articles in this category
$stmt = $conn->prepare("
    SELECT DISTINCT a.* 
    FROM article a 
    JOIN article_category ac ON a.id = ac.article_id 
    WHERE ac.category_id = ? AND a.status = 'published' 
    ORDER BY a.created_at DESC
");
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();
$articles = $result->fetch_all(MYSQLI_ASSOC);

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

<link href="https://fonts.googleapis.com/css2?family=Cheltenham:wght@400;700&family=Franklin+Gothic:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Franklin Gothic', 'Helvetica Neue', Arial, sans-serif;
        background-color: #ffffff;
        color: #121212;
        line-height: 1.5;
    }

    .main-container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        gap: 40px;
        padding: 32px 20px;
        border-top: 1px solid #e6e6e6;
    }

    .main-content {
        flex: 2;
    }

    .sidebar-container {
        flex: 1;
        min-width: 300px;
    }

    .category-header {
        background-color: #ffffff;
        padding: 32px 0;
        margin-bottom: 32px;
        border-bottom: 3px solid #000000;
    }

    .category-title {
        font-family: 'Cheltenham', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #000000;
        line-height: 1.1;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
    }

    .category-name {
        color: #000000;
        font-weight: 700;
    }

    .category-info {
        font-size: 0.875rem;
        color: #666666;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 8px;
    }

    .article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 40px;
        margin-top: 40px;
    }

    .article-card {
        background-color: #ffffff;
        border-bottom: 1px solid #e6e6e6;
        padding-bottom: 24px;
        transition: all 0.2s ease;
    }

    .article-card:hover {
        border-bottom: 2px solid #000000;
    }

    .article-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        margin-bottom: 16px;
    }

    .article-card-content {
        padding: 0;
    }

    .article-title {
        font-family: 'Cheltenham', serif;
        font-size: 1.375rem;
        font-weight: 700;
        color: #000000;
        line-height: 1.2;
        margin-bottom: 8px;
        text-decoration: none;
        display: block;
        transition: color 0.2s ease;
        letter-spacing: -0.01em;
    }

    .article-title:hover {
        color: #326891;
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 3px;
    }

    .article-meta {
        font-size: 0.75rem;
        color: #666666;
        margin-bottom: 12px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .article-meta span {
        color: #666666;
    }

    .article-excerpt {
        font-size: 0.9375rem;
        color: #333333;
        line-height: 1.5;
        font-family: 'Franklin Gothic', Arial, sans-serif;
    }

    .no-articles {
        text-align: center;
        padding: 60px 24px;
        background-color: #ffffff;
        border: 1px solid #e6e6e6;
        margin-bottom: 32px;
    }

    .no-articles-title {
        font-family: 'Cheltenham', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
    }

    .no-articles-text {
        color: #666666;
        font-size: 1rem;
        line-height: 1.5;
    }

    .category-navigation {
        padding: 24px 0;
        margin-top: 32px;
        border-top: 1px solid #e6e6e6;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #326891;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 8px 0;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .back-link:hover {
        color: #000000;
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 3px;
    }

    .back-link::before {
        content: "←";
        margin-right: 8px;
        font-size: 1rem;
    }

    /* Content section title styling */
    .content-section-title {
        font-family: 'Cheltenham', serif;
        font-size: 1.875rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 24px;
        padding-bottom: 8px;
        border-bottom: 1px solid #000000;
        display: inline-block;
        letter-spacing: -0.01em;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            gap: 24px;
            padding: 20px;
        }

        .category-title {
            font-size: 2rem;
        }

        .category-header {
            padding: 24px 0;
        }

        .article-grid {
            grid-template-columns: 1fr;
            gap: 32px;
            margin-top: 32px;
        }

        .content-section-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-container">
    <div class="main-content">
        <header class="category-header">
            <h1 class="category-title">
                <span class="category-name"><?= htmlspecialchars($category['name']) ?></span>
            </h1>
            <div class="category-info">
                <?= count($articles) ?> Articles Found
            </div>
        </header>

        <?php if (empty($articles)): ?>
            <div class="no-articles">
                <h2 class="no-articles-title">No Articles Yet</h2>
                <p class="no-articles-text">
                    No articles are available in the "<strong><?= htmlspecialchars($category['name']) ?></strong>" category yet.
                </p>
            </div>
        <?php else: ?>
            <h2 class="content-section-title">Category Articles</h2>
            <div class="article-grid">
                <?php foreach ($articles as $article): ?>
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

        <nav class="category-navigation">
            <a href="index.php" class="back-link">Back to Home</a>
        </nav>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>