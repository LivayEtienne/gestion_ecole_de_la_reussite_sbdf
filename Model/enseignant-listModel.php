<?php
// administrateurModel.php
require_once '/opt/lampp/htdocs/gestion_ecole_sabadifa/database.php';

function getAdministrateurs($roleFilter = '', $archiveFilter = '') {
    global $pdo;
    
    // Construction de la requête SQL
    $sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('surveillant_classe', 'surveillant_general')";
    
    // Ajoutez les conditions de filtre
    if (!empty($roleFilter)) {
        $sql .= " AND role = :role";
    }
    if ($archiveFilter !== '') {
        $sql .= " AND archive = :archive";
    }

    // Préparation et exécution de la requête
    $stmt = $pdo->prepare($sql);

    if (!empty($roleFilter)) {
        $stmt->bindParam(':role', $roleFilter);
    }
    if ($archiveFilter !== '') {
        $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
