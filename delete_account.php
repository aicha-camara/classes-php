<?php
session_start();
require_once 'config.php';
require_once 'user.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user = new User($conn);
$user->setId($_SESSION['user_id']);

if (isset($_POST['delete_account'])) {
    $deleteResult = $user->delete();

    if ($deleteResult) {
        header('Location: index.php');
        exit();
    } else {
        echo "Erreur lors de la suppression du compte.";
    }
} else {
    echo "Erreur : requête non valide.";
}
?>
