<?php
    /* Author: Dustin Martens
       Date: March 22nd 2019
       Purpose: Wiki Royale home page, contains a list of cards and their respective details.
    */
    require 'authenticate.php';
    require 'connect.php';
    
    $orderOptions = ['Name', 'ArenaLevel', 'ElixirCost', 'Type', 'Rarity'];

    // Sorting functionality
    if (isset($_POST['sort'])) {
        $order = filter_input(INPUT_POST, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    else
    {
        $order = $orderOptions[0];
    }

    $queryCards = "SELECT CardID, Name, Rarity, Type, ElixirCost, HitSpeed, Speed, Targets, AttackRange, Lifetime, ArenaLevel, SpawnSpeed, Description, Radius, Count 
                   FROM cards 
                   ORDER BY $order";
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
    <link href="https://fonts.googleapis.com/css?family=Germania+One" rel="stylesheet"> 
</head>
<body>
    <header>
        <h1>Wiki Royale</h1>
        <div>
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Members</a></li>
                <li><a href="add-card.php">Create Card</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>
        </div>

        <form action="index.php" method="post">
            <label for="sort">Sort by:</label>
            <select id="sort" name="sort">
                <?php foreach ($orderOptions as $orderOption): ?>
                    <?php if ($orderOption == $order): ?>
                        <option selected><?=$orderOption?></option>
                    <?php else: ?>
                        <option><?=$orderOption?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
            <input type="submit" value="Sort" />
        </form>

        <div id="wrapper">
            <?php foreach ($cards as $card): ?>
                <div class="card">
                    <img src="img/<?=$card['Name']?>.png" alt="<?=$card['Name']?>" width="100" />
                    <h1><?=$card['Name']?></h1> 
                    <h3><?=$card['Rarity']?></h3>
                    <h5><?=$card['Type']?></h5>
                    <p class="card-description"><?=$card['Description']?></p>

                    <div class="card-content">
                        <?php if ($card['HitSpeed']): ?>
                            <p><img class="card-content-img" src="img/card-details/HitSpeed.png" alt=""> Hit Speed ............... <?=$card['HitSpeed']?> sec</p>
                        <?php endif ?>
                        <?php if ($card['Speed']): ?>
                            <p><img class="card-content-img" src="img/card-details/Speed.png" alt=""> Speed ............... <?=$card['Speed']?></p>
                        <?php endif ?>
                            <p><img class="card-content-img" src="img/card-details/Targets.png" alt=""> Targets ............... <?=$card['Targets']?></p>
                        <?php if ($card['AttackRange']): ?>
                            <p><img class="card-content-img" src="img/card-details/AttackRange.png" alt=""> Attack Range ............... <?=$card['AttackRange']?></p>
                        <?php endif ?>
                        <?php if ($card['Lifetime']): ?>
                            <p><img class="card-content-img" src="img/card-details/Time.png" alt=""> Lifetime ............... <?=$card['Lifetime']?> sec</p>
                        <?php endif ?>
                        <?php if ($card['SpawnSpeed']): ?>
                            <p><img class="card-content-img" src="img/card-details/Time.png" alt=""> Spawn Speed ............... <?=$card['SpawnSpeed']?> sec</p>
                        <?php endif ?>
                        <?php if ($card['Radius']): ?>
                            <p><img class="card-content-img" src="img/card-details/Radius.png" alt=""> Radius ............... <?=$card['Radius']?></p>
                        <?php endif ?>
                        <?php if ($card['Count']): ?>
                            <p><img class="card-content-img" src="img/card-details/Count.png" alt=""> Count ............... <?=$card['Count']?></p>
                        <?php endif ?>
                    </div>
                    <h4 style="font-family: font-family: 'Germania One', cursive;">Unlocks at arena <?=$card['ArenaLevel']?></h4>
                    <p><a href="edit-card.php?card=<?=$card['CardID']?>">Edit</a></p>
                </div>
            <?php endforeach ?>
        </div>
        
    </header>
</body>
</html>