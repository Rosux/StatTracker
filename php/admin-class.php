<?php

require_once "../php/user.php";

class Admin extends User{

    public function __construct() {
        // call parent constructor
        parent::__construct();
        // new constructor functions stuff
        if($this->admin == 0){
            header("Location: " . "../pages/home.php");
            exit();
        }
    }

    public function adminAddUserToTeam($teamId, $userId){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        if($this->admin < 2){
            return 2;
        }
        // select players and convert into array
        $stmt = $this->conn->prepare("SELECT players FROM teams WHERE id=?");
        $stmt->execute([
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["players"];



        // fix
        $data = json_decode($data, true);
        if($data == null){
            $data = array();
        }
        if(!isset($data[$userId])){
            array_push($data, array(intval($userId)=>array("goals"=>0,"assists"=>0)));



            // fix



            $stmt = $this->conn->prepare("UPDATE teams SET players=? WHERE id=?");
            $stmt->execute([
                json_encode($data),
                $teamId
            ]);
            if($stmt->rowCount() == 0){
                return 1;
            }
            $this->adminUpdateUserStats($userId);
        }
        
        return 0;
    }

    public function adminDeleteTeam($teamid){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        if($this->admin < 2){
            return 2;
        }
        $data = null;
        $stmt = $this->conn->prepare("SELECT players FROM teams WHERE id=?");
        $stmt->execute([
            $teamid
        ]);
        if($stmt->rowCount() != 0){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["players"];
            $data = json_decode($data, true);
        }
        $stmt = $this->conn->prepare("DELETE FROM teams WHERE id=?");
        $stmt->execute([
            $teamid
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        if($data != null){
            foreach((array)$data as $key => $value){
                $this->adminUpdateUserStats($key);
            }
        }
        return 0;
    }

    public function adminUpdateTeamName($teamid, $teamName){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        if($this->admin < 2){
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE teams SET name=? WHERE id=?");
        $stmt->execute([
            $teamName,
            $teamid
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }

    // remove user from team
    public function adminRemoveUserFromTeam($teamId, $userId){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        if($this->admin < 2){
            return 2;
        }
        // select players and convert into array
        $stmt = $this->conn->prepare("SELECT players FROM teams WHERE id=?");
        $stmt->execute([
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        // convert data to json and decode to array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["players"];
        $data = json_decode($data, true);
        unset($data[strval($userId)]);
        $stmt = $this->conn->prepare("UPDATE teams SET players=? WHERE id=?");
        $stmt->execute([
            json_encode($data),
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $this->adminUpdateUserStats($userId);
        return 0;
    }
    // update goals on team
    public function adminUpdateUserTeamGoals($teamId, $userId, $goals){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        if($this->admin < 1){
            return 2;
        }
        // select players and convert into array
        $stmt = $this->conn->prepare("SELECT players FROM teams WHERE id=?");
        $stmt->execute([
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        // convert data to json and decode to array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["players"];
        $data = json_decode($data, true);
        $data[strval($userId)]["goals"] = intval($goals);
        $stmt = $this->conn->prepare("UPDATE teams SET players=? WHERE id=?");
        $stmt->execute([
            json_encode($data),
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $this->adminUpdateUserStats($userId);
        return 0;
    }
    // update assists on team
    public function adminUpdateUserTeamAssists($teamId, $userId, $assists){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        if($this->admin < 1){
            return 2;
        }

        
        // select players and convert into array
        $stmt = $this->conn->prepare("SELECT players FROM teams WHERE id=?");
        $stmt->execute([
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        // convert data to json and decode to array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["players"];
        $data = json_decode($data, true);
        $data[strval($userId)]["assists"] = intval($assists);
        $stmt = $this->conn->prepare("UPDATE teams SET players=? WHERE id=?");
        $stmt->execute([
            json_encode($data),
            $teamId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $this->adminUpdateUserStats($userId);
        return 0;

    }


    // create new team
    public function adminCreateTeam($teamName){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = not enough rights
        // INSERT INTO teams (name, players, team_goals, team_assists) VALUES (:name, :players, :team_goals, :team_assists),
        if($this->admin < 2){
            return 2;
        }
        $stmt = $this->conn->prepare("INSERT INTO teams (name, team_goals, team_assists) VALUES (:name, :team_goals, :team_assists)");
        $teamData = [
            "name" => htmlspecialchars($teamName),
            "team_goals" => 0,
            "team_assists" => 0
        ];
        $stmt->execute($teamData);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }
    
    // get all teams
    public function adminGetTeam($id){
        // error codes:
        // data = success
        // 1 = error
        $stmt = $this->conn->prepare("SELECT * FROM teams WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data[0];
    }

    // get all teams
    public function adminGetAllTeams(){
        // error codes:
        // data = success
        // 1 = error
        $stmt = $this->conn->prepare("SELECT * FROM teams");
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // get filtered teams
    public function adminGetFilteredTeams($teamid, $name, $playerid){
        // error codes:
        // data = success
        // 1 = no users found
        // initialize query
        $q = "SELECT * FROM teams WHERE 1";
        // add query filters
        if($teamid != ""){$q .= " AND id LIKE :id ";}
        if($name != ""){$q .= " AND name LIKE :name ";}
        if($playerid != ""){$q .= " AND players REGEXP ([^0-9])( :playerid )([^0-9]) ";}
        // prepare query
        $stmt = $this->conn->prepare($q);
        // bind query parameters
        if($teamid != ""){$stmt->bindValue(":id", "%".$teamid."%", PDO::PARAM_STR);}
        if($name != ""){$stmt->bindValue(":name", "%".$name."%", PDO::PARAM_STR);}
        if($playerid != ""){$stmt->bindValue(":playerid", "%".$playerid."%", PDO::PARAM_STR);}
        // execute cool awesome custom filtered query
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
    // find a team based on user id
    public function getUserTeams($id){
        // ([^0-9])( ID-HERE )([^0-9])
        $query = "([^0-9])(".$id.")([^0-9])";
        $stmt = $this->conn->prepare("SELECT * FROM teams WHERE players REGEXP '$query'");
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 0;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function adminComparePass($password){
        // error codes:
        // 0 = success
        // 1 = error
        // 2 = false password
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->execute([
            $this->email
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $data[0]["password"])){
            return 2;
        }
        return 0;
    }

    public function adminGetAllUsers(){
        $stmt = $this->conn->prepare("SELECT id,name,email FROM users");
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function adminGetAllFilteredUsers($idFilter="", $nameFilter="", $emailFilter=""){
        // initialize query
        $q = "SELECT id,name,email,goals,assists FROM users WHERE 1";
        // add query filters
        if($idFilter != ""){$q .= " AND id LIKE :id ";}
        if($nameFilter != ""){$q .= " AND name LIKE :name ";}
        if($emailFilter != ""){$q .= " AND email LIKE :email ";}
        // prepare query
        $stmt = $this->conn->prepare($q);
        // bind query parameters
        if($idFilter != ""){$stmt->bindValue(":id", "%".$idFilter."%", PDO::PARAM_STR);}
        if($nameFilter != ""){$stmt->bindValue(":name", "%".$nameFilter."%", PDO::PARAM_STR);}
        if($emailFilter != ""){$stmt->bindValue(":email", "%".$emailFilter."%", PDO::PARAM_STR);}
        // execute cool awesome custom filtered query
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function adminGetUser($userId){
        $stmt = $this->conn->prepare("SELECT id,name,email,goals,assists,admin FROM users WHERE id=?");
        $stmt->execute([$userId]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data[0];
    }

    // public function adminSetUserGoals($userId, $amount){
    //     // error codes:
    //     // 1 = couldnt update row
    //     $stmt = $this->conn->prepare("UPDATE users SET goals=? WHERE id=?");
    //     $stmt->execute([
    //         $amount,
    //         $userId
    //     ]);
    //     if($stmt->rowCount() == 0){
    //         return 1;
    //     }
    //     return 0;
    // }

    // public function adminSetUserAssists($userId, $amount){
    //     // error codes:
    //     // 1 = couldnt update row
    //     $stmt = $this->conn->prepare("UPDATE users SET assists=? WHERE id=?");
    //     $stmt->execute([
    //         $amount,
    //         $userId
    //     ]);
    //     if($stmt->rowCount() == 0){
    //         return 1;
    //     }
    //     return 0;
    // }

    public function adminUpdateUser($userId, $newData){
        // error codes:
        // 0 = success
        // 1 = couldnt update row
        // 2 = incorrect admin rights
        // 3 = data the same
        if($this->admin < 3 || $this->adminGetUser($userId)["admin"] > $this->admin || ($newData["admin"] == 3 && $this->admin < 4) || ($newData["admin"] == 4 && $this->admin < 4)){
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE users SET name=?, email=?, goals=?, assists=?, admin=? WHERE id=?");
        $stmt->execute([
            $newData["name"],
            $newData["email"],
            $newData["goals"],
            $newData["assists"],
            $newData["admin"],
            $userId
        ]);
        if($stmt->rowCount() == 0){
            if(!$stmt){
                return 1;
            }
            return 3;
        }
        return 0;
    }

    public function adminBulkDeleteUser($userIds){
        // error codes:
        // 0 = success
        // array = couldnt delete rows
        // 2 = incorrect admin rights
        // DELETE FROM users WHERE id IN (91, 90)

        if($this->admin < 3){
            return 2;
        }
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");

        $errorIds = [];
        for($i=0;$i<count($userIds);$i++){
            if($userIds[$i] == ""){
                continue;
            }
            if($this->adminGetUser($userIds[$i]) == 1){
                continue;
            }elseif($this->adminGetUser($userIds[$i])["admin"] >= $this->admin){
                array_push($errorIds,$userIds[$i]);
            }else{
                $stmt->execute([$userIds[$i]]);
                if($stmt->rowCount() == 0){
                    array_push($errorIds,$userIds[$i]);
                }
            } 
        }
        if(isset($errorIds[0])){
            return $errorIds;
        }
        return 0;
    }
    
    public function adminDeleteUser($userId){
        // error codes:
        // 0 = success
        // 1 = couldnt delete row
        // 2 = incorrect admin rights
        if($this->admin < 3 || $this->adminGetUser($userId)["admin"] >= $this->admin){
            return 2;
        }
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([$userId]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }

    public function adminUpdateUserStats($userId){
        // updates user stats based on all the games might take a bit of time
        $totalGoals = 0;
        $totalAssists = 0;
        $data = $this->getUserTeams($userId);
        foreach($data as $key=>$value){
            $user = json_decode($value["players"], true);
            $totalGoals += $user[intval($userId)]["goals"];
            $totalAssists += $user[intval($userId)]["assists"];
        }
        $stmt = $this->conn->prepare("UPDATE users SET goals=?, assists=? WHERE id=?");
        $stmt->execute([
            $totalGoals,
            $totalAssists,
            $userId
        ]);
    }
    
    public function protectPage(){
        if($this->checkLoggedIn() != 0){
            $this->logout();
            header("Location: " . "../pages/login.php");
            exit();
        }
    }
}
?>