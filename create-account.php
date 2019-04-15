<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="login.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <form action="submit-account.php" method="post" enctype="multipart/form-data">
                <input type="text" id="username" name="username" placeholder="username" />
                <input type="email" id="email" name="email" placeholder="email" />
                <input type="password" id="password" name="password" placeholder="password" />
                <input type="password" id="confirm-password" name="confirm-password" placeholder="confirm password" />
                <label for="profile-image">Profile picture:</label>
                <input type="file" name="profile-image" id="profile-image">
                <input type="submit" name="create" value="Create Account" />
            </form>
        </div>
    </div>
</body>
</html>