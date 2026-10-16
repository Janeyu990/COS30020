<?php
    require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Main Menu - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed main menu">
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
        <h1 class="section-title">Main Menu</h1>
        <p class="section-lead">Browsing is open to everyone. Booking a workshop needs a free account.</p>

        <?php
            /* If someone tried to book an activity without logging in,
               activity_reg.php sends them here with ?login_required=1
               so we can show a message explaining why. */
            if (isset($_GET['login_required'])) {
                echo '<div class="alert alert-error">Please log in or register before booking an activity.</div>';
            }
        ?>

        <div class="card-grid"> 

            <a href="catalog.php" class="card menu-card card-tool"> 
                <div class="card-body"> 
                    <h3>Tool Catalogue</h3> 
                    <p>Browse tools by category: power tools, garden tools and hand tools.</p> 
                </div> 
            </a> 

            <a href="activities.php" class="card menu-card card-workshop"> 
                <div class="card-body"> 
                    <h3>Workshops &amp; Activities</h3> 
                    <p>See upcoming repair &amp; garden workshops and register for a seat.</p> 
                </div> 
            </a> 

            <a href="community.php" class="card menu-card card-community"> 
                <div class="card-body"> 
                    <h3>Community Showcase</h3> 
                    <p>See what fellow students have fixed, built or grown with ShareShed's help.</p> 
                </div> 
            </a> 

            <!-- Smart Feature is built in Assignment 2, so this card cannot be clicked yet -->
            <div class="card menu-card card-smart card-disabled" title="Coming in Assignment 2" aria-disabled="true"> 
                <div class="card-body"> 
                    <h3>Smart Feature <span class="badge badge-coming-soon">Assignment 2</span></h3> 
                    <p>A tool recommender / carbon-saved calculator - coming in the next milestone.</p> 
                </div> 
            </div> 

        </div>

        <h2 class="section-title" >Extra: Tutorials</h2>
        <p class="section-lead">A searchable how-to library, on top of the four required sections above.</p>
        <div class="card-grid"> 
            <a href="tutorials.php" class="card menu-card card-tutorial"> 
                <div class="card-body"> 
                    <h3>Tutorials</h3> 
                    <p>Search ShareShed's own how-to and safety guides for the tools in our catalogue.</p> 
                </div> 
            </a> 
        </div>

        <?php if (isLoggedIn()): ?>
            <div class="space-top-xl">
                <a href="update_profile.php" class="btn btn-secondary">View / Update My Profile</a>
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
