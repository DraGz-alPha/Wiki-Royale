<?php
    require 'connect.php';

    session_start();

    $userLoggedIn = false;

    // Checks if there is a current session in progress.
    if (isset($_SESSION['user'])) {
        $user_sessionID = $_SESSION['user'];
        $userLoggedIn = true;

        if (isset($_GET['card'])) {
            // Retrieves the card name so the user knows what card they're adding levels to.

            $cardID = filter_input(INPUT_GET, 'card', FILTER_SANITIZE_NUMBER_INT);

            $card_query = "SELECT Name FROM cards WHERE CardID = $cardID";
            $statement_selectedCard = $db->prepare($card_query);
            $statement_selectedCard->execute();
            $card = $statement_selectedCard->fetch();
        }
        else {
            echo 'The specified card does not exist (yet)!';
        }
    }
    else {
        // Use system ID instead of user id.
        $user_sessionID = 1;
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
    <script src="main.js"></script>
</head>
<body>
    <form action="submit-levels.php" method="post">
        <p>Card Name: <?=$card['Name']?></p>
        <p>
            <label for="level">Card Level:</label>
            <input id="level" name="level" type="number" min="1" max="13" />
        </p>
        <p>
            <label for="hit_points">Hit Points:</label>
            <input id="hit_points" name="hit_points" type="number" />
        </p>
        <p>
            <label for="damage_per_second">Damage Per Second:</label>
            <input id="damage_per_second" name="damage_per_second" type="number" />
        </p>
        <p>
            <label for="crown_tower_damage">Crown Tower Damage:</label>
            <input id="crown_tower_damage" name="crown_tower_damage" type="number" />
        </p>
        <p>
            <label for="death_damage">Death Damage:</label>
            <input id="death_damage" name="death_damage" type="number" />
        </p>
        <p>
            <label for="charge_damage">Charge Damage:</label>
            <input id="charge_damage" name="charge_damage" type="number" />
        </p>
        <p>
            <label for="area_damage">Area Damage:</label>
            <input id="area_damage" name="area_damage" type="number" />
        </p>
        <p>
            <input type="hidden" name="cardID" value=<?=$cardID?> />
            <input type="hidden" name="userID" value=<?=$user_sessionID?> />
            <input type="submit" value="Create" />
        </p>
    </form>
</body>
</html>
