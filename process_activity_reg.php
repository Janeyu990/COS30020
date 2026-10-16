<?php
    /* process_activity_reg.php
       This file has no HTML at all - it only runs when the activity_reg.php
       form is submitted. It checks the data, saves it if everything is
       correct, then redirects the browser somewhere else. */

    require_once 'functions.php';
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: activities.php');
        exit;
    }

    $firstName = trim($_POST['first_name']);
    $lastName  = trim($_POST['last_name']);
    $contact   = trim($_POST['contact']);
    /* Always use the logged-in account's email (saved in the session by
       login.php), NOT what the form sent - the form value could be
       edited in the browser. This keeps every booking tied to the
       account that made it. */
    $email     = $_SESSION['user_email'];
    $datetime  = trim($_POST['activity_datetime']);
    $title     = trim($_POST['activity_title']);

    /* Don't trust the date/time sent by the form (someone could edit
       it in the browser). Look the workshop up in activities.txt and
       use ITS date and time instead. */
    $activity = null;
    foreach (readRecords(ACTIVITIES_FILE) as $a) {
        if ($a['Title'] == $title) {
            $activity = $a;
            break;
        }
    }
    if ($activity === null) {
        header('Location: activities.php');
        exit;
    }
    $datetime = date('Y-m-d\TH:i', strtotime($activity['Date'] . ' ' . $activity['Time']));

    /* We'll send these back to the form if something is wrong, so the
       user doesn't have to retype everything. */
    $repopulate = array(
        'first_name' => $firstName, 'last_name' => $lastName, 'contact' => $contact,
        'email' => $email, 'activity_datetime' => $datetime, 'activity_title' => $title,
    );

    $errors = array();

    /* Req-1a: every field is mandatory */
    foreach ($repopulate as $label => $value) {
        if ($value == '') {
            $errors[] = 'The field "' . $label . '" is required.';
        }
    }

    /* Req-1b: names may only contain letters and spaces */
    if ($firstName != '' && !preg_match('/^[A-Za-z ]+$/', $firstName)) {
        $errors[] = 'First name may only contain letters and spaces.';
    }
    if ($lastName != '' && !preg_match('/^[A-Za-z ]+$/', $lastName)) {
        $errors[] = 'Last name may only contain letters and spaces.';
    }

    /* Contact number: digits, spaces, + and - only */
    if ($contact != '' && !preg_match('/^[0-9+\-\s]{6,20}$/', $contact)) {
        $errors[] = 'Please enter a valid contact number.';
    }

    /* Req-1c: email format, checked using PHP's built-in filter_var() */
    if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    /* Uniqueness check: the same email can't register twice for the
       same activity title + date/time combination. */
    if (count($errors) == 0) {
        $existingRegistrations = readRecords(ACTIVITY_REG_FILE);
        foreach ($existingRegistrations as $existing) {
            $sameEmail = isset($existing['Email']) && strcasecmp($existing['Email'], $email) == 0;
            $sameSlot  = $existing['ActivityTitle'] == $title && $existing['ActivityDateTime'] == $datetime;
            if ($sameEmail && $sameSlot) {
                $errors[] = 'You have already registered for this activity session.';
                break;
            }
        }
    }

    /* Req-2: if anything is wrong, send the user back to the form with
       the error message and their answers, instead of saving. */
    if (count($errors) > 0) {
        $repopulate['error'] = implode(' ', $errors);
        header('Location: activity_reg.php?' . http_build_query($repopulate));
        exit;
    }

    /* Req-3/4: everything is valid - save the new record using the
       same Key:Value|Key:Value format as the other data files. */
    $record = array(
        'FirstName'        => $firstName,
        'LastName'         => $lastName,
        'Contact'          => $contact,
        'Email'            => $email,
        'ActivityDateTime' => $datetime,
        'ActivityTitle'    => $title,
    );
    appendRecord(ACTIVITY_REG_FILE, $record);

    /* Req-5: redirect somewhere useful on success */
    header('Location: activities.php?registered=1');
    exit;
?>
