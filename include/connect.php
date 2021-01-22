<?php
    // For production connection
    // $connection = parse_url(getenv("DATABASE_URL"));
    // $db = new PDO("pgsql:" . sprintf(
        // "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        // $connection["host"],
        // $connection["port"],
        // $connection["user"],
        // $connection["pass"],
        // ltrim($connection["path"], "/")
    // ));

    // For localhost connection
    define('DB_DSN', 'mysql:host=localhost;dbname=FamilyCookbook;charset=utf8');
    define('DB_USER','cookbookadmin');
    define('DB_PASS','gorgonzola7!');

    session_start();

    try{
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    }
    catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die();
    }
?>
