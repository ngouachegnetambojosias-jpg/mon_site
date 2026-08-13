<?php
require_once 'config.php';

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$message = '';

// Actions de gestion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = intval($_POST['user_id'] ?? 0);

    if ($user_id > 0) {
        try {
            if ($action === 'toggle_premium') {
                $status = intval($_POST['current_status'] ?? 0) === 1 ? 0 : 1;
                $stmt = $pdo->prepare("UPDATE users SET is_premium = :status WHERE id = :id");
                $stmt->execute([':status' => $status, ':id' => $user_id]);
                $message = "<p style='color: green;'>Statut Premium mis à jour avec succès.</p>";
            } elseif ($action === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
                $stmt->execute([':id' => $user_id]);
                $message = "<p style='color: red;'>Utilisateur supprimé avec succès.</p>";
            }
        } catch (PDOException $e) {
            $message = "<p style='color: red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

// Récupération de la liste de tous les utilisateurs
try {
    $stmt = $pdo->query("SELECT id, nom, email, is_premium, created_at FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur de récupération des utilisateurs : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-free {
            background-color: #6c757d;
            color: white;
        }
        .badge-premium {
            background-color: #ffc107;
            color: #212529;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-toggle {
            background-color: #17a2b8;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .back-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <h2>Gestion des Utilisateurs</h2>
        <a href="index.php" class="back-link">← Retour à l'accueil</a>
    </div>

    <?= $message ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['id']) ?></td>
                    <td><?= htmlspecialchars($u['nom']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?php if ($u['is_premium']): ?>
                            <span class="badge badge-premium">Premium</span>
                        <?php else: ?>
                            <span class="badge badge-free">Gratuit</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form style="display: inline;" action="admin.php" method="POST">
                            <input type="hidden" name="action" value="toggle_premium">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="current_status" value="<?= $u['is_premium'] ?>">
                            <button type="submit" class="btn btn-toggle">
                                <?= $u['is_premium'] ? 'Passer en Gratuit' : 'Passer en Premium' ?>
                            </button>
                        </form>

                        <form style="display: inline;" action="admin.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <button type="submit" class="btn btn-delete">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
