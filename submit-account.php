<?php
    require 'authenticate.php';
    require 'connect.php';

    $create = isset($_POST['create']);
    $update = isset($_POST['update']);
    $delete = isset($_POST['delete']);

    $admin_create = isset($_POST['admin-create']);
    $admin_update = isset($_POST['admin-update']);
    $admin_delete = isset($_POST['admin-delete']);

    // Assuming all form data is valid.
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

    // If all form data is valid, allow access to CRUD functionality.
    if ($formIsValid) {
        if ($create || $admin_create) {
            $userExists = CheckIfUserExists($db, $username, $email);
            
            if ($userExists == "User doesn't exist") {
                // If user decided to upload a profile picture, commit the image name to the users table in the database.
                $profilePictureFileName = null;
                
                if ($_FILES["profile-image"]["name"] != null) {
                    $target_dir = "img/Profile_Pics/";
                    $target_file = $target_dir . basename($_FILES["profile-image"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["profile-image"]["size"] > 500000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["profile-image"]["tmp_name"], $target_file)) {
                            echo "The file ". basename( $_FILES["profile-image"]["name"]). " has been uploaded.";
                            $profilePictureFileName = basename( $_FILES["profile-image"]["name"]);
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }

                CreateUser($db, $username, $email, $password, $profilePictureFileName, $admin_create);
            }
            else {
                echo $userExists;
            }
        }
        
        // Checking if user is updating their profile.
        if ($update || $admin_update) {
            $userExists = CheckIfUserExists($db, $username, $email);

            if ($userExists == "User doesn't exist") {

                UpdateUser($db, $userID, $username, $email, $password, $profilePictureFileName, $admin_update);
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
    function CheckIfUserExists($db, $username, $email) {

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
    function UpdateUser($db, $userID, $username, $email, $password, $profilePictureFileName, $admin_update) {

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
    function CreateUser ($db, $username, $email, $password, $profilePictureFileName, $admin_create) {
        
        $CheckIfUserExists_Result = CheckIfUserExists($db, $username, $email);

        if ($CheckIfUserExists_Result) {

            if ($profilePictureFileName != null) {
                $query = "INSERT INTO users (Username, Email, Password, AccountType, ProfilePicture) VALUES (:username, :email, :password, :accountType, :profilePicture)";
            }
            else {
                $query = "INSERT INTO users (Username, Email, Password, AccountType) VALUES (:username, :email, :password, :accountType)";
            }

            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':accountType', 'U');

            // If the profile picture isn't null, upload it to the users table.
            if ($profilePictureFileName != null) {
                $statement->bindValue(':profilePicture', $profilePictureFileName);
            }
            $statement->execute();
            $insert_id = $db->lastInsertId();

            if ($admin_create) {
                header("Location: admin.php");
            }
            else {
                header("Location: login.php");
            }
        } 

        
    }



























    //Deleting image
    if (isset($_POST['deleteImage'])) {
        $update->bindvalue(':image', null);
        unlink($_POST['deleteImage']);
    }
?>