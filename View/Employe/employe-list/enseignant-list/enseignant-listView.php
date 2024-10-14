<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//require_once '../../../../Model/Employe.php';
require_once  '../../../../Controlleur/EnseignantList.php'; 

$results = afficherEnseignants($pdo);
$admins = $results['admins'];
$roleFilter = $results['roleFilter'];
$archiveFilter = $results['archiveFilter'];
$searchTerm = $results['searchTerm'];
$page = $results['page'];
$totalPages = $results['totalPages'];
$titre = $results['titre'];
$offset = $results['offset'];

// Appel de la vue pour afficher les résultats
require 'enseignant-list.php';
?>
