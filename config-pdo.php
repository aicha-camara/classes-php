<?php
require_once 'user-pdo.php';

$dsn = 'mysql:host=localhost;dbname=classes';
$username = 'root'; 
$password = '';     
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Connexion réussie.<br>";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "<br>";
    exit();
}

$user = new Userpdo($pdo);

echo "Enregistrement d'un nouvel utilisateur :<br>";
$registerResult = $user->register('login', 'email@example.com', 'firstname', 'lastname', 'password');
if ($registerResult) {
    echo "Enregistrement réussi.<br>";
    print_r($registerResult);
} else {
    echo "Échec de l'enregistrement.<br>";
}

echo "Connexion d'un utilisateur :<br>";
$connectResult = $user->connect('login', 'password');
if ($connectResult) {
    echo "Connexion réussie.<br>";
    echo "ID utilisateur : " . $user->getId() . "<br>";
} else {
    echo "Échec de la connexion.<br>";
}

echo "Mise à jour des informations de l'utilisateur :<br>";
$updateResult = $user->update('newLogin', 'newEmail@example.com', 'newFirstname', 'newLastname');
if ($updateResult) {
    echo "Mise à jour réussie.<br>";
} else {
    echo "Échec de la mise à jour.<br>";
}

echo "Déconnexion de l'utilisateur :<br>";
$disconnectResult = $user->disconnect();
if ($disconnectResult) {
    echo "Déconnexion réussie.<br>";
} else {
    echo "Échec de la déconnexion.<br>";
}

echo "Enregistrement du deuxième utilisateur :<br>";
$registerResult = $user->register('login2', 'email2@example.com', 'firstname2', 'lastname2', 'password2');
if ($registerResult) {
    echo "Enregistrement réussi.<br>";
    print_r($registerResult);
    $user->setId($registerResult['id']);
} else {
    echo "Échec de l'enregistrement.<br>";
}

echo "Suppression du deuxième utilisateur :<br>";
$deleteResult = $user->delete();
if ($deleteResult) {
    echo "Suppression réussie.<br>";
} else {
    echo "Échec de la suppression.<br>";
}
?>
