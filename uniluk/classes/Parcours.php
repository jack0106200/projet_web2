<?php
class Parcours {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT id_parcours AS id, nom_parcours AS nom FROM parcours");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
?>