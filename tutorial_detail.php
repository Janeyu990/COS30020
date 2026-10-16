<?php
    require_once 'functions.php';

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $tutorial = null;
    foreach (readRecords(TUTORIALS_FILE) as $t) {
        if ($t['Id'] == $id) {
            $tutorial = $t;
            break;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tutorial Detail - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed tutorial detail">
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
                <li><a href="community.php" class="">Showcase</a></li>
                <li><a href="tutorials.php" class="active">Tutorials</a></li>
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
        <h1 class="section-title">Tutorial</h1>

        <?php if ($tutorial === null): ?>
            <div class="alert alert-error">That tutorial couldn't be found. <a href="tutorials.php">Back to Tutorials</a></div>
        <?php else: ?>
            <div class="detail-box">
                <span class="badge"><?php echo h($tutorial['Tool']); ?></span>
                <h2 class="space-top-sm"><?php echo h($tutorial['Title']); ?></h2>

                <?php if (isset($tutorial['Video']) && $tutorial['Video'] != ''): ?>
                    <!-- YouTube video for this tutorial. The video stays on YouTube;
                         we only embed YouTube's own player using the video ID
                         saved in tutorials.txt -->
                    <div class="video-wrap">
                        <iframe src="https://www.youtube-nocookie.com/embed/<?php echo h($tutorial['Video']); ?>" title="<?php echo h($tutorial['Title']); ?>" allowfullscreen></iframe>
                    </div>
                    <p class="field-hint">Video by <?php echo h($tutorial['VideoCredit']); ?> on YouTube</p>
                <?php endif; ?>
                <div class="detail-row"><strong>Written by</strong><span><?php echo h($tutorial['Author']); ?></span></div>
                <div class="detail-row"><strong>Tags</strong><span><?php echo h($tutorial['Tags']); ?></span></div>
                <div class="detail-row"><strong>Guide</strong><span><?php echo h($tutorial['Summary']); ?></span></div>
                <div class="space-top-md">
                    <a href="tutorials.php" class="btn btn-secondary">Back to Tutorials</a>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
