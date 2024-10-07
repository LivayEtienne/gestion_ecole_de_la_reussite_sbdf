<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Élèves Archivés</title>
    <link rel="stylesheet" href="../View/Eleve/Eleve-list/eleve-list.css">
    <script src="../View/Eleve/Eleve-list/desarchivage_modal.js" defer></script> <!-- Inclure le fichier JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Inclure Font Awesome -->
</head>
<body>
    <h1>Liste des Élèves Archivés</h1>

    <div id="confirmationModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <p>Êtes-vous sûr de vouloir désarchiver cet élève ?</p>
            <button id="confirmArchive">Confirmer</button>
            <button onclick="closeModal()">Annuler</button>
        </div>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>ID Classe</th>
            <th>Moyenne Générale</th>
            <th>Tuteur Email</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($eleves_archives)): ?>
            <?php foreach ($eleves_archives as $eleve): ?>
                <tr>
                    <td><?php echo htmlspecialchars($eleve['id']); ?></td>
                    <td><?php echo htmlspecialchars($eleve['nom']); ?></td>
                    <td><?php echo htmlspecialchars($eleve['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($eleve['date_naissance']); ?></td>
                    <td><?php echo htmlspecialchars($eleve['id_classe']); ?></td>
                    <td><?php echo htmlspecialchars($eleve['moyenne_generale']); ?></td>
                    <td><?php echo htmlspecialchars($eleve['tuteur_email']); ?></td>
                    <td>
                        <a href="#" onclick="openModal(<?php echo $eleve['id']; ?>)">
                            <i class="fas fa-eye"></i> <!-- Icône de l'œil -->
                        </a> 
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">Aucun élève archivé trouvé.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
