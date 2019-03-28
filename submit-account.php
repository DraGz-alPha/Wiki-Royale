<?php
    require 'connect.php';

    // Testing to see if all form data has been posted to this php file. 
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Query to check if user already exists in the database.
        $query_userExists = "SELECT Username, Email FROM users";
        $statement_userExists = $db->prepare($query_userExists);
        $statement_userExists->execute();
        $existing_users = $statement_userExists->fetchAll();

        // Assuming no user exists with the specified email address and username.
        $usernameExists = false;
        $emailExists = false;
        
        // Checking to see if a user exists with the specified username or email address.
        foreach ($existing_users as $existing_user) {
            if ($existing_user['Email'] == $email) {
                $usernameExists = true;
            }
            if ($existing_user['Username'] == $username) {
                $emailExists = true;
            }
        }

        // If there isn't already a user in the database with the specified username.
        if ($usernameExists != true && $emailExists != true) {
            if ($password == $confirmPassword) {
                $query = "INSERT INTO users (Username, Email, Password) VALUES (:username, :email, :password)";
    
                $statement = $db->prepare($query);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':password', $password);
                $statement->execute();
    
                $insert_id = $db->lastInsertId();
    
                header("Location: login.php");
            }
            else {
                echo "Passwords don't match!";
            }
        }
        else {
            echo 'Sorry, that username or email is already in use!';
        }  
    }
    else {
        echo 'All fields must be filled!';
    }
?>