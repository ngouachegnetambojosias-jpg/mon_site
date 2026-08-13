<?php
require_once 'config.php';

// Vérification de la connexion
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$is_premium = $user['is_premium'] ?? 0;

// Niveaux d'exercices disponibles
$levels = [
    [
        'code' => 'A1',
        'title' => 'Anfänger (A1)',
        'desc' => 'Bases de la grammaire, vocabulaire quotidien et phrases simples.',
        'premium' => false
    ],
    [
        'code' => 'A2',
        'title' => 'Grundlegende Kenntnisse (A2)',
        'desc' => 'Phrases courantes, expressions fréquentes et dialogues de la vie de tous les jours.',
        'premium' => false
    ],
    [
        'code' => 'B1',
        'title' => 'Mittelstufe (B1)',
        'desc' => 'Autonomie dans les conversations, récits et événements familiers.',
        'premium' => false
    ],
    [
        'code' => 'B2',
        'title' => 'Gute Sprachverwendung (B2)',
        'desc' => 'Compréhension de textes complexes, argumentation et expression fluide.',
        'premium' => true
    ],
    [
        'code' => 'C1',
        'title' => 'Fortgeschrittene (C1)',
        'desc' => 'Textes exigeants, structures grammaticales complexes et préparation aux examens officiels.',
        'premium' => true
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELC Prüfungen - Wähle dein Niveau</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            color: #ffffff;
            display: flex;
            flex-direction: column;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .logo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #ffffff;
        }
        .user-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-free {
            background-color: #6c757d;
            color: #fff;
        }
        .badge-premium {
            background-color: #ffd700;
            color: #000;
        }
        .logout-btn {
            background-color: #ff4757;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background-color: #ff6b81;
        }
        .hero {
            text-align: center;
            margin: 50px 20px 30px;
        }
        .hero h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 18px;
            color: #e0e0e0;
            font-weight: 300;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            max-width: 1100px;
            margin: 20px auto 60px;
            padding: 0 20px;
            width: 100%;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 30px 25px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
        }
        .card-code {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #ffffff;
            position: relative;
            display: inline-block;
        }
        .card-code::after {
            content: '';
            display: block;
            width: 40px;
            height: 4px;
            background: #00d2d3;
            margin: 8px auto 0;
            border-radius: 2px;
        }
        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .card-desc {
            font-size: 13px;
            color: #d1d8e0;
            line-height: 1.5;
            margin-bottom: 25px;
        }
        .btn-start {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #00d2d3;
            color: #011627;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: background 0.2s;
        }
        .btn-start:hover {
            background-color: #54a0ff;
            color: #fff;
        }
        .btn-locked {
            background-color: rgba(255, 255, 255, 0.2);
            color: #a4b0be;
            cursor: not-allowed;
            pointer-events: none;
        }
        .badge-card-premium {
            font-size: 11px;
            background-color: #ffd700;
            color: #000;
            padding: 3px 8px;
            border-radius: 4px;
            margin-bottom: 15px;
            display: inline-block;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">TELC Prüfungen</div>
    <div class="user-nav">
        <span><?= htmlspecialchars($user['nom'] ?? 'Utilisateur') ?></span>
        <?php if ($is_premium): ?>
            <span class="badge badge-premium">Premium</span>
        <?php else: ?>
            <span class="badge badge-free">Gratuit</span>
        <?php endif; ?>
        <a href="logout.php" class="logout-btn">Déconnexion</a>
    </div>
</header>

<div class="hero">
    <h1>Willkommen zu unserem Test</h1>
    <p>Wir freuen uns, Sie hier zu haben. Wählen Sie Ihr Sprachniveau aus.</p>
</div>

<div class="grid-container">
    <?php foreach ($levels as $lvl): ?>
        <?php $can_access = !$lvl['premium'] || $is_premium; ?>
        <div class="card">
            <div>
                <?php if ($lvl['premium']): ?>
                    <span class="badge-card-premium">🔒 Exclusif Premium</span>
                <?php endif; ?>
                <div class="card-code"><?= $lvl['code'] ?></div>
                <div class="card-title"><?= $lvl['title'] ?></div>
                <div class="card-desc"><?= $lvl['desc'] ?></div>
            </div>
            
            <?php if ($can_access): ?>
                <a href="exercice.php?niveau=<?= strtolower($lvl['code']) ?>" class="btn-start">Starten →</a>
            <?php else: ?>
                <a href="#" class="btn-start btn-locked">Réservé Premium</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
