<?php
    require 'connect.php';
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
    <form action="submit-card.php" method="post">
        <p>
            <label for="name">Name:</label>
            <input id="name" name="name" type="text" />
        </p>
        <p>
            <label for="rarity">Rarity:</label>
            <select>
                <option>Common</option>
                <option>Rare</option>
                <option>Epic</option>
                <option>Legendary</option>
            </select>
        </p>
        <p>
            <label for="elixir_cost">Elixir Cost:</label>
            <input id="elixir_cost" name="elixir_cost" type="number" max="10" />
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
            <label for="speed">Speed:</label>
            <select>
                <option>Slow</option>
                <option>Medium</option>
                <option>Fast</option>
                <option>Very Fast</option>
            </select>
        </p>
        <p>
            <label for="hit_speed">Hit Speed:</label>
            <input id="hit_speed" name="hit_speed" type="number" />
        </p>
        <p>
            <label for="targets">Targets:</label>
            <select>
                <option>Slow</option>
                <option>Medium</option>
                <option>Fast</option>
                <option>Very Fast</option>
            </select>
        </p>
        <p>
            <label for="range">Range:</label>
            <input id="range" name="range" type="text" />
        </p>
        <p>
            <label for="death_damage">Death Damage:</label>
            <input id="death_damage" name="death_damage" type="text" />
        </p>
        <p>
            <label for="lifetime">Lifetime:</label>
            <input id="lifetime" name="lifetime" type="number" />
        </p>
        <p>
            <label for="level">Level:</label>
            <input id="level" name="level" type="number" max="13"/>
        </p>
        <p>
            <label for="range">Spawn Speed:</label>
            <input id="spawn_speed" name="spawn_speed" type="number" />
        </p>
        <p>
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
        </p>
        <p>
            <input type="submit" value="Create" />
        </p>
    </form>
</body>
</html>
