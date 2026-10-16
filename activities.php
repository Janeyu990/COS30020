<?php
    require_once 'functions.php';

    /* Read every workshop from the text file so we can list them below. */
    $activities = readRecords(ACTIVITIES_FILE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Workshops - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed workshops and activities">
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
                <li><a href="activities.php" class="active">Workshops</a></li>
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
        <h1 class="section-title">Workshops &amp; Activities</h1>
        <p class="section-lead">Anyone can view the schedule - registering for a seat needs a free account.</p>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">You're registered! We'll see you at the workshop.</div>
        <?php endif; ?>

        <?php if (!isLoggedIn()): ?>
            <div class="alert alert-error">You can browse freely, but you'll need to <a href="login.php">log in</a> or <a href="registration.php">register</a> before booking a seat.</div>
        <?php endif; ?>

        <div class="card-grid">
            <?php
                /* Loop through each workshop record and print a card for it. */
                foreach ($activities as $a) {
                    echo '<div class="card"><div class="card-body">';
                    echo '<span class="badge">' . h($a['Type']) . '</span>';
                    echo '<h3>' . h($a['Title']) . '</h3>';
                    echo '<p>Date: ' . h($a['Date']) . ' &nbsp; Time: ' . h($a['Time']) . '</p>';
                    echo '<p>Venue: ' . h($a['Venue']) . '</p>';
                    echo '<p class="card-price">' . h($a['Price']) . ' &middot; ' . h($a['Seats']) . ' seats</p>';
                    echo '<div class="card-footer">';

                    if (isLoggedIn()) {
                        echo '<a href="activity_reg.php?title=' . urlencode($a['Title']) . '" class="btn btn-primary btn-block">Register for this Activity</a>';
                    } else {
                        echo '<a href="registration.php" class="btn btn-secondary btn-block">Register to Book</a>';
                    }

                    echo '</div></div></div>';
                }
            ?>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
