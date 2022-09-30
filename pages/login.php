<?php
    $userEmail = $_POST["loginEmail"];
    $userPassword = $_POST["loginPassword"];
    session_start();
    require_once "pdo.php";
    // check if fields are empty
    if(!isset($userEmail) || !isset($userPassword)){
        $_SESSION['loginError'] = "Fill in all the fields.<br>";
        header("Location: ./index.php");
        exit();
    }

    // get user by email from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(':email', $userEmail);
    $stmt->execute();
    $row = $stmt->fetch();
    $dbpassword = $row["password"];
    if ($row){
        if (password_verify($userPassword, $dbpassword)) {

            $_SESSION["user"] = $row["id"];
            // make a cookie token
            header("Location: ./home.php");
            exit();

        }else{
            // password is wrong
            $_SESSION['loginError'] = "Wrong password.<br>";
            header("Location: ./index.php");
            exit();
        }
    }else{
        // email is wrong
        $_SESSION['loginError'] = "Wrong email.<br>";
        header("Location: ./index.php");
        exit();
    }













?>