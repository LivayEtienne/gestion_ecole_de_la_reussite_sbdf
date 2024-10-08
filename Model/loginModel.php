<?php

class Employe {
    private $pdo;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authentifier($email, $motDePasse) {
        // Requête SQL pour vérifier si l'email existe dans la table 'admins'
        $sql = "SELECT * FROM administrateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Vérifier si un administrateur avec cet email a été trouvé
        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe (hypothèse : le mot de passe est haché)
            if (password_verify($motDePasse, $admin['mot_de_passe'])) {
                // Authentification réussie, retourner les informations de l'administrateur
                return $admin;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    public function comptersurveillants() {
        // Requête pour compter le nombre de surveillants
        $sql_surveillants = "SELECT COUNT(*) AS total FROM administrateur WHERE role = 'surveillant'";
        $stmt = $this->pdo->prepare($sql_surveillants);  // Préparation de la requête
        $stmt->execute();  // Exécution de la requête
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  // Récupération du résultat sous forme de tableau associatif

        // Si le résultat existe, on retourne la valeur 'total', sinon on retourne 0
        return $result ? $result['total'] : 0;
    }


}