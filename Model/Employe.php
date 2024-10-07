<?php
require_once '../database.php'; // Assurez-vous que le chemin est correct
class Employe {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function verifierEmailExistant($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM administrateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function verifierTelephoneExistant($telephone) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM administrateur WHERE telephone = ?");
        $stmt->execute([$telephone]);
        return $stmt->fetchColumn() > 0;
    }

    public function ajouterEmploye($nom, $prenom, $email, $telephone, $role, $salaire_fixe, $tarif_horaire, $mot_de_passe, $matricule) {
        $sql = "INSERT INTO administrateur (nom, prenom, email, telephone, role, salaire_fixe, tarif_horaire, mot_de_passe, matricule)
                VALUES (:nom, :prenom, :email, :telephone, :role, :salaire_fixe, :tarif_horaire, :mot_de_passe, :matricule)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':role' => $role,
            ':salaire_fixe' => $salaire_fixe,
            ':tarif_horaire' => $tarif_horaire,
            ':mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT),
            ':matricule' => $matricule
        ]);
    }

    public function genererMatricule($role) {
        $prefix = strtoupper(substr($role, 0, 3));
        $year = date('Y');
        $randomNumber = sprintf('%04d', rand(0, 9999));
        return $prefix . $year . $randomNumber;
    }

    
    public function getEmployes($roleFilter = '', $archiveFilter = '') {
        $sql = "SELECT nom, prenom, telephone, email, role, matricule 
                FROM administrateur 
                WHERE role IN ('enseignant_primaire', 'enseignant_secondaire')";

        // Ajoutez les conditions de filtre
        if (!empty($roleFilter)) {
            $sql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $sql .= " AND archive = :archive";
        }

        $stmt = $this->pdo->prepare($sql);

        if (!empty($roleFilter)) {
            $stmt->bindParam(':role', $roleFilter);
        }
        if ($archiveFilter !== '') {
            $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
