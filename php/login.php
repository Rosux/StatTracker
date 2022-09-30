<?php
    $email = $_POST["loginEmail"];
    $password = $_POST["loginPassword"];
    // $remember = $_POST["loginRemember"];
    session_start();
    $x = false;
    if(!isset($email) || !isset($password)){
        $_SESSION['registerError'] .= "not all fields are filled in<br>";
        $x = true;
    }
    if($x){
        header("Location: ../pages/login.php");
        exit();
    }
    // proceed with logging in then redirect to home page
    require_once "./user.php";
    $user = new User();
    $result = $user->login($email, $password);
    if($result == 1 || $result == 2){
        $_SESSION['registerError'] = "Wront username or email<br>";
    }elseif($result == 3){
        $_SESSION['registerError'] = "Server error, try again later<br>";
    }elseif($result == 0){
        header("Location: ../pages/home.php");
    }
?>