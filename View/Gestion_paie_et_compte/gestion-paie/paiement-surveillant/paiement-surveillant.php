<?php
require_once '../../../../database.php'; // Assurez-vous que le chemin est correct

// Récupération des filtres
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : ''; // Terme de recherche
$selectedMonth = isset($_GET['mois']) ? $_GET['mois'] : 'octobre'; // Mois par défaut
$selectedYear = isset($_GET['annee']) ? $_GET['annee'] : date('Y'); // Année par défaut
$roleFilter = isset($_GET['role']) ? $_GET['role'] : ''; // Filtre par rôle

// Nombre d'entrées par page
$entriesPerPage = 10;

// Récupération du numéro de page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $entriesPerPage;

// Construction de la requête SQL pour récupérer les surveillants et leurs classes (agrégées en une seule ligne)
$sql = "
    SELECT a.id, a.nom, a.prenom, a.telephone, a.email, a.role, a.salaire_fixe, a.matricule,
           GROUP_CONCAT(DISTINCT c.nom_classe ORDER BY c.nom_classe SEPARATOR ', ') AS classes,
           p.id AS paiement_id,
           p.mois AS paiement_mois,
           p.annee AS paiement_annee,
           p.date_paiement,
           p.mode
    FROM administrateur a 
    LEFT JOIN classe_matiere cm ON a.id = cm.id_enseignant
    LEFT JOIN classe c ON cm.id_classe = c.id
    LEFT JOIN paiement_enseignant p ON a.id = p.id_administrateur 
        AND p.mois = :mois 
        AND p.annee = :annee
    WHERE (a.role = 'surveillant_classe' OR a.role = 'surveillant_general')
";

// Ajoutez les conditions de filtre
if (!empty($searchTerm)) {
    $sql .= " AND (a.nom LIKE :search OR a.prenom LIKE :search OR a.matricule LIKE :search)";
}

if (!empty($roleFilter)) {
    $sql .= " AND a.role = :role";
}

$sql .= " GROUP BY a.id";

// Récupération du nombre total d'entrées (avant pagination)
$countSql = "
    SELECT COUNT(DISTINCT a.id) 
    FROM administrateur a 
    LEFT JOIN classe_matiere cm ON a.id = cm.id_enseignant
    LEFT JOIN classe c ON cm.id_classe = c.id
    WHERE (a.role = 'surveillant_classe' OR a.role = 'surveillant_general')
";

if (!empty($searchTerm)) {
    $countSql .= " AND (a.nom LIKE :search OR a.prenom LIKE :search OR a.matricule LIKE :search)";
}

if (!empty($roleFilter)) {
    $countSql .= " AND a.role = :role";
}

// Préparation et exécution des requêtes
$countStmt = $pdo->prepare($countSql);

if (!empty($searchTerm)) {
    $searchLike = '%' . $searchTerm . '%';
    $countStmt->bindParam(':search', $searchLike);
}

if (!empty($roleFilter)) {
    $countStmt->bindParam(':role', $roleFilter);
}

$countStmt->execute();
$totalEntries = $countStmt->fetchColumn();
$totalPages = ceil($totalEntries / $entriesPerPage);

$sql .= " LIMIT :offset, :entriesPerPage";
$stmt = $pdo->prepare($sql);

if (!empty($searchTerm)) {
    $stmt->bindParam(':search', $searchLike);
}

if (!empty($roleFilter)) {
    $stmt->bindParam(':role', $roleFilter);
}

$stmt->bindParam(':mois', $selectedMonth);
$stmt->bindParam(':annee', $selectedYear);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);

$stmt->execute();
$administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construction du titre
$titre = "Liste des Surveillants";

