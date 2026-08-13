<?php
session_start();
require_once 'config.php';

$message = '';

if (isset($_SESSION['success'])) {
    $message = "<p style='color: green;'>" . htmlspecialchars($_SESSION['success']) . "</p>";
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        try {
            // Tente de chercher avec 'password' puis avec 'mot_de_passe' si la colonne diffère
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe (gestion des deux noms de colonnes possibles)
                $user_password = $user['password'] ?? $user['mot_de_passe'] ?? '';

                if (password_verify($password, $user_password) || $password === $user_password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_nom'] = $user['nom'];
                    
                    // Redirection vers la page d'accueil
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "<p style='color: red;'>Mot de passe incorrect.</p>";
                }
            } else {
                $message = "<p style='color: red;'>Aucun compte trouvé avec cet email.</p>";
            }
        } catch (PDOException $e) {
            $message = "<p style='color: red;'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
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
    <title>Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-box { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .form-box input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        .form-box button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Connexion</h2>
    <?= $message ?>
    <form action="login.php" method="POST">
        <label>Email :</label>
        <input type="email" name="email" required>
        
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        
        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>
