<?php
// administrateurController.php
require_once 'administrateurModel.php';

// Récupération des filtres
$roleFilter = isset($_POST['role']) ? $_POST['role'] : '';
$archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';

// Récupération des données
$administrateurs = getAdministrateurs($roleFilter, $archiveFilter);

// Construction du titre
$titre = "Liste des Surveillants";
if (!empty($roleFilter)) {
    $titre .= " " . ($roleFilter === 'surveillant_classe' ? "Classe" : "General");
}
if ($archiveFilter !== '') {
    $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
}
?>
