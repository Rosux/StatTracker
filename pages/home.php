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
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/stats.css">
    <link rel="stylesheet" href="../styles/teams.css">
    <script src="../scripts/main.js"></script>
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
            <p class="teams-title">Your points per team:</p>
            <table class="teams-wrapper shadow">
                <tr class="team-row">
                    <th>Team Name:</th>
                    <th>Team Goals:</th>
                    <th>Team Assists:</th>
                </tr>
                <?php
                    // $teams["id"] || $teams["name"] || $teams["players"] = id (still gotta json parse it)
                    $teams = $user->getTeams();
                    if($teams == 0){
                        echo '<tr class="team-row"><td>No Team</td><td>No Team</td><td>No Team</td>';
                    }else{
                        foreach($teams as $team){
                            // echo $team["name"];
                            $user_points = json_decode($team["players"], true);
                            echo '<tr class="team-row"><td><a href="team.php?team='.$team["id"].'">'.$team["name"].'</a></td>';
                            echo '<td>'.$user_points[$user->id]["goals"].'</td>';
                            echo '<td>'.$user_points[$user->id]["assists"].'</td>';
                        }
                    }
                ?>
            </table>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>