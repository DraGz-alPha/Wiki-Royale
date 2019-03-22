<?php
    /* Author: Dustin Martens
       Date: March 21st 2019
       Purpose: Prompts user to enter login credentials to access exclusive features like editing and deleting posts.
    */
    
    define('ADMIN_LOGIN','ghostface');
    define('ADMIN_PASSWORD','killa');

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

        || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

        || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Wiki Royale"');

    exit("Access Denied: Username and password required.");

    }

?>

