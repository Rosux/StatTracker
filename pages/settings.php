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
    <script defer src="../scripts/form-error.js"></script>
    <script defer src="../scripts/settings.js"></script>
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
                        <input type="text" name="updateUsername" placeholder="New Username" form-validation="username" required>
                        <p class="row-error" form-error="username">
                        <?php
                            if(isset($_SESSION['settingNewUsernameError'])){
                                echo `<p>`.$_SESSION['settingNewUsernameError'].`</p>`;
                                unset($_SESSION["settingNewUsernameError"]);
                            }
                        ?>
                        </p>
                    </div>
                    <div class="settings-input settings-password">
                        <input type="password" name="currentPassword" placeholder="Current Password" required>
                        <p class="row-error-pass">
                        <?php
                            if(isset($_SESSION['settingPasswordError1'])){
                                echo `<p>`.$_SESSION['settingPasswordError1'].`</p>`;
                                unset($_SESSION["settingPasswordError1"]);
                            }
                        ?>
                        </p>
                    </div>
                    <div class="settings-save">
                        <input type="submit" name="SaveUsername" value="Save" class="shadow-small"/>
                    </div>
                </form>
            </div>
            <div class="settings-row">
                <form action="../php/update.php" method="POST">
                    <p class="setting-description">E-mail</p>
                    <div class="settings-input">
                        <input type="text" name="updateEmail" placeholder="New E-mail" form-validation="email" required>
                        <p class="row-error" form-error="email">
                        <?php
                            if(isset($_SESSION['settingNewEmailError'])){
                                echo `<p>`.$_SESSION['settingNewEmailError'].`</p>`;
                                unset($_SESSION["settingNewEmailError"]);
                            }
                        ?>
                        </p>
                    </div>
                    <div class="settings-input settings-password">
                        <input type="password" name="currentPassword" placeholder="Current Password" required>
                        <p class="row-error-pass">
                        <?php
                            if(isset($_SESSION['settingPasswordError2'])){
                                echo `<p>`.$_SESSION['settingPasswordError2'].`</p>`;
                                unset($_SESSION["settingPasswordError2"]);
                            }
                        ?>
                        </p>
                    </div>
                    <div class="settings-save">
                        <input type="submit" name="SaveEmail" value="Save" class="shadow-small"/>
                    </div>
                </form>
            </div>
            <div class="settings-row">
                <form action="../php/update.php" method="POST">
                    <p class="setting-description">Password</p>
                    <div class="settings-input">
                        <input type="text" name="updatePassword" placeholder="New Password" form-validation="password" required>
                        <p class="row-error" form-error="password">
                        <?php
                            if(isset($_SESSION['settingNewPasswordError'])){
                                echo `<p>`.$_SESSION['settingNewPasswordError'].`</p>`;
                                unset($_SESSION["settingNewPasswordError"]);
                            }
                        ?>  
                        </p>
                    </div>
                    <div class="settings-input settings-password">
                        <input type="password" name="currentPassword" placeholder="Current Password" required>
                        <p class="row-error-pass">
                        <?php
                            if(isset($_SESSION['settingPasswordError3'])){
                                echo `<p>`.$_SESSION['settingPasswordError3'].`</p>`;
                                unset($_SESSION["settingPasswordError3"]);
                            }
                        ?>
                        </p>
                    </div>
                    <div class="settings-save">
                        <input type="submit" name="SavePassword" value="Save" class="shadow-small"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>