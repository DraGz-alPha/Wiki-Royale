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
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Members</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
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
</body>
</html>