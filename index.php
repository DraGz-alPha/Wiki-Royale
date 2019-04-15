<?php
    /* Author: Dustin Martens
       Date: March 22nd 2019
       Purpose: Wiki Royale home page, contains a list of cards and their respective details.
    */
    require 'authenticate.php';
    require 'connect.php';

    session_start();

    $userLoggedIn = false;

    // If user is logged in, display welcome message at top of web page.
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();

        echo "Welcome back " . $user['Username'];
        $userLoggedIn = true;
    }

    $orderOptions = ['Name', 'ArenaLevel', 'ElixirCost', 'Type', 'Rarity'];
    $viewOptions = ['Simplistic', 'Detail'];
    $expandedDetails = false;

    // Sorting and view functionality
    if (isset($_POST['sort'])) {
        $order = filter_input(INPUT_POST, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $view = filter_input(INPUT_POST, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($view == 'Detail') {
            $expandedDetails = true;
        }
    }
    else
    {
        $order = $orderOptions[0];
        $view = $viewOptions[0];
    }

    $queryCards = "SELECT * FROM cards WHERE UserID = 1 ORDER BY $order";
    $statement = $db->prepare($queryCards);
    $statement->execute();

    $cards = $statement->fetchAll();

    // Retrieves all levels for the specified card.
    $queryCardLevels = "SELECT * FROM cardlevels";
    $statement_cardLevels = $db->prepare($queryCardLevels);
    $statement_cardLevels->execute();

    $cardLevels = $statement_cardLevels->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Wiki Royale</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Germania+One" rel="stylesheet"> 
</head>
<body>
    <header>
        <h1>Wiki Royale</h1>
        <div id="index_top_nav">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About</a></li>
                <?php if ($userLoggedIn && $user_session == 1): ?>
                    <li><a href="admin.php">Admin Tools</a></li>
                <?php endif ?>
                <li><a href="members.php">Members</a></li>
                <li><a href="add-card.php">Create Card</a></li>
                <?php if (!$userLoggedIn): ?>
                    <li><a href="login.php">Log In</a></li>
                <?php else: ?>
                    <li><a href="my-account.php">My Account</a></li>
                    <li><a href="logout.php">Log Out</a></li>                 
                    <!--<select>
                        <option>Your Account</option>
                        <option>My Cards</option>
                        <option>My Decks</option>
                        <option>Log Out</option>
                    </select>-->
                <?php endif ?>
            </ul>
        </div>
    </header>

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

            <label for="view">View:</label>
            <select id=" view" name="view">
                <?php foreach ($viewOptions as $viewOption): ?>
                    <?php if ($viewOption == $view): ?>
                        <option selected><?=$viewOption?></option>
                    <?php else: ?>
                        <option><?=$viewOption?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
            <input type="submit" value="Change" />
        </form>

        <div id="wrapper">
            <?php foreach ($cards as $card): ?>
                <div class="card">
                    <img src="img/<?=$card['Name']?>.png" alt="<?=$card['Name']?>" width="100" />

                    <?php if ($expandedDetails): ?>
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

                        <div id="card-levels">
                            <p><?=$cardLevels['Level']?></p>
                        </div>

                        <h4 style="font-family: font-family: 'Germania One', cursive;">Unlocks at arena <?=$card['ArenaLevel']?></h4> 
                    <?php endif ?>
                    
                    <!-- If user is logged in as system administrator, then provide an edit link for system cards. -->
                    <?php if (isset($_SESSION['user']) && $card['UserID'] == $user_session): ?>
                        <p><a href="edit-card.php?card=<?=$card['CardID']?>">Edit</a></p>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>