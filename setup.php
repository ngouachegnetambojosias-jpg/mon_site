<?php
require_once 'config.php';

try {
    // Supprime et recrée la table avec la colonne is_premium
    $pdo->exec("DROP TABLE IF EXISTS users;");

    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_premium TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo " La table 'users' a été recréée avec la colonne 'is_premium' !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
