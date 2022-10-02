<?php
// RETURN ERRORS:
// 0 = always true / successfull operation
// 1-9 = false+errorCode
class Game {
    public $pdo = "pdo.php";

    private $conn;
    public $id;
    public $team1_id;
    public $team2_id;
    public $scoreteam1_score;
    public $scoreteam2_score;
    public $date;

    public function __construct($id) {
        // error codes:
        // 1 = game not found (id wrong)
        require $this->pdo;
        $this->conn = $conn;
        // SELECT * FROM games WHERE id = $id
        $stmt = $this->conn->prepare("SELECT * FROM games WHERE id=?");
        if(!$stmt->execute([$id])){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->id = $data[0]["id"];
        $this->team1_id = $data[0]["team1_id"];
        $this->team2_id = $data[0]["team2_id"];
        $this->scoreteam1_score = $data[0]["scoreteam1_score"];
        $this->scoreteam2_score = $data[0]["scoreteam2_score"];
        $this->date = $data[0]["date"];
    }
}
?>