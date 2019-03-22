<?php
    require 'authenticate.php';
    require 'connect.php';

    $create = isset($_POST['create']);
    $update = isset($_POST['update']);
    $delete = isset($_POST['delete']);

    $cardID = filter_input(INPUT_POST, 'cardID', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rarity = filter_input(INPUT_POST, 'rarity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $elixirCost = filter_input(INPUT_POST, 'elixir_cost', FILTER_SANITIZE_NUMBER_INT);
    $hitSpeed = filter_input(INPUT_POST, 'hit_speed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $speed = filter_input(INPUT_POST, 'speed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $targets = $_POST['targets'];
    $attackRange = filter_input(INPUT_POST, 'attack_range', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lifetime = filter_input(INPUT_POST, 'lifetime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $arenaLevel = filter_input(INPUT_POST, 'arena_level', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $spawnSpeed = filter_input(INPUT_POST, 'spawn_speed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $count = filter_input(INPUT_POST, 'count', FILTER_SANITIZE_NUMBER_INT);
    $radius = filter_input(INPUT_POST, 'radius', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = $_POST['description'];

    if ($hitSpeed == 0) {
        $hitSpeed = null;
    }
    if ($lifetime == 0) {
        $lifetime = null;
    }
    if ($spawnSpeed == 0) {
        $spawnSpeed = null;
    }
    if ($count == 0) {
        $count = null;
    }
    if ($radius == 0) {
        $radius = null;
    }

    // CUD functionality
    if ($create) {
        $query = "INSERT INTO cards (Name, Rarity, Type, ElixirCost, HitSpeed, Speed, Targets, AttackRange, Lifetime, ArenaLevel, SpawnSpeed, Description, Count, Radius, UserID) 
                  VALUES (:name, :rarity, :type, :elixirCost, :hitSpeed, :speed, :targets, :attackRange, :lifetime, :arenaLevel, :spawnSpeed, :description, :count, :radius, 1)";
        
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
        $statement->bindValue(':count', $count);
        $statement->bindValue(':radius', $radius);
        $statement->execute();

        $insert_id = $db->lastInsertId();

        header("Location: index.php");
    }
    if ($update) {
        $query = "UPDATE cards SET Name = :name, Rarity = :rarity, Type = :type, ElixirCost = :elixirCost, HitSpeed = :hitSpeed, Speed = :speed, Targets = :targets, AttackRange = :attackRange, Lifetime = :lifetime, ArenaLevel = :arenaLevel, SpawnSpeed = :spawnSpeed,
                  Description = :description, Count = :count, Radius = :radius WHERE CardID = :CardID";
        
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
        $statement->bindValue(':count', $count);
        $statement->bindValue(':radius', $radius);
        $statement->bindValue(':CardID', $cardID, PDO::PARAM_INT);
        $statement->execute();

        header("Location: index.php");
    }
    if ($delete) {
        $query = "DELETE FROM cards WHERE CardID = :CardID";
        
        $statement = $db->prepare($query);
        $statement->bindValue(':CardID', $cardID, PDO::PARAM_INT);
        $statement->execute();

        header("Location: index.php");
    }
?>