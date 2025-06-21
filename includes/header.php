<?php
require_once '../config/database.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUpdate</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;500;600;700&family=Franklin+Gothic+Medium:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Serif', Georgia, serif;
            background-color: #ffffff;
            color: #333333;
            line-height: 1.7;
        }

        .main-header {
            background-color: #ffffff;
            border-bottom: 3px solid #000000;
            padding: 0;
            box-shadow: none;
        }

        .navbar-brand {
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #000000 !important;
            text-decoration: none;
            letter-spacing: 0.02em;
            padding: 20px 0;
            transition: none;
            text-transform: uppercase;
        }

        .navbar-brand:hover {
            color: #000000 !important;
            text-decoration: none;
        }

        .navbar {
            padding: 0;
            border-bottom: 1px solid #e6e6e6;
        }

        .navbar-nav .nav-link {
            color: #000000 !important;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 12px 18px !important;
            margin: 0;
            letter-spacing: 0.05em;
            border: none;
            border-radius: 0;
            transition: all 0.2s ease;
            position: relative;
            text-transform: uppercase;
        }

        .navbar-nav .nav-link:hover {
            color: #326891 !important;
            background-color: #f8f8f8;
        }

        .navbar-nav .nav-link.active {
            color: #326891 !important;
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 2px;
            background-color: #326891;
        }

        .sidebar {
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 0;
            padding: 24px;
            margin-bottom: 32px;
            height: fit-content;
            position: sticky;
            top: 32px;
        }

        .sidebar h3 {
            color: #000000;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #000000;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .sidebar form {
            margin-bottom: 32px;
        }

        .sidebar input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cccccc;
            border-radius: 0;
            margin-bottom: 12px;
            font-size: 0.9rem;
            font-family: 'Noto Serif', Georgia, serif;
            background-color: #ffffff;
            transition: border-color 0.2s ease;
            color: #333333;
        }

        .sidebar input[type="text"]:focus {
            outline: none;
            border-color: #326891;
            box-shadow: none;
        }

        .sidebar input[type="text"]::placeholder {
            color: #999999;
        }

        .sidebar button {
            width: 100%;
            padding: 10px 16px;
            background-color: #326891;
            color: #ffffff;
            border: 1px solid #326891;
            border-radius: 0;
            font-weight: 500;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar button:hover {
            background-color: #2c5d83;
            border-color: #2c5d83;
            transform: none;
            box-shadow: none;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-bottom: 32px;
        }

        .sidebar li {
            margin-bottom: 0;
            border-bottom: 1px solid #e6e6e6;
        }

        .sidebar li:last-child {
            border-bottom: none;
        }

        .sidebar li a {
            display: block;
            padding: 10px 0;
            color: #000000;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .sidebar li a:hover {
            color: #326891;
            text-decoration: underline;
            padding-left: 0;
        }

        .sidebar p {
            color: #666666;
            line-height: 1.6;
            margin-bottom: 0;
            font-size: 0.85rem;
            padding: 16px;
            background-color: #f8f8f8;
            border: 1px solid #e6e6e6;
            border-radius: 0;
        }

        .main-container {
            display: flex;
            gap: 32px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 16px;
        }

        .main-content {
            flex: 2;
        }

        .sidebar-container {
            flex: 1;
            max-width: 300px;
        }

        .main-footer {
            background-color: #ffffff;
            border-top: 3px solid #000000;
            margin-top: 48px;
            padding: 32px 0;
        }

        .footer-content {
            text-align: center;
            color: #666666;
            font-size: 0.8rem;
            font-weight: 400;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .footer-content p {
            margin: 0;
            padding: 16px 0;
            border: none;
            border-radius: 0;
            background-color: transparent;
        }

        .content-area {
            min-height: 60vh;
            padding: 48px 0;
        }

        .demo-card {
            background: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 0;
            padding: 32px;
            text-align: center;
        }

        .demo-card h2 {
            color: #000000;
            margin-bottom: 16px;
            font-weight: 600;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
        }

        .demo-card p {
            color: #666666;
            line-height: 1.6;
        }

        .related-articles {
            margin-top: 15px;
        }

        .related-article-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e6e6e6;
            transition: all 0.2s ease;
        }

        .related-article-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .related-article-item:hover {
            background-color: #f8f8f8;
            border-radius: 0;
            padding: 12px;
            margin: 0 -12px 20px -12px;
        }

        .related-article-image {
            flex: 0 0 80px;
            margin-right: 12px;
        }

        .related-article-image img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 0;
            transition: none;
            border: 1px solid #e6e6e6;
        }

        .related-article-content {
            flex: 1;
        }

        .related-article-content h4 {
            margin: 0 0 5px 0;
            font-size: 0.85rem;
            line-height: 1.4;
            font-weight: 500;
        }

        .related-article-content h4 a {
            color: #000000;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s ease;
        }

        .related-article-content h4 a:hover {
            color: #326891;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                gap: 24px;
                padding: 20px;
            }

            .sidebar-container {
                max-width: 100%;
            }

            .navbar-nav .nav-link {
                padding: 10px 14px !important;
                font-size: 0.75rem;
            }

            .navbar-brand {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid px-0">
                    <a class="navbar-brand" href="/">InfoUpdate</a>

                    <div class="navbar-nav ms-auto">
                        <a class="nav-link active" href="/">Beranda</a>
                        <a class="nav-link" href="/tentang">Tentang</a>
                        <a class="nav-link" href="/kontak">Kontak</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>