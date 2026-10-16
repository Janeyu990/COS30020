<?php
    require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="ShareShed account registration">
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
            <h2>Create Your ShareShed Account</h2>
            <p class="section-lead">
                ShareShed is for all Swinburne students - Student Village residents and
                anyone studying nearby. Your Swinburne Student ID is what the physical
                store's system uses to track which student borrowed which tool, so we
                ask for it here.
            </p>
            <p class="section-lead">Already have one? <a href="login.php">Log in instead</a>.</p>

            <?php
                /* process_registration.php sends errors back as an array
                   keyed by field name, e.g. $errors['email']. If there are
                   none (first visit), it's just an empty array. */
                $errors = (isset($_GET['errors']) && is_array($_GET['errors'])) ? $_GET['errors'] : array();
            ?>
            <?php if (count($errors) > 0): ?>
                <div class="alert alert-error" id="registerAlert">Please fix the fields marked in red below.</div>
            <?php endif; ?>

            <!-- novalidate turns off the browser's own pop-up bubbles, so our
                 JavaScript can show the messages under each field instead.
                 PHP still checks everything again on the server. -->
            <form method="POST" action="process_registration.php" id="registerForm" novalidate>
                <div class="field">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required class="<?php echo isset($errors['first_name']) ? 'input-error' : ''; ?>" value="<?php echo isset($_GET['first_name']) ? h($_GET['first_name']) : ''; ?>">
                    <div class="field-error" id="first_name_error"><?php echo isset($errors['first_name']) ? h($errors['first_name']) : ''; ?></div>
                </div>
                <div class="field">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required class="<?php echo isset($errors['last_name']) ? 'input-error' : ''; ?>" value="<?php echo isset($_GET['last_name']) ? h($_GET['last_name']) : ''; ?>">
                    <div class="field-error" id="last_name_error"><?php echo isset($errors['last_name']) ? h($errors['last_name']) : ''; ?></div>
                </div>
                <div class="field">
                    <label for="student_id">Swinburne Student ID</label>
                    <input type="text" id="student_id" name="student_id" required maxlength="9" class="<?php echo isset($errors['student_id']) ? 'input-error' : ''; ?>" value="<?php echo isset($_GET['student_id']) ? h($_GET['student_id']) : ''; ?>">
                    <div class="field-error" id="student_id_error"><?php echo isset($errors['student_id']) ? h($errors['student_id']) : ''; ?></div>
                    <div class="field-hint">9 digits. Your first name, last name and Student ID must match Swinburne's student records.</div>
                </div>
                <div class="field">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required class="<?php echo isset($errors['dob']) ? 'input-error' : ''; ?>" value="<?php echo isset($_GET['dob']) ? h($_GET['dob']) : ''; ?>">
                    <div class="field-error" id="dob_error"><?php echo isset($errors['dob']) ? h($errors['dob']) : ''; ?></div>
                </div>
                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="Female" <?php echo (!isset($_GET['gender']) || $_GET['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Male" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    </select>
                    <div class="field-error" id="gender_error"><?php echo isset($errors['gender']) ? h($errors['gender']) : ''; ?></div>
                </div>
                <div class="field">
                    <label for="email">Student Email</label>
                    <input type="text" id="email" name="email" required placeholder="e.g. 101202303@students.swinburne.edu.my" class="<?php echo isset($errors['email']) ? 'input-error' : ''; ?>" value="<?php echo isset($_GET['email']) ? h($_GET['email']) : ''; ?>">
                    <div class="field-error" id="email_error"><?php echo isset($errors['email']) ? h($errors['email']) : ''; ?></div>
                    <div class="field-hint">Use your Swinburne student email.</div>
                    <!-- <div class="field-hint">Plain text field per spec - still checked for valid email format on submit.</div> -->
                </div>
                <div class="field">
                    <label for="hometown">Hometown</label>
                    <input type="text" id="hometown" name="hometown" required class="<?php echo isset($errors['hometown']) ? 'input-error' : ''; ?>" value="<?php echo isset($_GET['hometown']) ? h($_GET['hometown']) : ''; ?>">
                    <div class="field-error" id="hometown_error"><?php echo isset($errors['hometown']) ? h($errors['hometown']) : ''; ?></div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="text" id="password" name="password" required class="<?php echo isset($errors['password']) ? 'input-error' : ''; ?>">
                    <div class="field-error" id="password_error"><?php echo isset($errors['password']) ? h($errors['password']) : ''; ?></div>
                    <div class="field-hint">At least 8 characters, including 1 number and 1 symbol.</div>
                </div>
                <div class="field">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="text" id="confirm_password" name="confirm_password" required class="<?php echo isset($errors['confirm_password']) ? 'input-error' : ''; ?>">
                    <div class="field-error" id="confirm_password_error"><?php echo isset($errors['confirm_password']) ? h($errors['confirm_password']) : ''; ?></div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
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
