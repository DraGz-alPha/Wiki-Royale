<?php
    require 'connect.php';

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
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <?php if ($userFound): ?>
        <h1><?=$username?>'s account</h1>
        <div id="user-cards">
            <h4><?=$username?>'s card collection:</h4>
            <?php if ($cards != null): ?>
                <?php foreach ($cards as $card): ?>
                    <img src="img/<?=$card['Name']?>.png" alt="<?=$card['Name']?>" width="100" />

                    <h1><?=$card['Name']?></h1> 
                    <h3><?=$card['Rarity']?></h3>
                    <h5><?=$card['Type']?></h5>
                    <p class="card-description"><?=$card['Description']?></p>
                    <p><a href="edit-card.php?card=<?=$card['CardID']?>">Edit</a></p>
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