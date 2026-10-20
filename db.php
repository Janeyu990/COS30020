<?php
    /* db.php
       Connects to MySQL and returns the connection in $conn, so every
       page that includes functions.php can run queries straight away.
       - creates the ShareShed database the first time if it doesn't exist
       - then includes setup.php, which creates the 5 tables and fills
         them with sample data if they are still empty
       Change the 4 settings below to match your own MySQL login.
    */

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');          // put your MySQL root password here if you set one
    define('DB_NAME', 'shareshed_db');

    // Make mysqli throw an exception on any error instead of failing silently
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Connect to the server first (no database yet), because the
        // database itself might not exist on the very first run.
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
        $conn->set_charset('utf8mb4');

        $conn->query('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '`');
        $conn->select_db(DB_NAME);

        require_once __DIR__ . '/setup.php';
    } catch (mysqli_sql_exception $e) {
        // Show a short, readable message instead of a long PHP error page
        die('<p style="font-family:sans-serif;color:#b00020;">Could not connect to the database. '
            . 'Check that MySQL is running and the login in db.php is correct.<br>'
            . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>');
    }
?>
