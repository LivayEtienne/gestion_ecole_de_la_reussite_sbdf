<?php
require_once '../Model/Classe.php';
require_once '../database.php';  // Assure-toi que le chemin est correct

class ClasseController {
    private $pdo;
    private $classeModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->classeModel = new Classe($pdo);
    }

    // Méthode pour récupérer les cycles
    public function getCycles() {
        return $this->classeModel->getAllCycles();
    }

    // Méthode pour créer une nouvelle classe
    public function createClasse($nomClasse, $idCycle, $seuilMax = 25, $isAnnexe = 0) {
        return $this->classeModel->createClasse($nomClasse, $idCycle, $seuilMax, $isAnnexe);
    }
}

// Tester la récupération des cycles (temporairement)
$controller = new ClasseController($pdo);
$cycles = $controller->getCycles();
?>
