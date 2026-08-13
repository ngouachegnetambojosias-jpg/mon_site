<?php
header('Content-Type: application/json');

// Vos clés API K-PAY
$apiKey = "kpay_test_85fa21f2fff3119a7f503c8f638ac9482559cb04c8a85a62";
$secretKey = "c99f295492b2556109035fb43fe883e2d1fae30bf2fff7425cbae4efc15fe7d3";

// Lecture des données envoyées par JavaScript
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['phoneNumber']) || empty($input['provider'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides.']);
    exit;
}

$amount = isset($input['amount']) ? (int)$input['amount'] : 2000;
$phoneNumber = preg_replace('/[^0-9]/', '', $input['phoneNumber']);

// Formatage automatique pour le Cameroun (ajout du 237 si 9 chiffres saisis)
if (strlen($phoneNumber) === 9) {
    $phoneNumber = "237" . $phoneNumber;
}

$provider = $input['provider'];
$externalId = "B1-TEST1-" . time();

// Préparation du payload K-PAY
$payload = [
    "amount" => $amount,
    "provider" => $provider,
    "phoneNumber" => $phoneNumber,
    "externalId" => $externalId
];

// Requete cURL vers l'API K-PAY
$ch = curl_init("https://admin.kpay.site/api/v1/payments/init");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-API-Key: " . $apiKey,
    "X-Secret-Key: " . $secretKey,
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$responseData = json_decode($response, true);

if ($httpCode === 200 || $httpCode === 201) {
    echo json_encode([
        'success' => true,
        'data' => $responseData
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => $responseData['message'] ?? 'Erreur lors du paiement K-PAY.'
    ]);
}
?>
