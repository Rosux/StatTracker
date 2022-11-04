<?php
header('Content-Type: application/json; charset=utf-8');

require_once "../php/admin-class.php";
$admin = new Admin();

$response = [
    "responseResult" => "",
    "closeOverlay" => false,
    "error" => false
];

if(!isset($_POST["internalMethod"])){
    $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
    $response["error"] = true;
    echo json_encode($response);
    exit();
}
if($_POST["internalMethod"] == "create"){
    // create team
    if(!isset($_POST["teamname"]) || !isset($_POST["adminPass"])){
        // return stuff
        $response["responseResult"] .= "Fill in all fields.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }
    $teamname = $_POST["teamname"];
    $adminPass = $_POST["adminPass"];
    if(strlen($teamname) < 4 || strlen($teamname) > 64){
        $response["responseResult"] .= "Team name must be between 4-64 characters.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }
    // check admin pass/perms
    $result = $admin->adminComparePass($adminPass);
    if($result == 1){
        $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }elseif($result == 2){
        $response["responseResult"] .= "Wrong admin password.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }elseif($result == 0){
        // continue
        $result = $admin->adminCreateTeam($teamname);
        if($result == 0){
            // success
            $response["responseResult"] .= "Team is created.<br>";
            $response["closeOverlay"] = true;
        }elseif($result == 1){
            // error
            $response["error"] = true;
            $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
        }elseif($result == 2){
            // no rights
            $response["error"] = true;
            $response["responseResult"] .= "Wrong admin password.<br>";
        }
        echo json_encode($response);
        exit();
    }
}elseif($_POST["internalMethod"] == "delete"){
    // delete team






}elseif($_POST["internalMethod"] == "getTeams"){
    // set filters and find teams
    if(isset($_POST["id"])){
        $idFilter = "";
        $nameFilter = "";
        $playerFilter = "";
        if(isset($_POST["idfilter"])){$idFilter=$_POST["idfilter"];}
        if(isset($_POST["namefilter"])){$nameFilter=$_POST["namefilter"];}
        if(isset($_POST["playerfilter"])){$playerFilter=$_POST["playerfilter"];}

        $teams = $admin->adminGetFilteredTeams($idFilter, $nameFilter, $playerFilter);
    }else{
        $teams = $admin->adminGetAllTeams();
    }
    // send teams data
    if($teams == 1){
        $response["error"] = true;
        $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
    }else{
        $response["responseResult"] .= "Success.<br>";
        $response["teams"] = $teams;
    }
    echo json_encode($response);
    exit();
}








?>