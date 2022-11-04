<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();
    $user = $admin;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Roles - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <script src="../scripts/main.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center welcome">
        <p>Admin Roles:</p>
        <div class="text-wrapper">
            <p>0:</p>
            <p>No Admin Rights</p><br>
            <p>1:</p>
            <p>Ability to manage teams</p><br>
            <p>2:</p>
            <p>Ability to manage player points & teams</p><br>
            <p>3:</p>
            <p>Ability to manage players & teams & player points</p><br>
            <p>4:</p>
            <p>Ability to manage players & admins & teams</p>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>