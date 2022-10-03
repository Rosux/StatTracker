<?php
    require_once "../php/user_profile.php";
    require_once "../php/user.php";
    $user = new User();
    if(isset($_GET["user"])){
        $profile = new Profile($_GET["user"]);
        if($profile->id != $_GET["user"]){
            $profile = false;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/stats.css">
    <link rel="stylesheet" href="../styles/profile.css">
    <script src="../scripts/main.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>



    <?php if(isset($profile) && !$profile){?>
        <!-- profile not set show temp error -->
        <div class="center">
            <p>User Profile Not Found</p>
            <a href="profile.php" class="button">Click here to get back to your profile</a>
        </div>
    <?php }else{ ?>
        <!-- profile is set -->
        <div class="center">
            <p><?php
                if(isset($profile)){
                    print($profile->name);
                }else{
                    print($user->name);
                }
            ?>'s stats:</p>
            <div class="stat-wrapper">
                <div class="stat-card shadow">
                    <p class="stat-card-counter-text">Goals:</p>
                    <p class="stat-card-counter-number"><?php
                        if(isset($profile)){
                            print($profile->goals);
                        }else{
                            print($user->goals);
                        }
                    ?></p>
                </div>
                <div class="stat-card shadow">
                    <p class="stat-card-counter-text">Assists:</p>
                    <p class="stat-card-counter-number"><?php
                        if(isset($profile)){
                            print($profile->assists);
                        }else{
                            print($user->assists);
                        }
                    ?></p>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php require_once("footer.php"); ?>
</body>
</html>