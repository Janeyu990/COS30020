<?php
    require_once 'functions.php';

    /* The tool catalogue data. In Assignment 2 this could move into its
       own text file, but for now a plain nested array is enough since
       the brief only asks for it to be displayed, not edited. --By Claude */
    $catalogue = array(
        'Power Tools' => array(
            array('name' => 'Cordless Drill Driver', 'price' => 'RM 8 / day', 'img' => 'img/tool_drill.jpg', 'desc' => '18V drill with two batteries and a mixed bit set.'),
            array('name' => 'Circular Saw', 'price' => 'RM 12 / day', 'img' => 'img/tool_saw.jpg', 'desc' => 'Great for straight cuts on wood panels and offcuts.'),
            array('name' => 'Orbital Sander', 'price' => 'RM 7 / day', 'img' => 'img/tool_sander.jpg', 'desc' => 'Finish sanding for furniture and upcycling projects.'),
            array('name' => 'Concrete Mixer (small)', 'price' => 'RM 20 / day', 'img' => 'img/tool_mixer.jpg', 'desc' => 'Small batch mixer, ideal for patch repairs and planters.'),
            array('name' => 'Portable Generator', 'price' => 'RM 25 / day', 'img' => 'img/tool_generator.jpg', 'desc' => 'Quiet inverter generator for outdoor jobs and events.'),
            array('name' => 'Bench Grinder', 'price' => 'RM 10 / day', 'img' => 'img/tool_grinder.jpg', 'desc' => 'Sharpen blades and shape metal safely on a stable base.'),
            array('name' => 'Jigsaw', 'price' => 'RM 8 / day', 'img' => 'img/tool_jigsaw.jpg', 'desc' => 'Cuts curves and shapes in wood, plastic and thin metal.'),
            array('name' => 'Impact Driver', 'price' => 'RM 8 / day', 'img' => 'img/tool_impact.jpg', 'desc' => 'Drives long screws easily for furniture and decking.'),
            array('name' => 'Heat Gun', 'price' => 'RM 6 / day', 'img' => 'img/tool_heatgun.jpg', 'desc' => 'Strips old paint, bends plastic and loosens stuck parts.'),
            array('name' => 'Pressure Washer', 'price' => 'RM 18 / day', 'img' => 'img/tool_washer.jpg', 'desc' => 'Blasts dirt off bikes, patios, bins and outdoor furniture.'),
            array('name' => 'Hot Glue Gun', 'price' => 'RM 2 / day', 'img' => 'img/tool_gluegun.jpg', 'desc' => 'Quick bonding for crafts, décor and small fixes.'),
        ),
        'Garden Tools' => array(
            array('name' => 'Lawn Mower', 'price' => 'RM 15 / day', 'img' => 'img/tool_mower.jpg', 'desc' => 'Push mower, serviced and sharpened monthly.'),
            array('name' => 'Garden Rake', 'price' => 'RM 3 / day', 'img' => 'img/tool_rake.jpg', 'desc' => 'Sturdy steel-tine rake for leaves and light soil work.'),
            array('name' => 'Digging Shovel', 'price' => 'RM 4 / day', 'img' => 'img/tool_shovel.jpg', 'desc' => 'Full-size shovel for garden beds and compost turning.'),
            array('name' => 'Garden Hose (20m)', 'price' => 'RM 5 / day', 'img' => 'img/tool_hose.jpg', 'desc' => 'Expandable hose with adjustable spray nozzle.'),
            array('name' => 'Hand Trowel', 'price' => 'RM 2 / day', 'img' => 'img/tool_trowel.jpg', 'desc' => 'For potting, transplanting and small bed work.'),
            array('name' => 'Wheelbarrow', 'price' => 'RM 6 / day', 'img' => 'img/tool_wheelbarrow.jpg', 'desc' => 'Single-wheel barrow for soil, mulch and offcuts.'),
            array('name' => 'Hedge Trimmer', 'price' => 'RM 12 / day', 'img' => 'img/tool_hedge.jpg', 'desc' => 'Electric trimmer for shaping hedges and bushes.'),
            array('name' => 'Pruning Shears', 'price' => 'RM 2 / day', 'img' => 'img/tool_pruner.jpg', 'desc' => 'Sharp bypass pruners for plants, stems and small branches.'),
            array('name' => 'Leaf Blower', 'price' => 'RM 10 / day', 'img' => 'img/tool_blower.jpg', 'desc' => 'Clears leaves and debris from paths and driveways fast.'),
            array('name' => 'Garden Fork', 'price' => 'RM 3 / day', 'img' => 'img/tool_fork.jpg', 'desc' => 'Loosens compacted soil and turns compost.'),
            array('name' => 'Watering Can (10L)', 'price' => 'RM 1 / day', 'img' => 'img/tool_wateringcan.jpg', 'desc' => 'Gentle rose head for seedlings and potted plants.'),
        ),
        'Hand Tools' => array(
            array('name' => 'Claw Hammer', 'price' => 'RM 2 / day', 'img' => 'img/tool_hammer.jpg', 'desc' => '16oz hammer, good balance for general repairs.'),
            array('name' => 'Adjustable Wrench Set', 'price' => 'RM 3 / day', 'img' => 'img/tool_wrench.jpg', 'desc' => 'Three sizes covering most household fittings.'),
            array('name' => 'Step Ladder (1.5m)', 'price' => 'RM 6 / day', 'img' => 'img/tool_ladder.jpg', 'desc' => 'Lightweight aluminium ladder, safe up to 120kg.'),
            array('name' => 'Spirit Level', 'price' => 'RM 2 / day', 'img' => 'img/tool_level.jpg', 'desc' => '60cm level for shelving and picture hanging.'),
            array('name' => 'Spade Set', 'price' => 'RM 4 / day', 'img' => 'img/tool_spade.jpg', 'desc' => 'Flat and pointed spades for edging and turfing.'),
            array('name' => 'Clamp Set (4pc)', 'price' => 'RM 3 / day', 'img' => 'img/tool_clamp.jpg', 'desc' => 'Bar clamps for gluing and holding furniture repairs.'),
            array('name' => 'Screwdriver Set', 'price' => 'RM 2 / day', 'img' => 'img/tool_screwdriver.jpg', 'desc' => 'Flat and Phillips heads in several sizes.'),
            array('name' => 'Tape Measure (5m)', 'price' => 'RM 1 / day', 'img' => 'img/tool_tape.jpg', 'desc' => 'Locking tape for measuring rooms and furniture.'),
            array('name' => 'Pliers Set', 'price' => 'RM 2 / day', 'img' => 'img/tool_pliers.jpg', 'desc' => 'Combination, long-nose and cutting pliers.'),
            array('name' => 'Hand Saw', 'price' => 'RM 3 / day', 'img' => 'img/tool_handsaw.jpg', 'desc' => 'General-purpose saw for timber and small cuts.'),
            array('name' => 'Stud Finder', 'price' => 'RM 3 / day', 'img' => 'img/tool_studfinder.jpg', 'desc' => 'Finds studs and pipes behind walls before you drill.'),
        ),
        'Home & Moving' => array(
            array('name' => 'Hand Truck Trolley', 'price' => 'RM 6 / day', 'img' => 'img/tool_trolley.jpg', 'desc' => 'Moves boxes and furniture on move-in and move-out day.'),
            array('name' => 'Vacuum Cleaner', 'price' => 'RM 6 / day', 'img' => 'img/tool_vacuum.jpg', 'desc' => 'Deep-clean your room before inspection.'),
            array('name' => 'Extension Reel (15m)', 'price' => 'RM 2 / day', 'img' => 'img/tool_extension.jpg', 'desc' => 'Four-socket reel with safety cut-out.'),
            array('name' => 'Sewing Machine', 'price' => 'RM 10 / day', 'img' => 'img/tool_sewing.jpg', 'desc' => 'Hem trousers, fix tears and try upcycling clothes.'),
            array('name' => 'Paint Roller Kit', 'price' => 'RM 4 / day', 'img' => 'img/tool_paintroller.jpg', 'desc' => 'Roller, tray and brushes for touch-ups and projects.'),
            array('name' => 'Garment Steamer', 'price' => 'RM 4 / day', 'img' => 'img/tool_steamer.jpg', 'desc' => 'Removes creases fast for interviews, presentations and events.'),
        ),
    );

    /* Search: the form below sends the search words in the URL
       (e.g. catalog.php?search=drill), so we read them from $_GET.
       trim() removes spaces the user may have typed at the start or end. */
    $search = '';
    if (isset($_GET['search'])) {
        $search = trim($_GET['search']);
    }

    /* Count how many tool names contain the search words.
       stripos() finds text without caring about upper/lower case,
       and returns false when the text is not found. */
    $matchCount = 0;
    if ($search != '') {
        foreach ($catalogue as $category => $items) {
            foreach ($items as $item) {
                if (stripos($item['name'], $search) !== false) {
                    $matchCount++;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tool Catalogue - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed tool catalogue">
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
                <li><a href="catalog.php" class="active">Tool Catalogue</a></li>
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
        <h1 class="section-title">Tool Catalogue</h1>
        <p class="section-lead">Reserve a tool online, then collect it from the ShareShed store on campus.</p>

        <!-- Search box: method="get" puts the search words in the URL -->
        <form action="catalog.php" method="get" class="search-bar">
            <input type="text" name="search" placeholder="Search for a tool, e.g. drill" value="<?php echo h($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
            <?php if ($search != ''): ?>
                <a href="catalog.php" class="btn btn-outline">Clear</a>
            <?php endif; ?>
        </form>

        <?php if ($search != '' && $matchCount == 0): ?>
            <div class="alert alert-error">Sorry, no tool matches "<?php echo h($search); ?>". Try another word.</div>
        <?php elseif ($search != ''): ?>
            <div class="alert alert-success">Found <?php echo $matchCount; ?> tool(s) matching "<?php echo h($search); ?>".</div>
        <?php endif; ?>

        <?php
            /* Loop through each category, then loop through its items.
               $category will be the array KEY (e.g. "Power Tools") and
               $items will be the array of tools inside it. */
            foreach ($catalogue as $category => $items) {
                echo '<div class="category-block">';
                echo '<h2 class="section-title">' . h($category) . '</h2>';
                echo '<div class="card-grid">';

                foreach ($items as $item) {
                    /* If this tool matches the search, give its card the
                       "card-found" class so CSS draws the dark brown border */
                    if ($search != '' && stripos($item['name'], $search) !== false) {
                        echo '<div class="card card-found">';
                    } else {
                        echo '<div class="card">';
                    }
                    /* If the photo file hasn't been added to img/ yet,
                       file_exists() is false and we show the placeholder instead */
                    if (file_exists($item['img'])) {
                        echo '<img src="' . h($item['img']) . '" alt="' . h($item['name']) . '">';
                    } else {
                        echo '<img src="img/placeholder.svg" alt="' . h($item['name']) . '">';
                    }
                    echo '<div class="card-body">';
                    echo '<h3>' . h($item['name']) . '</h3>';
                    echo '<p>' . h($item['desc']) . '</p>';
                    echo '<p class="card-price">' . h($item['price']) . '</p>';
                    echo '<div class="card-footer">';
                    /* Borrowing is an Assignment 2 feature, so the button is disabled for now */
                    echo '<button type="button" class="btn btn-primary btn-block" title="Coming in Assignment 2" disabled>Borrow This Tool</button>';
                    echo '</div></div></div>';
                }

                echo '</div></div>';
            }
        ?>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
