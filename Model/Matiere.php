<?php
class Matiere {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verifierMatiereExistant($nom_matiere) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM matiere WHERE nom_matiere = ?");
        $stmt->execute([$nom_matiere]);
        return $stmt->fetchColumn() > 0;
    }

    public function ajouterMatiere($nom_matiere) {
        $sql = "INSERT INTO matiere (nom_matiere)
                VALUES (:nom_matiere)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom_matiere' => $nom_matiere,
        ]);
    }
}
?>
