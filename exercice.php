<?php
require_once 'config.php';

// Vérification de la connexion
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$is_premium = $user['is_premium'] ?? 0;

// Récupération du niveau demandé dans l'URL (par défaut B1)
$niveau = strtoupper($_GET['niveau'] ?? 'B1');
$valid_niveaux = ['A1', 'A2', 'B1', 'B2', 'C1'];

if (!in_array($niveau, $valid_niveaux)) {
    $niveau = 'B1';
}

// Restriction Premium pour B2 et C1
if (in_array($niveau, ['B2', 'C1']) && !$is_premium) {
    header("Location: index.php");
    exit();
}

// Structure des parties d'examen TELC
$sections = [
    [
        'title' => 'Lesen Teil 1',
        'items' => ['PETRA/JENNIFER', 'EVA/IRIS', 'SOPHIE/ANDREAS2', 'NADJA/CLAUDIA', 'NICOLE', 'ANDREAS', 'ANNIKA1', 'ANNIKA2/SONJA/CORINA', 'CAROLINA/ALICIA', 'VERA', 'THOMAS', 'TAMARA/JAKOB/PAUL', 'JAN', 'VIKTOR', 'ALEX & CORA', 'RITA', 'MIROSLAV', 'KARLA', 'MORITZ']
    ],
    [
        'title' => 'Lesen Teil 2',
        'items' => ['PETRA & ALICIA', 'EVA1', 'IRIS', 'SOPHIE', 'NADJA & CLAUDIA', 'NICOLE', 'ANDREAS', 'ANDREAS2 & CORINA/ANNIKA(1&2)', 'CAROLINA/VERA', 'JENNIFER & TAMARA/JAKOB/PAUL', 'THOMAS', 'JAN', 'VIKTOR', 'SONJA', 'ALEX & CORA', 'RITA', 'MIROSLAV & KARLA', 'MORITZ', 'MARA']
    ],
    [
        'title' => 'Lesen Teil 3',
        'items' => ['PETRA', 'EVA1', 'IRIS', 'SOPHIE', 'NADJA & CLAUDIA', 'ANDREAS1', 'ANDREAS2', 'CAROLINA']
    ],
    [
        'title' => 'Sprachbausteine Teil 1',
        'items' => ['PETRA/NADJA2/CLAUDIA', 'EVA', 'IRIS', 'SOPHIE', 'NICOLE', 'ANDREAS', 'ANDREAS2/VIKTOR/SONJA', 'ANNIKA1', 'ANNIKA2/JAN/CORINA', 'CAROLINA/RITA', 'VERA/PAUL', 'THOMAS/ANNA', 'JENNIFER', 'TAMARA/JAKOB', 'ALEX & CORA', 'MIROSLAV', 'KARLA', 'MORITZ', 'ALICIA']
    ],
    [
        'title' => 'Sprachbausteine Teil 2',
        'items' => ['PETRA/ALICIA', 'EVA', 'IRIS', 'SOPHIE', 'NICOLE', 'NADJA/CLAUDIA', 'ANDREAS', 'ANDREAS2/JAN', 'ANNIKA1&2', 'CAROLINA/CORINA', 'VERA', 'THOMAS/ANNA/JENNIFER', 'TAMARA/JAKOB/SONJA', 'VIKTOR', 'ALEX & CORA', 'PAUL', 'RITA', 'MIROSLAV', 'KARLA/MORITZ', 'JAKOB2']
    ],
    [
        'title' => 'Hören',
        'items' => ['Teil 1', 'Teil 2', 'Teil 3']
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TELC Prüfungen - Prüfung <?= $niveau ?></title>
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
            padding: 15px 40px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-home {
            background-color: #00d2d3;
            color: #011627;
            padding: 8px 18px;
            text-decoration: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-home:hover {
            background-color: #54a0ff;
            color: #fff;
        }
        .page-title {
            font-size: 18px;
            font-weight: 600;
        }
        .btn-logout {
            background-color: #ff4757;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px 60px;
            width: 100%;
        }
        .banner-modelltest {
            background: linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 35px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .banner-modelltest h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffffff;
        }
        .banner-modelltest p {
            margin-bottom: 20px;
            font-size: 15px;
            opacity: 0.9;
        }
        .btn-modelltest {
            background-color: #ffffff;
            color: #10ac84;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 16px;
            display: inline-block;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-modelltest:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .section-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: #2c3e50;
        }
        .section-title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #1e3c72;
            position: relative;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: #00d2d3;
            margin: 8px auto 0;
            border-radius: 2px;
        }
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
        }
        .item-card {
            background: linear-gradient(135deg, #4a69bd 0%, #0c2461 100%);
            color: #ffffff;
            padding: 16px 12px;
            border-radius: 10px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 60px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
            word-break: break-word;
        }
        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #00d2d3 0%, #54a0ff 100%);
            color: #011627;
        }
    </style>
</head>
<body>

<header>
    <div class="nav-left">
        <a href="index.php" class="btn-home">Homepage</a>
        <span class="page-title">Telc - Prüfung <?= $niveau ?></span>
    </div>
    <a href="logout.php" class="btn-logout">Abmelden</a>
</header>

<div class="container">

    <!-- Accès direct et exclusif au Modelltest 1 avec audio -->
    <div class="banner-modelltest">
        <h2>🎧 Modelltest 1 (avec Audios) - TELC <?= $niveau ?></h2>
        <p>Passez le Test 1 complet incluant la partie audio (Hören Teil 1 à 4).</p>
        <a href="modelltest1.html" class="btn-modelltest">Lancer le Modelltest 1</a>
    </div>

    <?php foreach ($sections as $sec): ?>
        <div class="section-box">
            <h2 class="section-title"><?= htmlspecialchars($sec['title']) ?></h2>
            <div class="items-grid">
                <?php foreach ($sec['items'] as $item): ?>
                    <a href="quiz.php?niveau=<?= strtolower($niveau) ?>&sujet=<?= urlencode($item) ?>" class="item-card">
                        <?= htmlspecialchars($item) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
