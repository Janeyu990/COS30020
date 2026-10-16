<?php
    /* process_registration.php
       No HTML here either - this file only runs when the registration
       form is submitted. It validates everything, and only saves the
       new account if every rule passes. */

    require_once 'functions.php';

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: registration.php');
        exit;
    }

    $firstName = trim($_POST['first_name']);
    $lastName  = trim($_POST['last_name']);
    $studentId = trim($_POST['student_id']);
    $dob       = trim($_POST['dob']);
    $gender    = trim($_POST['gender']);
    $email     = trim($_POST['email']);
    $hometown  = trim($_POST['hometown']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    /* Fields we send back to pre-fill the form if there's an error -
       never the passwords, for basic security. */
    $repopulate = array(
        'first_name' => $firstName, 'last_name' => $lastName, 'student_id' => $studentId,
        'dob' => $dob, 'gender' => $gender, 'email' => $email, 'hometown' => $hometown,
    );

    /* $errors is keyed by field name (e.g. $errors['email']) so the
       registration page can show each message under its own input.
       Each field only keeps its FIRST problem, so the user sees one
       clear message per box instead of a pile of them. */
    $errors = array();

    /* Req-1a: all fields are mandatory */
    $requiredFields = array(
        'first_name'       => array($firstName, 'First name is required.'),
        'last_name'        => array($lastName,  'Last name is required.'),
        'student_id'       => array($studentId, 'Student ID is required.'),
        'dob'              => array($dob,       'Date of birth is required.'),
        'gender'           => array($gender,    'Please choose a gender.'),
        'email'            => array($email,     'Email is required.'),
        'hometown'         => array($hometown,  'Hometown is required.'),
        'password'         => array($password,  'Password is required.'),
        'confirm_password' => array($confirm,   'Please confirm your password.'),
    );
    foreach ($requiredFields as $field => $pair) {
        if ($pair[0] == '') {
            $errors[$field] = $pair[1];
        }
    }

    /* Req-1b: names may only contain letters and spaces */
    if (!isset($errors['first_name']) && !preg_match('/^[A-Za-z ]+$/', $firstName)) {
        $errors['first_name'] = 'First name may only contain letters and spaces.';
    }
    if (!isset($errors['last_name']) && !preg_match('/^[A-Za-z ]+$/', $lastName)) {
        $errors['last_name'] = 'Last name may only contain letters and spaces.';
    }

    /* Student ID must be exactly 9 digits. */
    if (!isset($errors['student_id']) && !preg_match('/^[0-9]{9}$/', $studentId)) {
        $errors['student_id'] = 'Student ID must be exactly 9 digits.';
    }

    /* The name and Student ID must match a real student in our
       students.txt list. Only checked once the names and ID are all in
       the right format. The message is the same whether the name or the
       ID is wrong, so nobody can guess one piece at a time. */
    if (!isset($errors['first_name']) && !isset($errors['last_name']) && !isset($errors['student_id'])
        && !isValidStudent($firstName, $lastName, $studentId)) {
        $errors['student_id'] = 'Your name and Student ID do not match our student records.';
    }

    /* One Student ID = one account: it can't already belong to
       another registered user. */
    if (!isset($errors['student_id'])) {
        foreach (readRecords(USERS_FILE) as $existingUser) {
            if (isset($existingUser['StudentID']) && $existingUser['StudentID'] === $studentId) {
                $errors['student_id'] = 'That Student ID is already linked to another account.';
                break;
            }
        }
    }

    /* Req-1c: email format, checked with PHP's built-in filter_var() */
    if (!isset($errors['email']) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    /* The email must be the student's own Swinburne student email,
       as stored next to their Student ID in students.txt
       (e.g. 104395810@students.swinburne.edu.my).
       Only checked once the name + Student ID have matched a student.
       strcasecmp() compares without caring about upper/lower case,
       and gives 0 when the two texts are the same. */
    if (!isset($errors['email']) && !isset($errors['student_id'])) {
        $studentEmail = '';
        foreach (readRecords(STUDENTS_FILE) as $student) {
            if (isset($student['StudentID'], $student['Email']) && $student['StudentID'] === $studentId) {
                $studentEmail = $student['Email'];
                break;
            }
        }
        if ($studentEmail == '' || strcasecmp($email, $studentEmail) != 0) {
            $errors['email'] = 'Please use your own Swinburne student email: ' . $studentId . '@students.swinburne.edu.my';
        }
    }

    /* Email must be unique too */
    if (!isset($errors['email']) && findUserByEmail($email) !== null) {
        $errors['email'] = 'An account with that email already exists. Please log in instead.';
    }

    /* Req-1d: password must be at least 8 characters with 1 number and 1 symbol */
    if (!isset($errors['password']) && !preg_match('/^(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
        $errors['password'] = 'Password must be at least 8 characters and include a number and a symbol.';
    }

    /* Req-1e: confirm password must match */
    if (!isset($errors['password']) && !isset($errors['confirm_password']) && $password != $confirm) {
        $errors['confirm_password'] = 'Password and Confirm Password do not match.';
    }

    /* Req-2: do not save if anything failed - send the user back with
       errors. http_build_query() turns the $errors array into
       errors[email]=...&errors[password]=... in the URL, and PHP
       rebuilds it as the array $_GET['errors'] on registration.php. */
    if (count($errors) > 0) {
        $repopulate['errors'] = $errors;
        header('Location: registration.php?' . http_build_query($repopulate));
        exit;
    }

    /* Req-3/4: everything passed - save the account.
       appendRecord() will auto-create the "User" folder if it's missing. */
    $record = array(
        'First Name' => $firstName,
        'LastName'   => $lastName,
        'StudentID'  => $studentId,
        'DOB'        => $dob,
        'Gender'     => $gender,
        'Email'      => $email,
        'Hometown'   => $hometown,
        'Password'   => password_hash($password, PASSWORD_DEFAULT), // never save plain text passwords
    );
    appendRecord(USERS_FILE, $record);

    /* Req-5: redirect to the login page on success */
    header('Location: login.php?registered=1');
    exit;
?>
