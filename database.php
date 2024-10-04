<?php
// Configuration de la base de données
// Configuration de la base de données
$host = 'localhost';
$dbname = 'gestion_sabadifa';
$username = 'root';
$password = '';

// Connexion à la base de données
// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}