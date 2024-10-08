<?php
require_once '../Model/Cycle.php';
require_once '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_cycle = $_POST['nom_cycle'];

    $cycleModel = new Cycle($pdo);

    // Vérifier si l'email existe déjà
    if ($cycleModel->verifierCycleExistant($nom_cycle)) {
        // Rediriger avec un message d'erreur
        header("Location: ../View/Cycle/cycle-new/cycle-new.html?error=1&message=Nom de cycle déjà utilisé");
        exit();
    }

    $cycleModel->ajouterCycle($nom_cycle);
    
    // Rediriger vers la page avec les informations nécessaires à afficher dans la modale
    header("Location: ../View/Cycle/cycle-new/cycle-new.html?success=1&nom_cycle=$nom_cycle");
    exit();
}
?>
