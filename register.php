<?php
    $userName = $_POST["registerUsername"];
    $userEmail = $_POST["registerEmail"];
    $userPassword = $_POST["registerPassword"];
    session_start();
    $x = false;
    if(!isset($userEmail) || !isset($userName) || !isset($userPassword)){
        // not all fields are filled in
        $_SESSION['registerError'] .= "not all fields are filled in<br>";
        $x = true;
    }
    if(strlen($userName)>30){
        // username is too long or short or contains illegal chars;
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
        // email niet geldig;
        $_SESSION['registerError'] .= "Email is not valid<br>";
        $x = true;
    }
    $passFilter = "/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/";
    if(!preg_match($passFilter, $userPassword) || strlen($userPassword) < 8 || strlen($userPassword) > 40){
        // pass not strong enough;
        $_SESSION['registerError'] .= "Password is not strong enough<br>";
        $x = true;
    }
    if($x){
        // error
        header("Location: ./index.php");
        exit();
    }
    // proceed with uploading to db then redirect to home page



    
?>