<?php
// Activer le mode de débogage pour voir les erreurs (à enlever en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once '../config/database.php';
require_once '../controllers/SurveillantController.php';

// Gestion de l'URL pour déterminer quelle action appeler
$url = isset($_GET['url']) ? explode('/', $_GET['url']) : ['/'];

// Affichage de l'URL demandée pour le débogage
echo "URL demandée : " . htmlspecialchars($_GET['url'] ?? '');

// Instanciation du contrôleur
$controller = new SurveillantController();

// Switch pour appeler les différentes méthodes du contrôleur en fonction de l'URL
switch ($url[0]) {
    case 'surveillants':
        if (isset($url[1]) && $url[1] == 'create') {
            $controller->create();
        } elseif (isset($url[1]) && $url[1] == 'edit' && isset($url[2])) {
            $controller->edit($url[2]);
        } elseif (isset($url[1]) && $url[1] == 'delete' && isset($url[2])) {
            $controller->delete($url[2]);
        } else {
            $controller->index();
        }
        break;
    default:
        echo "Page d'accueil";
        break;
}
