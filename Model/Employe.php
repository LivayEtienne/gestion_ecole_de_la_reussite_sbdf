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
            // Aucun administrateur trouvé avec cet email
            return false;
        }
    }
}
?>
