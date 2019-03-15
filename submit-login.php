<?php
    require 'connect.php';

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $query = "SELECT * FROM users WHERE Username = $username";
    $statement = $db->prepare($query);
    $statement->execute();
    
    header("Location: index.php");
?>