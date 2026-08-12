<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercices d'Allemand</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Plateforme d'Exercices d'Allemand</h1>
    
    <div class="modules-grid">
        <div class="card">
            <h2>Module A1 - Grammaire</h2>
            <p>Gratuit pour débutants</p>
            <a href="exercice.php?module=A1">Accéder aux exercices</a>
        </div>
        
        <div class="card">
            <h2>Module A2 - Vocabulaire & Dialogue</h2>
            <p>Réservé aux membres Premium</p>
            <a href="exercice.php?module=A2">Accéder aux exercices</a>
        </div>
    </div>
</body>
</html>
