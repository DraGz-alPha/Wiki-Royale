<?php
    require 'connect.php';
    session_start();
    $userLoggedIn = false;

    // If user is logged in, display welcome message at top of web page and set teh userLoggedIn variable to true.
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $loggedInUser = $statement_user->fetch();
        $userLoggedIn = true;
    }

    // If a username GET parameter is set, sanitize it and dassign the value to the username variable.
    if (isset($_GET['username'])) {
        $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    // Query the database with the username specified from the GET parameter.
    $query = "SELECT UserID FROM users WHERE Username = '$username'";
    $statement = $db->prepare($query);
    $statement->execute();
    $user = $statement->fetch();

    $userFound = true;

    // If a user is found in the database, query the cards table to retrieve the user's card collection.
    if ($user == null) {
        $userFound = false;
    }
    else {
        $userID = $user['UserID'];
        $queryCards = "SELECT * FROM cards WHERE UserID = '$userID'";
        $statement = $db->prepare($queryCards);
        $statement->execute();

        $cards = $statement->fetchAll();
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--If the searched user is found in the database, change the tab title to be the user's username-->
    <?php if ($userFound): ?>
        <title><?=$username?>'s Profile</title>
    <?php else: ?>
        <title>User not found</title>
    <?php endif ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="user-account.css">
    <script src="main.js"></script>
</head>
<body>
    <!--If the searched user is found in the database, return the associated information, otherwise display that the user doesn't exist in the database-->
    <?php if ($userFound): ?>
        <h1><?=$username?>'s account</h1>
        <div id="user-cards">
            <h4><?=$username?>'s card collection:</h4>

            <!--If the user created cards, display them on their profile, otherwise display "user doesn't have any cards yet!"-->
            <?php if ($cards != null): ?>
                <?php foreach ($cards as $card): ?>
                    <div style="border: 1px black solid; background-color: grey; width: 300px;">
                        <img src="img/<?=$card['Name']?>.png" alt="<?=$card['Name']?>" width="100" />

                        <h1><?=$card['Name']?></h1> 
                        <h3><?=$card['Rarity']?></h3>
                        <h5><?=$card['Type']?></h5>
                        <p class="card-description"><?=$card['Description']?></p>
                        <p><a href="edit-card.php?card=<?=$card['CardID']?>">Edit</a></p>
                        <p><a href="add-comment.php?card=<?=$card['CardID']?>">Comment</a></p>
                    </div>

                    <!--Returning comments for the given card-->
                    <?php $cardID = $card['CardID'] ?>
                    <?php $commentQuery = "SELECT * FROM comments WHERE CardID = $cardID ORDER BY Date_Posted DESC" ?>
                    <?php $comment_statement = $db->prepare($commentQuery) ?>
                    <?php $comment_statement->execute() ?>
                    <?php $comments = $comment_statement->fetchAll() ?>
                    <!--If the card has comments associated with it, display them, otherwise display nothing-->
                    <?php if ($comments != null): ?>
                        <?php foreach($comments as $comment): ?>
                            <!--Fetch the username associated with the specified comment-->
                            <?php $commentUserID = $comment['UserID']?>
                            <?php $usernameQuery = "SELECT username FROM users WHERE UserID = $commentUserID" ?>
                            <?php $commentUsername_statement = $db->prepare($usernameQuery)?>
                            <?php $commentUsername_statement->execute() ?>
                            <?php $commentUsername = $commentUsername_statement->fetch() ?>

                            <h4><?=$commentUsername['username']?></h4>
                            <p>Rating: <?php for ($i = 0; $i < $comment['Rating']; $i++): ?><img src="img/comment/Star.jpg" alt="" width="25"><?php endfor ?></p>
                            <p>Content: <?=$comment['Content']?></p>
                            <p>Posted on: <?=date("F d, Y", strtotime($comment['Date_Posted']))?><p>

                            <!--If the currently logged in user is an administrator, then provide update and delete options for each comment-->
                            <?php if ($loggedInUser['AccountType'] == 'A'): ?>
                                <form id="" action="submit-comment.php" method="post">
                                <input type="submit" name="delete" value="Delete" onclick=" return confirm('Are you sure you wish to delete this card?')" />
                                <input type="hidden" name="commentID" value=<?=$comment['CommentID']?> />
                                <input type="hidden" name="username" value=<?=$username?> />
                            <?php endif ?>
                            
                            <h4>___________</h4>
                        <?php endforeach ?>
                    <?php endif ?>  
                    <!--Finished returning card comments-->

                <?php endforeach ?>
            <?php else: ?>
                <p><?=$username?> doesn't have any cards yet!</p>
            <?php endif ?>
        </div>
    <?php else: ?>
        <p>The specified user doesn't exist</p>
    <?php endif ?>
</body>
</html>