<?php
require_once "./user.php";
$user = new User();
$user->protectPage();
// check the submit button name
if(isset($_POST["SaveUsername"])){
    // update username
    $username = $_POST['updateUsername'];
    $currentPassword = $_POST['currentPassword'];
    if(strlen($username)>30){
        $_SESSION['settingNewUsernameError'] .= "username is too long<br>";
        $x = true;
    }
    if(strlen($username)<4){
        $_SESSION['settingNewUsernameError'] .= "username is too short<br>";
        $x = true;
    }
    if(preg_match('/[^A-Za-z]/', $username)){
        $_SESSION['settingNewUsernameError'] .= "username can only containt a-Z<br>";
        $x = true;
    }
    if($x){
        header("Location: ../pages/settings.php");
        exit();
    }
    // all fine try to change username
    $result = $user->updateName($username, $currentPassword);
    // 1 = user not found
    // 2 = current password incorect
    // 3 = couldnt update user row
    if($result == 3){
        $_SESSION['settingNewUsernameError'] = "Couldn't update username. try again later.<br>";
    }elseif($result == 2){
        $_SESSION['settingPasswordError1'] = "Password incorrect.<br>";
    }elseif($result == 1){
        $_SESSION['settingNewUsernameError'] = "User not found. try refreshing the page.<br>";
    }elseif($result == 0){
        $_SESSION['settingNewUsernameError'] = "Success.<br>";
    }
}elseif(isset($_POST["SaveEmail"])){
    // update email
    $email = $_POST['updateEmail'];
    $currentPassword = $_POST['currentPassword'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['settingNewEmailError'] .= "Email is not valid<br>";
        $x = true;
    }
    if($x){
        header("Location: ../pages/settings.php");
        exit();
    }
    // all fine try to change username
    $result = $user->updateEmail($email, $currentPassword);
    // 1 = user not found
    // 2 = current password incorect
    // 3 = couldnt update user row
    if($result == 3){
        $_SESSION['settingNewEmailError'] = "Couldn't update email. try again later.<br>";
    }elseif($result == 2){
        $_SESSION['settingPasswordError2'] = "Password incorrect.<br>";
    }elseif($result == 1){
        $_SESSION['settingNewEmailError'] = "User not found. try refreshing the page.<br>";
    }elseif($result == 0){
        $_SESSION['settingNewEmailError'] = "Success.<br>";
    }
}elseif(isset($_POST["SavePassword"])){
    // update password
    $newPassword = $_POST['updatePassword'];
    $currentPassword = $_POST['currentPassword'];
    $passFilter = "/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/";
    if(!preg_match($passFilter, $newPassword) || strlen($newPassword) < 8 || strlen($newPassword) > 40){
        $_SESSION['settingNewPasswordError'] .= "Password is not strong enough<br>";
        $x = true;
    }
    if($x){
        header("Location: ../pages/settings.php");
        exit();
    }
    // all fine try to change username
    $result = $user->updatePassword($newPassword, $currentPassword);
    // 1 = user not found
    // 2 = current password incorect
    // 3 = couldnt update user row
    if($result == 3){
        $_SESSION['settingNewPasswordError'] = "Couldn't update password. try again later.<br>";
    }elseif($result == 2){
        $_SESSION['settingPasswordError3'] = "Password incorrect.<br>";
    }elseif($result == 1){
        $_SESSION['settingNewPasswordError'] = "User not found. try refreshing the page.<br>";
    }elseif($result == 0){
        $_SESSION['settingNewPasswordError'] = "Success.<br>";
    }
}
header("Location: ../pages/settings.php");
exit();
?>