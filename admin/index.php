<?php
require_once 'auth.php';
require_once '../config/database.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            font-size: 16px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            border-top: 3px solid #000000;
            border-bottom: 3px solid #000000;
            background-color: #ffffff;
            padding: 20px 0;
            margin-bottom: 40px;
        }

        h1 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            color: #000000;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .subtitle {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.9rem;
            text-align: center;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .dashboard-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .nav-card {
            border: 1px solid #000000;
            background-color: #ffffff;
            padding: 30px 25px;
            transition: all 0.2s ease;
        }

        .nav-card:hover {
            background-color: #f8f8f8;
            border-color: #326891;
        }

        .nav-card a {
            text-decoration: none;
            color: #000000;
            display: block;
        }

        .nav-card h3 {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
        }

        .nav-card p {
            font-family: 'Noto Serif', serif;
            color: #666666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .nav-card:hover h3 {
            color: #326891;
            border-bottom-color: #326891;
        }

        .logout-section {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #cccccc;
            text-align: center;
        }

        .logout-btn {
            font-family: 'Franklin Gothic Medium', sans-serif;
            background-color: #326891;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #2a5578;
            color: #ffffff;
        }

        footer {
            margin-top: 60px;
            padding: 20px 0;
            border-top: 3px solid #000000;
            text-align: center;
            background-color: #ffffff;
        }

        .footer-text {
            font-family: 'Franklin Gothic Medium', sans-serif;
            font-size: 0.8rem;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .dashboard-nav {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .nav-card {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <h1>Dashboard Admin</h1>
            <div class="subtitle">System Management Portal</div>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-nav">
            <div class="nav-card">
                <a href="artikel/list.php">
                    <h3>Kelola Artikel</h3>
                    <p>Manage and organize all articles, create new content, edit existing posts, and maintain your publication's editorial standards.</p>
                </a>
            </div>

            <div class="nav-card">
                <a href="kategori/list.php">
                    <h3>Kelola Kategori</h3>
                    <p>Organize content categories, create new sections, and maintain the taxonomical structure of your publication.</p>
                </a>
            </div>

            <div class="nav-card">
                <a href="penulis/list.php">
                    <h3>Kelola Penulis</h3>
                    <p>Manage writer profiles, author information, and contributor access to maintain editorial quality and accountability.</p>
                </a>
            </div>
        </div>

        <div class="logout-section">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-text">Admin Dashboard System</div>
        </div>
    </footer>
</body>

</html>