<?php
    require 'connect.php';

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rarity = filter_input(INPUT_POST, 'rarity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $elixirCost = filter_input(INPUT_POST, 'elixir_cost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hitSpeed = filter_input(INPUT_POST, 'hit_speed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $speed = filter_input(INPUT_POST, 'speed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $targets = $_POST['targets'];
    $attackRange = filter_input(INPUT_POST, 'attack_range', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lifetime = filter_input(INPUT_POST, 'lifetime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $arenaLevel = filter_input(INPUT_POST, 'arena_level', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $spawnSpeed = filter_input(INPUT_POST, 'spawn_speed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = $_POST['description'];

    if ($hitSpeed == 0) {
        $hitSpeed = null;
    }

    $query = "INSERT INTO cards (Name, Rarity, Type, ElixirCost, HitSpeed, Speed, Targets, AttackRange, Lifetime, ArenaLevel, SpawnSpeed, Description, UserID) 
              VALUES (:name, :rarity, :type, :elixirCost, :hitSpeed, :speed, :targets, :attackRange, :lifetime, :arenaLevel, :spawnSpeed, :description, 1)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':rarity', $rarity);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':elixirCost', $elixirCost);
    $statement->bindValue(':hitSpeed', $hitSpeed);
    $statement->bindValue(':speed', $speed);
    $statement->bindValue(':targets', $targets);
    $statement->bindValue(':attackRange', $attackRange);
    $statement->bindValue(':lifetime', $lifetime);
    $statement->bindValue(':arenaLevel', $arenaLevel);
    $statement->bindValue(':spawnSpeed', $spawnSpeed);
    $statement->bindValue(':description', $description);
    $statement->execute();

    $insert_id = $db->lastInsertId();


    echo $name;
    echo $rarity;
    echo $type;
    echo $elixirCost;
    echo $hitSpeed;
    echo $speed;
    echo $targets;
    echo $attackRange;
    echo $arenaLevel;
    echo $description;



    header("Location: add-card.php");
?>