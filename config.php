<?php
$servername = "localhost";
$username = "root";
$password = "za9?-U5zwD4-6#L";
$dbname = "classes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
