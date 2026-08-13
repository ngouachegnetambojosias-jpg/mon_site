<?php
require_once 'config.php';

try {
    // Supprime l'ancienne table si elle existe pour repartir sur une base propre
    $pdo->exec("DROP TABLE IF EXISTS users;");

    // Recrée la table avec les bons noms de colonnes (email, password, etc.)
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo " La table 'users' a été recréée avec succès avec la colonne 'password' !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
