<?php
// Démarrer la session pour accéder aux messages
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Assurez-vous que le modèle est chargé et que vous avez la liste des surveillants
require_once '../../../database.php';
require_once __DIR__ . '/../../../Model/Surveillant.php';
require_once __DIR__ . '/../../../Controlleur/SurveillantController.php';

// Créer une instance du contrôleur
$controller = new SurveillantController($pdo);
$surveillants = $controller->getAll(); // Récupérez les surveillants

require_once 'layout.php'; // ou '../views/layout.php' selon votre structure de dossier
?>



<div class="d-flex">
    <!-- Sidebar -->
    <div class="col-md-2 d-none d-md-block bg-primary h-1000 position-sticky sidebar">
    <h2 class="text-white">Dashboard</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Surveillants</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Autres Liens</a>
            </li>
            <!-- Ajoutez d'autres liens ici -->
        </ul>
    </div>

    <div class="container-fluid h-100 bg-light">
        <h1 class="text-dark">Liste des Surveillants</h1>

        <!-- Affichage des messages de succès -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['message']; // Afficher le message de succès
                unset($_SESSION['message']); // Effacer le message après l'affichage
                ?>
            </div>
        <?php endif; ?>

        <!-- Affichage des messages d'erreur -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'surveillant_deja_archive'): ?>
            <div class="alert alert-warning">Ce surveillant est déjà archivé.</div>
        <?php endif; ?>

            <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher par matricule ou nom...">
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-3">
                <button id="searchButton"class="btn btn-danger float-end">RECHERCHE</button>
            </div>
            </div>

        <div class="table-responsive">
            <table class="table table-striped mt-3 text-dark">
                <thead class="bg-primary">
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Archivage</th>
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
                                    <?php if ($surveillant['archive']): ?>
                                        <span class="text-danger">Archivé</span>
                                    <?php else: ?>
                                        <span class="text-success">Actif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Bouton de modification -->
                                    <a href="edit.php?id=<?= $surveillant['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Bouton d'archivage -->
                                    <a href="../../../Controlleur/SurveillantController.php?action=archive&id=<?= $surveillant['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir archiver cet enregistrement ?')">
                                        <i class="fas fa-archive"></i>
                                    </a>
                                
                                    <!-- Bouton de visualisation -->
                                    <a href="voir_surveillant.php?id=<?= $surveillant['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>                 <tr>
                        <td colspan="6">Aucun surveillant trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Bouton de redirection vers la page des surveillants archivés -->
        <div class="mt-3">
            <a href="indexSurveillantArchiver.php" class="btn btn-info">Voir les Surveillants Archivés</a>
        </div>
    </div>
</div>

</body>
<script>
    document.getElementById('searchButton').addEventListener('click', function() {
        var searchInput = document.getElementById('searchInput').value;
        var tableRows = document.getElementById('surveillantTableBody').rows;

        for (var i = 0; i < tableRows.length; i++) {
            var row = tableRows[i];
            var matriculeCell = row.cells[0];
            var nomCell = row.cells[1];

            if (matriculeCell.textContent.toLowerCase().includes(searchInput.toLowerCase()) || nomCell.textContent.toLowerCase().includes(searchInput.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
</script>
</html>
