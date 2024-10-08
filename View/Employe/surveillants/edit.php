<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion du modèle
require_once __DIR__ . '/../../../Model/Surveillant.php';

$surveillantModel = new Surveillant($pdo);

// Vérifier si l'ID du surveillant est présent dans l'URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Assurez-vous que l'ID est un entier
    $surveillant = $surveillantModel->getById($id); // Récupérer le surveillant par ID

    if (!$surveillant) {
        echo "Surveillant introuvable.";
        exit;
    }
} else {
    echo "ID manquant.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $matricule = $_POST['matricule'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    // Mise à jour du surveillant
    $surveillantModel->update($id, [
        'matricule' => $matricule,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email
    ]);

    // Debug : Vérifiez si le code atteint cette ligne
    echo "Mise à jour réussie. Redirection...";
    header("Location: index.php"); // Rediriger vers la liste des surveillants
    exit;
}


// Inclure la mise en page
require_once 'layout.php'; 
?>

<div class="container">
    <h1>Modifier Surveillant</h1>
    <form method="post">
        <div class="form-group">
            <label for="matricule">Matricule</label>
            <input type="text" name="matricule" id="matricule" class="form-control" value="<?= htmlspecialchars($surveillant['matricule']) ?>" required>
        </div>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($surveillant['nom']) ?>" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="<?= htmlspecialchars($surveillant['prenom']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($surveillant['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
