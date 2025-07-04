<?php
class Etudiant {
    private $conn;
    private $table_name = "etudiant";

    public $id, $nom, $post_nom, $prenom, $sexe, $date_naissance, $adresse, $email, $telephone, $photo, $date_enregistrement;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insert() {
        $query = "INSERT INTO " . $this->table_name . "
            (nom, post_nom, prenom, sexe, date_naissance, adresse, email, telephone, photo, date_enregistrement)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $this->nom,
            $this->post_nom,         // ✅ c’est ici l’erreur corrigée
            $this->prenom,
            $this->sexe,
            $this->date_naissance,
            $this->adresse,
            $this->email,
            $this->telephone,
            $this->photo,
            $this->date_enregistrement
        ]);

        return $this->conn->lastInsertId();
    }
    public function mettreAJour() {
    $sql = "UPDATE etudiant SET
        nom = :nom,
        post_nom = :post_nom,
        prenom = :prenom,
        sexe = :sexe,
        date_naissance = :date_naissance,
        adresse = :adresse,
        email = :email,
        telephone = :telephone" .
        ($this->photo ? ", photo = :photo" : "") .
        " WHERE id_etudiant = :id";

    $stmt = $this->conn->prepare($sql);

    $params = [
        ':nom' => $this->nom,
        ':post_nom' => $this->post_nom,
        ':prenom' => $this->prenom,
        ':sexe' => $this->sexe,
        ':date_naissance' => $this->date_naissance,
        ':adresse' => $this->adresse,
        ':email' => $this->email,
        ':telephone' => $this->telephone,
        ':id' => $this->id
    ];

    if ($this->photo) {
        $params[':photo'] = $this->photo;
    }

    return $stmt->execute($params);
}

}
?>
