<?php
    require_once "./user.php";
    $user = new User();
    echo $user->goals;
    $result = $user->getGoals();
    echo $result;
    echo $user->goals;
    exit();
?>