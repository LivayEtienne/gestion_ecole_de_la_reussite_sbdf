<?php
class Cycle {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verifierCycleExistant($nom_cycle) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM cycle WHERE nom_cycle = ?");
        $stmt->execute([$nom_cycle]);
        return $stmt->fetchColumn() > 0;
    }

    public function ajouterCycle($nom_cycle) {
        $sql = "INSERT INTO cycle (nom_cycle)
                VALUES (:nom_cycle)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom_cycle' => $nom_cycle,
        ]);
    }
}
?>
