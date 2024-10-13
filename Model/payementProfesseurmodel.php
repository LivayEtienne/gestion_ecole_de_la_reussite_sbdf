<?php
// Surveillant.php

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/../database.php';

class Surveillant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les professeurs secondaires actifs
    public function getAll() {
        $sql = "
            SELECT 
                a.nom AS nom_enseignant,
                a.prenom AS prenom_enseignant,
                a.matricule,
                c.nom_classe,
                p.status,
                p.nombre_heure,
                a.tarif_horaire,
                CASE
                    WHEN p.status = 'non payé' THEN NULL
                    ELSE p.date_paiement
                END AS date_paiement,
                p.montant_total  -- Récupération du montant_total de la table paiements
            FROM 
                administrateur a
            LEFT JOIN 
                paiements p ON a.id = p.professeur_id
            LEFT JOIN 
                classe c ON p.id_cycle = c.id_cycle
            WHERE 
                a.role = 'enseignant_secondaire';
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfessorsByMonthAndYear() {
        try {
            $query = $this->pdo->prepare("
                SELECT 
                    p.nom AS professeur_nom,
                    p.prenom AS professeur_prenom,
                    COUNT(*) AS nombre_paiements,
                    MONTH(pa.date_paiement) AS mois,
                    YEAR(pa.date_paiement) AS annee
                FROM 
                    paiements pa
                JOIN 
                    professeurs p ON pa.professeur_id = p.id
                GROUP BY 
                    annee, mois, p.nom
                ORDER BY 
                    annee DESC, mois DESC
            ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération des professeurs par mois et année : ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de la récupération des professeurs.'];
        }
    }
    
// Mettre à jour le statut de paiement
public function updatePaymentStatus($professeurId) {
    try {
        // Préparer la requête pour mettre à jour le statut et la date de paiement
        $sql = "UPDATE paiements 
                SET status = :status, date_paiement = NOW() 
                WHERE professeur_id = :professeurId AND status = :currentStatus";

        // Préparer la requête SQL
        $stmt = $this->pdo->prepare($sql);

        // Exécuter la requête
        $stmt->execute([
            'status' => 'Payé',               // Nouveau statut à mettre à jour
            'currentStatus' => 'non payé',    // Statut actuel à vérifier avant la mise à jour
            'professeurId' => $professeurId   // ID du professeur dont le statut doit être mis à jour
        ]);

        // Vérifier si la mise à jour a affecté une ligne
        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Le statut de paiement a été mis à jour avec succès.'];
        } else {
            return ['success' => false, 'message' => 'Aucune mise à jour effectuée. Le statut est peut-être déjà payé ou le professeur n\'existe pas.'];
        }
    } catch (PDOException $e) {
        // Log de l'erreur en cas de problème
        error_log('Erreur lors de la mise à jour du statut de paiement : ' . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour du statut de paiement.'];
    }
}



}
?>
