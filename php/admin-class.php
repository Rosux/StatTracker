<?php

require_once "../php/user.php";

class Admin extends User{

    public function __construct() {
        // call parent constructor
        parent::__construct();
        // new constructor functions stuff
        // echo $this->name;
        if($this->admin == 0){
            header("Location: " . "../pages/home.php");
            exit();
        }
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
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$userId]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data[0];
    }

    public function adminSetUserGoals($userId, $amount){
        // error codes:
        // 1 = couldnt update row
        $stmt = $this->conn->prepare("UPDATE users SET goals=? WHERE id=?");
        $stmt->execute([
            $amount,
            $userId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }

    public function adminSetUserAssists($userId, $amount){
        // error codes:
        // 1 = couldnt update row
        $stmt = $this->conn->prepare("UPDATE users SET assists=? WHERE id=?");
        $stmt->execute([
            $amount,
            $userId
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }

    public function adminDeleteUser($userId){

    }

    public function adminUpdateUserStats(){
        // updates user stats based on all the games might take a bit of time
    }
    
}
?>