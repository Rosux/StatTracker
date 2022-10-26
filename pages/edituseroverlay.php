<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();

    if(isset($_GET["userid"])){
        $user = $admin->adminGetUser($_GET["userid"]);
    }




    
?>


<link rel="stylesheet" href="../styles/overlay.css">

<div class="center">
    <form action="../php/edit-users.php" method="POST" class="shadow user-overlay-wrapper" onsubmit="postForm(event);">

        <p class="form-title"><?php echo $user["name"]; ?>'s Settings:</p>

        <div class="user-overlay-wrapper-card">
            <p class="title">Current Username: <span><?php echo $user["name"]; ?></span></p>
            <input type="text" name="username" placeholder="New Username" autocomplete="off">
        </div>

        <div class="user-overlay-wrapper-card">
            <p class="title">Current E-mail: <span><?php echo $user["email"]; ?></span></p>
            <input type="text" name="email" placeholder="New E-mail" autocomplete="off">
        </div>
        
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Goals: <span><?php echo $user["goals"]; ?></span></p>
            <input type="text" name="goals" placeholder="New Goals" autocomplete="off">
        </div>
        
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Assists: <span><?php echo $user["assists"]; ?></span></p>
            <input type="text" name="assists" placeholder="New Assists" autocomplete="off">
        </div>
        

        <!-- ADMIN PART -->
        <!-- USE SOME SELECT THING TO SEE ROLE INFO STUFF -->
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Admin role: <span><?php echo $user["admin"]; ?></span></p>
            <input type="text" name="admin" placeholder="New Admin" autocomplete="off">
        </div>





        <div class="form-full-width">
            <input type="submit" value="Delete User" class="delete-button" name="delete">
            <input type="submit" value="Update User" name="update">
        </div>
        
        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">

    </form>
</div>
