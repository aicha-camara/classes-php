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

    $userInfo = $user->getAllInfos();

    if (!$userInfo) {
        echo "Erreur : utilisateur non trouvé.";
        exit();
    }
    ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="./assets/style_home.css?v=<?php echo time(); ?>">

    
<body>
    <div class="container">
        <h2>Bienvenue, <?php echo htmlspecialchars($userInfo['firstname']) . ' ' . htmlspecialchars($userInfo['lastname']); ?>!</h2>
        
        <form method="POST" action="update_user.php">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required>

            <label for="lastname">Nom de famille :</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($userInfo['lastname']); ?>" required>

            <label for="firstname">Prénom :</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($userInfo['firstname']); ?>" required>

            <label for="login">Login :</label>
            <input type="text" name="login" id="login" value="<?php echo htmlspecialchars($userInfo['login']); ?>" required>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userInfo['id']); ?>">

            <button type="submit" name="update_user">Mettre à jour</button>
        </form>

        <form method="POST" action="delete_account.php">
            <button type="submit" name="delete_account" class="delete-button">Supprimer mon compte</button>
        </form>

        <p><a href="logout.php">Déconnexion</a></p>
    </div>
</body>
</html>
