<?php
// listAdminController.php
require_once __DIR__ . '/../Model/Employe.php';
require_once __DIR__ . '/../database.php'; // Assurez-vous que le chemin est correct

function afficherAdmins($pdo) {
    $employeModel = new Employe($pdo);

    // Récupération des filtres
    $archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';
    $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
    
    // Nombre d'entrées par page
    $entriesPerPage = 10;

    // Récupération du numéro de page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $entriesPerPage;

    // Construction de la requête SQL
    $admins = $employeModel->getComptables($archiveFilter, $searchTerm, $offset, $entriesPerPage);

    // Récupération du nombre total d'administrateurs
    $totalEntries = $employeModel->countComptables($archiveFilter, $searchTerm);
    $totalPages = ceil($totalEntries / $entriesPerPage);

    // Construction du titre
    $titre = "Liste des Comptables";
    if ($archiveFilter !== '') {
        $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
    }

    return [
        'admins' => $admins,
        'archiveFilter' => $archiveFilter,
        'searchTerm' => $searchTerm,
        'page' => $page,
        'totalPages' => $totalPages,
        'titre' => $titre,
        'offset' => $offset 
    ];
}
