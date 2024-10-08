<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Élèves Archivés</title>
    <link rel="stylesheet" href="eleve-list.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Liste des Élèves Archivés</h1>

    <!-- Tableau d'affichage des élèves archivés -->
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Classe</th>
                <th>Matricule</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les données des élèves archivés seront insérées ici à partir du modèle -->
            <tr>
                <td colspan="7">Aucun élève archivé trouvé.</td>
            </tr>
        </tbody>
    </table>

    <!-- Bouton de retour à la liste des élèves non archivés -->
    <div>
        <a href="list_eleve_non_archiver.php" class="button">Retour à la liste des élèves non archivés</a>
    </div>
</body>
</html>
