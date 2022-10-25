<?php
    require_once "../php/user.php";
    $user = new User();
    $user->protectPage();



    // echo $_GET["userid"]; // THE GET USERID


    
?>

<a><?php echo $_GET["userid"]; ?></a>