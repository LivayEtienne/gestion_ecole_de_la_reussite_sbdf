<?php
class myDatabase {
    private $host = 'localhost';
    private $db_name = 'note_base';
    private $user = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

?>
