<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($nom) && !empty($email) && !empty($password)) {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertion de l'utilisateur
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, password, is_premium) VALUES (?, ?, ?, 0)");
            if ($stmt->execute([$nom, $email, $hashedPassword])) {
                $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Exercices d'Allemand</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Créer un compte</h2>
        
        <?php if ($error): ?>
            <p class="msg-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <p class="msg-success"><?= htmlspecialchars($success) ?></p>
            <p><a href="login.php">Se connecter</a></p>
        <?php else: ?>
            <form action="register.php" method="POST">
                <label for="nom">Nom complet :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">S'inscrire</button>
            </form>
            <p>Déjà inscrit ? <a href="login.php">Se connecter ici</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
