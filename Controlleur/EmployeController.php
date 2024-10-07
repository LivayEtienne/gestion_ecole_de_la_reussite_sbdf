<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../database.php'; 
require_once '/opt/lampp/htdocs/gestion_ecole_sabadifa/Model/emplyeModel_archiver.php';

class EmployeController {
    private $employeModel;

    public function __construct($employeModel) {
        $this->employeModel = $employeModel;
    }

    // Gestion de la connexion
    public function connexion($emailOrMatricule, $motDePasse) {
        $employe = $this->employeModel->verifierIdentifiants($emailOrMatricule);

        if ($employe && password_verify($motDePasse, $employe['mot_de_passe'])) {
            // Authentification réussie, redirection vers la page d'accueil ou tableau de bord
            header("Location: ../View/Dashboard/dashboard_directeur.php");
            exit();
        } else {
            // Authentification échouée, enregistrer le message d'erreur dans la session
            $_SESSION['errorMessage'] = "Identifiant ou mot de passe incorrect.";
            header("Location: login.php");
            exit();
        }
    }

    // Gestion de l'inscription
    public function inscrireEmploye($nom, $prenom, $email, $telephone, $role, $mot_de_passe, $salaire_fixe = null, $tarif_horaire = null) {
        if ($this->employeModel->verifierEmailExistant($email)) {
            // Rediriger avec un message d'erreur
            header("Location: ../View/Employe/employe-new/employe-new.html?error=1&message=Email déjà utilisé");
            exit();
        }

        // Générer un matricule
        $matricule = $this->employeModel->genererMatricule($role);

        // Ajouter l'employé
        $this->employeModel->ajouterEmploye($nom, $prenom, $email, $telephone, $role, $salaire_fixe, $tarif_horaire, $mot_de_passe, $matricule);

        // Rediriger avec succès
        header("Location: ../View/Employe/employe-new/employe-new.html?success=1&nom=$nom&prenom=$prenom&email=$email&role=$role");
        exit();
    }
}
require_once '/opt/lampp/htdocs/gestion_ecole_sabadifa/View/Employe/employe-list/enseignant-list/enseignant-list.php';