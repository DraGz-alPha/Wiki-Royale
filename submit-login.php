<?php
    require 'connect.php';

    session_start();

    if (isset($_POST['email'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }
    if (isset($_POST['password'])) {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    $query = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
    $statement = $db->prepare($query);
    $statement->execute();
    $user = $statement->fetch();

    if ($user == null) {
        echo 'Email or password is incorrect';
    }
    else {
        $_SESSION['user'] = $user['UserID'];
        header("Location: index.php");
    }
?>