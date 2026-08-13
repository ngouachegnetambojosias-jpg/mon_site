<?php
require_once 'config.php';

try {
    // Ajouter la colonne password si elle n'existe pas
    $sql = "ALTER TABLE users ADD COLUMN IF NOT EXISTS password VARCHAR(255) NOT NULL AFTER email;";
    $pdo->exec($sql);

    echo " La base de données a été mise à jour avec succès !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
