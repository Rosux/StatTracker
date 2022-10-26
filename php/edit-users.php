<?php
header('Content-Type: application/json; charset=utf-8');

$id = $_POST["id"];
$name = $_POST["username"];
$email = $_POST["email"];
$goals = $_POST["goals"];
$assists = $_POST["assists"];
$admin = $_POST["admin"];

$response = "ERROR: nothing";

// if(isset($_POST["update"])){
    
// }elseif(isset($_POST["delete"])){
    
// }

if($name == ""){
    // no name so ignore
}

echo json_encode($response);
exit();
?>