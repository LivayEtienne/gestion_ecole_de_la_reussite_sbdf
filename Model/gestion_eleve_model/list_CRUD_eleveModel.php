<?php
// model/EleveModel.php

include_once '/opt/lampp/htdocs/gestion_ecole_sabadifa/database.php';

class EleveModel {
    private $db;

    public function __construct() {
        $this->db = new myDatabase(); // Crée une instance de myDatabase
    }

    // Méthode pour récupérer tous les élèves
    public function getAllEleves() {
        try {
            $query = "SELECT id, nom, prenom, date_naissance, id_classe, moyenne_generale, tuteur_email, archive FROM eleve WHERE archive = 0";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des élèves : " . $e->getMessage();
            return [];
        }
    }

    // Méthode pour récupérer les élèves archivés
    public function getArchivedEleves() {
        $sql = "SELECT * FROM eleve WHERE archive = 1"; // 1 pour les élèves archivés
        $stmt = $this->db->getConnection()->prepare($sql); // Utiliser la connexion de $db
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function archiverEleve($id) {
        try {
            $query = "UPDATE eleve SET archive = 1 WHERE id = :id"; // 1 pour archiver l'élève
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute(); // Retourne true si la mise à jour a réussi
        } catch (PDOException $e) {
            echo "Erreur lors de l'archivage de l'élève : " . $e->getMessage();
            return false;
        }
    }

    public function desarchiverEleve($id) {
        try {
            $query = "UPDATE eleve SET archive = 0 WHERE id = :id"; // 0 pour désarchiver l'élève
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute(); // Retourne true si la mise à jour a réussi
        } catch (PDOException $e) {
            echo "Erreur lors du désarchivage de l'élève : " . $e->getMessage();
            return false;
        }
    }
    
}
?>