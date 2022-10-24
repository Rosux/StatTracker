<?php

// set JSON type header for ajax data
header('Content-Type: application/json; charset=utf-8');

// username search
$searchId = $_POST["id"];
$searchName = $_POST["username"];
$searchEmail = $_POST["email"];

require_once "./admin-class.php";
$admin = new Admin();
$result = $admin->adminGetAllFilteredUsers($searchId, $searchName, $searchEmail);
echo json_encode($result);
exit();
?>