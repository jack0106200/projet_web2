<?php
class Base {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT id_base AS id, nom_base AS nom FROM base");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}