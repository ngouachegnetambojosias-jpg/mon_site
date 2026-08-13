<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupération des variables d'environnement de Render
$host = getenv('DB_HOST') ?: '127.0.0.1'; // '127.0.0.1' force TCP/IP au lieu du socket Unix
$port = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'upskill';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

$pdo = null;

try {
    // Ajout de port=$port pour éviter le blocage du socket local
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
