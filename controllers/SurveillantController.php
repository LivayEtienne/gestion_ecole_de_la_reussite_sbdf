<?php
// Activer le mode de débogage pour voir les erreurs (à enlever en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../models/Surveillant.php'; // Vérifiez que le chemin est correct
require_once __DIR__ . '/../config/database.php';    // Connexion à la base de données

class SurveillantController {
    private $model;

    public function __construct() {
        $this->model = new Surveillant();
    }

    public function index() {
        $surveillants = $this->model->getAll();
        require 'views/surveillants/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Valider les entrées
            $matricule = trim($_POST['matricule']);
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $email = trim($_POST['email']);
            $classe = trim($_POST['classe']);
            
            if (!empty($matricule) && !empty($nom) && !empty($prenom) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($classe)) {
                // Si tout est valide, créer le surveillant
                $data = [
                    'matricule' => $matricule,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'classe' => $classe
                ];
                $this->model->create($data); // Passer le tableau $data
                header('Location: /surveillants');
                exit;
            } else {
                $errorMessage = "Veuillez remplir tous les champs correctement.";
                // Gérer l'affichage de l'erreur
            }
        }
        require 'views/surveillants/create.php';
    }

    public function edit($id) {
        $surveillant = $this->model->getById($id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Rassembler les données dans un tableau
            $data = [
                'matricule' => trim($_POST['matricule']),
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'email' => trim($_POST['email']),
                'classe' => trim($_POST['classe'])
            ];

            // Vérifiez que les données sont valides
            if (!empty($data['matricule']) && !empty($data['nom']) && !empty($data['prenom']) && 
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !empty($data['classe'])) {
                // Passez le tableau $data à la méthode update
                $this->model->update($id, $data);
                header('Location: /surveillants'); // Redirige vers la liste des surveillants après mise à jour
                exit;
            } else {
                $errorMessage = "Veuillez remplir tous les champs correctement.";
                // Gérer l'affichage de l'erreur
            }
        }
        
        require '../views/surveillants/edit.php'; // Affiche le formulaire d'édition
    }
    
    public function delete($id) {
        $this->model->delete($id);
        header('Location: /surveillants'); // Redirige vers la liste des surveillants après suppression
        exit; // Évitez l'exécution ultérieure
    }
}
