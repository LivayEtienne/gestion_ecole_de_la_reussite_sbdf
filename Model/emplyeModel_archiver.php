<?php
class EmployeModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer les administrateurs en fonction des filtres
    public function getAdministrateurs($roleFilter, $archiveFilter) {
        $sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('surveillant_classe', 'surveillant_general')";

        // Ajoutez les conditions de filtre
        if (!empty($roleFilter)) {
            $sql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $sql .= " AND archive = :archive";
        }

        // Préparation de la requête
        $stmt = $this->pdo->prepare($sql);

        if (!empty($roleFilter)) {
            $stmt->bindParam(':role', $roleFilter);
        }
        if ($archiveFilter !== '') {
            $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Archiver un employé
    public function archiveEmploye($id) {
        $sql = "UPDATE administrateur SET archive = 1 WHERE matricule = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
