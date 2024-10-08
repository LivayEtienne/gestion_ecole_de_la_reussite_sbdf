<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Élève</title>
    <link rel="stylesheet" href="../View/Eleve/Eleve-list/modifie-eleve/eleve-list.css">
</head>
<body>
    <h1>Modifier les informations de l'élève</h1>

    <form action="modifier_eleve.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($eleve['id']); ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($eleve['nom']); ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($eleve['prenom']); ?>" required>

        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($eleve['date_naissance']); ?>" required>

        <label for="id_classe">Classe :</label>
        <input type="text" id="id_classe" name="id_classe" value="<?= htmlspecialchars($eleve['id_classe']); ?>" required>

        <label for="moyenne_generale">Moyenne Générale :</label>
        <input type="number" step="0.01" id="moyenne_generale" name="moyenne_generale" value="<?= htmlspecialchars($eleve['moyenne_generale']); ?>" required>

        <label for="tuteur_email">Email du Tuteur :</label>
        <input type="email" id="tuteur_email" name="tuteur_email" value="<?= htmlspecialchars($eleve['tuteur_email']); ?>" required>

        <label for="archive">Archivé :</label>
        <select id="archive" name="archive">
            <option value="0" <?= $eleve['archive'] == 0 ? 'selected' : ''; ?>>Non</option>
            <option value="1" <?= $eleve['archive'] == 1 ? 'selected' : ''; ?>>Oui</option>
        </select>

        <button type="submit">Mettre à jour</button>
        <a href="eleve-list.php" class="btn">Annuler</a>
    </form>
</body>
</html>
