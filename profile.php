<?php
    require_once 'functions.php';

    /* This page is the required "about the developer" profile (Task 7):
       my own photo, name, student ID and student email. It is separate
       from update_profile.php, which lets a registered website USER
       edit their own account details. */
    $studentName  = 'Jane Yu Yan Zhen';
    $studentId    = '1000xxxxx'; // replace with your real student ID
    $studentEmail = 'yourname@student.swin.edu.au'; // replace with your real student email
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="Developer profile page">
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
        <h1 class="section-title">Profile</h1>

        <div class="profile-card">
            <img src="img/default_avatar.svg" alt="Profile photo" class="profile-photo">
            <!-- Replace img/default_avatar.svg above with your own real photo -->
            <h2><?php echo h($studentName); ?></h2>
            <p><strong>Student ID:</strong> <?php echo h($studentId); ?></p>
            <p><strong>Student Email:</strong> <?php echo h($studentEmail); ?></p>

            <div class="declaration">
                <strong>Academic Integrity Declaration</strong>
                <p>
                    I declare that this assignment is my own original work, except where
                    acknowledged, and has not been submitted, whether in the same or
                    different form, for assessment in any other unit or course.
                </p>
            </div>

            <div class="hero-actions centered-actions">
                <a href="index.php" class="btn btn-outline">Home</a>
                <a href="about.php" class="btn btn-secondary">About this Project</a>
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
