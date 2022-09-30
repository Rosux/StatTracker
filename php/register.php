<?php
    $userName = $_POST["registerUsername"];
    $userEmail = $_POST["registerEmail"];
    $userPassword = $_POST["registerPassword"];
    session_start();
    $x = false;
    if(!isset($userEmail) || !isset($userName) || !isset($userPassword)){
        $_SESSION['registerError'] .= "not all fields are filled in<br>";
        $x = true;
    }
    if(strlen($userName)>30){
        $_SESSION['registerError'] .= "username is too long<br>";
        $x = true;
    }
    if(strlen($userName)<4){
        $_SESSION['registerError'] .= "username is too short<br>";
        $x = true;
    }
    if(preg_match('/[^A-Za-z]/', $userName)){
        $_SESSION['registerError'] .= "username can only containt a-Z<br>";
        $x = true;
    }
    if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
        $_SESSION['registerError'] .= "Email is not valid<br>";
        $x = true;
    }
    $passFilter = "/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/";
    if(!preg_match($passFilter, $userPassword) || strlen($userPassword) < 8 || strlen($userPassword) > 40){
        $_SESSION['registerError'] .= "Password is not strong enough<br>";
        $x = true;
    }
    if($x){
        header("Location: ../pages/register.php");
        exit();
    }
    // proceed with uploading to db then redirect to home page
    require_once "./user.php";
    $user = new User();
    $result = $user->register($userName, $userEmail, $userPassword);
    if($result == 1){
        $_SESSION['registerError'] = "Email already in use<br>";
    }elseif($result == 2){
        $_SESSION['registerError'] = "Error while registering account. try again later.<br>";
    }else{
        header("Location: ../pages/home.php");
    }
?>