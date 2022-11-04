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
    // data not set
    if(!isset($_POST["adminPass"]) || !isset($_POST["teamid"])){
        $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }
    $result = $admin->adminComparePass($_POST["adminPass"]);
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
        // clear
        $result = $admin->adminDeleteTeam($_POST["teamid"]);
        // delete team
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
            $response["responseResult"] .= "Team deleted.<br>";
            $response["closeOverlay"] = true;
            $response["deletedTeam"] = $_POST["teamid"];
            echo json_encode($response);
            exit();
        }
    }
}elseif($_POST["internalMethod"] == "getTeams"){
    // set filters and find teams
    if(isset($_POST["id"])){
        $idFilter = "";
        $nameFilter = "";
        $playerFilter = "";
        if(isset($_POST["idfilter"])){$idFilter=$_POST["idfilter"];}
        if(isset($_POST["namefilter"])){$nameFilter=$_POST["namefilter"];}
        if(isset($_POST["playerfilter"])){$playerFilter=$_POST["playerfilter"];}else{$playerFilter = "";}

        $teams = $admin->adminGetFilteredTeams($idFilter, $nameFilter, $playerFilter);
    }else{
        $teams = $admin->adminGetAllTeams();
    }
    // send teams data
    if($teams == 1){
        $response["error"] = true;
        $response["responseResult"] .= "No teams found.<br>";
    }else{
        $response["responseResult"] .= "Success.<br>";
        $response["teams"] = $teams;
    }
    echo json_encode($response);
    exit();
}elseif($_POST["internalMethod"] == "edit"){
    // data not set
    if(!isset($_POST["userData"]) || !isset($_POST["adminPass"]) || !isset($_POST["teamid"])){
        $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
        $response["error"] = true;
        echo json_encode($response);
        exit();
    }
    // set user edit data
    $userData = json_decode($_POST["userData"], true);
    $teamid = $_POST["teamid"];
    // compare admin pass
    $result = $admin->adminComparePass($_POST["adminPass"]);
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
        // update/remove users in team/teamname/deleteTeam
        $removedUsers = [];
        $error = false;
        foreach($userData as $key=>$value){
            // $value["id"] = id
            $id = $value["id"];
            $goals = $value["goals"];
            $assists = $value["assists"];
            $remove = $value["remove"];
            if($remove){
                // remove the user from team
                $result = $admin->adminRemoveUserFromTeam($teamid, $id);
                if($result == 0){
                    // success
                    array_push($removedUsers, $id);
                    $response["responseResult"] = "Success, Team Updated.<br>";
                    continue;
                }elseif($result == 1){
                    // error
                    $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
                    $response["error"] = true;
                    $error = true;
                }elseif($result == 2){
                    // not enough rights
                    $response["responseResult"] .= "Incorrect Admin Rights.<br>";
                    $response["error"] = true;
                }
            }else{
                if($goals != "" && preg_match('/[0-9]/', $goals) && $goals >= 0){
                    // update user goals in team
                    $result = $admin->adminUpdateUserTeamGoals($teamid, $id, $goals);
                    // $response["responseResult"] = $result;   // temp
                    // echo json_encode($response);             // temp
                    // exit();                                  // temp
                    if($result == 0){
                        // success
                        $updatedUsers = true;
                        $response["responseResult"] = "Success, Player Stats Updated.<br>";
                    }

                }elseif($goals != ""){
                    $response["responseResult"] = "Goals can only be a positive number.<br>";
                    $response["error"] = true;
                }
                if($assists != "" && preg_match('/[0-9]/', $assists) && $assists >= 0){
                    // update user assists in team
                    $result = $admin->adminUpdateUserTeamAssists($teamid, $id, $assists);
                    if($result == 0){
                        // success
                        $updatedUsers = true;
                        $response["responseResult"] = "Success, Player Stats Updated.<br>";
                    }

                }elseif($assists != ""){
                    $response["responseResult"] = "assists can only be a positive number.<br>";
                    $response["error"] = true;
                }
            }
            
        }
        if(isset($_POST["teamname"]) && $_POST["teamname"] != ""){
            // change teamname
            if(strlen($_POST["teamname"]) < 4 || strlen($_POST["teamname"]) > 64){
                $response["responseResult"] .= "Team name must be between 4-64 characters.<br>";
                $response["error"] = true;
                echo json_encode($response);
                exit();
            }
            $result = $admin->adminUpdateTeamName($teamid, $_POST["teamname"]);
            if($result == 0){
                // success
                $response["responseResult"] = "Success, Teamname Updated.<br>";
                $response["newTeamName"] = $_POST["teamname"];
            }elseif($result == 1){
                // error
                $response["responseResult"] .= "Failed, Something went wrong try again later.<br>";
                $response["error"] = true;
            }elseif($result == 2){
                // not enough rights
                $response["responseResult"] .= "Incorrect Admin Rights.<br>";
                $response["error"] = true;
            }
        }
        if($response["responseResult"] == ''){
            $response["responseResult"] = "nothing changed";
        }
        if($error){
            $response["responseResult"] = "Couldnt remove/update some users.<br>";
        }
        if(isset($updatedUsers)){
            $response["updatedUsers"] = true;
        }
        if(!empty($removedUsers)){
            $response["removedUsers"] = $removedUsers;
        }
        echo json_encode($response);
        exit();
    }
}
?>