<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stat-tracker</title>
    <link rel="stylesheet" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <form action="register.php" method="POST">
        <h1>Register</h1>
        <input type="text" name="registerUsername" placeholder="Username"><br>
        <input type="email" name="registerEmail" placeholder="Email"><br>
        <input type="password" name="registerPassword" placeholder="Password"><br>
        <input type="submit" value="Register"><br>
        <div class="errormessage registererror">
            <?php
                if(isset($_SESSION['registerError'])){
                    echo `<p>`.$_SESSION['registerError'].`</p>`;
                    unset($_SESSION["registerError"]);
                }
            ?>
        </div>
    </form>
    <form action="login.php" method="POST">
        <h1>Login</h1>
        <input type="email" name="loginEmail" placeholder="Email"><br>
        <input type="password" name="loginPassword" placeholder="Password"><br>
        <input type="submit" value="Register"><br>
        <div class="errormessage loginerror">
            <?php
                if(isset($_SESSION['loginError'])){
                    echo `<p>`.$_SESSION['loginError'].`</p>`;
                    unset($_SESSION["loginError"]);
                }
            ?>
        </div>
    </form>
</body>
</html>