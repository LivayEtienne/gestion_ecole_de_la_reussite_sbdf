<?php
require_once '../.././../../database.php'; // Assurez-vous que le chemin est correct

// Récupération des filtres
$roleFilter = isset($_POST['role']) ? $_POST['role'] : '';
$archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';

// Construction de la requête SQL
$sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('comptable')";

// Ajoutez les conditions de filtre
if (!empty($roleFilter)) {
    $sql .= " AND role = :role";
}
if ($archiveFilter !== '') {
    $sql .= " AND archive = :archive";
}

// Préparation et exécution de la requête
$stmt = $pdo->prepare($sql);

if (!empty($roleFilter)) {
    $stmt->bindParam(':role', $roleFilter);
}
if ($archiveFilter !== '') {
    $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
}

$stmt->execute();
$administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construction du titre
$titre = "Liste des Comptables";

if ($archiveFilter !== '') {
    $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Listes Comptables</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <main>
        <div class="container mt-4">
            <form method="POST" action="comptable-list.php">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="archive">Archivés:</label>
                    <select class="form-select" name="archive" id="archive">
                        <option value="">Tous</option>
                        <option value="0" <?= $archiveFilter === '0' ? 'selected' : '' ?>>Non Archivés</option>
                        <option value="1" <?= $archiveFilter === '1' ? 'selected' : '' ?>>Archivés</option>
                    </select>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="submit" value="Filtrer" class="btn btn-danger">Recherche</button>
                </div>
            </div>
            </form>
        </div>
    </main>
    <h1 class="text-center mb-4"><?= htmlspecialchars($titre)?></h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-primary text-white text-center">
                <tr>
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
                <?php foreach ($administrateurs as $admin): ?>
                    <tr>
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
                    <td colspan="6">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
