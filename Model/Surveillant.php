<?php
// Surveillant.php

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/../database.php';

class Surveillant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM administrateur WHERE role = 'surveillant_classe' AND archive = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM administrateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function archive($id) {
        $sql = "UPDATE administrateur SET archive = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function unarchive($id) {
        $sql = "UPDATE administrateur SET archive = 0 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function isArchived($id) {
        $sql = "SELECT archive FROM administrateur WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (bool) $result['archive'] : false;
    }

    public function getArchived() {
        $sql = "SELECT * FROM administrateur WHERE role = 'surveillant_classe' AND archive = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau surveillant
    public function create($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO administrateur (matricule, nom, prenom, email, role) VALUES (:matricule, :nom, :prenom, :email, 'surveillant_classe')");
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
                $stmt = $this->pdo->prepare("UPDATE administrateur SET matricule = :matricule, nom = :nom, prenom = :prenom, email = :email WHERE id = :id");
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
            $stmt = $this->pdo->prepare("DELETE FROM administrateur WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du surveillant : " . $e->getMessage());
        }
    }
    public function validateEmail($email) {
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/';
        if (!preg_match($pattern, $email)) {
            return false;
        }
        return true;
    }
}
?>
