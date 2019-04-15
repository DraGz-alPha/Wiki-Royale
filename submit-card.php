<?php
    require_once('ImageResize.php');
    require 'authenticate.php';
    require 'connect.php';

    session_start();

    // If user is currently logged in, the card will be submitted with their own userID. 
    // If the user is not logged in, the default userID of 1 shall be used (system id).
    if (isset($_SESSION['user'])) {
        $user_session = $_SESSION['user'];

        $user_query = "SELECT * FROM users WHERE UserID = $user_session";
        $statement_user = $db->prepare($user_query);
        $statement_user->execute();

        $user = $statement_user->fetch();

        $userID = $user['UserID'];
    }
    else {
        $userID = 1;
    }

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
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
        $query = "INSERT INTO cards (Name, Rarity, Type, ElixirCost, HitSpeed, Speed, Targets, AttackRange, Lifetime, ArenaLevel, SpawnSpeed, Description, Count, Radius, UserID, CardImage) 
                  VALUES (:name, :rarity, :type, :elixirCost, :hitSpeed, :speed, :targets, :attackRange, :lifetime, :arenaLevel, :spawnSpeed, :description, :count, :radius, '$userID', :cardImage)";
        
        $cardPictureFileName = null;

        if ($_FILES["card-image"]["name"] != null) {
            $target_dir = "img/user_cards/";
            $target_file = $target_dir . basename($_FILES["card-image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["card-image"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["card-image"]["tmp_name"], $target_file)) {
                    
                    // File upload path.
                    function file_upload_path($original_filename, $upload_subfolder_name = 'img/user_cards/') 
                    {
                        $current_folder = dirname(__FILE__);
                        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
                        return join(DIRECTORY_SEPARATOR, $path_segments);
                    }
                    
                    // If the image passes all requirements, resize and upload.
                    $cardPictureFileName = basename( $_FILES["card-image"]["name"]);
                    $temporary_image_path = $_FILES['card-image']['tmp_name'];
                    $new_image_path       = file_upload_path($cardPictureFileName);

                    $resizeObj = new resize('img/user_cards/' . $cardPictureFileName);
                    $resizeObj -> resizeImage(100, 100, 0);
                    $resizeObj -> saveImage('img/user_cards/' . $cardPictureFileName, 100);

                    move_uploaded_file($temporary_image_path, $new_image_path);
                    $cardImageName = $new_image_path;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        echo $cardPictureFileName;

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
        $statement->bindValue(':cardImage', $cardPictureFileName);
        $statement->execute();

        $insert_id = $db->lastInsertId();
        header("Location: index.php");
    }
    if ($update) {
        $query = "UPDATE cards SET Name = :name, Rarity = :rarity, Type = :type, ElixirCost = :elixirCost, HitSpeed = :hitSpeed, Speed = :speed, Targets = :targets, AttackRange = :attackRange, Lifetime = :lifetime, ArenaLevel = :arenaLevel, SpawnSpeed = :spawnSpeed,
                  Description = :description, Count = :count, Radius = :radius, CardImage = :cardImage WHERE CardID = :CardID";
        
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
        $statement->bindValue(':cardImage', $cardPictureFileName);
        $statement->bindValue(':CardID', $cardID, PDO::PARAM_INT);
        $statement->execute();

        header("Location: index.php");
    }

    if ($delete) {
        $cardPicture_Query = "SELECT CardImage FROM cards WHERE CardID = :cardID";
        $cardPicture_statement = $db->prepare($cardPicture_Query);
        $cardPicture_statement->bindvalue(':cardID', $cardID);
        $cardPicture_statement->execute();  
        $cardPictureFileName = $cardPicture_statement->fetch();

        $query = "DELETE FROM cards WHERE CardID = :CardID"; 
        $statement = $db->prepare($query);
        $statement->bindValue(':CardID', $cardID, PDO::PARAM_INT);
        $statement->execute();
        unlink("img/user_cards/" . $cardPictureFileName['CardImage']);
        header("Location: index.php");
    }

?>