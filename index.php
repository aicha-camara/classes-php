<?php

session_start();


require_once 'config.php';  
require_once 'user.php';   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = new User($conn);

    if ($user->connect($login, $password)) {
        $_SESSION['user'] = $user->getAllInfos();

        header("Location: home.php");
        exit(); 
    } else {
        $message = "Échec de la connexion. Veuillez vérifier vos identifiants.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="./assets/style_index.css?v=<?php echo time(); ?>">
   
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form method="POST" action="">
            <label for="login">Login :</label>
            <input type="text" name="login" required><br>
            
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required><br>
            
            <button type="submit">Connexion</button>
        </form>

        <p><?php echo $message; ?></p>

        <p>Pas encore inscrit ? <a href="register.php">Inscrivez-vous ici</a></p>
    </div>
</body>
</html>
