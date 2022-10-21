<?php


header('Content-Type: application/json; charset=utf-8');








// username search
$searchId = $_POST["id"];
$searchName = $_POST["username"];
$searchEmail = $_POST["email"];



require_once "./admin-class.php";
$admin = new Admin();
$result = $admin->adminGetAllUsers();


// $search = explode(" ", $search);




$result = $admin->adminGetAllFilteredUsers($searchId, $searchName, $searchEmail);

echo json_encode($result);
exit();








// SELECT * FROM `users` WHERE name LIKE '%1%'; 
// SELECT * FROM `users` WHERE column LIKE '%query stuff%'; 
// SELECT * FROM `users` WHERE name LIKE '%1%' OR name LIKE '%a%';
// SELECT * FROM `users` WHERE name LIKE '%1%' AND name LIKE '%a%';









?>