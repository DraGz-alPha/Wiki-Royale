<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
</head>
<body>
    <div>
        <form action="submit-account.php" method="post">
            <p>
                <label for="username">Username:</label>
                <input id="username" name ="username" type="text" />
            </p>
            <p>
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" />
            </p>
            <p>
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" />
            </p>
            <p>
                <label for="confirm-password">Confirm password:</label>
                <input id="confirm-password" name="confirm-password" type="password" />
            </p>
            <p>
                <input type="submit" name="create" value="Create Account" />
            </p>
        </form>
    </div>
</body>
</html>