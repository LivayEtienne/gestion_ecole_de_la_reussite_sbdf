<?php
$host = 'localhost';
$dbname = 'EcoleReussite';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    
    // Configuration pour afficher les erreurs sous forme d'exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // En cas d'échec de la connexion, affichage d'un message d'erreur
    echo "Échec de la connexion : " . $e->getMessage();
}
?>
