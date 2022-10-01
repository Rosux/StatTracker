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
    <link rel="stylesheet" href="../styles/stats.css">
    <link rel="stylesheet" href="../styles/teams.css">
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center welcome">
        <p>Welcome, <?php print($user->name);?></p>
    </div>
    <div class="center">
        <div class="stat-wrapper">
            <p class="stat-title">Stats:</p>
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
    <div class="center">
        <div class="teams-title-wrapper">
            <p class="teams-title">Teams:</p>
            <table class="teams-wrapper shadow">
                <tr class="team-row">
                    <th>Team Name:</th>
                    <th>Team Goals:</th>
                    <th>Team Assists:</th>
                </tr>
                <tr class="team-row">
                    <td>Name</td>
                    <td>Goals</td>
                    <td>Assists</td>
                </tr>
                <tr class="team-row">
                    <td>Name</td>
                    <td>Goals</td>
                    <td>Assists</td>
                </tr>
                <tr class="team-row">
                    <td>Name</td>
                    <td>Goals</td>
                    <td>Assists</td>
                </tr>
            </table>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>