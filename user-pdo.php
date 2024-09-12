<?php
require_once 'config-pdo.php';


class Userpdo {
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    private $pdo;

    public function __construct($pdo, $login = '', $email = '', $firstname = '', $lastname = '', $password = '') {
        $this->pdo = $pdo;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM utilisateurs WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }
    public function register($login, $email, $firstname, $lastname, $password) {
        $query = "INSERT INTO utilisateurs (login, email, firstname, lastname, password) VALUES (:login, :email, :firstname, :lastname, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':password', $password);
        $result = $stmt->execute();
    
        if ($result) {
            $id = $this->pdo->lastInsertId();
            return $this->getUserById($id);
        }
    
        return false;
    }
    

    public function connect($login, $password) {
        $query = "SELECT id, login, email, firstname, lastname FROM utilisateurs WHERE login = :login AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $user['id'];
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $this->id;

            return true;
        }

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

        $query = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $result = $stmt->execute();

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

        $query = "UPDATE utilisateurs SET login = :login, email = :email, firstname = :firstname, lastname = :lastname WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function getAllInfos() {
        if ($this->id === null) {
            return false;
        }

        $query = "SELECT * FROM utilisateurs WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
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