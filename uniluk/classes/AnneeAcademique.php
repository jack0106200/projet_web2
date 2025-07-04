<?php
class AnneeAcademique {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT id_annee AS id, annee FROM annee_academique");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
