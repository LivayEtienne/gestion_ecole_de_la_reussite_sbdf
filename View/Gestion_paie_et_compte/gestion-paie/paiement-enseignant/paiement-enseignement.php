<?php
require_once '../../../../database.php'; // Assurez-vous que le chemin est correct

// Récupération des filtres

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : ''; // Récupération du terme de recherche

// Nombre d'entrées par page
$entriesPerPage = 10;

// Récupération du numéro de page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage;

// Construction de la requête SQL
$sql = "SELECT nom, prenom, telephone, email, role, salaire_fixe FROM administrateur WHERE role IN ('enseignant_primaire')";


if (!empty($searchTerm)) {
    $sql .= " AND (nom LIKE :search OR prenom LIKE :search)"; // Recherche par nom ou prénom
}

// Récupération du nombre total d'entrées
$countSql = "SELECT COUNT(*) FROM administrateur WHERE role IN ('enseignant_primaire')";

if (!empty($searchTerm)) {
    $countSql .= " AND (nom LIKE :search OR prenom LIKE :search)";
}

$countStmt = $pdo->prepare($countSql);

if (!empty($searchTerm)) {
    $searchLike = '%' . $searchTerm . '%';
    $countStmt->bindParam(':search', $searchLike);
}
$countStmt->execute();
$totalEntries = $countStmt->fetchColumn();
$totalPages = ceil($totalEntries / $entriesPerPage);

// Ajout de la pagination à la requête principale
$sql .= " LIMIT :offset, :entriesPerPage";

$stmt = $pdo->prepare($sql);

if (!empty($searchTerm)) {
    $stmt->bindParam(':search', $searchLike);
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);

$stmt->execute();
$administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construction du titre
$titre = "Liste des Enseignants";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="paiement-enseignement.css">
</head>
<body>
    <div class="container mt-4">
        <form method="POST" action="paiement-enseignement.php">
            <div class="row mb-3">
                
                <div class="col-md-4">
                    <label for="search">Rechercher par nom :</label>
                    <input type="text" name="search" id="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>" />
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="submit" value="Filtrer" class="btn btn-danger">Recherche</button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Menu déroulant pour sélectionner un mois -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-center mb-4"><?= htmlspecialchars($titre)?></h1>
        <select id="mois-select" class="form-select w-auto">
            <option value="octobre">Octobre</option>
            <option value="novembre">Novembre</option>
            <option value="decembre">Décembre</option>
            <option value="janvier">Janvier</option>
            <option value="fevrier">Février</option>
            <option value="mars">Mars</option>
            <option value="avril">Avril</option>
            <option value="mai">Mai</option>
            <option value="juin">Juin</option>
        </select>
    </div>

    <!-- Tableau d'affichage -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Salaire</th>
                    <th>Statut</th> <!-- Colonne Statut ajoutée -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($administrateurs) > 0): ?>
                <?php foreach ($administrateurs as $index => $admin): ?>
                    <tr>
                        <td><?= $offset + $index + 1 ?></td> <!-- Affiche le numéro de ligne -->
                        <td><?= htmlspecialchars($admin['nom']) ?></td>
                        <td><?= htmlspecialchars($admin['prenom']) ?></td>
                        <td><?= htmlspecialchars($admin['telephone']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td><?= htmlspecialchars($admin['role']) ?></td>
                        <td><?= htmlspecialchars($admin['salaire_fixe']) ?></td>
                        <td class="text-center statut">
                            <span class="badge bg-danger">Non payé</span>
                        </td>
                        <td class="text-center">
                        <button class="btn btn-danger payer-btn" data-id="<?= $admin['id'] ?>">Payer</button>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= !empty($roleFilter) ? '&role=' . urlencode($roleFilter) : '' ?><?= $archiveFilter !== '' ? '&archive=' . $archiveFilter : '' ?><?= !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <script src="paiement-enseignement.js"></script>
</body>
</html>
