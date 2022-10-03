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
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/settings.css">
    <script src="../scripts/main.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center welcome">
        <p>Settings:</p>
    </div>
    <div class="center">


        <div class="settings-wrapper">
            <div class="settings-row">
                <form>
                    <p class="setting-description">Dark mode</p>
                    <div class="settings-input">
                        <div class="button-switch">
                            <input type="checkbox" id="darkmode" darkmode-selector="1">
                            <label for="darkmode"><p>Dark</p><p>Bright</p></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="settings-row">
                
                <form action="../php/update.php" method="POST">

                    <p class="setting-description">Username</p>
                    <div class="settings-input">
                        <input type="text" name="updateUsername" placeholder="Username">
                    </div>
                    <div class="settings-save">
                        <input type="submit" name="Save" value="Save" class="shadow-small"/>
                    </div>

                </form>

            </div>
            <div class="settings-row">

                <form action="../php/update.php" method="POST">
            
                    <p class="setting-description">E-mail</p>
                    <div class="settings-input">
                        <input type="text" name="updateUsername" placeholder="E-mail">
                    </div>
                    <div class="settings-save">
                        <input type="submit" name="Save" value="Save" class="shadow-small"/>
                    </div>

                </form>
                
            </div>
            <div class="settings-row">

                <form action="../php/update.php" method="POST">
            
                    <p class="setting-description">Password</p>
                    <div class="settings-input">
                        <input type="password" name="updateUsername" placeholder="Password">
                    </div>
                    <div class="settings-save">
                        <input type="submit" name="Save" value="Save" class="shadow-small"/>
                    </div>

                </form>
                
            </div>
        </div>



    </div>






    <?php require_once("footer.php"); ?>
</body>
</html>