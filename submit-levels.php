<?php
    require 'authenticate.php';
    require 'connect.php';

    $level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_NUMBER_INT);
    $cardID = filter_input(INPUT_POST, 'cardID', FILTER_SANITIZE_NUMBER_INT);
    $userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
    $hitPoints = filter_input(INPUT_POST, 'hit_points', FILTER_SANITIZE_NUMBER_INT);
    $damagePerSecond = filter_input(INPUT_POST, 'damage_per_second', FILTER_SANITIZE_NUMBER_INT);
    $crownTowerDamage = filter_input(INPUT_POST, 'crown_tower_damage', FILTER_SANITIZE_NUMBER_INT);
    $deathDamage = filter_input(INPUT_POST, 'death_damage', FILTER_SANITIZE_NUMBER_INT);
    $chargeDamage = filter_input(INPUT_POST, 'charge_damage', FILTER_SANITIZE_NUMBER_INT);
    $areaDamage = filter_input(INPUT_POST, 'area_damage', FILTER_SANITIZE_NUMBER_INT);

    $query = "INSERT INTO cardlevels (Level, CardID, UserID, HitPoints, DamagePerSecond, CrownTowerDamage, DeathDamage, ChargeDamage, AreaDamage)
              VALUES (:level, :cardID, :userID, :hitPoints, :damagePerSecond, :crownTowerDamage, :deathDamage, :chargeDamage, :areaDamage)";

    $statement = $db->prepare($query);
    $statement->bindValue(':level', $level);
    $statement->bindValue(':cardID', $cardID);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':hitPoints', $hitPoints);
    $statement->bindValue(':damagePerSecond', $damagePerSecond);
    $statement->bindValue(':crownTowerDamage', $crownTowerDamage);
    $statement->bindValue(':deathDamage', $deathDamage);
    $statement->bindValue(':chargeDamage', $chargeDamage);
    $statement->bindValue(':areaDamage', $areaDamage);

    $statement->execute();

    header("Location: add-levels.php");
?>