<?php

// RETURN ERRORS:
// 0 = always true / successfull operation
// 1-9 = false+errorCode

class User{
    public $pdo = "pdo.php";

    public $conn;
    public $id;
    public $name;
    public $email;
    public $goals;
    public $assists;
    public $admin;

    public function __construct() {
        require $this->pdo;
        $this->conn = $conn;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if($this->checkLoggedIn() == 0){
            $this->setUserData();
        }
    }

    private function setUserData() {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$_SESSION["id"]]);
        if($stmt->rowCount() == 0){
            $this->logout();
            header("Location: " . "../pages/login.php");
            exit();
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->id = $data[0]["id"];
        $this->name = $data[0]["name"];
        $this->email = $data[0]["email"];
        $this->goals = $data[0]["goals"];
        $this->assists = $data[0]["assists"];
        $this->admin = $data[0]["admin"];
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
    public function updateName($newName, $password){
        // error codes:
        // 1 = user not found
        // 2 = current password incorect
        // 3 = couldnt update user row
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $data[0]["password"])){
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->execute([
            htmlspecialchars($newName),
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 3;
        }
        return 0;
    }

    public function updateEmail($newemail, $password){
        // error codes:
        // 1 = user not found
        // 2 = current password incorect
        // 3 = couldnt update user row
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $data[0]["password"])){
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE users SET email=? WHERE id=?");
        $stmt->execute([
            htmlspecialchars($newemail),
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 3;
        }
        return 0;
    }

    public function updatePassword($newpassword, $password){
        // error codes:
        // 1 = user not found
        // 2 = current password incorect
        // 3 = couldnt update user row
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 1;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $data[0]["password"])){
            return 2;
        }
        $stmt = $this->conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->execute([
            password_hash($newpassword, PASSWORD_DEFAULT),
            $this->id
        ]);
        if($stmt->rowCount() == 0){
            return 3;
        }
        return 0;
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
            setcookie("stat-tracker-tokn", $logintoken, time() + (86400 * 30), "/", "", true, true);
            return 0;
        }
        return 0;
    }

    public function logout(){
        if (isset($_COOKIE["stat-tracker-tokn"])) {
            unset($_COOKIE["stat-tracker-tokn"]); 
            setcookie("stat-tracker-tokn", null, -1, '/');
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
            header("Location: " . "../pages/login.php");
            exit();
        }
    }

    // TODO remove soon if safe
    // public function updateGoals($goals){
    //     // error codes:
    //     // 1 = couldnt update row
    //     $stmt = $this->conn->prepare("UPDATE users SET goals=? WHERE id=?");
    //     $stmt->execute([
    //         $goals,
    //         $this->id
    //     ]);
    //     if($stmt->rowCount() == 0){
    //         return 1;
    //     }
    //     return 0;
    // }
    // public function updateAssists($assists){
    //     // error codes:
    //     // 1 = couldnt update row
    //     $stmt = $this->conn->prepare("UPDATE users SET assists=? WHERE id=?");
    //     $stmt->execute([
    //         $assists,
    //         $this->id
    //     ]);
    //     if($stmt->rowCount() == 0){
    //         return 1;
    //     }
    //     return 0;
    // }

    public function getTeams(){
        // ([^0-9])( ID-HERE )([^0-9])
        $query = "([^0-9])(".$_SESSION["id"].")([^0-9])";
        $stmt = $this->conn->prepare("SELECT * FROM teams WHERE players REGEXP '$query'");
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 0;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getTeam($id){
        $stmt = $this->conn->prepare("SELECT * FROM teams WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
            return 0;
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}

?>