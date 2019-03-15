<?php
    define('DB_DSN','mysql:host=localhost;dbname=webdev_project');
    define('DB_USER','webdevuser');
    define('DB_PASS','gorgonzola7!');     
    
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>