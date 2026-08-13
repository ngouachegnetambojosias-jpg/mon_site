<?php
  // Vous pouvez ajouter du code PHP ici si nécessaire (ex: gestion de session, inclusions)
  $pageTitle = "Deutsch Lernen & B1 Simulator";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      background-color: #f4f6f9;
      color: #333;
    }
    header {
      background-color: #0056b3;
      color: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h1 {
      font-size: 1.5rem;
    }
    nav ul {
      display: flex;
      list-style: none;
      gap: 20px;
    }
    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.2s;
    }
    nav a:hover {
      color: #ffcc00;
    }
    .btn-link {
      background-color: #ffcc00;
      color: #0056b3;
      padding: 8px 15px;
      border-radius: 4px;
    }
    .btn-link:hover {
      background-color: #e6b800;
      color: #003d80;
    }
    main {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .hero {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      text-align: center;
      margin-bottom: 30px;
    }
    .hero h2 {
      margin-bottom: 15px;
      color: #0056b3;
    }
    .modules-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      border-left: 5px solid #0056b3;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .card h3 {
      margin-bottom: 10px;
    }
    .card a {
      display: inline-block;
      margin-top: 15px;
      color: #0056b3;
      font-weight: bold;
      text-decoration: none;
    }
    .card a:hover {
      text-decoration: underline;
    }
    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      background-color: #222;
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Barre de Navigation -->
  <header>
    <h1>Allemand Simulator</h1>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <!-- Intégration du lien dans le menu -->
        <li><a href="modelltest1.html" class="btn-link">Modelltest 1 (B1)</a></li>
      </ul>
    </nav>
  </header>

  <!-- Contenu Principal -->
  <main>
    <section class="hero">
      <h2>Préparez votre examen Goethe / ÖSD B1</h2>
      <p>Entraînez-vous dans des conditions réelles aux épreuves de Lesen, Hören, Schreiben et Sprechen.</p>
    </section>

    <section class="modules-grid">
      <div class="card">
        <h3>Modelltest 1</h3>
        <p>Test complet incluant toutes les 4 compétences avec corrigés et fichiers audio.</p>
        <!-- Intégration du lien dans une carte de module -->
        <a href="modelltest1.html">Modelltest 1 (B1)</a>
      </div>

      <div class="card">
        <h3>Modelltest 2</h3>
        <p>Prochainement disponible pour continuer votre entraînement B1.</p>
        <span style="color: #888;">(En cours de développement)</span>
      </div>
    </section>
  </main>

  <!-- Pied de page -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> Allemand Simulator - Tous droits réservés.</p>
  </footer>

</body>
</html>
