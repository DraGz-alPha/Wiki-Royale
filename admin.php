<?php
    require 'connect.php';
    session_start();

    $adminUser = false;

    if (isset($_SESSION['user']) && $_SESSION['user'] == 1) {

        $adminUser = true;
        $query = "SELECT * FROM users";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
    }  
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <?php if ($adminUser): ?>

        <form action="submit-user.php" method="post">
            
        </form>

        <table>
            <tr>
                <th></th>
                <th>UserID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Country</th>
                <th>Favourite Card</th>
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
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p>Only Administrators have access to this page</p>
    <?php endif ?>
</body>
</html>