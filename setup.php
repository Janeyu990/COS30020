<?php
    /* setup.php
       Included by db.php after it has connected to the database.
       1. Creates the 5 tables required by Assignment 2, each only if it
          does not already exist (CREATE TABLE IF NOT EXISTS).
       2. Fills each table with sample data, but ONLY when that table is
          still empty, so refreshing a page never adds duplicate rows.
       Every insert uses a prepared statement, and every password is
       stored as a hash from password_hash(), never as plain text.
    */

    /* ---------- 1. Create the tables ---------- */

    // user_table: one row per person (members and the admin)
    $conn->query("CREATE TABLE IF NOT EXISTS user_table (
        email         VARCHAR(50)  NOT NULL,
        first_name    VARCHAR(50)  NOT NULL,
        last_name     VARCHAR(50)  NOT NULL,
        dob           DATE         NULL,
        gender        VARCHAR(6)   NOT NULL,
        hometown      VARCHAR(50)  NOT NULL,
        profile_image VARCHAR(100) NULL,
        PRIMARY KEY (email)
    ) ENGINE=InnoDB");

    // account_table: login details. The foreign key means that if a
    // user's email changes or the user is deleted in user_table, MySQL
    // updates/deletes the matching account row automatically.
    $conn->query("CREATE TABLE IF NOT EXISTS account_table (
        email    VARCHAR(50)  NOT NULL,
        password VARCHAR(255) NOT NULL,
        type     VARCHAR(5)   NOT NULL,
        PRIMARY KEY (email),
        FOREIGN KEY (email) REFERENCES user_table(email)
            ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB");

    // smart_feature_table: the tools behind the Smart Feature page
    $conn->query("CREATE TABLE IF NOT EXISTS smart_feature_table (
        id               INT          NOT NULL AUTO_INCREMENT,
        item_name        VARCHAR(50)  NOT NULL,
        item_category    VARCHAR(50)  NOT NULL,
        item_image       VARCHAR(100) NULL,
        description_file VARCHAR(100) NULL,
        status           VARCHAR(10)  NOT NULL DEFAULT 'pending',
        PRIMARY KEY (id)
    ) ENGINE=InnoDB");

    // activity_table: members who registered for a workshop
    $conn->query("CREATE TABLE IF NOT EXISTS activity_table (
        id             INT         NOT NULL AUTO_INCREMENT,
        email          VARCHAR(50) NOT NULL,
        first_name     VARCHAR(50) NOT NULL,
        last_name      VARCHAR(50) NOT NULL,
        date           DATE        NULL,
        time           TIME        NULL,
        contact_number VARCHAR(15) NULL,
        status         VARCHAR(10) NOT NULL DEFAULT 'pending',
        PRIMARY KEY (id)
    ) ENGINE=InnoDB");

    // community_table: projects members share on the Showcase page
    $conn->query("CREATE TABLE IF NOT EXISTS community_table (
        id                 INT          NOT NULL AUTO_INCREMENT,
        first_name         VARCHAR(50)  NOT NULL,
        last_name          VARCHAR(50)  NOT NULL,
        contribution_image VARCHAR(100) NULL,
        related_activity   VARCHAR(50)  NOT NULL,
        status             VARCHAR(10)  NOT NULL DEFAULT 'pending',
        PRIMARY KEY (id)
    ) ENGINE=InnoDB");

    /* ---------- 2. Sample data ---------- */

    /* Returns true if the table has no rows yet. The table name comes
       from our own code below, never from the user, so it is safe to
       put straight into the query. */
    function tableIsEmpty($conn, $table) {
        $result = $conn->query("SELECT COUNT(*) AS total FROM $table");
        $row = $result->fetch_assoc();
        return $row['total'] == 0;
    }

    // user_table + account_table are filled together, because every
    // account row needs a matching user row first (foreign key).
    if (tableIsEmpty($conn, 'user_table')) {
        // email, first name, last name, dob, gender, hometown, photo, password, type
        $users = array(
            array('admin@swin.edu.my', 'ShareShed', 'Admin', null, 'Other', 'Kuching', 'img/default_avatar.svg', 'admin', 'admin'),
            array('104395810@students.swinburne.edu.my', 'Jane', 'Yu', '2006-12-04', 'Female', 'Kuching', 'profile_images/female.svg', 'password123', 'user'),
            array('102345671@students.swinburne.edu.my', 'Nur Aisyah', 'Rahman', '2005-03-14', 'Female', 'Miri', 'profile_images/female.svg', 'password123', 'user'),
            array('102345682@students.swinburne.edu.my', 'Muhammad Farid', 'Hassan', '2004-08-22', 'Male', 'Sibu', 'profile_images/male.svg', 'password123', 'user'),
            array('102345704@students.swinburne.edu.my', 'Ahmad Irfan', 'Zulkifli', '2005-11-02', 'Male', 'Bintulu', 'profile_images/male.svg', 'password123', 'user')
        );

        $userStmt = $conn->prepare('INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $accountStmt = $conn->prepare('INSERT INTO account_table (email, password, type) VALUES (?, ?, ?)');

        foreach ($users as $u) {
            $userStmt->bind_param('sssssss', $u[0], $u[1], $u[2], $u[3], $u[4], $u[5], $u[6]);
            $userStmt->execute();

            $hash = password_hash($u[7], PASSWORD_DEFAULT);
            $accountStmt->bind_param('sss', $u[0], $hash, $u[8]);
            $accountStmt->execute();
        }
        $userStmt->close();
        $accountStmt->close();
    }

    if (tableIsEmpty($conn, 'smart_feature_table')) {
        // name, category, image, PDF description, status
        // The PDF paths are left empty until the PDFs are added to
        // smart_feature_description/ (Task 3.4 / 5.1).
        $tools = array(
            array('Cordless Drill Driver', 'Power Tools', 'img/tool_drill.jpg', null, 'approved'),
            array('Orbital Sander', 'Power Tools', 'img/tool_sander.jpg', null, 'approved'),
            array('Lawn Mower', 'Garden', 'img/tool_mower.jpg', null, 'approved'),
            array('Pruning Shears', 'Garden', 'img/tool_pruner.jpg', null, 'approved'),
            array('Heat Gun', 'Power Tools', 'img/tool_heatgun.jpg', null, 'pending')
        );

        $stmt = $conn->prepare('INSERT INTO smart_feature_table (item_name, item_category, item_image, description_file, status) VALUES (?, ?, ?, ?, ?)');
        foreach ($tools as $t) {
            $stmt->bind_param('sssss', $t[0], $t[1], $t[2], $t[3], $t[4]);
            $stmt->execute();
        }
        $stmt->close();
    }

    if (tableIsEmpty($conn, 'activity_table')) {
        // email, first name, last name, date, time, contact, status
        $registrations = array(
            array('104395810@students.swinburne.edu.my', 'Jane', 'Yu', '2026-12-05', '10:00:00', '0123456789', 'approved'),
            array('102345671@students.swinburne.edu.my', 'Nur Aisyah', 'Rahman', '2026-12-19', '13:00:00', '0198765432', 'pending'),
            array('102345682@students.swinburne.edu.my', 'Muhammad Farid', 'Hassan', '2026-12-06', '14:00:00', '0134567890', 'approved'),
            array('102345704@students.swinburne.edu.my', 'Ahmad Irfan', 'Zulkifli', '2026-12-13', '11:00:00', '0167654321', 'rejected')
        );

        $stmt = $conn->prepare('INSERT INTO activity_table (email, first_name, last_name, date, time, contact_number, status) VALUES (?, ?, ?, ?, ?, ?, ?)');
        foreach ($registrations as $r) {
            $stmt->bind_param('sssssss', $r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6]);
            $stmt->execute();
        }
        $stmt->close();
    }

    if (tableIsEmpty($conn, 'community_table')) {
        // first name, last name, photo, related workshop, status
        // (the same six contributions that were in data/community.txt)
        $contributions = array(
            array('Aisyah', 'Rahman', 'img/community/contrib1.jpg', 'Furniture Upcycling 101', 'approved'),
            array('Marcus', 'Tan', 'img/community/contrib2.jpg', 'Bicycle Tune-Up Basics', 'approved'),
            array('Priya', 'Nathan', 'img/community/contrib3.jpg', 'Composting for Beginners', 'approved'),
            array('Farid', 'Hassan', 'img/community/contrib4.jpg', 'Mend & Sew Sunday', 'approved'),
            array('Grace', 'Lim', 'img/community/contrib5.jpg', 'Basic Power Drill Safety', 'pending'),
            array('Daniel', 'Wong', 'img/community/contrib6.jpg', 'Tool Care & Sharpening', 'pending')
        );

        $stmt = $conn->prepare('INSERT INTO community_table (first_name, last_name, contribution_image, related_activity, status) VALUES (?, ?, ?, ?, ?)');
        foreach ($contributions as $c) {
            $stmt->bind_param('sssss', $c[0], $c[1], $c[2], $c[3], $c[4]);
            $stmt->execute();
        }
        $stmt->close();
    }
?>
