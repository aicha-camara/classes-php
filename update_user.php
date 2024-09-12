<?php
session_start();
require_once 'config.php';
require_once 'User.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user = new User($conn);
$user->setId($_SESSION['user_id']);

if (isset($_POST['update_user'])) {
    $email = $_POST['email'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $login = $_POST['login'];
    $id = $_POST['id']; 

    $updateResult = $user->update($login, $email, $firstname, $lastname);

    if ($updateResult) {
        header('Location: home.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour des informations.";
    }
} else {
    echo "Erreur : requête non valide.";
}
?>
