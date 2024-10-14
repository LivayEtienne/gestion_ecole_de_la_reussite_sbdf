<?php
require_once __DIR__ . '/../database.php'; // Assurez-vous que le chemin est correct
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

     // Méthode pour récupérer la liste des administrateurs avec filtres et pagination
    
     public function getComptables($archiveFilter, $searchTerm, $offset, $entriesPerPage) {
        // Construction de la requête SQL
        $sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('comptable')";

        // Ajoutez les conditions de filtre
        if ($archiveFilter !== '') {
            $sql .= " AND archive = :archive";
        }
        if (!empty($searchTerm)) {
            $sql .= " AND (nom LIKE :search OR prenom LIKE :search)";
        }

        // Ajout de la pagination à la requête
        $sql .= " LIMIT :offset, :entriesPerPage";

        $stmt = $this->pdo->prepare($sql);
        
        if ($archiveFilter !== '') {
            $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }
        if (!empty($searchTerm)) {
            $searchLike = '%' . $searchTerm . '%';
            $stmt->bindParam(':search', $searchLike);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countComptables($archiveFilter, $searchTerm) {
        // Construction de la requête de comptage
        $countSql = "SELECT COUNT(*) FROM administrateur WHERE role IN ('comptable')";
        
        if ($archiveFilter !== '') {
            $countSql .= " AND archive = :archive";
        }
        if (!empty($searchTerm)) {
            $countSql .= " AND (nom LIKE :search OR prenom LIKE :search)";
        }

        $countStmt = $this->pdo->prepare($countSql);
        
        if ($archiveFilter !== '') {
            $countStmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }
        if (!empty($searchTerm)) {
            $searchLike = '%' . $searchTerm . '%';
            $countStmt->bindParam(':search', $searchLike);
        }
        $countStmt->execute();
        
        return $countStmt->fetchColumn();
    }

    public function getEnseignants($roleFilter,$archiveFilter, $searchTerm, $offset, $entriesPerPage){
        // Construction de la requête SQL
        $sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('enseignant_primaire', 'enseignant_secondaire')";

        // Ajoutez les conditions de filtre
        if (!empty($roleFilter)) {
            $sql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $sql .= " AND archive = :archive";
        }
        if (!empty($searchTerm)) {
            $sql .= " AND (nom LIKE :search OR prenom LIKE :search)"; // Recherche par nom ou prénom
        }

        // Ajout de la pagination à la requête principale
        $sql .= " LIMIT :offset, :entriesPerPage";

        $stmt = $this->pdo->prepare($sql);
        if (!empty($roleFilter)) {
            $stmt->bindParam(':role', $roleFilter);
        }
        if ($archiveFilter !== '') {
            $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }
        if (!empty($searchTerm)) {
            $searchLike = '%' . $searchTerm . '%';
            $stmt->bindParam(':search', $searchLike);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);

        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countEnseignants($archiveFilter, $searchTerm, $roleFilter){
        // Récupération du nombre total d'entrées
        $countSql = "SELECT COUNT(*) FROM administrateur WHERE role IN ('enseignant_primaire', 'enseignant_secondaire')";
        if (!empty($roleFilter)) {
            $countSql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $countSql .= " AND archive = :archive";
        }
        if (!empty($searchTerm)) {
            $countSql .= " AND (nom LIKE :search OR prenom LIKE :search)";
        }

        $countStmt = $this->pdo->prepare($countSql);

        if (!empty($roleFilter)) {
            $countStmt->bindParam(':role', $roleFilter);
        }
        if ($archiveFilter !== '') {
            $countStmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }
        if (!empty($searchTerm)) {
            $searchLike = '%' . $searchTerm . '%';
            $countStmt->bindParam(':search', $searchLike);
        }
        $countStmt->execute();

        return $countStmt->fetchColumn();
    }


    public function getSurveillants($roleFilter,$archiveFilter, $searchTerm, $offset, $entriesPerPage){
        // Construction de la requête SQL
        $sql = "SELECT nom, prenom, telephone, email, role, matricule FROM administrateur WHERE role IN ('surveillant_classe', 'surveillant_general')";

        // Ajoutez les conditions de filtre
        if (!empty($roleFilter)) {
            $sql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $sql .= " AND archive = :archive";
        }
        if (!empty($searchTerm)) {
            $sql .= " AND (nom LIKE :search OR prenom LIKE :search)"; // Recherche par nom ou prénom
        }

        // Ajout de la pagination à la requête principale
        $sql .= " LIMIT :offset, :entriesPerPage";

        $stmt = $this->pdo->prepare($sql);
        if (!empty($roleFilter)) {
            $stmt->bindParam(':role', $roleFilter);
        }
        if ($archiveFilter !== '') {
            $stmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }
        if (!empty($searchTerm)) {
            $searchLike = '%' . $searchTerm . '%';
            $stmt->bindParam(':search', $searchLike);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);

        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSurveillants($archiveFilter, $searchTerm, $roleFilter){
        // Récupération du nombre total d'entrées
        $countSql = "SELECT COUNT(*) FROM administrateur WHERE role IN ('surveillant_classe', 'surveillant_general')";
        if (!empty($roleFilter)) {
            $countSql .= " AND role = :role";
        }
        if ($archiveFilter !== '') {
            $countSql .= " AND archive = :archive";
        }
        if (!empty($searchTerm)) {
            $countSql .= " AND (nom LIKE :search OR prenom LIKE :search)";
        }

        $countStmt = $this->pdo->prepare($countSql);

        if (!empty($roleFilter)) {
            $countStmt->bindParam(':role', $roleFilter);
        }
        if ($archiveFilter !== '') {
            $countStmt->bindParam(':archive', $archiveFilter, PDO::PARAM_BOOL);
        }
        if (!empty($searchTerm)) {
            $searchLike = '%' . $searchTerm . '%';
            $countStmt->bindParam(':search', $searchLike);
        }
        $countStmt->execute();

        return $countStmt->fetchColumn();
    }

    
    
}
