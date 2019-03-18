<?php
    require 'connect.php';
    
    $queryCards = "SELECT CardID, Name, Rarity, Type, ElixirCost, HitSpeed, Speed, Targets, AttackRange, Lifetime, ArenaLevel, SpawnSpeed, Description FROM cards ORDER BY ElixirCost DESC";
    $statement = $db->prepare($queryCards);
    $statement->execute();

    $cards = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index.css">
    <script src="main.js"></script>
</head>
<body>
    <header>
        <h1>Wiki Royale</h1>
        <div>
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Contact</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>
        </div>

        <?php foreach ($cards as $card): ?>
            <div class="card">
                <h1><?=$card['Name']?></h1> 
                <h3><?=$card['Rarity']?></h3>
                <h5><?=$card['Type']?></h5>
                <p><?=$card['Description']?></p>
            </div>
        <?php endforeach ?>
        
    </header>
</body>
</html>