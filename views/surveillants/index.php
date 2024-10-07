<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Assurez-vous que le modèle est chargé et que vous avez la liste des surveillants
require_once __DIR__ . '/../../models/Surveillant.php';

$surveillantModel = new Surveillant();
$surveillants = $surveillantModel->getAll(); // Récupérez les surveillants

require_once '../layout.php'; // ou '../views/layout.php' selon votre structure de dossier
?>

<div class="container">
    <h1>Liste des Surveillants</h1>
    
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

    <table class="table table-striped mt-3 ">
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
                <a href="edit.php?id=<?= $surveillant['id'] ?>" class="btn btn-warning btn-sm">
    <i class="fas fa-edit"></i> <!-- Icône d'édition -->
</a>

    <a href="/surveillants/archive/<?= $surveillant['id'] ?>" class="btn btn-secondary btn-sm">
        <i class="fas fa-archive"></i> <!-- Icône d'archivage -->
    </a>
    <a href="/surveillants/delete/<?= $surveillant['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')">
        <i class="fas fa-trash-alt"></i> <!-- Icône de suppression -->
    </a>
</td>

            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="no-data">Aucun surveillant trouvé.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</div>

