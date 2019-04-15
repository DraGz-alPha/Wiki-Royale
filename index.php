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
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" media="screen" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Germania+One" rel="stylesheet"> 
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
        <select id="view" name="view">
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
                <?php if ($card['CardImage']): ?>
                    <img src="img/<?=$card['CardImage']?>" alt="<?=$card['Name']?>" />
                <?php else: ?>
                    <p>No Image</p>
                <?php endif ?>

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

                    <h4 style="font-family: 'Germania One', cursive;">Unlocks at arena <?=$card['ArenaLevel']?></h4> 
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