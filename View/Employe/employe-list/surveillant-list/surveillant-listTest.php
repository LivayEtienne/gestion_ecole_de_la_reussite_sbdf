<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titre) ?></title>
    <link rel="stylesheet" href="surveillant-list.css">
</head>
<body>
    <h1><?= htmlspecialchars($titre) ?></h1>

    <!-- Formulaire de filtre -->
    <form method="POST" action="surveillant-list.php">
        <label for="role">Rôle :</label>
        <select name="role" id="role">
            <option value="">Tous</option>
            <option value="enseignant_primaire" <?= $roleFilter === 'enseignant_primaire' ? 'selected' : '' ?>>Enseignant Primaire</option>
            <option value="enseignant_secondaire" <?= $roleFilter === 'enseignant_secondaire' ? 'selected' : '' ?>>Enseignant Secondaire</option>
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
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script src=""></script>
</body>
</html>
