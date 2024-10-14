<?php
header('Content-Type: application/json'); // Pour renvoyer une réponse JSON

require_once '../../../../database.php'; // Assurez-vous que le chemin est correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données POST
    $idAdmin = isset($_POST['id_admin']) ? intval($_POST['id_admin']) : 0;
    $salaire = isset($_POST['salaire']) ? floatval($_POST['salaire']) : 0.00;
    $mois = isset($_POST['mois']) ? trim($_POST['mois']) : '';
    $annee = isset($_POST['annee']) ? intval($_POST['annee']) : 0;
    $datePaiement = isset($_POST['date_paiement']) ? trim($_POST['date_paiement']) : '';
    $modePaiement = isset($_POST['mode_paiement']) ? trim($_POST['mode_paiement']) : '';

    // Validation des données
    if ($idAdmin > 0 && $salaire > 0 && !empty($mois) && $annee >= 2000 && !empty($datePaiement) && !empty($modePaiement)) {
        try {
            // Début de la transaction
            $pdo->beginTransaction();

            // Insérer le paiement dans la table paiement_enseignant
            $insertSql = "INSERT INTO paiement_enseignant (id_administrateur, mois, annee, salaire, date_paiement, mode) 
                          VALUES (:id_administrateur, :mois, :annee, :salaire, :date_paiement, :mode)";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([
                ':id_administrateur' => $idAdmin,
                ':mois' => $mois,
                ':annee' => $annee,
                ':salaire' => $salaire,
                ':date_paiement' => $datePaiement,
                ':mode' => $modePaiement
            ]);

            // Récupérer l'ID du paiement inséré
            $paiementId = $pdo->lastInsertId();

            // Commit de la transaction
            $pdo->commit();

            // Répondre avec succès et retourner l'ID du paiement
            echo json_encode(['success' => true, 'paiement_id' => $paiementId]);
        } catch (PDOException $e) {
            // Rollback en cas d'erreur
            $pdo->rollBack();
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        // Répondre avec une erreur de validation
        echo json_encode(['success' => false, 'error' => 'Données invalides.']);
    }
} else {
    // Méthode HTTP non autorisée
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
?>
