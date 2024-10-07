<?php
// model/ListEleveController.php
include '../database.php';
include '/opt/lampp/htdocs/gestion_ecole_sabadifa/Model/gestion_eleve_model/list_CRUD_eleveModel.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ListEleveController {
    private $eleveModel;

    public function __construct() {
        $this->eleveModel = new EleveModel(); // Crée une instance d'EleveModel
    }

    public function index() {
        $eleves = $this->eleveModel->getAllEleves(); // Récupère tous les élèves non archivés
        include '/opt/lampp/htdocs/gestion_ecole_sabadifa/View/Eleve/eleve_list/eleve_list_view_nn_archiver.php'; // Charge la vue
    }

    public function archiver($id) {
        if ($this->eleveModel->archiverEleve($id)) {
            // Redirection après succès
            header("Location: list_EleveController.php");
            exit();
        } else {
            echo "Erreur lors de l'archivage de l'élève.";
        }
    }
}

// Pour exécuter le contrôleur
if (isset($_GET['action']) && $_GET['action'] === 'archiver' && isset($_GET['id'])) {
    $controller = new ListEleveController();
    $controller->archiver($_GET['id']); // Appel de la méthode archiver pour archiver l'élève
} else {
    $controller = new ListEleveController();
    $controller->index(); // Appel de la méthode index pour afficher les élèves
}

?>
