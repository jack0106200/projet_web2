<?php
class Inscription {
    private $conn;
    private $table_name = "inscription";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insert($etudiant_id, $base_id, $parcours_id, $niveau_id, $annee_id) {
        $query = "INSERT INTO " . $this->table_name . "
            (id_etudiant, id_base, id_parcours, id_niveau, id_annee, date_inscription)
            VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$etudiant_id, $base_id, $parcours_id, $niveau_id, $annee_id]);
    }
}
?>
