<?php
session_start();

$host = "VOTRE_HOST_MYSQL";
$user = "VOTRE_UTILISATEUR";
$pass = "VOTRE_MOT_DE_PASSE";
$dbname = "VOTRE_BDD";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
