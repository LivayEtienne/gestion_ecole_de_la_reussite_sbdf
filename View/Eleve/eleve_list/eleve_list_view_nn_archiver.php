<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Élèves</title>
    <!-- Inclure le fichier CSS pour les styles -->
    <link rel="stylesheet" href="../View/Eleve/Eleve-list/eleve-list.css">
    
    <!-- Inclure Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Inclure le fichier JS pour les scripts -->
    <script src="../View/Eleve/eleve-list/eleve-list.js" defer></script> <!-- Ajout de 'defer' -->
</head>
<body>
    <h1>Liste des Élèves</h1>

    <!-- Champs de recherche -->
    <div class="search-container">
    <div class="search-box">
        <input type="text" id="searchMatricule" placeholder="Recherche par matricule" />
        <input type="text" id="searchClasse" placeholder="Recherche par classe" />
        <button onclick="searchStudents()">Rechercher</button>
    </div>
</div>

    <!-- Modale de confirmation -->
    <div id="confirmationModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <p>Êtes-vous sûr de vouloir archiver cet élève ?</p>
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
            <th>Archive</th>
            <th>Actions</th>
        </tr>
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
                    <td>
                        <!-- Icône pour modifier -->
                        <a href="edit.php?id=<?php echo $eleve['id']; ?>" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Icône pour supprimer -->
                        <a href="delete.php?id=<?php echo $eleve['id']; ?>" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">
                            <i class="fas fa-trash"></i>
                        </a>

                        <!-- Icône pour archiver remplacée par l'icône de l'œil -->
                        <a href="#" title="Archiver" onclick="openModal(<?php echo $eleve['id']; ?>)">
                            <i class="fas fa-eye"></i> <!-- Icône de l'œil -->
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">Aucun élève trouvé.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
