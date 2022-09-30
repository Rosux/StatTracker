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
    <title>Home - StatTracker</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/home.css">
</head>
<body>
    <?php require_once("header.php"); ?>





    <div class="center welcome">
        <p>Welcome, <?php print($user->name);?></p>
    </div>
    <div class="center">
        <div class="stat-wrapper">
            <p class="stat-title">Stats:</p>
            <div class="stat-card">
                <p class="stat-card-counter-text">Goals:</p>
                <p class="stat-card-counter-number"><?php print($user->goals);?></p>
            </div>
            <div class="stat-card">
                <p class="stat-card-counter-text">Assists:</p>
                <p class="stat-card-counter-number"><?php print($user->assists);?></p>
            </div>
        </div>
    </div>
    









</body>
</html>