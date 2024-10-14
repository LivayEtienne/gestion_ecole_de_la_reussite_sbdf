<?php
// listAdminController.php
require_once __DIR__ . '/../Model/Employe.php';
require_once __DIR__ . '/../database.php'; // Assurez-vous que le chemin est correct

function afficherSurveillants($pdo) {
    $surveillantModel = new Employe($pdo);

    // Récupération des filtres
    $roleFilter = isset($_POST['role']) ? $_POST['role'] : '';
    $archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';
    $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : ''; // Récupération du terme de recherche

    // Nombre d'entrées par page
    $entriesPerPage = 10;

    // Récupération du numéro de page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $entriesPerPage;

    // Construction de la requête SQL
    $admins = $surveillantModel->getSurveillants($roleFilter,$archiveFilter, $searchTerm, $offset, $entriesPerPage);

    // Récupération du nombre total d'administrateurs
    $totalEntries = $surveillantModel->countSurveillants($archiveFilter, $searchTerm, $roleFilter);
    $totalPages = ceil($totalEntries / $entriesPerPage);

    // Construction du titre
    $titre = "Liste des Surveillants";
    if (!empty($roleFilter)) {
        $titre .= " " . ($roleFilter === 'surveillant_classe' ? "Classe" : "General");
    }
    if ($archiveFilter !== '') {
        $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
    }

    return [
        'admins' => $admins,
        'roleFilter'=> $roleFilter,
        'archiveFilter' => $archiveFilter,
        'searchTerm' => $searchTerm,
        'page' => $page,
        'totalPages' => $totalPages,
        'titre' => $titre,
        'offset' => $offset 
    ];

}