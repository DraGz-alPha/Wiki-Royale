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
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Wiki Royale</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-card.php">Create Card</a>
                    </li>
                </ul>
                <?php if ($userLoggedIn): ?> 
                    <!--Account drop-down list-->
                    <div class="btn-group">
                        <?php if ($user['AccountType'] == 'A'): ?>
                            <button type="button" class="btn btn-warning">Welcome, <?=$user['Username']?> [A]</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-warning">Welcome, <?=$user['Username']?></button>
                        <?php endif ?>
                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="my-account.php">My Account</a>
                            <?php if ($user['AccountType'] == 'A'): ?>
                                <a class="dropdown-item" href="admin.php">Admin Tools</a>
                            <?php endif ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Sign out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="btn btn-warning" href="login.php" role="button">Sign in</a>
                <?php endif ?>
            </div>
            <?php if ($userLoggedIn && $user['ProfilePicture'] != null): ?>
                <img src="img/Profile_Pics/<?=$user['ProfilePicture']?>" alt="<?=$user['ProfilePicture']?>" />
            <?php endif ?>
        </nav>
    </header>
    <?php if ($userLoggedIn): ?>
        <form id="cardDetails" action="submit-card.php" method="post" enctype="multipart/form-data">
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
                    <option>-</option>
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
                <input id="radius" name="radius" type="number" step="0.1" />
            </p>
            <p>
                <label for="description">Description:</label>
                <textarea id="description" name="description" form="cardDetails"></textarea>
            </p>
            <p>
                <input id="card-image" name="card-image" type="file" />
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
