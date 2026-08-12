<?php
require_once 'config.php';

// Récupération des données renvoyées par le service de paiement
$reference = $_POST['reference'] ?? '';
$status = $_POST['status'] ?? ''; // 'SUCCESS' ou 'APPROVED'

if ($status === 'SUCCESS' && !empty($reference)) {
    // 1. Marquer la transaction comme payée
    $stmt = $pdo->prepare("UPDATE transactions SET statut = 'PAID' WHERE reference = ?");
    $stmt->execute([$reference]);

    // 2. Récupérer l'utilisateur correspondant
    $stmt = $pdo->prepare("SELECT user_id FROM transactions WHERE reference = ?");
    $stmt->execute([$reference]);
    $transaction = $stmt->fetch();

    if ($transaction) {
        // 3. Activer le statut Premium
        $stmt = $pdo->prepare("UPDATE users SET is_premium = 1 WHERE id = ?");
        $stmt->execute([$transaction['user_id']]);
        
        $_SESSION['is_premium'] = 1;
    }
}
http_response_code(200);
?>
