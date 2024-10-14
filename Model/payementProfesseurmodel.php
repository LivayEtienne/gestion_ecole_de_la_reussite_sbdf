<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
                p.professeur_id,
                p.nombre_heure,
                a.tarif_horaire,
                CASE
                    WHEN p.status = 'non payé' THEN NULL
                    ELSE p.date_paiement
                END AS date_paiement,
                p.montant_total  
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

    public function updatePaymentStatus($professeurId) {
        try {
            // Mettre à jour le statut de paiement
            $sql = "UPDATE paiements 
                    SET status = 'Payé', date_paiement = NOW() 
                    WHERE professeur_id = :professeurId AND status = 'non payé'";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['professeurId' => $professeurId]);
    
            // Vérifier si la mise à jour a bien été effectuée
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Le statut de paiement a été mis à jour avec succès.'];
            } else {
                return ['success' => false, 'message' => 'Aucune mise à jour effectuée. Le statut est peut-être déjà payé ou le professeur n\'existe pas.'];
            }
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour du statut de paiement : ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de la mise à jour du statut de paiement.'];
        }
    }
}


?>
