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

// Initialiser les messages d'erreur
$errorMessage = '';

// Traitement du formulaire
// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $matricule = $_POST['matricule'];
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email)) {
        $errorMessage = "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "L'email est invalide.";
    } else {
        // Vérifier si l'email existe déjà (sauf si c'est la même que l'email actuel)
        $existingSurveillant = $surveillantModel->getByEmail($email);
        if ($existingSurveillant && $existingSurveillant['id'] != $id) {
            $errorMessage = "L'email est déjà utilisé par un autre surveillant.";
        } else {
            // Mise à jour du surveillant
            $surveillantModel->update($id, [
                'matricule' => $matricule,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email
            ]);

            // Redirection après succès
            header("Location: index.php"); // Rediriger vers la liste des surveillants
            exit;
        }
    }
}

// Inclure la mise en page
require_once 'layout.php'; 
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Modifier Surveillant</h1>
    
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form method="post" class="bg-light p-4 rounded shadow-sm">
        <input type="hidden" name="matricule" id="matricule" value="<?= htmlspecialchars($surveillant['matricule']) ?>">

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
        
        <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
        <a href="index.php" class="btn btn-secondary btn-block">Annuler</a>
    </form>
</div>
