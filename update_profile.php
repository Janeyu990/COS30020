<?php
    require_once 'functions.php';
    requireLogin();

    $originalEmail = $_SESSION['user_email'];
    $errors = array();
    $success = false;

    /* Find which line in the file belongs to the logged-in user, so we
       can show their current details and know which line to overwrite
       if they save changes. */
    $allUsers = readRecords(USERS_FILE);
    $currentIndex = null;
    for ($i = 0; $i < count($allUsers); $i++) {
        if (strcasecmp($allUsers[$i]['Email'], $originalEmail) == 0) {
            $currentIndex = $i;
            break;
        }
    }

    if ($currentIndex === null) {
        header('Location: logout.php');
        exit;
    }

    $user = $allUsers[$currentIndex];

    /* Handle the form submission (Req-3: Update button saves changes) */
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {

        $firstName = trim($_POST['first_name']);
        $lastName  = trim($_POST['last_name']);
        $dob       = trim($_POST['dob']);
        $gender    = trim($_POST['gender']);
        $email     = trim($_POST['email']);
        $hometown  = trim($_POST['hometown']);

        if ($firstName == '' || $lastName == '' || $dob == '' || $gender == '' || $email == '' || $hometown == '') {
            $errors[] = 'All fields are required.';
        }
        if ($firstName != '' && !preg_match('/^[A-Za-z ]+$/', $firstName)) {
            $errors[] = 'First name may only contain letters and spaces.';
        }
        if ($lastName != '' && !preg_match('/^[A-Za-z ]+$/', $lastName)) {
            $errors[] = 'Last name may only contain letters and spaces.';
        }
        if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($email != '' && strcasecmp($email, $originalEmail) != 0 && findUserByEmail($email) !== null) {
            $errors[] = 'That email is already used by another account.';
        }

        if (count($errors) == 0) {
            $allUsers[$currentIndex] = array(
                'First Name' => $firstName,
                'LastName'   => $lastName,
                'StudentID'  => $user['StudentID'], // identity field, kept as-is
                'DOB'        => $dob,
                'Gender'     => $gender,
                'Email'      => $email,
                'Hometown'   => $hometown,
                'Password'   => $user['Password'], // password unchanged here
            );
            writeAllRecords(USERS_FILE, $allUsers);
            $_SESSION['user_email'] = $email;
            $user = $allUsers[$currentIndex];
            $success = true;
        }
    }

    /* Req-2: default avatar picked based on the stored gender */
    $gender = $user['Gender'];
    $defaultAvatar = (strcasecmp($gender, 'Male') == 0) ? 'profile_images/male.svg' : 'profile_images/female.svg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Profile - ShareShed</title>
    <meta charset="utf-8">
    <meta name="description" content="Update my ShareShed account">
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
            <h2>Update My Profile</h2>

            <?php if ($success): ?>
                <div class="alert alert-success">Your profile has been updated.</div>
            <?php elseif (count($errors) > 0): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $e) { echo '<li>' . h($e) . '</li>'; } ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="avatar-preview">
                <img src="<?php echo h($defaultAvatar); ?>" alt="Default profile picture" class="profile-photo">
                <div class="field-hint">Default avatar shown by gender (Req-2).</div>
            </div>

            <form method="POST" action="update_profile.php">
                <input type="hidden" name="action" value="update">
                <div class="field">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required value="<?php echo h($user['First Name']); ?>">
                </div>
                <div class="field">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required value="<?php echo h($user['LastName']); ?>">
                </div>
                <div class="field">
                    <label>Swinburne Student ID</label>
                    <input type="text" value="<?php echo h($user['StudentID']); ?>" disabled>
                    <div class="field-hint">Fixed to your account - can't be changed here.</div>
                </div>
                <div class="field">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required value="<?php echo h($user['DOB']); ?>">
                </div>
                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="Female" <?php echo (strcasecmp($gender, 'Female') == 0) ? 'selected' : ''; ?>>Female</option>
                        <option value="Male" <?php echo (strcasecmp($gender, 'Male') == 0) ? 'selected' : ''; ?>>Male</option>
                    </select>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required value="<?php echo h($user['Email']); ?>">
                </div>
                <div class="field">
                    <label for="hometown">Hometown</label>
                    <input type="text" id="hometown" name="hometown" required value="<?php echo h($user['Hometown']); ?>">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="main_menu.php" class="btn btn-secondary">Cancel</a>
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
