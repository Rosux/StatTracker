<?php
header('Content-Type: application/json; charset=utf-8');

$idData = $_POST["id"];
$nameData = $_POST["username"];
$emailData = $_POST["email"];
$goalsData = $_POST["goals"];
$assistsData = $_POST["assists"];
$adminData = $_POST["admin"];

require_once "../php/admin-class.php";
$admin = new Admin();

$response = [
    "updateStatus" => "",
    "updateStatus" => "",
    "error" => false
];
$userData = $admin->adminGetUser($idData);
if(isset($_POST["update"])){
    $response["postMethod"] = "update";
    // update user
    // create original data and update each value
    $updateData = [
        "name" => $userData["name"],
        "email" => $userData["email"],
        "goals" => $userData["goals"],
        "assists" => $userData["assists"],
        "admin" => $userData["admin"]
    ];
    // check if data isset and change the updatedData
    if($goalsData != ""){
        $y = false;
        if($goalsData < 0){
            $response["updateStatus"] .= "Goals cant be negative<br>";
            $response["error"] = true;
            $y = true;
        }
        if(preg_match('/[^0-9]/', $goalsData)){
            $response["updateStatus"] .= "Goals must be a number<br>";
            $response["error"] = true;
            $y = true;
        }
        if(!$y){
            $updateData["goals"] = $goalsData;
        }
    }
    if($assistsData != ""){
        $y = false;
        if($assistsData < 0){
            $response["updateStatus"] .= "Assists cant be negative<br>";
            $response["error"] = true;
            $y = true;
        }
        if(preg_match('/[^0-9]/', $assistsData)){
            $response["updateStatus"] .= "Assists must be a number<br>";
            $response["error"] = true;
            $y = true;
        }
        if(!$y){
            $updateData["assists"] = $assistsData;
        }
    }
    if($adminData != ""){
        $updateData["admin"] = $adminData;
    }
    if($nameData != ""){
        $x = false;
        if(strlen($nameData)>30 || strlen($nameData)<4){
            $response["updateStatus"] .= "Username must be between 4-30 characters<br>";
            $response["error"] = true;
            $x = true;
        }
        if(preg_match('/[^A-Za-z]/', $nameData)){
            $response["updateStatus"] .= "username can only containt a-Z<br>";
            $response["error"] = true;
            $x = true;
        }
        if(!$x){
            $updateData["name"] = $nameData;
        }
    }
    if($emailData != ""){
        if(!filter_var($emailData, FILTER_VALIDATE_EMAIL)){
            $response["updateStatus"] .= "Email is not valid<br>";
            $response["error"] = true;
        }else{
            $updateData["email"] = $emailData;
        }
    }
    $result = $admin->adminUpdateUser($idData, $updateData);
    if($result == 2){
        // not enough admin rights
        $response["updateStatus"] .= "Incorrect Admin Rights.<br>";
        $response["error"] = true;
    }elseif($result == 0){
        // user is updated
        $response["updateStatus"] .= "Success, User Updated.<br>";
    }elseif($result == 1){
        // query failed
        $response["updateStatus"] .= "Failed, Something went wrong try again later.<br>";
        $response["error"] = true;
    }elseif($result == 3){
        // user is updated but the same as before
        $response["updateStatus"] .= "No changes made.<br>";
    }
}elseif(isset($_POST["delete"])){
    $response["postMethod"] = "delete";
    // delete user
    $result = $admin->adminDeleteUser($idData);
    if($result == 2){
        // not enough admin rights
        $response["updateStatus"] .= "Incorrect Admin Rights.<br>";
        $response["error"] = true;
    }elseif($result == 0){
        // user is deleted
        $response["updateStatus"] .= "Success, User Deleted.<br>";
    }elseif($result == 1){
        // query failed
        $response["updateStatus"] .= "Failed, Something went wrong try again later.<br>";
        $response["error"] = true;
    }
}
if($response["updateStatus"] == ""){
    unset($response["updateStatus"]);
}
if($response["updateStatus"] == ""){
    unset($response["updateStatus"]);
}
$response["newUserData"] = $admin->adminGetUser($idData);
if($response["newUserData"] == 1){
    unset($response["newUserData"]);
    $response["UUID"] = $idData;
}
echo json_encode($response);
exit();
?>