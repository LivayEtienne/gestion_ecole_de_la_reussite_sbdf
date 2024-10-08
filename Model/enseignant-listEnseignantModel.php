<?php
require_once '/opt/lampp/htdocs/gestion_ecole_sabadifa/database.php';

class AdministrateurModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAdministrateurs($roleFilter = '', $archiveFilter = '') {
        $sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('surveillant_classe', 'surveillant_general')";
        
        if (!empty($roleFilter)) {
            $sql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $sql .= " AND archive = :archive";
        }

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
}
?>
