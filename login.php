<?php
    require_once 'functions.php';

    $error = '';

    /* login.php is "self-calling": the form on this same page submits
       back to itself, and this code at the top handles the submission
       before any HTML is printed. */
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = findUserByEmail($email);

        if ($user !== null && password_verify($password, $user['Password'])) {
            $_SESSION['user_email'] = $user['Email'];
            $_SESSION['user_first_name'] = $user['First Name'];
            $_SESSION['user_last_name'] = $user['LastName'];
            header('Location: main_menu.php');
            exit;
        } else {
            $error = 'Incorrect email or password. Please try again.';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed login">
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
        <div class="form-wrap">
            <h2>Log In</h2>
            <p class="section-lead">New to ShareShed? <a href="registration.php">Register an account</a>.</p>

            <?php if ($error != ''): ?>
                <div class="alert alert-error"><?php echo h($error); ?></div>
            <?php elseif (isset($_GET['registered'])): ?>
                <div class="alert alert-success">Account created! You can log in now.</div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="registration.php" class="btn btn-outline">Register</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 ShareShed &mdash; a COS30020 student project. <a href="about.php">About this project</a></p>
    </footer>

    <!-- Back to top button (shown by js/script.js after scrolling down) -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top"><svg class="back-to-top-icon" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>

    </body>
</html>