// Détermination du statut de paiement
$statutPayé = [];
foreach ($administrateurs as $admin) {
    if ($admin['paiement_id']) {
        $statutPayé[$admin['id']] = true;
    } else {
        $statutPayé[$admin['id']] = false;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="paiement-surveillant.css">
    <title>Paiement-Surveillant</title>
</head>
<body>
    <div class="container mt-4">
        <form method="GET" action="paiement-surveillant.php">
            <div class="row mb-3">               
                
                <div class="col-md-6">
                    <label for="mois">Sélectionner le mois :</label>
                    <select name="mois" id="mois-select" class="form-select">
                        <option value="">Tous les mois</option>
                        <option value="janvier" <?= $selectedMonth == 'janvier' ? 'selected' : '' ?>>Janvier</option>
                        <option value="fevrier" <?= $selectedMonth == 'fevrier' ? 'selected' : '' ?>>Février</option>
                        <option value="mars" <?= $selectedMonth == 'mars' ? 'selected' : '' ?>>Mars</option>
                        <option value="avril" <?= $selectedMonth == 'avril' ? 'selected' : '' ?>>Avril</option>
                        <option value="mai" <?= $selectedMonth == 'mai' ? 'selected' : '' ?>>Mai</option>
                        <option value="juin" <?= $selectedMonth == 'juin' ? 'selected' : '' ?>>Juin</option>
                        <option value="juillet" <?= $selectedMonth == 'juillet' ? 'selected' : '' ?>>Juillet</option>
                        <option value="aout" <?= $selectedMonth == 'aout' ? 'selected' : '' ?>>Août</option>
                        <option value="septembre" <?= $selectedMonth == 'septembre' ? 'selected' : '' ?>>Septembre</option>
                        <option value="octobre" <?= $selectedMonth == 'octobre' ? 'selected' : '' ?>>Octobre</option>
                        <option value="novembre" <?= $selectedMonth == 'novembre' ? 'selected' : '' ?>>Novembre</option>
                        <option value="decembre" <?= $selectedMonth == 'decembre' ? 'selected' : '' ?>>Décembre</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="annee">Sélectionner l'année :</label>
                    <select name="annee" id="annee-select" class="form-select">
                        <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                            <option value="<?= $i ?>" <?= $selectedYear == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h1 class="text-center mb-4"><?= htmlspecialchars($titre) ?></h1>
                    </div>
                </div>              
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="search">Rechercher par nom, prenom ou matricule :</label>
                    <input type="text" name="search" id="search-input" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>" />
                </div>
                <div class="col-md-6">
                    <label for="role">Rôle :</label>
                    <select class="form-select" name="role" id="role">
                        <option value="">Tous</option>
                        <option value="surveillant_classe" <?= $roleFilter === 'surveillant_classe' ? 'selected' : '' ?>>Surveillant de classe</option>
                        <option value="surveillant_general" <?= $roleFilter === 'surveillant_general' ? 'selected' : '' ?>>Surveillant général</option>
                    </select>
                </div>             
            </div>
        </form>
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
                    <th>Matricule</th>
                    <th>Rôle</th>
                    <th>Salaire</th>
                    <th>Classes</th> <!-- Colonne pour afficher les classes (agrégées) -->
                    <th>Statut</th>
                    <th>Actions</th>
                    <th>Reçu</th> <!-- Nouvelle colonne pour le bouton de PDF -->
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
                        <td><?= htmlspecialchars($admin['matricule']) ?></td>
                        <td><?= htmlspecialchars($admin['role']) ?></td>
                        <td><?= htmlspecialchars($admin['salaire_fixe']) ?> FCFA</td>
                        <td><?= htmlspecialchars($admin['classes'] ?? 'Non attribuées') ?></td> <!-- Affiche toutes les classes sous forme de liste -->
                        <td class="text-center statut" id="status-<?= $admin['id'] ?>">
                            <?= isset($statutPayé[$admin['id']]) && $statutPayé[$admin['id']] ? '<span class="badge bg-success">Payé</span>' : '<span class="badge bg-danger">Non payé</span>' ?>
                        </td>
                        <td class="text-center">
                            <?php if (!isset($statutPayé[$admin['id']]) || !$statutPayé[$admin['id']]): ?>
                                <button class="btn btn-danger payer-btn" 
                                        data-id="<?= $admin['id'] ?>" 
                                        data-nom="<?= htmlspecialchars($admin['nom']) ?>" 
                                        data-prenom="<?= htmlspecialchars($admin['prenom']) ?>" 
                                        data-salaire="<?= htmlspecialchars($admin['salaire_fixe']) ?>" 
                                        data-mois="<?= $selectedMonth ?>" 
                                        data-annee="<?= $selectedYear ?>">
                                    Payer
                                </button>
                            <?php else: ?>
                                <button class="btn btn-success" disabled>Payé</button>
                            <?php endif; ?>
                        </td>
                        <td class="text-center recu-cell" id="recu-<?= $admin['id'] ?>">
                            <?php if (isset($statutPayé[$admin['id']]) && $statutPayé[$admin['id']]): ?>
                                <a href="generate-pdf.php?id=<?= $admin['paiement_id'] ?>" class="btn btn-info">Télécharger Reçu</a>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Non disponible</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>&mois=<?= urlencode($selectedMonth) ?>&annee=<?= $selectedYear ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <!-- Modal de sélection du mode de paiement -->
    <div class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="paiementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choisissez un Mode de Paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir payer <strong id="nom-complet"></strong> pour <strong id="mois-paiement"></strong> <strong id="annee-paiement"></strong> ?</p>
                    <p>Montant : <strong id="montant-paiement"></strong> FCFA</p>
                    
                    <!-- Modes de paiement sous forme de cartes -->
                    <h6>Sélectionnez un mode de paiement :</h6>
                    <div class="row mt-3">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card h-100 payment-card" data-mode="Wave">
                                <div class="card-body text-center">
                                    <i class="fas fa-mobile-alt fa-3x mb-3"></i>
                                    <h5 class="card-title">Wave</h5>
                                    <p class="card-text">Paiement via Wave.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card h-100 payment-card" data-mode="Orange Money">
                                <div class="card-body text-center">
                                    <i class="fas fa-money-bill-alt fa-3x mb-3"></i>
                                    <h5 class="card-title">Orange Money</h5>
                                    <p class="card-text">Paiement via Orange Money.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card h-100 payment-card" data-mode="Wizall">
                                <div class="card-body text-center">
                                    <i class="fas fa-wallet fa-3x mb-3"></i>
                                    <h5 class="card-title">Wizall</h5>
                                    <p class="card-text">Paiement via Wizall.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card h-100 payment-card" data-mode="Espèces">
                                <div class="card-body text-center">
                                    <i class="fas fa-money-check-alt fa-3x mb-3"></i>
                                    <h5 class="card-title">Espèces</h5>
                                    <p class="card-text">Paiement en espèces.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="selectedPaymentMode" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmPayment" disabled>Valider</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title">Paiement Réussi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
             <p>Le paiement a été effectué avec succès via <strong id="successPaymentMode"></strong>.</p>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
           </div>
         </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="paiement-surveillant.js"></script>
</body>
</html>
