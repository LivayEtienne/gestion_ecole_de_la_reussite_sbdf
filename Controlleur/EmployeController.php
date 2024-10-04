<?php
require_once '../Model/Employe.php';
require_once '../database.php'; // Connection à la base de données
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $role = $_POST['role'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $salaire_fixe = null;
    $tarif_horaire = null;

    if ($role === 'enseignant_secondaire') {
        $tarif_horaire = $_POST['tarif_horaire'];
    } else {
        $salaire_fixe = $_POST['salaire_fixe'];
    }

    $employeModel = new Employe($pdo);

    // Vérifier si l'email existe déjà
    if ($employeModel->verifierEmailExistant($email)) {
        // Rediriger avec un message d'erreur
        header("Location: ../View/Employe/employe-new/employe-new.html?error=1&message=Email déjà utilisé");
        exit();
    }
    $matricule = $employeModel->genererMatricule($role);

    $employeModel->ajouterEmploye($nom, $prenom, $email, $telephone, $role, $salaire_fixe, $tarif_horaire, $mot_de_passe, $matricule);
    
    // Rediriger vers la page avec les informations nécessaires à afficher dans la modale
    header("Location: ../View/Employe/employe-new/employe-new.html?success=1&nom=$nom&prenom=$prenom&email=$email&role=$role");
    exit();
}


?>
