<?php
session_start();
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

            // Insertion dans la table users
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (:nom, :email, :password)");
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':password' => $hash
            ]);

            // Message de succès et redirection vers la connexion
            $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("Location: login.php");
            exit();

        } catch (PDOException $e) {
            // Gestion de l'erreur si l'email existe déjà
            if ($e->getCode() == 23000) {
                $message = "<p style='color: red;'>Cet email est déjà utilisé par un autre compte.</p>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Créer un compte</h2>
    
    <?= $message ?>

    <form action="register.php" method="POST">
        <label for="nom">Nom complet :</label>
        <input type="text" id="nom" name="nom" required placeholder="Votre nom">

        <label for="email">Adresse Email :</label>
        <input type="email" id="email" name="email" required placeholder="exemple@mail.com">

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">

        <button type="submit">S'inscrire</button>
    </form>

    <a href="login.php" class="login-link">Déjà un compte ? Se connecter</a>
</div>

</body>
</html>
