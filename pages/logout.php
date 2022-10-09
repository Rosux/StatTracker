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
    <title>Logout - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/form.css">
    <script src="../scripts/main.js"></script>
    <script defer src="../scripts/form-error.js"></script>
</head>
<body>
<?php require_once("header.php"); ?>
    <div class="center">
        <div class="form-wrapper">
            <p class="form-title" style="text-align: center;margin-bottom: 2rem;">Logout</p>
            <form action="../php/logout.php" method="POST">
                <div class="form-row form-center">
                    <input type="submit" value="Logout">
                </div>
            </form>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>