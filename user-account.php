<?php
    require 'connect.php';
    session_start();
    $userLoggedIn = false;

    // If user is logged in, display welcome message at top of web page.
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $loggedInUser = $statement_user->fetch();
        $userLoggedIn = true;
    }

    if (isset($_GET['username'])) {
        $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    $query = "SELECT UserID FROM users WHERE Username = '$username'";
    $statement = $db->prepare($query);
    $statement->execute();
    $user = $statement->fetch();

    $userFound = true;

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
    <?php if ($userFound): ?>
        <title><?=$username?></title>
    <?php else: ?>
        <title>User not found</title>
    <?php endif ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="user-account.css">
    <script src="main.js"></script>
</head>
<body>
    <?php if ($userFound): ?>
        <h1><?=$username?>'s account</h1>
        <div id="user-cards">
            <h4><?=$username?>'s card collection:</h4>
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
                    <?php $commentQuery = "SELECT * FROM comments WHERE CardID = $cardID" ?>
                    <?php $comment_statement = $db->prepare($commentQuery) ?>
                    <?php $comment_statement->execute() ?>
                    <?php $comments = $comment_statement->fetchAll() ?>
                    <?php if ($comments != null): ?>
                        <?php foreach($comments as $comment): ?>
                            <h4>COMMENT</h4>
                            <p>Rating: <?php for ($i = 0; $i < $comment['Rating']; $i++): ?><img src="img/comment/Star.jpg" alt="" width="30"><?php endfor ?></p>
                            <p>Content: <?=$comment['Content']?></p>
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