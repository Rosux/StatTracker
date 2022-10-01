<?php
    require_once "../php/user.php";
    $user = new User();
    $user->protectPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - StatTracker</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/stats.css">
    <link rel="stylesheet" href="../styles/profile.css">
</head>
<body>
    <?php require_once("header.php"); ?>




    <div class="center">
        <p><?php print($user->name);?>'s stats:</p>
        <div class="stat-wrapper">
            <div class="stat-card shadow">
                <p class="stat-card-counter-text">Goals:</p>
                <p class="stat-card-counter-number"><?php print($user->goals);?></p>
            </div>
            <div class="stat-card shadow">
                <p class="stat-card-counter-text">Assists:</p>
                <p class="stat-card-counter-number"><?php print($user->assists);?></p>
            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>
</body>
</html>