<?php
    require_once 'functions.php';
    $contributions = readRecords(COMMUNITY_FILE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Community Showcase - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed community showcase">
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
                <li><a href="main_menu.php" class="">Menu</a></li>
                <li><a href="catalog.php" class="">Tool Catalogue</a></li>
                <li><a href="activities.php" class="">Workshops</a></li>
                <li><a href="community.php" class="active">Showcase</a></li>
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
        <h1 class="section-title">Community Showcase</h1>
        <p class="section-lead">Real fixes, builds and grows from ShareShed members. Uploading your own contribution arrives in Assignment 2.</p>

        <div class="card-grid">
            <?php
                foreach ($contributions as $c) {
                    echo '<a class="card" href="community_detail.php?id=' . urlencode($c['Id']) . '">';
                    echo '<img src="' . h($c['Image']) . '" alt="Contribution by ' . h($c['Name']) . '">';
                    echo '<div class="card-body">';
                    echo '<h3>' . h($c['Name']) . '</h3>';
                    echo '<p>' . h($c['Activity']) . '</p>';
                    echo '<p>' . h(mb_strimwidth($c['Caption'], 0, 80, '...')) . '</p>';
                    echo '</div></a>';
                }
            ?>
        </div>

        <div class="notice-box space-top-xl">
            <p>Adding your own photo/video contribution will be enabled in Assignment 2.</p>
            <button type="button" class="btn btn-primary" title="Coming in Assignment 2" disabled>Upload a Contribution</button>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
