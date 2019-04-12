<?php
    require 'connect.php';
    $validCard = false;

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
            echo $username;
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
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">

    <!--Include CKEditor-->
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>
<body>
    <?php if ($validCard): ?>
        <form action="submit-comment.php" method="post">
            <p>Commenting on <?=$card['Name']?></p>
            <p>
                <label for="Rating">Rating:</label>
                <input id="rating" name="rating" type="number" min="1" max="5" value="5" />
            </p>
            <p>
                <label for="content">Content:</label>
                <textarea id="content" name="content"></textarea>
                <script>CKEDITOR.replace('content')</script>
            </p>
                <img src="captcha.php" alt="Captcha" /><br>
                <input type="text" name="captcha" />
            <p>
                <input type="hidden" name="username" value=<?=$username?> />
                <input type="hidden" name="cardID" value=<?=$cardID?> />
                <input type="submit" name="create" value="Create"/>
            </p>

        </form>
    <?php else: ?>
        <p>That card doesn't exist!</p>
    <?php endif ?>
</body>
</html>