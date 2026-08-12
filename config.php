<?php
session_start();

$host = "mysql-241da189-ngouachegnetambojosias-5bf2.e.aivencloud.com";
$port = "14350";
$user = "avnadmin";
$pass = "AVNS_psIyW88G81zuO80_aHb";
$dbname = "defaultdb";

try {
    // Note : Aiven exige une connexion SSL
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => true,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion BDD : " . $e->getMessage());
}
?>
