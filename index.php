<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercices d'Allemand</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>Bienvenue, <strong><?= htmlspecialchars($_SESSION['user_nom']) ?></strong> 
                (<?= $_SESSION['is_premium'] ? 'Compte Premium ⭐' : 'Compte Gratuit' ?>)</span> | 
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="login.php">Connexion</a> | <a href="register.php">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>

    <h1>Plateforme d'Exercices d'Allemand</h1>
    <!-- Reste du code des modules -->
