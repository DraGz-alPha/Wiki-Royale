<?php
    require 'authenticate.php';
    require 'connect.php';

    session_start();

    $userLoggedIn = false;

    // If user is logged in, display welcome message at top of web page.
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();

        echo "Welcome back " . $user['Username'];
        $userLoggedIn = true;
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
</head>
<body>
    <?php if ($userLoggedIn): ?>
        <form id="cardDetails" action="submit-card.php" method="post">
            <p>
                <label for="name">Name:</label>
                <input id="name" name="name" type="text" required autofocus />
            </p>
            <p>
                <label for="rarity">Rarity:</label>
                <select id="rarity" name="rarity">
                    <option>Common</option>
                    <option>Rare</option>
                    <option>Epic</option>
                    <option>Legendary</option>
                </select>
            </p>
            <p>
                <label for="type">Type:</label>
                <select id="type" name="type">
                    <option>Troop</option>
                    <option>Spell</option>
                    <option>Building</option>
                    <option>-User Created-</option>
                </select>
            </p>
            <p>
                <label for="elixir_cost">Elixir Cost:</label>
                <input id="elixir_cost" name="elixir_cost" type="number" min="1" max="10" value="1" required />
            </p>
            <p>
                <label for="hit_speed">Hit Speed:</label>
                <input id="hit_speed" name="hit_speed" type="number" step="0.1" />
            </p>
            <p>
                <label for="speed">Speed:</label>
                <select id="speed" name="speed">
                    <option></option>
                    <option>Slow</option>
                    <option>Medium</option>
                    <option>Fast</option>
                    <option>Very Fast</option>
                </select>
            </p>
            <p>
                <label for="targets">Targets:</label>
                <select id="targets" name="targets">
                    <option>Ground</option>
                    <option>Air</option>
                    <option>Air & Ground</option>
                    <option>Buildings</option>
                </select>
            </p>
            <p>
                <label for="attack_range">Range:</label>
                <input id="attack_range" name="attack_range" type="text" />
            </p>
            <p>
                <label for="lifetime">Lifetime:</label>
                <input id="lifetime" name="lifetime" type="number" />
            </p>
            <p>
                <label for="arena_level">Unlocks at arena level:</label>
                <input id="arena_level" name="arena_level" type="number" max="13"/>
            </p>
            <p>
                <label for="spawn_speed">Spawn Speed:</label>
                <input id="spawn_speed" name="spawn_speed" type="number" step="0.1"/>
            </p>
            <p>
                <label for="count">Count:</label>
                <input id="count" name="count" type="number" />
            </p>
            <p>
                <label for="radius">Radius:</label>
                <input id="radius" name="radius" type="number" step="0.1"/>
            </p>
            <p>
                <label for="description">Description:</label>
                <textarea id="description" name="description" form="cardDetails"></textarea>
            </p>
            <p>
                <input id="image" name="image" type="file" />
            </p>
            <p>
                <input type="submit" name="create" value="Create" />
            </p>
        </form>
    <?php else: ?>
        <p>Sorry, this page is for members only!</p>
        <img src="img/page_error/crying.gif" alt="">
        <audio autoplay>
            <source src="crying.mp3" type="audio/mpeg">
        </audio> 
    <?php endif ?>
</body>
</html>
