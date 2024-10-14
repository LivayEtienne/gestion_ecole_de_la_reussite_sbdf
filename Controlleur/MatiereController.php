<?php
require_once '../Model/Matiere.php';
require_once '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_matiere = $_POST['nom_matiere'];

    $matiereModel = new Matiere($pdo);

    // Vérifier si l'email existe déjà
    if ($matiereModel->verifierMatiereExistant($nom_matiere)) {
        // Rediriger avec un message d'erreur
        header("Location: ../View/Matiere/matiere-new/matiere-new.html?error=1&message=Nom de matiere déjà utilisé");
        exit();
    }

    $matiereModel->ajouterMatiere($nom_matiere);
    
    // Rediriger vers la page avec les informations nécessaires à afficher dans la modale
    header("Location: ../View/Matiere/matiere-new/matiere-new.html?success=1&nom_matiere=$nom_matiere");
    exit();
}
?>