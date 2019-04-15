<?php
    session_start();
    require 'connect.php';
    $validCard = false;
    $userLoggedIn = false;

    if (isset($_SESSION['user'])) {
        $user_sessionID = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_sessionID";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();

        $userLoggedIn = true;
    }

    if (isset($_GET['card'])) {
        $cardID = filter_input(INPUT_GET, 'card', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM cards WHERE CardID = $cardID";
        $statement = $db->prepare($query);
        $statement->execute();

        $card = $statement->fetch();

        if ($card != null) {
            $validCard = true;
            $cardOwner = $card['UserID'];
            // If a specified card is valid, retrieve the username associated with that card.
            $usernameQuery = "SELECT username FROM users WHERE UserID = '$cardOwner'";
            $usernameStatement = $db->prepare($usernameQuery);
            $usernameStatement->execute();

            $result = $usernameStatement->fetch();
            $username = $result['username'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>

    <!--Include CKEditor-->
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
    <?php if ($validCard && $userLoggedIn): ?>
        <form action="submit-comment.php" method="post">
            <p>Commenting on <?=$username?>'s card: <?=$card['Name']?></p>
            <p>
                <label for="Rating">Rating:</label>
                <input id="rating" name="rating" type="number" min="1" max="5" value="5" />
            </p>
            <p>
                <label for="content">Content:</label>
                <textarea id="content" name="content"></textarea>
                <script>CKEDITOR.replace('content')</script>
                <input type="hidden" name="username" value=<?=$username?> />
                <input type="hidden" name="cardID" value=<?=$cardID?> />
                <input type="submit" name="create" value="Create"/>
            </p>

        </form>
    <?php else: ?>
        <p>That card doesn't exist!</p>
    <?php endif ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>