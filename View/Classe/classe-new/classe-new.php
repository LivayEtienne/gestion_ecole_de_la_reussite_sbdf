<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Inclure la connexion à la base de données
require_once '../../../database.php';

// Récupérer les cycles depuis la base de données
try {
    $stmt = $pdo->prepare("SELECT id, nom_cycle FROM cycle");
    $stmt->execute();
    $cycles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cycles : " . $e->getMessage());
}

// Si le formulaire est soumis, traiter la création de la classe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomClasse = $_POST['nom_classe'];
    $idCycle = $_POST['id_cycle'];
    $seuilMax = isset($_POST['seuil_max']) ? (int)$_POST['seuil_max'] : 25;
    $isAnnexe = isset($_POST['is_annexe']) ? 1 : 0;

    // Insérer la nouvelle classe dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO classe (nom_classe, id_cycle, seuil_max, is_annexe) VALUES (:nom_classe, :id_cycle, :seuil_max, :is_annexe)");
        $stmt->bindParam(':nom_classe', $nomClasse);
        $stmt->bindParam(':id_cycle', $idCycle);
        $stmt->bindParam(':seuil_max', $seuilMax);
        $stmt->bindParam(':is_annexe', $isAnnexe);
        $stmt->execute();
        $successMessage = "La classe a été créée avec succès !";
    } catch (PDOException $e) {
        $errorMessage = "Erreur lors de la création de la classe : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une nouvelle classe</title>
    <link rel="stylesheet" href="classe-new.css"> <!-- Ton fichier CSS -->
</head>
<body>
    <h1>Créer une nouvelle classe</h1>

    <?php if (isset($successMessage)): ?>
        <div style="color: green;">
            <?= htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div style="color: red;">
            <?= htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form action="classe-new.php" method="POST">
        <label for="nom_classe">Nom de la classe :</label>
        <input type="text" id="nom_classe" name="nom_classe" required><br>

        <label for="id_cycle">Cycle :</label>
        <select id="id_cycle" name="id_cycle" required>
            <option value="">Sélectionner un cycle</option>
            <?php foreach ($cycles as $cycle): ?>
                <option value="<?= htmlspecialchars($cycle['id']); ?>"><?= htmlspecialchars($cycle['nom_cycle']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="seuil_max">Seuil maximum :</label>
        <input type="number" id="seuil_max" name="seuil_max" value="25"><br>

        <label for="is_annexe">Annexe :</label>
        <input type="checkbox" id="is_annexe" name="is_annexe"><br>

        <button type="submit">Créer la classe</button>
    </form>

    <script src="classe-new.js"></script> <!-- Ton fichier JS si nécessaire -->
</body>
</html>
