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

    public function adminFindUser($userId){

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