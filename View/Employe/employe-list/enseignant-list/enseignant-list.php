<?php
// enseignant-list.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../../../database.php'; // Assurez-vous que le chemin est correct


// Récupération des filtres
$roleFilter = isset($_POST['role']) ? $_POST['role'] : '';
$archiveFilter = isset($_POST['archive']) ? $_POST['archive'] : '';

// Construction de la requête SQL
$sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('surveillant_classe', 'surveillant_general')";

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
$titre = "Liste des Surveillants";
if (!empty($roleFilter)) {
    $titre .= " " . ($roleFilter === 'surveillant_classe' ? "Classe" : "General");
}
if ($archiveFilter !== '') {
    $titre .= $archiveFilter === '1' ? " Archivés" : " Non Archivés";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titre) ?></title>
    <link rel="stylesheet" href="enseignant-list.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1><?= htmlspecialchars($titre) ?></h1>

    <!-- Formulaire de filtre -->
    <form method="POST" action="enseignant-list.php">
        <label for="role">Rôle :</label>
        <select name="role" id="role">
            <option value="">Tous</option>
            <option value="surveillant_classe" <?= $roleFilter === 'surveillant_classe' ? 'selected' : '' ?>>Surveillant de classe</option>
            <option value="surveillant_general" <?= $roleFilter === 'surveillant_general' ? 'selected' : '' ?>>Surveillant général</option>
        </select>

        <label for="archive">Archivés :</label>
        <select name="archive" id="archive">
            <option value="">Tous</option>
            <option value="0" <?= $archiveFilter === '0' ? 'selected' : '' ?>>Non Archivés</option>
            <option value="1" <?= $archiveFilter === '1' ? 'selected' : '' ?>>Archivés</option>
        </select>

        <input type="submit" value="Filtrer">
    </form>

    <!-- Tableau d'affichage -->
    <table>
        <thead>
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
            <?php if (is_array($administrateurs) && count($administrateurs) > 0): ?>
                <?php foreach ($administrateurs as $admin): ?>
                    <tr>
                        <td><?= htmlspecialchars($admin['nom']) ?></td>
                        <td><?= htmlspecialchars($admin['prenom']) ?></td>
                        <td><?= htmlspecialchars($admin['telephone']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td><?= htmlspecialchars($admin['role']) ?></td>
                        <td><?= htmlspecialchars($admin['matricule']) ?></td>
                        <td>
                            <a href="list_employeArchiveView.php" title="Archiver" class="icon-yellow"><i class="fas fa-archive"></i></a>
                            <a href="modifier.php?id=<?= htmlspecialchars($admin['matricule']) ?>" title="Modifier" class="icon-blue"><i class="fas fa-edit"></i></a>
                            <a href="supprimer.php?id=<?= htmlspecialchars($admin['matricule']) ?>" title="Supprimer" class="icon-red" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="overlay"></div>

    <!-- Modal de confirmation d'archivage -->
    <div id="confirmModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Êtes-vous sûr de vouloir archiver cet administrateur ?</p>
            <button id="confirmArchive" class="button-confirm">Oui</button>
            <button id="cancelArchive" class="button-cancel">Non</button>
        </div>
    </div>

    <script src="enseignant-list.js"></script>
</body>
</html>
