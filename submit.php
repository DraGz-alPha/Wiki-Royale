<?php
    require 'connect.php';

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO users (Username, Email, Password) VALUES (:username, :email, :password)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();

    echo "$username";
    echo "$email";
    echo "$password";
    echo "hello";

    $insert_id = $db->lastInsertId();

    header("Location: index.php");
?>