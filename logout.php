<?php
session_start();
require_once 'config.php';
require_once 'user.php';

$user = new User($conn);

$user->disconnect();

header('Location: index.php');
exit();
?>
