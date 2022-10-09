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
    public $goals;
    public $assists;

    public function __construct($id) {
        require $this->pdo;
        $this->conn = $conn;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $x = $this->setTeamData($id);
        if($x == 1){
            return 1;
        };
    }

    private function setTeamData($id){
        $stmt = $this->conn->prepare("SELECT * FROM teams WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->id = $data[0]["id"];
        $this->name = $data[0]["name"];
        $this->players = json_decode($data[0]["players"]);
        $this->goals = $data[0]["team_goals"];
        $this->assists = $data[0]["team_assists"];
    }

    public function addPlayer(){

    }
    
    public function removePlayer(){

    }

    public function setPlayerScore(){

    }

    public function setName(){

    }

    public function getPlayerName($id){
        // error codes:
        // 1 = user not found
        $stmt = $this->conn->prepare("SELECT name FROM users WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]["name"];
    }
}
?>