<?php
header('Content-Type: application/json; charset=utf-8');




if(isset($_POST["id"])){
    $idData = $_POST["id"];
}
if(isset($_POST["username"])){
    $nameData = $_POST["username"];
}
if(isset($_POST["email"])){
    $emailData = $_POST["email"];
}
if(isset($_POST["goals"])){
    $goalsData = $_POST["goals"];
}
if(isset($_POST["assists"])){
    $assistsData = $_POST["assists"];
}
if(isset($_POST["admin"])){
    $adminData = $_POST["admin"];
}

require_once "../php/admin-class.php";
$admin = new Admin();

$response = [
    "updateStatus" => "",
    "error" => false
];
if(isset($_POST["update"])){
    if(!isset($_POST["adminPass"])){
        $response["postMethod"] = "update";
        $response["updateStatus"] .= "Admin password not set.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }else{
        $result = $admin->adminComparePass($_POST["adminPass"]);
        if($result == 1){
            $response["postMethod"] = "update";
            $response["updateStatus"] .= "Failed, Something went wrong try again later.<br>";
            $response["error"] = true;
            echo json_encode($response);
            exit();
        }elseif($result == 2){
            $response["postMethod"] = "update";
            $response["updateStatus"] .= "Wrong admin password.<br>";
            $response["error"] = true;
            echo json_encode($response);
            exit();
        }elseif($result == 0){
            $response["postMethod"] = "update";
            // update user
            // create original data and update each value
            if(!isset($idData)){
                $response["postMethod"] = "update";
                $response["updateStatus"] .= "No users selected.<br>";
                $response["error"] = true;
                echo json_encode($response);
                exit();
            }
            $userData = $admin->adminGetUser($idData);
            $updateData = [
                "name" => $userData["name"],
                "email" => $userData["email"],
                "goals" => $userData["goals"],
                "assists" => $userData["assists"],
                "admin" => $userData["admin"]
            ];
            // check if data isset and change the updatedData
            if(isset($goalsData) && $goalsData != ""){
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
            if(isset($assistsData) && $assistsData != ""){
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
            if(isset($adminData) && $adminData != ""){
                $updateData["admin"] = $adminData;
            }
            if(isset($nameData) && $nameData != ""){
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
            if(isset($emailData) && $emailData != ""){
                if(!filter_var($emailData, FILTER_VALIDATE_EMAIL)){
                    $response["updateStatus"] .= "Email is not valid<br>";
                    $response["error"] = true;
                }else{
                    $updateData["email"] = $emailData;
                }
            }
            if(isset($idData)){
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
            }
        }
    }
}elseif(isset($_POST["delete"])){
    // bulk delete
    if(!isset($_POST["adminPass"])){
        $response["postMethod"] = "delete";
        $response["updateStatus"] .= "Admin password not set.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }else{
        $result = $admin->adminComparePass($_POST["adminPass"]);
        if($result == 1){
            $response["postMethod"] = "delete";
            $response["updateStatus"] .= "Failed, Something went wrong try again later.<br>";
            $response["error"] = true;
            echo json_encode($response);
            exit();
        }elseif($result == 2){
            $response["postMethod"] = "delete";
            $response["updateStatus"] .= "Wrong admin password.<br>";
            $response["error"] = true;
            echo json_encode($response);
            exit();
        }elseif($result == 0){
            $response["postMethod"] = "delete";
            // delete user
            if(isset($idData)){
                $result = $admin->adminBulkDeleteUser($idData);
                if($result == 2){
                    // not enough admin rights
                    $response["updateStatus"] .= "Incorrect Admin Rights.<br>";
                    $response["error"] = true;
                    echo json_encode($response);
                    exit();
                }elseif($result == 0){
                    // users are all deleted
                    $response["UUID"] = $idData;
                    $response["updateStatus"] .= "Success, User Deleted.<br>";
                    echo json_encode($response);
                    exit();
                }elseif(is_array($result)){
                    // couldnt delete all users
                    $responseDeletedUsers = [];
                    for($i=0;$i<count($idData);$i++){
                        if($admin->adminGetUser($idData[$i]) == 1){
                            // user is deleted
                            array_push($responseDeletedUsers, $idData[$i]);
                        }
                    }
                    $response["UUID"] = $responseDeletedUsers;
                    $response["updateStatus"] .= "Couldn't delete all users.<br>";
                    $response["error"] = true;
                    echo json_encode($response);
                    exit();
                }
            }
        }
    }
}elseif(isset($_POST["addToTeam"])){
    // add users to team
    if(!isset($_POST["adminPass"])){
        $response["postMethod"] = "addToTeam";
        $response["updateStatus"] .= "Admin password not set.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }
    $result = $admin->adminComparePass($_POST["adminPass"]);
    if($result == 1){
        $response["postMethod"] = "addToTeam";
        $response["updateStatus"] .= "Failed, Something went wrong try again later.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }elseif($result == 2){
        $response["postMethod"] = "addToTeam";
        $response["updateStatus"] .= "Wrong admin password.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }elseif($result == 0){

        $response["postMethod"] = "addToTeam";
        $response["updateStatus"] = "Users added to team.<br>";

        $ids = $_POST["id"];
        $teamId = $_POST["teamId"];
        foreach($ids as $key=>$value){
            $result = $admin->adminAddUserToTeam($teamId, $value);
            if($result == 1){
                $response["updateStatus"] = "Failed, Something went wrong try again later.<br>";
            }
        }
        $response["closeOverlay"] = true;









    }
    echo json_encode($response);
    exit();
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