<?php
    require 'authenticate.php';
    require 'connect.php';

    $cardID = filter_input(INPUT_GET, 'card', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT CardID, Name, Rarity, Type, ElixirCost, HitSpeed, Speed, Targets, AttackRange, Lifetime, ArenaLevel, SpawnSpeed, Description 
    FROM cards 
    WHERE CardID = $cardID";

    $statement = $db->prepare($query);
    $statement->execute();
    $card = $statement->fetch();

    $rarities = ['Common', 'Rare', 'Epic', 'Legendary'];
    $types = ['Troop', 'Spell', 'Building'];
    $targets = ['Ground', 'Air', 'Air & Ground', 'Buildings'];
    $speeds = ['Slow', 'Medium', 'Fast', 'Very Fast'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="edit-card.css">
    <script src="main.js"></script>
</head>
<body>
    <div id="wrapper">
        <form id="cardDetails" action="submit-card.php" method="post">
            <img src="img/<?=$card['Name']?>.png" alt="<?=$card['Name']?>" width="150" />
            <p>
                <label for="name">Name:</label>
                <input id="name" name="name" type="text" value="<?=$card['Name']?>" />
            </p>
            <p>
                <label for="rarity">Rarity:</label>
                <select id="rarity" name="rarity" value="<?=$card['Rarity']?>" >
                    <?php foreach ($rarities as $rarity): ?>
                        <?php if ($rarity == $card['Rarity']): ?>
                            <option selected><?=$rarity?></option>
                        <?php else: ?>
                            <option><?=$rarity?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="type">Type:</label>
                <select id="type" name="type">
                    <?php foreach ($types as $type): ?>
                        <?php if ($type == $card['Type']): ?>
                            <option selected><?=$type?></option>
                        <?php else: ?>
                            <option><?=$type?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="elixir_cost">Elixir Cost:</label>
                <input id="elixir_cost" name="elixir_cost" type="number" max="10" value="<?=$card['ElixirCost']?>" />
            </p>
            <p>
                <label for="hit_speed">Hit Speed:</label>
                <input id="hit_speed" name="hit_speed" type="number" step="0.1" value="<?=$card['HitSpeed']?>"/>
            </p>
            <p>
                <label for="speed">Speed:</label>
                <select id="speed" name="speed">
                    <?php foreach ($speeds as $speed): ?>
                        <?php if ($speed == $card['Speed']): ?>
                            <option selected><?=$speed?></option>
                        <?php else: ?>
                            <option><?=$speed?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="targets">Targets:</label>
                <select id="targets" name="targets">
                    <?php foreach ($targets as $target): ?>
                        <?php if ($target == $card['Targets']): ?>
                            <option selected><?=$target?></option>
                        <?php else: ?>
                            <option><?=$target?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="attack_range">Range:</label>
                <input id="attack_range" name="attack_range" type="text" value="<?=$card['AttackRange']?>" />
            </p>
            <p>
                <label for="lifetime">Lifetime:</label>
                <input id="lifetime" name="lifetime" type="number" value="<?=$card['Lifetime']?>" />
            </p>
            <p>
                <label for="arena_level">Unlocks at arena level:</label>
                <input id="arena_level" name="arena_level" type="number" max="13" value="<?=$card['ArenaLevel']?>" />
            </p>
            <p>
                <label for="spawn_speed">Spawn Speed:</label>
                <input id="spawn_speed" name="spawn_speed" type="number" step="0.1" value="<?=$card['SpawnSpeed']?>" />
            </p>
            <p>
                <label for="count">Count:</label>
                <input id="count" name="count" type="number" value="<?=$card['Count']?>" />
            </p>
            <p>
                <label for="radius">Radius:</label>
                <input id="radius" name="radius" type="number" step="0.1" value="<?=$card['Radius']?>" />
            </p>
            <p>
                <label for="description">Description:</label>
                <textarea id="description" name="description" form="cardDetails"><?=$card['Description']?></textarea>
            </p>
            <p>
                <input type="hidden" name="cardID" value=<?=$cardID?> />
                <input type="submit" name="update" value="Update"/>
                <input type="submit" name="delete" value="Delete" onclick=" return confirm('Are you sure you wish to delete this card?')" />
            </p>
        </form>
    </div>
</body>
</html>