<?php

// RETURN ERRORS:
// 0 = always true / successfull operation
// 1-9 = false+errorCode

class Profile {
    public $pdo = "pdo.php";

    private $conn;
    public $id;
    public $name;
    public $goals;
    public $assists;

    public function __construct($id) {
        require $this->pdo;
        $this->conn = $conn;
        try{
            $this->setUserData($id);
        }catch(Exception $e){
            return $e->getMessage();
        }
        
    }

    private function setUserData($id) {
        // error codes:
        // 1 = user not found
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $result = $stmt->execute([$id]);
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
            throw new Exception(1);
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->id = $data[0]["id"];
        $this->name = $data[0]["name"];
        $this->goals = $data[0]["goals"];
        $this->assists = $data[0]["assists"];
    }
}
?>