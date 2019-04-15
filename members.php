<?php
    require 'connect.php';
    session_start();

    $userLoggedIn = false;

    if (isset($_SESSION['user'])) {
        $user_sessionID = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_sessionID";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();

        $userLoggedIn = true;
    }

    $userExists = false;
    
    if (isset($_POST['user-search'])) {
        $searchText = filter_input(INPUT_POST,'user-search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $returnedUsersQuery = "SELECT UserID, Username FROM users WHERE Username LIKE '%$searchText%' AND UserID != '$user_sessionID'";
        $statement_returnedUsers = $db->prepare($returnedUsersQuery);
        $statement_returnedUsers->execute();
        
        $returnedUsers = $statement_returnedUsers->fetchAll();

        if ($returnedUsers != null) {
            $userExists = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Members</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <script src="main.js"></script>
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
    <?php if ($userLoggedIn): ?>
        <form action="members.php" method="post">
            <label for="user-search">User Account:</label>
            <input id="user-search" name="user-search" type="text">
            <input type="submit" value="Search">
        </form>

        <div id="user=profiles">
            <?php if ($userExists): ?>
                <table>
                    <tr>
                        <td>Username<td>
                    </tr>
                    <?php foreach ($returnedUsers as $returnedUser): ?>
                        <tr>
                            <td><a href="user-account.php?username=<?=$returnedUser['Username']?>"><?=$returnedUser['Username']?></a></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            <?php else: ?>
                <p>Sorry, no users match your search.</p>
            <?php endif ?>
        </div>
    <?php else: ?>
        <p>Sorry, this page is for members only!</p>
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