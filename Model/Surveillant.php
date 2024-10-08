<?php
require_once __DIR__ . '/../database.php'; // Chemin correct pour inclure database.php
// Utilise __DIR__ pour s'assurer que le chemin est correct

class Surveillant {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection(); // Utilisez getConnection() ici
    }

    // Récupérer tous les surveillants
    public function getAll() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM administrateur WHERE role = :role");
            $role = 'surveillant_classe'; // Définit le rôle à rechercher
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des surveillants : " . $e->getMessage());
        }
    }

    // Récupérer un surveillant par ID
    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM administrateur WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Retourne null si aucun résultat
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du surveillant : " . $e->getMessage());
        }
    }

    // Ajouter un surveillant
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO administrateur (matricule, nom, prenom, email) VALUES (:matricule, :nom, :prenom, :email)");
            $stmt->bindParam(':matricule', $data['matricule']);
            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':prenom', $data['prenom']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du surveillant : " . $e->getMessage());
        }
    }

    // Modifier un surveillant
    public function update($id, $data) {
        if (is_array($data)) {
            try {
                $stmt = $this->conn->prepare("UPDATE administrateur SET matricule = :matricule, nom = :nom, prenom = :prenom, email = :email WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':matricule', $data['matricule']);
                $stmt->bindParam(':nom', $data['nom']);
                $stmt->bindParam(':prenom', $data['prenom']);
                $stmt->bindParam(':email', $data['email']);
                $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la mise à jour du surveillant : " . $e->getMessage());
            }
        } else {
            throw new InvalidArgumentException("Les données de mise à jour doivent être un tableau.");
        }
    }

    // Supprimer un surveillant
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM administrateur WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du surveillant : " . $e->getMessage());
        }
    }
}
?>
