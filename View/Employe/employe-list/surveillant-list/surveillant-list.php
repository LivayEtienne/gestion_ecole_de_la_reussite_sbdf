<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?= htmlspecialchars($titre) ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <main>
        <div class="container mt-4">
            <form method="POST" action="surveillant-listView.php">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="search">Rechercher par nom :</label>
                        <input type="text" name="search" id="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="role">Rôle :</label>
                        <select class="form-select" name="role" id="role">
                            <option value="">Tous</option>
                            <option value="surveillant_classe" <?= $roleFilter === 'surveillant_classe' ? 'selected' : '' ?>>surveillant de classe</option>
                            <option value="surveillant_general" <?= $roleFilter === 'surveillant_general' ? 'selected' : '' ?>>surveillant general</option>
                        </select><br>
                    </div>
                    <div class="col-md-3">
                        <label for="archive">Archivés:</label>
                        <select class="form-select" name="archive" id="archive">
                            <option value="">Tous</option>
                            <option value="0" <?= $archiveFilter === '0' ? 'selected' : '' ?>>Non Archivés</option>
                            <option value="1" <?= $archiveFilter === '1' ? 'selected' : '' ?>>Archivés</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 text-md-end">
                        <button type="submit" value="Filtrer" class="btn btn-danger">Recherche</button>
                    </div>
                </div>
            </form>
        </div>
    
        <h1 class="text-center mb-4"><?= htmlspecialchars($titre) ?></h1>

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
                <?php if (count($admins) > 0): ?>
                    <?php foreach ($admins as $index => $admin):  ?>
                        <tr>
                            <td><?= $offset + $index + 1 ?></td>
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
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?><?= $archiveFilter !== '' ? '&archive=' . $archiveFilter : '' ?><?= !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
