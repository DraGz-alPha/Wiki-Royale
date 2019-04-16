<?php
    require 'connect.php';
    session_start();

    $adminUser = false;
    $requestUserModification = false;
    $userLoggedIn = false;

    // If user is logged in, display welcome message at top of web page.
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();
        if ($user['AccountType'] == 'A') {
            $adminUser = true;
            $query = "SELECT * FROM users";
            $statement = $db->prepare($query);
            $statement->execute();
            $users = $statement->fetchAll();
        }
        $userLoggedIn = true;
    }

    if (isset($_GET['user'])) {
        $requestUserModification = true;
        $userID = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_NUMBER_INT);
        
        $requestedUserQuery = "SELECT UserID, Username, Email, Password FROM users WHERE UserID = '$userID'";
        $requestedUserStatement = $db->prepare($requestedUserQuery);
        $requestedUserStatement->execute();
        $requestedUser = $requestedUserStatement->fetch();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
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
    <?php if ($adminUser): ?>
        <table class="table">
            <tr>
                <th scope="col"></th>
                <th scope="col">UserID</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Country</th>
                <th scope="col">Favourite Card</th>
                <th scope="col">Account Type</th>
                <th></th>
            </tr>
            <?php foreach($users as $user): ?>
                <tr>   
                    <td><a href="user-account.php?username=<?=$user['Username']?>">View Profile</a></td>
                    <td><?=$user['UserID']?></td>
                    <td><?=$user['Username']?></td>
                    <td><?=$user['Email']?></td>
                    <td><?=$user['Password']?></td>
                    <?php if ($user['Country']): ?>
                        <td><?=$user['Country']?></td>
                    <?php else: ?>
                        <td>Null</td>
                    <?php endif ?>
                    <?php if ($user['FavouriteCardName']): ?>
                        <td><?=$user['FavouriteCardName']?></td>
                    <?php else: ?>
                        <td>Null</td>
                    <?php endif ?>
                    <?php if ($user['AccountType'] == "A"): ?>
                        <td>Admin</td>
                    <?php elseif ($user['AccountType'] == "U"): ?>
                        <td style="font-style: italic;">User</td>
                    <?php endif ?>
                    <td><a href="admin.php?user=<?=$user['UserID']?>">Modify</a></td>
                </tr>
            <?php endforeach ?>
            <td><a href="create-account.php">Create User</a></td>
        </table>

        <?php if ($requestUserModification): ?>
            <form action="submit-account.php" method="post">
                <p>UserID: <?=$requestedUser['UserID']?></p>
                <p>
                    <label for="username">Username:</label>
                    <input id="username" name ="username" type="text" value="<?=$requestedUser['Username']?>" />
                </p>
                <p>
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="email" value="<?=$requestedUser['Email']?>" />
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password" value="<?=$requestedUser['Password']?>" />
                </p>
                <p>
                    <label for="confirm-password">Confirm password:</label>
                    <input id="confirm-password" name="confirm-password" type="password" />
                </p>
                <p>
                    <label for="account-type">Account Type:</label>
                    <select id="account-type" name="account-type">
                        <option>User</option>
                        <option>Administrator</option>
                    </select>
                </p>
                <p>
                    <input type="hidden" name="userID" value=<?=$requestedUser['UserID']?> />
                    <input type="submit" name="admin-update" value="Update"/>
                    <input type="submit" name="admin-delete" value="Delete" onclick=" return confirm('Are you sure you wish to delete this user?')" />
                </p>
            </form>
        <?php endif ?>
    <?php else: ?>
        <p>Only Administrators have access to this page</p>
    <?php endif ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>