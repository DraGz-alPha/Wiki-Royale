<?php
    require 'authenticate.php';
    require 'connect.php';

    $create = isset($_POST['create']);
    $update = isset($_POST['update']);
    $delete = isset($_POST['delete']);

    $admin_create = isset($_POST['admin-create']);
    $admin_update = isset($_POST['admin-update']);
    $admin_delete = isset($_POST['admin-delete']);


    $formIsValid = true;
    $usernameSet = isset($_POST['username']);
    $emailSet = isset($_POST['email']);
    $passwordSet = isset($_POST['password']);
    $confirmPasswordSet = isset($_POST['confirm-password']);

    if ($usernameSet && $emailSet && $passwordSet && $confirmPasswordSet) {
        $userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (strlen($password) > 6 && strlen($confirmPassword) > 6) {

            if ($password != $confirmPassword) {
                $formIsValid = false;
                echo 'Passwords do not match!';
            }
        }
        else {
            $formIsValid = false;
            echo 'Passwords must be 7 or more characters.';
        }   
    }
    else {
        $formIsValid = false;
        echo 'All fields must be filled!';
    }

    
    if ($formIsValid) {
        if ($create || $admin_create) {
            $userExists = CheckIfUserExists($username, $email);

            if ($userExists == "User doesn't exist") {
                CreateUser($username, $email, $password, $admin_create);
            }
            else {
                echo $userExists;
            }
        }
     
        if ($update || $admin_update) {
            $userExists = CheckIfUserExists($username, $email);

            if ($userExists == "User doesn't exist") {
                UpdateUser($userID, $username, $email, $password, $admin_update);
            }
            else {
                echo $userExists;
            }
        }
    }
    if ($delete || $admin_delete) {
        $delete_query = "DELETE FROM users WHERE UserID = :userID";
        
        $delete_statement = $db->prepare($delete_query);
        $delete_statement->bindValue(':userID', $userID, PDO::PARAM_INT);
        $delete_statement->execute();
        header("Location: admin.php");
    }
    
    // Queries the database to ensure no user exists with the same information from the form.
    function CheckIfUserExists($username, $email) {
        require 'connect.php';

        $err_message = "User doesn't exist";

        $query_userExists = "SELECT Username, Email FROM users";
        $statement_userExists = $db->prepare($query_userExists);
        $statement_userExists->execute();
        $existing_users = $statement_userExists->fetchAll();

        // Assuming no user exists with the specified email address and username.
        $usernameExists = false;
        $emailExists = false;
        
        // Checking to see if a user exists with the specified username or email address.
        foreach ($existing_users as $existing_user) {
            if ($existing_user['Username'] == $username && $existing_user['Email'] == $email) {
                $err_message = "Username and email are already in use by another user.";
                break;
            }
            if ($existing_user['Username'] == $username) {
                $err_message = "The specified username is already taken.";
                break;
            }
            if ($existing_user['Email'] == $email) {
                $err_message = "The specified email address is already in use by another user.";
                break;
            }
        }

        return $err_message;
    }

    // Updates a specified user account based on the userID.
    function UpdateUser($userID, $username, $email, $password, $admin_update) {
        require 'connect.php';

        $query = "UPDATE users SET Username = :username, Email = :email, Password = :password WHERE UserID = :userID";

        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
        $statement->execute();

        if ($admin_update) {
            header("Location: admin.php");
        }
    }

    // Creates a new user account.
    function CreateUser ($username, $email, $password, $admin_create) {
        require 'connect.php';
        
        $CheckIfUserExists_Result = CheckIfUserExists($username, $email);

        if ($CheckIfUserExists_Result) {
            $query = "INSERT INTO users (Username, Email, Password, AccountType) VALUES (:username, :email, :password, :accountType)";

            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':accountType', 'U');
            $statement->execute();

            $insert_id = $db->lastInsertId();

            if (!$admin_create) {
                header("Location: admin.php");
            }
            else {
                header("Location: login.php");
            }
        } 
    }

?>