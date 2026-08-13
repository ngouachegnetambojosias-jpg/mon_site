<?php
require_once 'config.php';

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// Vérification sécurisée du statut Premium (évite le Warning)
$is_premium = $user['is_premium'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme d'Exercices d'Allemand</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-info {
            font-size: 14px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
        }
        .badge-free {
            background-color: #6c757d;
            color: white;
        }
        .badge-premium {
            background-color: #ffc107;
            color: #212529;
        }
        .container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }
        .logout-btn {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            background-color: #dc3545;
            padding: 6px 12px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<header>
    <div>
        <strong>Plateforme d'Exercices d'Allemand</strong>
    </div>
    <div class="user-info">
        Bienvenue, <strong><?= htmlspecialchars($user['nom'] ?? 'Utilisateur') ?></strong> 
        (<?php if ($is_premium): ?>
            <span class="badge badge-premium">Compte Premium</span>
        <?php else: ?>
            <span class="badge badge-free">Compte Gratuit</span>
        <?php endif; ?>)
        <a href="logout.php" class="logout-btn">Déconnexion</a>
    </div>
</header>

<div class="container">
    <h2>Espace d'apprentissage</h2>
    <p>Sélectionnez un module pour commencer vos exercices d'allemand.</p>
</div>

</body>
</html>
