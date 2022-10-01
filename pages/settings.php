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
    <title>Settings - StatTracker</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/settings.css">
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center welcome">
        <p>Settings:</p>
    </div>
    <div class="center">


        <div class="settings-wrapper">
            <div class="settings-row">
                <p class="setting-description">Dark mode</p>
                <div class="settings-input">
                    <div class="button-switch">
                        <input type="checkbox" id="darkmode">
                        <label for="darkmode"><p>Dark</p><p>Bright</p></label>
                    </div>
                </div>
            </div>
            <div class="settings-row">
                <p class="setting-description">Username</p>
                <div class="settings-input">
                    <form action="../php/update.php" method="POST">
                        <input type="text" name="updateUsername" placeholder="Username">
                    </form>
                </div>
            </div>
            <div class="settings-row">
                <p class="setting-description">Password</p>
                <div class="settings-input">
                    <form action="../php/update.php" method="POST">
                        <input type="password" name="updateUsername" placeholder="Password">
                    </form>
                </div>
            </div>
        </div>



    </div>






    <?php require_once("footer.php"); ?>
</body>
</html>