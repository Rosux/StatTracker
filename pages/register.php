<?php
    require_once "../php/user.php";
    $user = new User();
    if($user->checkLoggedIn() == 0){
        header("Location: logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/form.css">
    <script src="../scripts/main.js"></script>
    <script defer src="../scripts/form-error.js"></script>
</head>
<body>
<?php require_once("header.php"); ?>
    <div class="center">
        <div class="form-wrapper shadow">
            <p class="form-title">Register</p>
            <form action="../php/register.php" method="POST">
                <div class="form-row">
                    <p class="row-title">Username:</p>
                    <input type="text" name="registerUsername" placeholder="Username" form-validation="username" required>
                    <p class="row-error" form-error="username"></p>
                </div>
                <div class="form-row">
                    <p class="row-title">E-Mail:</p>
                    <input type="email" name="registerEmail" placeholder="Email" form-validation="email" required>
                    <p class="row-error" form-error="email"></p>
                </div>
                <div class="form-row">
                    <p class="row-title">Password:</p>
                    <input type="password" name="registerPassword" placeholder="Password" form-validation="password" required>
                    <p class="row-error" form-error="password"></p>
                </div>
                <div class="form-row form-center">
                    <input type="submit" value="Register">
                    <p class="row-error">
                        <?php
                            if(isset($_SESSION['registerError'])){
                                echo `<p>`.$_SESSION['registerError'].`</p>`;
                                unset($_SESSION["registerError"]);
                            }
                        ?>
                    </p>
                </div>
            </form>
            <div class="form-links">
                <a href="login.php">Login</a>
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>