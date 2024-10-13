<?php
// Activer le mode de débogage pour voir les erreurs (à enlever en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../database.php'; // Connexion à la base de données
require_once __DIR__ . '/../Model/payementProfesseurmodel.php'; // Assurez-vous que le chemin est correct

class PaymentProfController {
    private $model;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; // Récupérer la connexion PDO
        $this->model = new Surveillant($this->pdo); // Passer la connexion PDO à Surveillant
    }

    // Récupérer tous les professeurs secondaires actifs
    public function getAll() {
        return $this->model->getAll();
    }

    // Vérifier un contact
    public function verifyContact($nom, $numero) {
        $contact = $this->model->verifyContact($nom, $numero);
        if ($contact) {
            return [
                'success' => true,
                'data' => $contact
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Contact non trouvé.'
            ];
        }
    }

    // Traitement des requêtes (exemple)
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification d'un contact
            if (isset($_POST['action']) && $_POST['action'] === 'verifyContact') {
                $nom = $_POST['nom'];
                $numero = $_POST['numero'];
                return $this->verifyContact($nom, $numero);
            }

            // Traitement d'un paiement
            if (isset($_POST['action']) && $_POST['action'] === 'processPayment') {
                $professeurId = $_POST['professeurId'];
                $montant = $_POST['montant'];
                return $this->processPayment($professeurId, $montant);
            }
        }
        
        // Pour une requête GET, par exemple, récupérer tous les professeurs
        return $this->getAll();
    }
   public function updatePaymentStatus(Request $request) {
    // Récupérer l'ID du professeur depuis le formulaire
    $professeurId = $request->input('professeurId');

    // Appeler la méthode pour mettre à jour le statut de paiement
    $updateResult = $this->model->updatePaymentStatus($professeurId);

    if ($updateResult['success']) {
        // Redirection en cas de succès avec un indicateur pour afficher le bulletin
        return redirect()->back()->with('success', 'Le statut de paiement a été mis à jour avec succès.')->with('showBulletin', true);
    } else {
        // Redirection en cas d'échec
        return redirect()->back()->with('error', $updateResult['message']);
    }
}
}
?>
