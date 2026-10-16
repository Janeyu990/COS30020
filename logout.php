<?php
    /* logout.php
       Clears everything stored in the session (so isLoggedIn() becomes
       false again) and sends the browser back to the homepage. */

    require_once 'functions.php';

    $_SESSION = array();
    session_destroy();

    header('Location: index.php');
    exit;
?>
