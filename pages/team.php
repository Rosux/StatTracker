<?php
    require_once "../php/user.php";
    require_once "../php/team.php";
    $user = new User();
    if(isset($_GET["team"])){
        $team = new Team($_GET["team"]);
        if($team === 1){
            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/stats.css">
    <link rel="stylesheet" href="../styles/profile.css">
    <link rel="stylesheet" href="../styles/teams.css">
    <script src="../scripts/main.js"></script>
    </style>
</head>
<body>
    <?php require_once("header.php"); ?>



    <div class="center" style="min-height: unset; padding: 4rem 0;">
        <p><?php echo($team->name); ?> stats:</p>
        <div class="stat-wrapper">
            <div class="stat-card shadow" data-tilt data-tilt-glare data-tilt-max-glare="0.1">
                <p class="stat-card-counter-text">Team Goals:</p>
                <p class="stat-card-counter-number"><?php
                    echo $team->goals
                ?></p>
            </div>
            <div class="stat-card shadow" data-tilt data-tilt-glare data-tilt-max-glare="0.1">
                <p class="stat-card-counter-text">Team Assists:</p>
                <p class="stat-card-counter-number"><?php
                    echo $team->assists
                ?></p>
            </div>
        </div>
    </div>









    <div class="center" style="min-height: unset; padding: 4rem 0;">
        <div class="teams-title-wrapper">
            <p class="teams-title"><?php
                echo $team->name . " player stats:";
            ?></p>
            <table class="teams-wrapper shadow">
                <tr class="team-row">
                    <th>Player Name:</th>
                    <th>Player Goals:</th>
                    <th>Player Assists:</th>
                </tr>
                <?php
                    foreach($team->players as $playerId => $playerStats){
                        $playerName = $team->getPlayerName($playerId);
                        if($playerName != 1){
                            echo '<tr class="team-row"><td><a href="profile.php?user='.$playerId.'">'.$playerName.'</a></td>';
                            echo '<td>'.$playerStats->goals.'</td>';
                            echo '<td>'.$playerStats->assists.'</td>';
                        }else{
                            $error = true;
                        }
                    }
                    if(isset($error)){
                        echo '<tr class="team-row"><td>Some users were not found</td><td></td><td></td>';
                    }
                ?>
            </table>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>