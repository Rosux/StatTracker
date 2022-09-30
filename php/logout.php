<?php
    require_once "./user.php";
    $user = new User();
    $result = $user->logout();
    header("Location: ../pages/index.php");
?>