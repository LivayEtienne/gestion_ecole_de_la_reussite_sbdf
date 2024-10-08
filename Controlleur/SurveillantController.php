<?php
// Activer le mode de débogage pour voir les erreurs (à enlever en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../database.php'; // Connexion à la base de données
require_once __DIR__ . '/../Model/Surveillant.php'; // Assurez-vous que le chemin est correct

class SurveillantController {
    private $model;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; // Récupérer la connexion PDO
        $this->model = new Surveillant($this->pdo); // Passer la connexion PDO à Surveillant
    }

    public function edit($id) {
        $surveillant = $this->model->getById($id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'matricule' => trim($_POST['matricule']),
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'email' => trim($_POST['email']),
                'classe' => trim($_POST['classe'])
            ];

            if (!empty($data['matricule']) && !empty($data['nom']) && !empty($data['prenom']) && 
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !empty($data['classe'])) {
                $this->model->update($id, $data);
                session_start();
                $_SESSION['message'] = "Surveillant mis à jour avec succès.";
                header('Location: /surveillants');
                exit;
            } else {
                $errorMessage = "Veuillez remplir tous les champs correctement.";
                // Gérer l'affichage de l'erreur
            }
        }
        
        require '/../View/Employe/surveillants/edit.php';
    }
    
    // Récupérer tous les surveillants actifs
    public function getAll() {
        return $this->model->getAll();
    }

    public function archive($id) {
        // Vérifiez si le surveillant est déjà archivé
        if ($this->model->isArchived($id)) {
            header('Location: ../View/Employe/surveillants/index.php?error=surveillant_deja_archive');
            exit;
        }
        
        // Archive le surveillant
        $this->model->archive($id);
        
        // Ajouter un message de succès à la session
        session_start();
        $_SESSION['message'] = "Surveillant archivé avec succès.";
        
        header('Location: ../View/Employe/surveillants/index.php');
        exit;
    }

    public function unarchive($id) {
        // Désarchiver le surveillant par son ID
        $this->model->unarchive($id);
        
        // Ajouter un message de succès à la session
        session_start();
        $_SESSION['message'] = "Surveillant désarchivé avec succès.";
        
        header('Location: ../View/Employe/surveillants/index.php');
        exit;
    }

    public function showArchived() {
        $surveillantsArchives = $this->model->getArchived();
        require '../View/Employe/surveillants/archived.php';
    }
}

// Gérer les actions basées sur les requêtes
if (isset($_GET['action'])) {
    $controller = new SurveillantController($pdo); // Passer la connexion PDO au contrôleur
    
    if ($_GET['action'] === 'archive' && isset($_GET['id'])) {
        $id = intval($_GET['id']); // Assurez-vous de valider l'ID
        $controller->archive($id);
    } elseif ($_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $controller->edit($id);
    } elseif ($_GET['action'] === 'unarchive' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $controller->unarchive($id);
    } elseif ($_GET['action'] === 'showArchived') {
        $controller->showArchived();
    }
}
?>
