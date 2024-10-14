<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__. '/../../../../database.php'; // Assurez-vous que le chemin est correct
require_once __DIR__.('/../../../../vendor/setasign/fpdf/fpdf.php'); // Incluez la bibliothèque FPDF

// Vérifiez si l'ID du paiement est fourni
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $paiementId = intval($_GET['id']);

    // Récupérer les informations du paiement
    $sql = "SELECT p.*, a.nom, a.prenom FROM paiement_enseignant p
            JOIN administrateur a ON p.id_administrateur = a.id
            WHERE p.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $paiementId]);
    $paiement = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($paiement) {
        // Créer un nouveau PDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Ajouter le logo de l'école (si disponible)
        // $pdf->Image('logo.png',10,6,30);

        // Titre du bulletin de paie
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Ecole de la Reussite',0,1,'C');
        $pdf->Ln(5); // Espacement
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(0,10,'Bulletin de Paie',0,1,'C');
        $pdf->Ln(10);

        // Informations de l'enseignant
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(50,10,'Informations de l\'enseignant :',0,1);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,'Nom :',0,0);
        $pdf->Cell(0,10,$paiement['nom'],0,1);

        $pdf->Cell(50,10,'Prenom :',0,0);
        $pdf->Cell(0,10,$paiement['prenom'],0,1);

        $pdf->Ln(5); // Espacement

        // Informations sur le paiement
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(50,10,'Details du paiement :',0,1);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,'Date de Paiement :',0,0);
        $pdf->Cell(0,10,date('d-m-Y', strtotime($paiement['date_paiement'])),0,1);

        $pdf->Cell(50,10,'Mode de Paiement :',0,0);
        $pdf->Cell(0,10,$paiement['mode'],0,1);

        $pdf->Cell(50,10,'Mois :',0,0);
        $pdf->Cell(0,10,$paiement['mois'],0,1);

        $pdf->Cell(50,10,'Anee :',0,0);
        $pdf->Cell(0,10,$paiement['annee'],0,1);

        $pdf->Cell(50,10,'Montant :',0,0);
        $pdf->Cell(0,10,number_format($paiement['salaire'], 0, ',', ' ').' FCFA',0,1); // Format du salaire

        $pdf->Ln(10); // Espacement

        // Ajout d'une ligne pour simuler une séparation
        $pdf->Cell(0,0,'','T');
        $pdf->Ln(10);

        // Section pour les signatures
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Signatures :',0,1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial','',12);
        // Signature du Directeur
        $pdf->Cell(80,10,'Le Directeur',0,0,'C');
        $pdf->Cell(0,10,'L\'Enseignant',0,1,'C');
        $pdf->Ln(20); // Espacement pour les signatures

        $pdf->Cell(80,10,'_____________________',0,0,'C');
        $pdf->Cell(0,10,'_____________________',0,1,'C');
        $pdf->Cell(80,10,'Signature',0,0,'C');
        $pdf->Cell(0,10,'Signature',0,1,'C');

        // Générer le PDF et l'envoyer au navigateur
        $pdf->Output('D', 'Recu_Paiement_'.$paiement['nom'].'_'.$paiement['prenom'].'.pdf');
    } else {
        echo "Paiement non trouvé.";
    }
} else {
    echo "ID de paiement invalide.";
}
?>
