<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../database.php'; // Connexion à la base de données
require_once __DIR__ . '/../Model/payementProfesseurmodel.php'; // Chemin correct vers le modèle

class PaymentProfController {
    private $model;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->model = new Surveillant($this->pdo);
    }

    // Récupérer tous les professeurs secondaires actifs
    public function getAll() {
        return $this->model->getAll();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier l'action
            if (isset($_POST['action']) && $_POST['action'] === 'confirmPayment') {
                $professeurId = $_POST['professeurId'] ?? null; // ID du professeur
                if (!$professeurId) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'ID du professeur manquant.']);
                    exit;
                }
                return $this->updatePaymentStatus($professeurId);
            }
        }
        
        // Pour une requête GET, récupérer tous les professeurs
        return $this->getAll();
    }
    

    public function updatePaymentStatus($professeurId) {
        // Préparer une requête pour mettre à jour le statut du paiement
        $query = "UPDATE paiements SET payment_status = :status WHERE professeur_id = :id";
        $stmt = $this->pdo->prepare($query);
        
        // Vous pouvez définir le statut comme nécessaire, par exemple 'paid'
        $status = 'paid';
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $professeurId);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Statut de paiement mis à jour avec succès.'];
        } else {
            return ['success' => false, 'message' => 'Échec de la mise à jour du statut de paiement.'];
        }
    }
}


// Initialisation du contrôleur et traitement de la requête
$controller = new PaymentProfController($pdo);
$controller->handleRequest();
?>
