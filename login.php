<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="login.css">
    <script src="login.js"></script>
</head>
<body>
    <div id="login_form">
        <form action="submit-login.php" method="post">
            <p>
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" />
            </p>
            <p>
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" />
            </p>
            <p>
                <input type="submit" value="Log In" />
            </p>
        </form>
    </div>

    <h5>Don't have an account yet? Create one <a href="create-account.php">here!</a></h5>
</body>
</html>