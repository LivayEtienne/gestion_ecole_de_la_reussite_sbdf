<?php
require_once '../database.php';

class Classe {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCycles() {
        // Requête pour récupérer les cycles
        $stmt = $this->pdo->prepare("SELECT id, nom_cycle FROM cycle");
        $stmt->execute();
        
        // Vérification des résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createClasse($nomClasse, $idCycle, $seuilMax = 25, $isAnnexe = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO classe (nom_classe, id_cycle, seuil_max, is_annexe) VALUES (:nom_classe, :id_cycle, :seuil_max, :is_annexe)");
        $stmt->bindParam(':nom_classe', $nomClasse);
        $stmt->bindParam(':id_cycle', $idCycle);
        $stmt->bindParam(':seuil_max', $seuilMax);
        $stmt->bindParam(':is_annexe', $isAnnexe);
        return $stmt->execute();
    }
}
