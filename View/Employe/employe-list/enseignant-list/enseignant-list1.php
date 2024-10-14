<?php
require_once '../.././../../database.php'; // Assurez-vous que le chemin est correct

// Récupération des filtres
$roleFilter = isset($_POST['role']) ? $_POST['role'] : '';
$archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : ''; // Récupération du terme de recherche

// Nombre d'entrées par page
$entriesPerPage = 10;

// Récupération du numéro de page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage;

// Construction de la requête SQL
$sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('enseignant_primaire', 'enseignant_secondaire')";

// Ajoutez les conditions de filtre
if (!empty($roleFilter)) {
    $sql .= " AND role = :role";
}
if ($archiveFilter !== '') {
    $sql .= " AND archive = :archive";
}
if (!empty($searchTerm)) {
    $sql .= " AND (nom LIKE :search OR prenom LIKE :search)"; // Recherche par nom ou prénom
}

// Récupération du nombre total d'entrées
$countSql = "SELECT COUNT(*) FROM administrateur WHERE role IN ('enseignant_primaire', 'enseignant_secondaire')";
if (!empty($roleFilter)) {
    $countSql .= " AND role = :role";
}
if ($archiveFilter !== '') {
    $countSql .= " AND archive = :archive";
}
if (!empty($searchTerm)) {
    $countSql .= " AND (nom LIKE :search OR prenom LIKE :search)";
}

$countStmt = $pdo->prepare($countSql);
if (!empty($roleFilter)) {
    $countStmt->bindParam(':role', $roleFilter);
}
if ($archiveFilter !== '') {
    $countStmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
}
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
if (!empty($roleFilter)) {
    $stmt->bindParam(':role', $roleFilter);
}
if ($archiveFilter !== '') {
    $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
}
if (!empty($searchTerm)) {
    $stmt->bindParam(':search', $searchLike);
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);

$stmt->execute();
$administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construction du titre
$titre = "Liste des Enseignants";
if (!empty($roleFilter)) {
    $titre .= " " . ($roleFilter === 'enseignant_primaire' ? "Primaires" : "Secondaires");
}
if ($archiveFilter !== '') {
    $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <form method="POST" action="enseignant-list.php">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="role">Rôle :</label>
                    <select name="role" id="role">
                        <option value="">Tous</option>
                        <option value="enseignant_primaire" <?= $roleFilter === 'enseignant_primaire' ? 'selected' : '' ?>>Enseignant Primaire</option>
                        <option value="enseignant_secondaire" <?= $roleFilter === 'enseignant_secondaire' ? 'selected' : '' ?>>Enseignant Secondaire</option>
                    </select><br>
                    <label for="archive">Archivés :</label>
                    <select name="archive" id="archive">
                        <option value="">Tous</option>
                        <option value="0" <?= $archiveFilter === '0' ? 'selected' : '' ?>>Non Archivés</option>
                        <option value="1" <?= $archiveFilter === '1' ? 'selected' : '' ?>>Archivés</option>
                    </select>
                </div>
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
    <h1 class="text-center mb-4"><?= htmlspecialchars($titre)?></h1>

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
                    <th>Matricule</th>
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
                        <td><?= htmlspecialchars($admin['matricule']) ?></td>
                        <td class="text-center">
                            <a href="#" class="text-success me-2 edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="#" class="text-danger me-2" title="Supprimer"><i class="fas fa-trash"></i></a>
                            <a href="#" class="text-warning" title="Archiver"><i class="fas fa-eye"></i></a>
                        </td>
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
</body>
</html>