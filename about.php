<?php
    require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>About - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="About the ShareShed project">
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
        <h1 class="section-title">About This Project</h1>

        <div class="detail-box detail-box-wide">
            <p><strong>What problem does ShareShed solve, and why did I choose it?</strong></p>
            <ul>
                <li>Swinburne students, especially those in the Student Village or living nearby, rarely own tools like drills, sanders or ladders, but regularly need one for a single afternoon. Buying one for a one-off job is wasteful; borrowing from a shared, accountable store solves that.</li>
                <li>ShareShed pairs a bookable tool catalogue with a real physical pickup model: students reserve online, then collect from the on-campus ShareShed store by tapping their Swinburne Student ID, which the store's own system logs against the borrow record.</li>
                <li>I chose this idea because it needed every required feature to make sense together - a catalogue, a bookable activity, an account tied to a real identity, and a way to contribute.</li>
            </ul>

            <p><strong>PHP version used</strong> (generated with phpversion()):</p>
            <ul>
                <li>PHP <?php echo phpversion(); ?></li>
            </ul>

            <p><strong>Tasks completed in this submission (Assignment 1):</strong></p>
            <ul>
                <li>Task 1 - Home page with randomly displayed photos and the three entry buttons</li>
                <li>Task 2 - Main menu with nav bar, home, logout, and the four option cards</li>
                <li>Task 3 - Tool Catalogue with 4 categories and 39 tools, plus a keyword search that highlights matching tools</li>
                <li>Task 4 - Activities page showing type, date/time, price and venue</li>
                <li>Task 5 &amp; 6 - Community Showcase list and contribution detail page</li>
                <li>Task 7 &amp; 8 - Static developer profile page, and the editable "Update Profile" page</li>
                <li>Task 9 &amp; 10 - Registration form and its full server-side validation/storage script</li>
                <li>Task 11 - Activity registration form and its validation/storage script</li>
                <li>Task 12 - Self-calling login page with session handling</li>
                <li>Task 13 - This about page</li>
                <li>Extra: a searchable Tutorials library with pre-populated how-to guides and keyword search (guides are written by the ShareShed team only, so tool-safety advice stays accurate)</li>
            </ul>

            <p><strong>Tasks not attempted / left for Assignment 2:</strong></p>
            <ul>
                <li>Uploading a new contribution to the Community Showcase</li>
                <li>The purchase/order flow from the Catalogue page</li>
                <li>The Smart Feature (planned as a tool recommender / CO2-saved calculator)</li>
            </ul>

            <p><strong>Frameworks / third-party libraries used:</strong></p>
            <ul>
                <li>None - plain HTML, CSS, JavaScript and PHP.</li>
            </ul>

            <p><strong>Video presentation:</strong></p>
            <ul>
                <li><a href="https://youtu.be/EokfQoDSH4Y?si=WpC_2wfXsLtfiJPu" target="_blank">Watch the demo video on YouTube （Click here）</a></li>
            </ul>

            <div class="space-top-lg">
                <a href="index.php" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
