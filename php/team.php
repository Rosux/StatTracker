<?php

// RETURN ERRORS:
// 0 = always true / successfull operation
// 1-9 = false+errorCode
class Team {
    public $pdo = "pdo.php";

    private $conn;
    public $id;
    public $name;
    public $players;

    public function __construct() {
        require_once $this->pdo;
        $this->conn = $conn;
    }

    public function getTeam($id){

    }

    public function addPlayer(){

    }
    
    public function removePlayer(){

    }

    public function changeName(){

    }
}
?>