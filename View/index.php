<!doctype html>
<html lang="fr">
<head>
    <title>Gestion des Élèves</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="modification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="container mt-4">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Recherche par nom">
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option selected>Recherche par classe</option>
                        <option value="6EME">6EME</option>
                        <option value="5EME">5EME</option>
                    </select>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-danger">Recherche</button>
                </div>
            </div>

            <h3 class="text-center mb-4">TOUS LES ÉLÈVES DU SECONDAIRE</h3>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de Naissance</th>
                            <th>ID Classe</th>
                            <th>Moyenne Générale</th>
                            <th>Tuteur Email</th>
                            <th>Archive</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($eleves)): ?>
                            <?php foreach ($eleves as $eleve): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($eleve['id']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['date_naissance']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['id_classe']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['moyenne_generale']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['tuteur_email']); ?></td>
                                    <td><?php echo htmlspecialchars($eleve['archive']); ?></td>
                                    <td class="text-center">
                                        <a href="#" class="text-success me-2 edit-btn" 
                                           data-matricule="<?php echo htmlspecialchars($eleve['id']); ?>"
                                           data-nom="<?php echo htmlspecialchars($eleve['nom']); ?>"
                                           data-prenom="<?php echo htmlspecialchars($eleve['prenom']); ?>"
                                           data-email="<?php echo htmlspecialchars($eleve['tuteur_email']); ?>"
                                           data-classe="<?php echo htmlspecialchars($eleve['id_classe']); ?>" 
                                           title="Modifier"><i class="fas fa-edit"></i></a>
                                        <a href="delete.php?id=<?php echo $eleve['id']; ?>" class="text-danger me-2" title="Supprimer"><i class="fas fa-trash"></i></a>
                                        <a href="archive.php?id=<?php echo $eleve['id']; ?>" class="text-warning" title="Archiver"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Aucun élève trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal pour le formulaire de modification -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier l'élève</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <div class="mb-3">
                                <label for="matricule" class="form-label">Matricule</label>
                                <input type="text" class="form-control" id="matricule" name="matricule" required>
                            </div>
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail Parent</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="classe" class="form-label">Classe</label>
                                <input type="text" class="form-control" id="classe" name="classe" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-p0BHZCzHqPzZpCPzPbUul8M4zZ7vvmpS2uoS1uhWynJ4L7MoBpLl11rZUJnmc5UJ" crossorigin="anonymous"></script>
    
    <!-- Lien vers le fichier JavaScript -->
    <script src="View/Eleve/Eleve-list/eleve-list.js"></script>
</body>
</html>