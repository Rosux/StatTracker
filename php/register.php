<?php
    $name = $_POST["registerUsername"];
    $email = $_POST["registerEmail"];
    $password = $_POST["registerPassword"];
    session_start();
    $x = false;
    if(!isset($email) || !isset($name) || !isset($password)){
        $_SESSION['registerError'] .= "not all fields are filled in<br>";
        $x = true;
    }
    if(strlen($name)>30){
        $_SESSION['registerError'] .= "username is too long<br>";
        $x = true;
    }
    if(strlen($name)<4){
        $_SESSION['registerError'] .= "username is too short<br>";
        $x = true;
    }
    if(preg_match('/[^A-Za-z]/', $name)){
        $_SESSION['registerError'] .= "username can only containt a-Z<br>";
        $x = true;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['registerError'] .= "Email is not valid<br>";
        $x = true;
    }
    $passFilter = "/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/";
    if(!preg_match($passFilter, $password) || strlen($password) < 8 || strlen($password) > 40){
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
    $result = $user->register($name, $email, $password);
    if($result == 1){
        $_SESSION['registerError'] = "Email already in use<br>";
        header("Location: ../pages/register.php");
    }elseif($result == 2){
        $_SESSION['registerError'] = "Error while registering account. try again later.<br>";
        header("Location: ../pages/register.php");
    }elseif($result == 0){
        $user->login($email, $password);
        header("Location: ../pages/home.php");
    }
?>