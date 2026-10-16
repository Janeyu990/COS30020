<?php
    require_once 'functions.php';
    requireLogin(); // send them to the main menu if they're not logged in

    /* Look up the logged-in user's saved details so we can pre-fill
       the form with their name and email. */
    $currentUser = findUserByEmail($_SESSION['user_email']);
    /* The Workshops page sends the chosen title as ?title=...
       If the form was sent back with an error, it comes back as
       ?activity_title=... instead, so check both. */
    $prefillTitle = '';
    if (isset($_GET['title'])) {
        $prefillTitle = $_GET['title'];
    } elseif (isset($_GET['activity_title'])) {
        $prefillTitle = $_GET['activity_title'];
    }

    /* Find that workshop in activities.txt so we can fill in its date
       and time for the user - they shouldn't have to type it. */
    $activity = null;
    foreach (readRecords(ACTIVITIES_FILE) as $a) {
        if ($a['Title'] == $prefillTitle) {
            $activity = $a;
            break;
        }
    }

    /* datetime-local inputs need the format 2026-10-12T13:00, so turn
       "2026-10-12" + "1:00 PM" into that with strtotime() and date(). */
    $prefillDateTime = '';
    if ($activity !== null) {
        $prefillDateTime = date('Y-m-d\TH:i', strtotime($activity['Date'] . ' ' . $activity['Time']));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register for Activity - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed activity registration">
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
        <div class="form-wrap">
            <h2>Register for a Workshop</h2>
            <p class="section-lead">
                Logged in as <?php echo h($_SESSION['user_email']); ?>
                <?php if (!empty($currentUser['StudentID'])) { echo '(Student ID: ' . h($currentUser['StudentID']) . ')'; } ?>
                - this booking will be tied to your account.
            </p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error"><?php echo h($_GET['error']); ?></div>
            <?php endif; ?>

            <?php if ($activity === null): ?>
                <div class="alert alert-error">Please choose a workshop first. <a href="activities.php">Go to Workshops</a></div>
            <?php else: ?>
            <form method="POST" action="process_activity_reg.php">
                <div class="field">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required
                           value="<?php echo isset($_GET['first_name']) ? h($_GET['first_name']) : h(isset($currentUser['First Name']) ? $currentUser['First Name'] : ''); ?>">
                </div>
                <div class="field">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required
                           value="<?php echo isset($_GET['last_name']) ? h($_GET['last_name']) : h(isset($currentUser['LastName']) ? $currentUser['LastName'] : ''); ?>">
                </div>
                <div class="field">
                    <label for="contact">Contact Number</label>
                    <input type="text" id="contact" name="contact" required value="<?php echo isset($_GET['contact']) ? h($_GET['contact']) : ''; ?>">
                    <div class="field-hint">Use the phone number you frequently use.</div>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required readonly
                           value="<?php echo h($_SESSION['user_email']); ?>">
                </div>
                <div class="field">
                    <label for="activity_datetime">Activity Date &amp; Time</label>
                    <input type="datetime-local" id="activity_datetime" name="activity_datetime" required readonly
                           value="<?php echo h($prefillDateTime); ?>">
                </div>
                <div class="field">
                    <label for="activity_title">Activity Title</label>
                    <input type="text" id="activity_title" name="activity_title" required readonly
                           value="<?php echo h($activity['Title']); ?>">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="activities.php" class="btn btn-outline">Cancel</a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
