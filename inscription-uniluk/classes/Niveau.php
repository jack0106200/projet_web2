<?php
class Niveau {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT id_niveau AS id, nom_niveau AS nom FROM niveau");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
