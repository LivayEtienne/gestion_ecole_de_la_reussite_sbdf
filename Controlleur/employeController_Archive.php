<?php
require_once '../.././../../database.php'; // Assurez-vous que le chemin est correct
// Importer le modèle d'archivage

// Vérifier si une demande d'archivage a été faite
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Appeler le modèle pour archiver l'employé
    archiveEmployee($id);
}

// Fonction pour archiver l'employé
function archiveEmployee($id) {
    global $pdo;

    // Mettre à jour le statut d'archivage de l'employé
    $sql = "UPDATE administrateur SET archive = 1 WHERE matricule = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Rediriger vers la page principale après l'archivage
        header("Location: enseignant-list.php");
        exit();
    } else {
        // Gérer l'erreur
        echo "Erreur lors de l'archivage de l'employé.";
    }
}

// Inclure la vue
include '../View/Employe/employe-list/enseignant-list/enseignant-list.php';
?>
