<?php

class EmployeController {
    private $employe;

    public function __construct($employe) {
        $this->employe = $employe;
    }

    public function connexion() {
        // Vérifier si le formulaire de connexion a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les valeurs du formulaire
            $email = $_POST['email'] ?? '';
            $motDePasse = $_POST['mot_de_passe'] ?? '';

            // Valider que les champs ne sont pas vides
            if (!empty($email) && !empty($motDePasse)) {
                // Appel du modèle Employe pour authentifier l'utilisateur
                $admin = $this->employe->authentifier($email, $motDePasse);

                if ($admin) {
                    // Authentification réussie
                    // Par exemple : démarrer une session et rediriger vers le tableau de bord
                    session_start();
                    $_SESSION['admin'] = $admin;
                    header('Location: Dashboard/dashboard_directeur.php');
                    exit();
                } else {
                    $_SESSION['errorMessage'] = "Email ou mot de passe incorrect.";
                }
            } else {
                $_SESSION['errorMessage'] = "Veuillez entrer votre email et mot de passe.";
            }
        }
    }
}

?>
