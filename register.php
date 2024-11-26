<?php
session_start();
require_once 'config.php';
require_once 'user.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'], $_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $user = new User($conn);

        $userInfo = $user->register($login, $email, $firstname, $lastname, $password);
        if ($userInfo) {
            header('Location: index.php');
            exit();
        } else {
            $message = "Erreur d'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="./assets/style_register.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form method="POST" action="">
            <label for="login">Login :</label>
            <input type="text" name="login" id="login" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="firstname">Prénom :</label>
            <input type="text" name="firstname" id="firstname" required>

            <label for="lastname">Nom :</label>
            <input type="text" name="lastname" id="lastname" required>  

            <button type="submit">S'inscrire</button>
        </form>
        <p><?php echo $message; ?></p>
        <p>Déjà inscrit ? <a href="index.php">Connectez-vous ici</a></p>
    </div>
</body>
</html>
