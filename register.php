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
    require_once "pdo.php";
    // create user obj
    $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $registerUser = [
        "name" => $userName,
        "email" => $userEmail,
        "password" => $userPassword
    ];
    // check if email is already used
    $sql = "SELECT * FROM users WHERE email=?";
    $p = $conn->prepare($sql);
    $e = $p->execute([$userEmail]);
    $result = $p->rowCount();
    if($result > 0){
        // deny request
        $_SESSION['registerError'] = "Email already in use<br>";
        header("Location: ./index.php");
        exit();
    }
    // INSERT INTO `users` (`name`, `email`, `password`, `goals`, `assists`, `id`) VALUES ('name', 'email', 'password', '0', '0', NULL);
    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $p = $conn->prepare($sql);
    $e = $p->execute($registerUser);
    $result = $p->rowCount();
    // check if it failed or worked
    if($result > 0){
        header("Location: ./home.php");
        exit();
    }else{
        $_SESSION['registerError'] = "Error while registering account. try again later.<br>";
    }

    
?>