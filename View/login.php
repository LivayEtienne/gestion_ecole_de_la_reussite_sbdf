<?php
session_start();
$errorMessage = $_SESSION['errorMessage'] ?? ''; // Récupérer le message d'erreur de la session


require_once '../database.php'; 
require_once '../Model/loginModel.php'; 
require_once '../Controlleur/loginController.php'; 

// Créer une instance du modèle Employe
$employeModel = new Employe($pdo); // $pdo venant du fichier database.php (connexion à la BDD)

$controller = new EmployeController($employeModel);
$controller->connexion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <img src="../assets/SABADIFA.png" alt="Logo" class="logo mb-3">
                    <div class="text-icon">
                        <span class="bg-icons">Discipline</span>
                        <span class="bg-icons1">Assiduité</span>
                        <span class="bg-icons2">Réussite</span>
                    </div>
                </div>
               
                <form class="login-form" method="POST" action="login.php">
                    <div class="form-group">
                        <label class="text" for="">Email ou Matricule</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="text" for="">Mot de passe</label>
                        <input type="password" class="form-control" name="mot_de_passe" id="password" required  >
                     </div>
                    <div class="form-group">
                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;  position: absolute; right: 80px; top: 60%; transform: translateY(-70%);"></i>
                        <button type="submit" class="btn btn-connexion btn-block">Connexion</button>
                    </div>

                </form>
                <div id="errorMessage" class="error-message">
                <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?= $errorMessage; ?></div>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
  
    <script src="./script.js"></script>
</body>
</html>