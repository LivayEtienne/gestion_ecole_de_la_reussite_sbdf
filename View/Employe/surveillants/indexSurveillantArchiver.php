<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charger le modèle Surveillant
require_once __DIR__ . '/../../../Model/Surveillant.php';

// Assurez-vous que la connexion PDO est initialisée
$surveillantModel = new Surveillant($pdo);
$surveillants = $surveillantModel->getArchived(); // Récupère uniquement les surveillants archivés

// Vérification des messages de session pour afficher les notifications
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Réinitialiser le message

require_once 'layout.php';
?>

<div class="container">
    <h1>Liste des Surveillants Archivés</h1>

    <!-- Affichage du message de succès -->
    <?php if ($message): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchMatricule" placeholder="Rechercher par Matricule">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchNom" placeholder="Rechercher par Nom">
        </div>
        <div class="col-md-3">
            <button class="btn bg-danger float-end text-white">RECHERCHE</button>
        </div>
    </div>

    <table class="table table-striped mt-3">
        <thead class="bg-primary">
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="surveillantTableBody">
            <?php if ($surveillants): ?>
                <?php foreach ($surveillants as $surveillant): ?>
                    <tr>
                        <td><?= htmlspecialchars($surveillant['matricule']) ?></td>
                        <td><?= htmlspecialchars($surveillant['nom']) ?></td>
                        <td><?= htmlspecialchars($surveillant['prenom']) ?></td>
                        <td><?= htmlspecialchars($surveillant['email']) ?></td>
                        <td>
                            <a href="../../../Controlleur/SurveillantController.php?action=unarchive&id=<?= $surveillant['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir désarchiver cet enregistrement ?')">
                                <i class="fas fa-undo"></i> <!-- Icône de désarchivage -->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="no-data">Aucun surveillant archivé trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-3">
    <a href="index.php" class="btn btn-info">Voir liste des surveillants actifs</a>
</div>
