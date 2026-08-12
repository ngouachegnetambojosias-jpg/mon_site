<?php
session_start();

$host = getenv('DB_HOST') ?: "mysql-241da189-ngouachegnetambojosias-5bf2.e.aivencloud.com";
$port = getenv('DB_PORT') ?: "14350";
$user = getenv('DB_USER') ?: "avnadmin";
$pass = getenv('DB_PASS'); // Récupéré depuis l'environnement Render
$dbname = getenv('DB_NAME') ?: "defaultdb";

try {
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => true,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion BDD : " . $e->getMessage());
}
?>
