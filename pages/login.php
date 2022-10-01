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
    <title>Login - StatTracker</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center welcome">
        <p>Welcome, <?php print($user->name);?></p>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>