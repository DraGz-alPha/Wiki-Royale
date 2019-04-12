<?php
    require 'connect.php';
    session_start();
    $userLoggedIn = false;
    $formValid = false;

    $create = isset($_POST['create']);
    $update = isset($_POST['update']);
    $delete = isset($_POST['delete']);

    $ratingSet = isset($_POST['rating']);
    $contentSet = isset($_POST['content']);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // If rating and content sections of the form are set, then put their values into variables.
    if ($ratingSet && $contentSet) {
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
        $content = $_POST['content'];
        $formValid = true;
    }

    // If user is logged in, display welcome message at top of web page.
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();
        $user = $statement_user->fetch();
        $userID = $user['UserID'];

        $userLoggedIn = true;
    }

    if ($userLoggedIn) {
        // Since form data doesn't need to be valid to delete a comment, it skips that check.
        if ($delete) {
            $commentID = filter_input(INPUT_POST, 'commentID', FILTER_SANITIZE_NUMBER_INT);
            DeleteComment($db, $commentID, $username);
        }

        // If the form is valid, checks done within the if statement can be performed.
        if ($formValid) {
            // If user is creating a comment, call the CreateComment function.
            if ($create) {
                $cardID = filter_input(INPUT_POST, 'cardID', FILTER_SANITIZE_NUMBER_INT);
                CreateComment($db, $cardID, $userID, $rating, $content, $username);
            }
            if ($update) {
                UpdateComment();
            }
        }
        else {
            echo 'Please check form data and try again.';
        }
    }
    else {
        echo 'This page is for members only!';
    }
    
    // Creates a comment for a specific user card.
    function CreateComment($db, $cardID, $userID, $rating, $content, $username) {

        $query= "INSERT INTO comments (UserID, CardID, Rating, Content, Date_Posted) VALUES (:userID, :cardID, :rating, :content, CURRENT_TIMESTAMP)";

        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':cardID', $cardID);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':content', $content);
        $statement->execute();
        $insert_id = $db->lastInsertId();

        header("Location: user-account.php?username=$username");
    }

    // Deletes a specified comment.
    function DeleteComment($db, $commentID, $username) {

        $query = "DELETE FROM comments WHERE CommentID = :CommentID";
        
        $statement = $db->prepare($query);
        $statement->bindValue(':CommentID', $commentID, PDO::PARAM_INT);
        $statement->execute();

        header("Location: user-account.php?username=$username");
    }
?>