<?php
    require 'connect.php';

    session_start();

    if (isset($_SESSION['user'])) {
        $user_sessionID = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_sessionID";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();

        echo "Welcome back " . $user['Username'];
    }

    $queryCards = "SELECT * FROM cards WHERE UserID = $user_sessionID";
    $statement = $db->prepare($queryCards);
    $statement->execute();

    $cards = $statement->fetchAll();
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
        <?php foreach ($cards as $card): ?>
            <img src="img/<?=$card['Name']?>.png" alt="<?=$card['Name']?>" width="100" />

            <h1><?=$card['Name']?></h1> 
            <h3><?=$card['Rarity']?></h3>
            <h5><?=$card['Type']?></h5>
            <p class="card-description"><?=$card['Description']?></p>
            <p><a href="edit-card.php?card=<?=$card['CardID']?>">Edit</a></p>
        <?php endforeach ?>
    </div>
</body>
</html>