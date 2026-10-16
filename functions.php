<?php
    /* functions.php
       This file only holds PHP logic that every page needs to reuse:
       - starting the session and checking if someone is logged in
       - reading/writing our pipe-delimited text-file "database"
       It does NOT print any HTML. Every page writes its own full
       <!DOCTYPE html> / head / body — this file just gives them the
       PHP tools to work with, the same way we use built-in functions
       like round() or implode(), except these are ones we wrote ourselves.
    */

    session_start();

    // File locations - all inside the data folder as required by the brief
    define('DATA_DIR', __DIR__ . '/data');
    define('USER_DIR', DATA_DIR . '/User');
    define('USERS_FILE', USER_DIR . '/users.txt');
    define('ACTIVITIES_FILE', DATA_DIR . '/activities.txt');
    define('COMMUNITY_FILE', DATA_DIR . '/community.txt');
    define('ACTIVITY_REG_FILE', DATA_DIR . '/activity_registrations.txt');
    define('TUTORIALS_FILE', DATA_DIR . '/tutorials.txt');
    define('STUDENTS_FILE', DATA_DIR . '/students.txt'); // list of real Swinburne students allowed to register

    /* Escape a value before printing it into HTML, so a user typing
       something like <script> into a form can't break the page. */
    function h($value) {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    /* Returns true/false depending on whether the user is logged in.
       We know they're logged in because login.php stores their email
       in $_SESSION when the password matches. */
    function isLoggedIn() {
        return !empty($_SESSION['user_email']);
    }

    /* Sends a user back to the main menu if they try to open a page
       that needs login (like booking an activity) without being
       logged in first. */
    function requireLogin() {
        if (!isLoggedIn()) {
            header('Location: main_menu.php?login_required=1');
            exit;
        }
    }

    /* Reads a text file where each line looks like:
       Key:Value|Key:Value|Key:Value
       and turns it into an array of associative arrays, one per line,
       so we can loop through it with foreach like a normal array. */
    function readRecords($file) {
        $records = array();
        if (!file_exists($file)) {
            return $records; // no file yet = nobody has registered/booked yet
        }
        $handle = fopen($file, 'r');
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') continue; // skip blank lines
            $record = array();
            $fields = explode('|', $line); // split the line into Key:Value pieces
            for ($i = 0; $i < count($fields); $i++) {
                $pair = explode(':', $fields[$i], 2); // split only on the FIRST colon
                if (count($pair) == 2) {
                    $record[trim($pair[0])] = trim($pair[1]);
                }
            }
            $records[] = $record;
        }
        fclose($handle);
        return $records;
    }

    /* Adds one new record (an associative array) as a new line at the
       end of the file, in the Key:Value|Key:Value format required by
       the brief. Creates the folder first if it doesn't exist yet. */
    function appendRecord($file, $record) {
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); // auto-create the folder, e.g. data/User
        }
        $parts = array();
        foreach ($record as $key => $value) {
            $parts[] = $key . ':' . $value;
        }
        $line = implode('|', $parts);

        $handle = fopen($file, 'a'); // 'a' = append, adds to the end without erasing old lines
        fwrite($handle, $line . "\n");
        fclose($handle);
    }

    /* Overwrites the whole file with a new set of records. Used when a
       user updates their profile - we replace their one line but keep
       everybody else's the same. */
    function writeAllRecords($file, $records) {
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $handle = fopen($file, 'w'); // 'w' = overwrite from scratch
        foreach ($records as $record) {
            $parts = array();
            foreach ($record as $key => $value) {
                $parts[] = $key . ':' . $value;
            }
            fwrite($handle, implode('|', $parts) . "\n");
        }
        fclose($handle);
    }

    /* Looks through users.txt for one whose Email matches (not
       case-sensitive), used by login.php and the uniqueness check in
       process_registration.php. Returns null if nobody matches. */
    function findUserByEmail($email) {
        $users = readRecords(USERS_FILE);
        for ($i = 0; $i < count($users); $i++) {
            if (isset($users[$i]['Email']) && strcasecmp($users[$i]['Email'], $email) == 0) {
                return $users[$i];
            }
        }
        return null;
    }

    /* Tidies up a name before comparing it: removes spaces at both
       ends, squeezes double spaces into one, and makes it lowercase,
       so "  Wei  Jie " and "wei jie" count as the same name. */
    function normaliseName($name) {
        return strtolower(preg_replace('/\s+/', ' ', trim($name)));
    }

    /* Checks students.txt to see if this first name, last name and
       Student ID all belong to the SAME student. All three must match
       on one line - a correct ID with somebody else's name fails.
       Returns true if a matching student is found, false otherwise. */
    function isValidStudent($firstName, $lastName, $studentId) {
        foreach (readRecords(STUDENTS_FILE) as $student) {
            if (isset($student['FirstName'], $student['LastName'], $student['StudentID'])
                && normaliseName($student['FirstName']) === normaliseName($firstName)
                && normaliseName($student['LastName'])  === normaliseName($lastName)
                && $student['StudentID'] === $studentId) {
                return true;
            }
        }
        return false;
    }
?>
