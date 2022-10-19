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
    <title>Login - StatTracker</title>
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
            <p class="form-title">Login</p>
            <form action="../php/login.php" method="POST">
                <div class="form-row">
                    <p class="row-title">E-Mail:</p>
                    <input type="email" name="loginEmail" placeholder="Email" required>
                    <p class="row-error"></p>
                </div>
                <div class="form-row">
                    <p class="row-title">Password:</p>
                    <input type="password" name="loginPassword" placeholder="Password" required>
                    <p class="row-error"></p>
                </div>
                <div class="form-row form-center">
                    <input type="submit" value="Login">
                    <p class="row-error">
                        <?php
                            if(isset($_SESSION['loginError'])){
                                echo `<p>`.$_SESSION['loginError'].`</p>`;
                                unset($_SESSION["loginError"]);
                            }
                        ?>
                    </p>
                </div>
            </form>
            <div class="form-links">
                <a href="register.php">Register</a>
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>