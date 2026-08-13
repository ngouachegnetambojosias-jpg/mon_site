<?php
require_once 'config.php';

$message = '';

// Récupération du message de succès d'inscription si présent
if (isset($_SESSION['success'])) {
    $message = "<p style='color: green; text-align: center;'>" . htmlspecialchars($_SESSION['success']) . "</p>";
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        try {
            // Recherche de l'utilisateur par son email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            // Vérification de l'existence de l'utilisateur et du mot de passe haché
            if ($user && password_verify($password, $user['password'])) {
                
                // Enregistrement des informations utilisateur en session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                    'is_premium' => $user['is_premium'] ?? 0
                ];

                // Redirection vers la page d'accueil
                header("Location: index.php");
                exit();
            } else {
                $message = "<p style='color: red; text-align: center;'>Email ou mot de passe incorrect.</p>";
            }
        } catch (PDOException $e) {
            $message = "<p style='color: red; text-align: center;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $message = "<p style='color: red; text-align: center;'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
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
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
            display: block;
            color: #28a745;
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Connexion</h2>
    
    <?= $message ?>

    <form action="login.php" method="POST">
        <label for="email">Adresse Email :</label>
        <input type="email" id="email" name="email" required placeholder="exemple@mail.com">

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">

        <button type="submit">Se connecter</button>
    </form>

    <a href="register.php" class="register-link">Pas encore de compte ? S'inscrire</a>
</div>

</body>
</html>
