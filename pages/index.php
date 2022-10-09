<?php
    require_once "../php/user.php";
    $user = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/about.css">
    <script src="../scripts/main.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>

    <div class="lander">
        <div class="text-wrapper shadow">
            <h1>Keep Track Of Your Stats!</h1>
            <h3>Now made easy</h3>
        </div>
        <video class="background-video" muted autoplay loop>
            <source src="../videos/lander.mp4" type="video/mp4">
        </video>
    </div>

    <?php require_once("footer.php"); ?>
</body>
</html>