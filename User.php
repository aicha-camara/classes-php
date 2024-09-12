<?php

require_once 'config.php';

class User {
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $conn;

    public function __construct($conn, $login = '', $email = '', $firstname = '', $lastname = '', $password = '') {
        $this->conn = $conn;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
    }

    public function register($login, $email, $firstname = '', $lastname = '', $password = '') {
        $query = "INSERT INTO utilisateurs(login, email, firstname, lastname, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $login, $email, $firstname, $lastname, $password);
        $result = $stmt->execute();
        
        if ($result) {
            $id = $this->conn->insert_id;
            $query = "SELECT * FROM utilisateurs WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $userInfo = $result->fetch_assoc();
            $stmt->close();
            
            return $userInfo;
        }
        
        return false;
    }

    public function connect($login, $password) {
        $query = "SELECT id, login, email, firstname, lastname FROM utilisateurs WHERE login = ? AND password = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->id = $user["id"];
            $this->login = $user["login"];
            $this->email = $user["email"];
            $this->firstname = $user["firstname"];
            $this->lastname = $user["lastname"];
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $this->id;
            
            $stmt->close();
            return true;
        }
        
        $stmt->close();
        return false;
    }

    public function disconnect() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->password = null;
    
        return true;
    }

    public function delete() {
        if ($this->id === null) {
            return false; 
        }
        
        $query = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $result = $stmt->execute();
        $stmt->close();
        
        if ($result) {
            $this->disconnect();
            return true;
        }
        
        return false;   
    }

    public function update($login, $email, $firstname, $lastname) {
        if ($this->id === null) {
            return false;
        }

        $query = "UPDATE utilisateurs SET login = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssssi', $login, $email, $firstname, $lastname, $this->id);
        return $stmt->execute();
    }
    
    public function isConnected() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    public function getAllInfos() {
        if ($this->id === null) {
            return false;
        }

        $query = "SELECT * FROM utilisateurs WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->login = $user["login"];
            $this->email = $user["email"];
            $this->firstname = $user["firstname"];
            $this->lastname = $user["lastname"];
            $this->password = $user["password"];
            return $user;
        }

        return false;
    }
     public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }
}

?>
