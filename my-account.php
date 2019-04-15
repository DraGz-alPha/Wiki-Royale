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
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" media="screen" href="my-account.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Wiki Royale</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-card.php">Create Card</a>
                    </li>
                </ul>
                <?php if ($userLoggedIn): ?> 
                    <!--Account drop-down list-->
                    <div class="btn-group">
                        <?php if ($user['AccountType'] == 'A'): ?>
                            <button type="button" class="btn btn-warning">Welcome, <?=$user['Username']?> [A]</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-warning">Welcome, <?=$user['Username']?></button>
                        <?php endif ?>
                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="my-account.php">My Account</a>
                            <?php if ($user['AccountType'] == 'A'): ?>
                                <a class="dropdown-item" href="admin.php">Admin Tools</a>
                            <?php endif ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Sign out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="btn btn-warning" href="login.php" role="button">Sign in</a>
                <?php endif ?>
            </div>
            <?php if ($userLoggedIn && $user['ProfilePicture'] != null): ?>
                <img src="img/Profile_Pics/<?=$user['ProfilePicture']?>" alt="<?=$user['ProfilePicture']?>" />
            <?php endif ?>
        </nav>
    </header>
    <!--If the user is logged in, display all page data, otherwise diplay an error message-->
    <?php if ($userLoggedIn): ?>
        <?php if (isset($user['ProfilePicture'])): ?>
            <img src="img/Profile_Pics/<?=$user['ProfilePicture']?>" alt="<?=$user['ProfilePicture']?>" />
            <form action="submit-account.php" method="post"> 
                <input type="submit" name="deleteImage" id="deleteImage" value="Delete" onclick=" return confirm('Are you sure you wish to delete your profile picture?')" />
            </form>
        <?php endif ?>

        <div id="wrapper">
            <div id="user-cards">
                <!--If the user created cards, display them on their profile, otherwise display "I don't have any cards yet :("-->
                <?php if ($cards != null): ?>
                    <?php foreach ($cards as $card): ?>
                        <div style="border: 1px black solid; background-color: grey; width: 300px;">
                        <?php if ($card['CardImage']): ?>
                            <img src="img/user_cards/<?=$card['CardImage']?>" alt="<?=$card['Name']?>" />
                        <?php else: ?>
                            <p>No Image</p>
                        <?php endif ?>

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
                                <?php $commentUserID = $comment['UserID']?>
                                <?php $usernameQuery = "SELECT username FROM users WHERE UserID = $commentUserID" ?>
                                <?php $commentUsername_statement = $db->prepare($usernameQuery)?>
                                <?php $commentUsername_statement->execute() ?>
                                <?php $commentUsername = $commentUsername_statement->fetch() ?>

                                <h4><?=$commentUsername['username']?></h4>
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
            </div>
        </div>
        
    <?php else: ?>
        <p>You can't access the my account page if you're not logged in!</p>
        <img src="img/page_error/crying.gif" alt="">
        <audio autoplay>
            <source src="crying.mp3" type="audio/mpeg">
        </audio> 
    <?php endif ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>