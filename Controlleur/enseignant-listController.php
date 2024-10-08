<?php
require_once '/opt/lampp/htdocs/gestion_ecole_sabadifa/database.php';
require_once '../Model/enseignant-listEnseignantModel.php';

class AdministrateurController {
    private $model;

    public function __construct($pdo) {
        $this->model = new AdministrateurModel($pdo);
    }

    public function afficherListe() {
        $roleFilter = isset($_POST['role']) ? $_POST['role'] : '';
        $archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';

        $administrateurs = $this->model->getAdministrateurs($roleFilter, $archiveFilter);

        $titre = "Liste des Surveillants";
        if (!empty($roleFilter)) {
            $titre .= " " . ($roleFilter === 'surveillant_classe' ? "Classe" : "General");
        }
        if ($archiveFilter !== '') {
            $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
        }

        include 'administrateurListView.php';
    }
}

$controller = new AdministrateurController($pdo);
$controller->afficherListe();
?>
