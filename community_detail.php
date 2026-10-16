<?php
    require_once 'functions.php';

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $contribution = null;

    /* Loop through every contribution until we find the one whose Id
       matches what was clicked on the showcase page. */
    foreach (readRecords(COMMUNITY_FILE) as $c) {
        if ($c['Id'] == $id) {
            $contribution = $c;
            break;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contribution Detail - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed contribution detail">
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
        <h1 class="section-title">Contribution Detail</h1>

        <?php if ($contribution === null): ?>
            <div class="alert alert-error">That contribution couldn't be found. <a href="community.php">Back to Showcase</a></div>
        <?php else: ?>
            <div class="detail-box">
                <img src="<?php echo h($contribution['Image']); ?>" alt="Contribution by <?php echo h($contribution['Name']); ?>">
                <div class="detail-row"><strong>Contributor</strong><span><?php echo h($contribution['Name']); ?></span></div>
                <div class="detail-row"><strong>Related Activity</strong><span><?php echo h($contribution['Activity']); ?></span></div>
                <div class="detail-row"><strong>Story</strong><span><?php echo h($contribution['Caption']); ?></span></div>
                <div class="space-top-md">
                    <a href="community.php" class="btn btn-secondary">Back to Showcase</a>
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
