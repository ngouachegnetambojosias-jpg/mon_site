<?php
require_once 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($nom) && !empty($email) && !empty($password)) {
        try {
            // Hachage du mot de passe pour la sécurité
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Insertion dans la table users (en gérant les colonnes password ou mot_de_passe)
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (:nom, :email, :password)");
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':password' => $hash
            ]);

            $message = "<p style='color: green;'>Inscription réussie ! <a href='login.php'>Se connecter</a></p>";
        } catch (PDOException $e) {
            // Si la colonne 'password' n'existe pas, on tente 'mot_de_passe'
            if (strpos($e->getMessage(), "Unknown column 'password'") !== false) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe) VALUES (:nom, :email, :password)");
                    $stmt->execute([
                        ':nom' => $nom,
                        ':email' => $email,
                        ':password' => $hash
                    ]);
                    $message = "<p style='color: green;'>Inscription réussie ! <a href='login.php'>Se connecter</a></p>";
                } catch (PDOException $e2) {
                    $message = "<p style='color: red;'>Erreur BDD : " . htmlspecialchars($e2->getMessage()) . "</p>";
                }
            } else {
                $message = "<p style='color: red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    } else {
        $message = "<p style='color: red;'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-box { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .form-box input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        .form-box button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Créer un compte</h2>
    <?= $message ?>
    <form action="register.php" method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required>
        
        <label>Email :</label>
        <input type="email" name="email" required>
        
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        
        <button type="submit">S'inscrire</button>
    </form>
</div>

</body>
</html>
