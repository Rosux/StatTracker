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
    <title>Admin - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/admin.css">
    <script src="../scripts/main.js"></script>
    <script defer src="../scripts/admin.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center">
        <div class="admin-user-search-wrapper">
            <div class="admin-search-bar shadow">
                <form action="../php/admin.php" method="POST">
                    <input type="text" name="username" placeholder="Filter For User" autocomplete="off">
                </form>
            </div>
            <div class="admin-search-result">
                
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>