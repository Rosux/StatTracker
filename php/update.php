<?php

require_once "./user.php";
$user = new User();
$user->protectPage();

// todo fix
// if(isset($_POST["currentPassword"])){
//     header("Location: " . "../pages/settings.php");
//     exit();
// }

if(isset($_POST["SaveUsername"])){
    // update username
    if(!isset($_POST['updateUsername'])){
        header("Location: " . "../pages/login.php");
        exit();
    }
    echo $_POST['updateUsername'];
    exit();



}elseif(isset($_POST["updateEmail"])){
    // update email


    echo "email";
    exit();



}elseif(isset($_POST["updatePassword"])){
    // update password


    echo "password";
    exit();



}





?>