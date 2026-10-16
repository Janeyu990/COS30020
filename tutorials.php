<?php
    require_once 'functions.php';

    $query = isset($_GET['q']) ? trim($_GET['q']) : '';
    $allTutorials = readRecords(TUTORIALS_FILE);

    /* If a search word was typed, only keep tutorials whose title, tool
       name or tags contain that word (case-insensitive). This is a
       simple keyword search - it just checks if the text appears
       anywhere inside using strpos(). */
    $results = array();
    if ($query != '') {
        $needle = strtolower($query);
        foreach ($allTutorials as $t) {
            $haystack = strtolower($t['Title'] . ' ' . $t['Tool'] . ' ' . $t['Tags']);
            if (strpos($haystack, $needle) !== false) {
                $results[] = $t;
            }
        }
    } else {
        $results = $allTutorials;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tutorials - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed tutorials">
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
        <h1 class="section-title">Tutorials</h1>
        <p class="section-lead">Short how-to guides for the tools in our catalogue, searchable by keyword.</p>
        <p class="section-lead">Every guide here is written and checked by the ShareShed team, so the safety steps are always accurate.</p>

        <form method="GET" action="tutorials.php" class="form-wrap search-panel">
            <div class="field">
                <label for="q">Search by tool name or keyword</label>
                <div class="search-row">
                    <input type="text" id="q" name="q" placeholder="e.g. screwdriver, bicycle, sewing"
                           value="<?php echo h($query); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <?php if ($query != ''): ?>
                        <a href="tutorials.php" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <?php if ($query != ''): ?>
            <p class="section-lead"><?php echo count($results); ?> result(s) for "<?php echo h($query); ?>"</p>
        <?php endif; ?>

        <?php if (count($results) == 0): ?>
            <div class="notice-box">No tutorials matched that search. Try a different keyword, like a tool name.</div>
        <?php else: ?>
            <div class="card-grid">
                <?php
                    foreach ($results as $t) {
                        echo '<a class="card tutorial-card" href="tutorial_detail.php?id=' . urlencode($t['Id']) . '">';

                        /* Top of the card: the YouTube video's thumbnail picture.
                           YouTube gives every video a thumbnail at
                           img.youtube.com/vi/VIDEO_ID/mqdefault.jpg, so we only
                           need the video ID saved in tutorials.txt.
                           Tutorials without a video get a plain brown block instead. */
                        if (isset($t['Video']) && $t['Video'] != '') {
                            echo '<div class="tutorial-thumb">';
                            echo '<img src="https://img.youtube.com/vi/' . h($t['Video']) . '/mqdefault.jpg" alt="Video thumbnail for ' . h($t['Title']) . '">';
                            echo '<span class="play-icon">&#9654;</span>';
                            echo '</div>';
                        } else {
                            echo '<div class="tutorial-thumb tutorial-thumb-text">';
                            echo '<span>Written guide</span>';
                            echo '</div>';
                        }

                        echo '<div class="card-body">';
                        echo '<span class="badge">' . h($t['Tool']) . '</span>';
                        echo '<h3>' . h($t['Title']) . '</h3>';
                        echo '<p>' . h(mb_strimwidth($t['Summary'], 0, 90, '...')) . '</p>';
                        echo '<p class="field-hint">By ' . h($t['Author']) . '</p>';
                        echo '</div></a>';
                    }
                ?>
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
