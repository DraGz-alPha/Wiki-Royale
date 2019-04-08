<?php
    require 'connect.php';
    session_start();
    $userLoggedIn = false;

    // If an active session is in progress, query the users table and retrieve all information associated with that userID.
    if (isset($_SESSION['user'])) {
        $user_sessionID = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_sessionID";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();
        $user = $statement_user->fetch();

        echo "Welcome back " . $user['Username'];
        $userLoggedIn = true;

        // Query the cards table to retrieve the logged-in user's card collection.
        $queryCards = "SELECT * FROM cards WHERE UserID = $user_sessionID";
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
    <title>My Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>
    <!--If the user is logged in, display all page data, otherwise diplay an error message-->
    <?php if ($userLoggedIn): ?>
        <div id="index_top_nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Members</a></li> 
                <li><a href="add-card.php">Create Card</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>

        <div id="user-cards">
            <!--If the user created cards, display them on their profile, otherwise display "I don't have any cards yet :("-->
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
                    <!--If the card has comments associated with it, display them, otherwise display nothing-->
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
                <p>I don't have any cards yet :(</p>
            <?php endif ?>
        
    <?php else: ?>
        <p>You can't access the my account page if you're not logged in!</p>
        <img src="img/page_error/crying.gif" alt="">
        <audio autoplay>
            <source src="crying.mp3" type="audio/mpeg">
        </audio> 
    <?php endif ?>
</body>
</html>