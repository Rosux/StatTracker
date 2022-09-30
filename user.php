<?php

// RETURN ERRORS:
// 0 = always true / successfull operation
// 1-9 = false+errorCode

// pages for easy linking
$pdo = "./pdo.php";
$home = "./home.php";
$login = "./login.php";
$logout = "./logout.php";
$cookieName = "stat-tracker-tokn";



class User {

    private $conn;
    public $id;
    public $name;
    public $email;
    public $goals;
    public $assists;

    public function __construct() {
        require_once $pdo;
        $this->conn = $connection;
        session_start();
        if($this->checkLoggedIn() == 0){
            $this->setUserData();
        }
    }

    private function setUserData() {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        if(!$stmt->execute([$_SESSION["id"]])){
            $this->logout();
            header("Location: " + $login);
            exit();
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->id = $data[0]["id"];
        $this->name = $data[0]["name"];
        $this->email = $data[0]["email"];
        $this->goals = $data[0]["goals"];
        $this->assists = $data[0]["assists"];
    }

    public function register($name, $email, $password) {
        // error codes:
        // 1 = email already in use
        // 2 = failed insert statement
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            return 1;
        }
        // INSERT INTO `users` (`name`, `email`, `password`, `goals`, `assists`, `id`) VALUES ('name', 'email', 'password', '0', '0', NULL);\
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $registerUser = [
            "name" => htmlspecialchars($name),
            "email" => htmlspecialchars($email),
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ];
        $stmt->execute($registerUser);
        if($stmt->rowCount() == 0){
            return 2;
        }
        return 0;
    }

    
    public function getUser($id){
        // error codes:
        // 1 = couldnt find user / user does not exist
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([
            $id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // public function updateUser(){
    //     $stmt = $this->conn->prepare("UPDATE users SET name=?, email=?, password=?");
    //     $stmt->execute([
    //         htmlspecialchars($firstname),
    //         htmlspecialchars($lastname),
    //         date("Y/m/d/h/m/s"),
    //         htmlspecialchars($street),
    //         htmlspecialchars($postalcode),
    //         htmlspecialchars($livingplace)
    //     ]);
    //     if($stmt->rowCount() != 0){
    //         return 0;
    //     }else{
    //         return false;
    //     }
    // }

    public function changePasswords($oldpassword, $newpassword){
        // error codes:
        // 1 = user not found
        // 2 = incorrect old password
        // 3 = couldnt update row
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
        $stmt->execute([
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($oldpassword, $data[0]["password"])){
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->execute([
            password_hash($newpassword, PASSWORD_DEFAULT),
            $this->id
        ]);
        if($stmt->rowCount() == 1){
            return 0;
        }else{
            return 3;
        }
    }

    public function login($email, $password, $remember=false){
        // error codes:
        // 1 = user not found
        // 2 = password doesnt match
        // 3 = cant execute query
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->execute([
            $email
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $data[0]["password"])){   
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE users SET login_token=? WHERE email=?");
        $stmt->execute([
            null,
            $email
        ]);
        $_SESSION["id"] = $data[0]['id'];
        $this->setUserData();
        if($remember){
            $logintoken = bin2hex(random_bytes(32));
            // anytime you require a login it checks if the token and cookie match. if so ur logged in and a new token gets generated every time
            $stmt = $this->conn->prepare("UPDATE users SET login_token=? WHERE email=?");
            $stmt->execute([
                password_hash($logintoken, PASSWORD_DEFAULT),
                $email
            ]);
            if($stmt->rowCount() == 0){
                return 3;
            }
            // set cookie and make checklogin func
            setcookie($cookieName, $logintoken, time() + (86400 * 30), "/", "", true, true);
            return 0;
        }
        return 0;
    }

    public function logout(){
        if (isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]); 
            setcookie($cookieName, null, -1, '/');
        }
        session_unset();
        session_destroy();
    }

    public function checkLoggedIn() {
        if(isset($_SESSION["id"])) {
            return 0;
        } else {
            return 1;
        }
    }

    public function protectPage(){
        if($this->checkLoggedIn() != 0){
            $this->logout();
            header("Location: " + $login);
            exit();
        }
    }

    public function updateGoals($goals){
        // error codes:
        // 1 = couldnt update row
        $stmt = $this->conn->prepare("UPDATE users SET goals=? WHERE id=?");
        $stmt->execute([
            $goals,
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }
    
    public function updateAssists($assists){
        // error codes:
        // 1 = couldnt update row
        $stmt = $this->conn->prepare("UPDATE users SET assists=? WHERE id=?");
        $stmt->execute([
            $assists,
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        return 0;
    }
}
?>