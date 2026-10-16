<?php
    require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Smart Feature - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="Reserved for Assignment 2">
    <meta name="keywords" content="HTML, CSS, PHP, ShareShed">
    <meta name="author" content="Jane Yu Yan Zhen">
    <link rel="stylesheet" href="style/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <a href="index.php" class="brand"><img src="img/logo.png" alt="ShareShed logo">ShareShed</a>
            <button class="nav-toggle" id="navToggle">&#9776;</button>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php" class="">Home</a></li>
                <li><a href="main_menu.php" class="active">Menu</a></li>
                <li><a href="catalog.php" class="">Tool Catalogue</a></li>
                <li><a href="activities.php" class="">Workshops</a></li>
                <li><a href="community.php" class="">Showcase</a></li>
                <li><a href="tutorials.php" class="">Tutorials</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="update_profile.php">My Account</a></li>
                    <li><a href="logout.php" class="btn-nav-logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="registration.php" class="btn-nav-register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="page-content">
        <h1 class="section-title">Smart Feature <span class="badge badge-coming-soon">Coming in Assignment 2</span></h1>
        <div class="notice-box">
            <p>
                This page is reserved for ShareShed's advanced feature, planned as
                either a tool recommender or a CO2/cost-saved calculator based on a
                member's borrowing history.
            </p>
            <a href="main_menu.php" class="btn btn-outline">Back to Main Menu</a>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
