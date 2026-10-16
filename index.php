<?php
    require_once 'functions.php';

    /* The three homepage photos used in the rotating banner.
       The JavaScript in js/script.js switches to the next one every 5 seconds. */
    $heroImages = array('img/index1.avif', 'img/index2.jpg', 'img/index3.jpg');

    /* Upcoming workshops: only keep the ones that haven't started yet.
       strtotime() turns "2026-12-05 10:00 AM" into a timestamp we can
       compare with time() (right now). activities.txt is already in
       date order, so the list stays in date order too. */
    $upcoming = array();
    foreach (readRecords(ACTIVITIES_FILE) as $a) {
        if (strtotime($a['Date'] . ' ' . $a['Time']) >= time()) {
            $upcoming[] = $a;
        }
    }

    /* If someone is logged in, find which of those upcoming workshops
       they've booked. Bookings are saved with the account's email
       (see process_activity_reg.php), so we match on that. */
    $myWorkshops = array();
    if (isLoggedIn()) {
        $myTitles = array();
        foreach (readRecords(ACTIVITY_REG_FILE) as $r) {
            if (isset($r['Email']) && strcasecmp($r['Email'], $_SESSION['user_email']) == 0) {
                $myTitles[] = $r['ActivityTitle'];
            }
        }
        foreach ($upcoming as $a) {
            if (in_array($a['Title'], $myTitles)) {
                $myWorkshops[] = $a;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed - a tool-lending library for Swinburne students">
    <meta name="keywords" content="HTML, CSS, PHP, ShareShed">
    <meta name="author" content="Jane Yu Yan Zhen">
    <link rel="stylesheet" href="style/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <a href="index.php" class="brand"><img src="img/logo.png" alt="ShareShed logo" >ShareShed</a>
            <button class="nav-toggle" id="navToggle">&#9776;</button>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php" class="active">Home</a></li>
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

    <!-- Rotating photo banner: all three photos sit on top of each other,
         only the one with class "active" is visible -->
    <section class="banner">
        <?php foreach ($heroImages as $i => $img): ?>
            <img src="<?php echo h($img); ?>" alt="ShareShed photo <?php echo $i + 1; ?>" class="banner-slide<?php if ($i == 0) echo ' active'; ?>">
        <?php endforeach; ?>
        <h1 class="banner-text">Welcome to ShareShed</h1>
        <div class="banner-dots">
            <?php foreach ($heroImages as $i => $img): ?>
                <span class="banner-dot<?php if ($i == 0) echo ' active'; ?>"></span>
            <?php endforeach; ?>
        </div>
    </section>

    <main class="page-content">
        <section class="hero">
            <div>
                <span class="badge">Swinburne Student Village &middot; Sustainability &middot; Skills</span>
                <h1>Don't buy it for one job. Borrow it, learn it, share it.</h1>
                <p>
                    ShareShed is a tool-lending library for Swinburne students, whether you
                    live in the Student Village or nearby. Instead of buying a drill you'll
                    use twice, book it online and pick it up from the ShareShed store on
                    campus by tapping in with your Swinburne Student ID. The physical
                    store keeps its own record of which student has which tool.
                </p>
                <p>
                    Alongside tools, ShareShed runs hands-on repair &amp; garden workshops,
                    a searchable tutorial library, and a showcase of what students have
                    fixed, built, or upcycled together.
                </p>
                <div class="hero-actions">
                    <a href="main_menu.php" class="btn btn-primary">Explore the Menu</a>
                    <?php if (isLoggedIn()): ?>
                        <!-- Already logged in - no need to show Log In / Register -->
                        <a href="update_profile.php" class="btn btn-outline">My Account</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline">Log In</a>
                        <a href="registration.php" class="btn btn-accent">Register an Account</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php if (isLoggedIn()): ?>
            <!-- Logged in: show this user's own bookings first -->
            <h2 class="section-title">My Upcoming Workshops</h2>
            <?php if (count($myWorkshops) == 0): ?>
                <div class="card empty-card">
                    <div class="card-body">
                        <p>You haven't booked any workshops yet.</p>
                        <a href="activities.php" class="btn btn-primary">Browse Workshops</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card-grid card-grid-fixed">
                    <?php foreach ($myWorkshops as $a): ?>
                        <div class="card">
                            <div class="card-body">
                                <span class="badge">Booked</span>
                                <h3><?php echo h($a['Title']); ?></h3>
                                <p><?php echo date('l, j F Y', strtotime($a['Date'])); ?> &middot; <?php echo h($a['Time']); ?></p>
                                <p>Venue: <?php echo h($a['Venue']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <h2 class="section-title">Why ShareShed?</h2>
        <div class="card-grid">
            <div class="card">
                <div class="card-body">
                    <h3>Borrow, don't buy</h3>
                    <p>Browse a growing catalogue of tools sorted by category and skip the one-off purchase.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Learn a repair skill</h3>
                    <p>Book a seat at a hands-on workshop, from bike tune-ups to furniture upcycling.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Share what you made</h3>
                    <p>See what fellow students have fixed, built or grown, and add your own story.</p>
                </div>
            </div>
        </div>

        <?php if (!isLoggedIn()): ?>
            <!-- Visitors: a preview of the next 3 workshops -->
            <h2 class="section-title">Upcoming Workshops</h2>
            <div class="card-grid">
                <?php for ($i = 0; $i < count($upcoming) && $i < 3; $i++): ?>
                    <div class="card">
                        <div class="card-body">
                            <span class="badge"><?php echo h($upcoming[$i]['Type']); ?></span>
                            <h3><?php echo h($upcoming[$i]['Title']); ?></h3>
                            <p><?php echo date('l, j F Y', strtotime($upcoming[$i]['Date'])); ?> &middot; <?php echo h($upcoming[$i]['Time']); ?></p>
                            <p class="card-price"><?php echo h($upcoming[$i]['Price']); ?></p>
                            <div class="card-footer">
                                <a href="registration.php" class="btn btn-secondary btn-block">Register to Book</a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <p class="section-more"><a href="activities.php">See all workshops &rarr;</a></p>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
