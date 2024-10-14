<?php
// Inclure la configuration de la base de données
require '../../../database.php';

// Récupérer les administrateurs (sauf directeur et comptable)
$query = "SELECT id, nom, prenom, role FROM administrateur WHERE role NOT IN ('directeur','surveillant_general', 'comptable')";
$stmt = $pdo->prepare($query);
$stmt->execute();
$administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les classes
$query = "SELECT id, nom_classe FROM classe";
$stmt = $pdo->prepare($query);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les matières
$query = "SELECT id, nom_matiere FROM matiere";
$stmt = $pdo->prepare($query);
$stmt->execute();
$matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
$success = false;

// Définir les classes par niveau
$classes_primaire = ['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'];
$classes_secondaire = ['6e', '5e', '4e', '3e'];

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_classe = isset($_POST['id_classe']) ? $_POST['id_classe'] : [];
    $id_enseignant = $_POST['id_enseignant'];
    $id_matieres = isset($_POST['id_matiere']) ? $_POST['id_matiere'] : [];

    // Vérifier le rôle de l'administrateur sélectionné
    $query = "SELECT role FROM administrateur WHERE id = :id_enseignant";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_enseignant' => $id_enseignant]);
    $role = $stmt->fetchColumn();

    // Vérification des classes sélectionnées
    $selected_classes = [];
    foreach ($id_classe as $classe_id) {
        $query = "SELECT nom_classe FROM classe WHERE id = :id_classe";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id_classe' => $classe_id]);
        $selected_classes[] = $stmt->fetchColumn();
    }

    // Validation des règles selon le rôle
    if ($role == 'enseignant_primaire') {
        // Vérifier que les classes sont uniquement des classes de niveau primaire
        if (array_diff($selected_classes, $classes_primaire)) {
            $errors[] = "Un enseignant primaire ne peut enseigner que dans des classes de niveau primaire (CI, CP, CE1, CE2, CM1, CM2).";
        }
        if (count($id_classe) > 1) {
            $errors[] = "Un enseignant primaire ne peut enseigner qu'une seule classe.";
        }
        if (!empty($id_matieres)) {
            // Ajouter ici la validation des matières si nécessaire
        }
    } elseif ($role == 'enseignant_secondaire') {
        // Vérifier que les classes sont uniquement des classes de niveau secondaire
        if (array_diff($selected_classes, $classes_secondaire)) {
            $errors[] = "Un enseignant secondaire ne peut enseigner que dans des classes de niveau secondaire (6e, 5e, 4e, 3e).";
        }
        if (empty($id_matieres)) {
            $errors[] = "Un enseignant secondaire doit enseigner au moins une matière.";
        }
    } elseif ($role == 'surveillant_classe') {
        if (count($id_classe) > 1) {
            $errors[] = "Un surveillant ne peut enseigner qu'une seule classe.";
        }
        if (!empty($id_matieres)) {
            $errors[] = "Un surveillant ne peut enseigner aucune matière.";
        }
        $id_matieres = []; // Les matières doivent être nulles
    }

    // Vérification des doublons
    if (empty($errors)) {
        foreach ($id_classe as $classe) {
            foreach ($id_matieres as $matiere) {
                $query = "SELECT COUNT(*) FROM classe_matiere WHERE id_classe = :id_classe AND id_matiere = :id_matiere AND id_enseignant = :id_enseignant";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'id_classe' => $classe,
                    'id_matiere' => $matiere,
                    'id_enseignant' => $id_enseignant
                ]);
                if ($stmt->fetchColumn() == 0) {
                    // Insertion des données si pas de doublon
                    $query = "INSERT INTO classe_matiere (id_classe, id_matiere, id_enseignant) VALUES (:id_classe, :id_matiere, :id_enseignant)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        'id_classe' => $classe,
                        'id_matiere' => $matiere,
                        'id_enseignant' => $id_enseignant
                    ]);
                }else {
                    $errors[] = "données existantes";
                }
            }

            // Si pas de matière (pour surveillant_classe), insertion de classe avec matiere NULL
            if (empty($id_matieres)) {
                $query = "SELECT COUNT(*) FROM classe_matiere WHERE id_classe = :id_classe AND id_matiere IS NULL AND id_enseignant = :id_enseignant";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'id_classe' => $classe,
                    'id_enseignant' => $id_enseignant
                ]);
                if ($stmt->fetchColumn() == 0) {
                    $query = "INSERT INTO classe_matiere (id_classe, id_matiere, id_enseignant) VALUES (:id_classe, NULL, :id_enseignant)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        'id_classe' => $classe,
                        'id_enseignant' => $id_enseignant
                    ]);
                }
            }
        }
        $success = true;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="matiere_classe-new.css">
    <title>Assignation Classe-Matière-Enseignant</title>
    <style>
        /* Simple style pour la modale */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .modal.active {
            display: block;
        }
        .modal .close-btn {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Assigner une ou plusieurs matières à une classe avec un enseignant</h1>
    
    <form method="POST" action="matiere_classe-new.php">
        <!-- Sélecteur d'administrateur (enseignant) -->
        <label for="id_enseignant">Sélectionnez un enseignant :</label>
        <select name="id_enseignant" id="id_enseignant" required onchange="handleRoleChange(this)">
            <option value="">-- Choisir un enseignant --</option>
            <?php foreach ($administrateurs as $admin): ?>
                <option value="<?= $admin['id']; ?>" data-role="<?= $admin['role']; ?>"><?= $admin['nom'] . " " . $admin['prenom'] . " - " . $admin['role']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <!-- Sélecteur de classes sous forme de cases à cocher -->
        <div id="classes-container">
            <label>Sélectionnez une ou plusieurs classes :</label><br>
            <?php foreach ($classes as $classe): ?>
                <input type="checkbox" name="id_classe[]" value="<?= $classe['id']; ?>"> <?= $classe['nom_classe']; ?><br>
            <?php endforeach; ?><br>
        </div>

        <!-- Sélecteur de matières sous forme de cases à cocher -->
        <div id="matieres-container">
            <label>Sélectionnez une ou plusieurs matières :</label><br>
            <?php foreach ($matieres as $matiere): ?>
                <input type="checkbox" name="id_matiere[]" value="<?= $matiere['id']; ?>"> <?= $matiere['nom_matiere']; ?><br>
            <?php endforeach; ?>
        </div><br>

        <button type="submit">Enregistrer</button>
    </form>

    <!-- Modale d'affichage des messages -->
    <div id="modal" class="modal">
        <p id="modal-message"></p>
        <button class="close-btn" onclick="closeModal()">Fermer</button>
    </div>

    <script>
        // Fonction pour fermer la modale
        function closeModal() {
            document.getElementById('modal').classList.remove('active');
        }

        // Afficher la modale avec les erreurs ou le succès
        <?php if (!empty($errors)): ?>
            document.getElementById('modal-message').innerHTML = "<?= implode('<br>', $errors); ?>";
            document.getElementById('modal').classList.add('active');
        <?php elseif ($success): ?>
            document.getElementById('modal-message').innerHTML = "Données enregistrées avec succès.";
            document.getElementById('modal').classList.add('active');
        <?php endif; ?>

        // Gérer l'affichage des champs en fonction du type d'enseignant
        function handleRoleChange(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var role = selectedOption.getAttribute('data-role');
            var matieresContainer = document.getElementById('matieres-container');
            var classesContainer = document.getElementById('classes-container');

            // Réinitialiser les sélections
            for (let checkbox of matieresContainer.querySelectorAll('input[type="checkbox"]')) {
                checkbox.checked = false;
            }

            // Afficher/Masquer les sélecteurs selon le rôle
            if (role === 'surveillant_classe') {
                matieresContainer.style.display = 'block';
                classesContainer.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.disabled = false; // Désactiver les classes
                });
            } else {
                matieresContainer.style.display = 'block';
                classesContainer.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.disabled = false; // Activer les classes
                });
            }
        }
    </script>
</body>
</html>
