<?php
require_once 'config.php';

$module = $_GET['module'] ?? 'A1';
$isPremium = $_SESSION['is_premium'] ?? 0;

// Le module A1 est gratuit, les autres sont réservés aux utilisateurs payants
$isFreeModule = ($module === 'A1');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Module <?= htmlspecialchars($module) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Exercices - Module <?= htmlspecialchars($module) ?></h1>

    <?php if ($isFreeModule || $isPremium): ?>
        <div class="exercise-content">
            <h3>Exercice 1 : Completez les phrases</h3>
            <p>1. Er _____ Deutsch. (lernen)</p>
            <input type="text" placeholder="Votre réponse">
        </div>
    <?php else: ?>
        <div class="paywall">
            <h2>🔒 Module Verrouillé</h2>
            <p>Vous devez acheter un accès Premium pour accéder au Module <?= htmlspecialchars($module) ?>.</p>
            <a href="checkout.php" class="btn-buy">Acheter l'accès (K-Pay / Mobile Money)</a>
        </div>
    <?php endif; ?>
</body>
</html>
