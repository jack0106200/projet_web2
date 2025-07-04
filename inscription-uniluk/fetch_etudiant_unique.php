<?php
require_once 'classes/Database.php'; // Adapter selon le nom de ta classe de connexion

header('Content-Type: application/json');

// Activer les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['id_etudiant'])) {
    echo json_encode(['error' => 'ID étudiant non fourni']);
    exit;
}

$id_etudiant = $_GET['id_etudiant'];

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $sql = "
        SELECT 
            e.id_etudiant,
            i.id_inscription,
            e.nom,
            e.post_nom,
            e.prenom,
            e.date_naissance,
            e.sexe,
            e.adresse,
            e.email,
            e.telephone,
            b.nom_base,
            p.nom_parcours,
            n.nom_niveau,
            a.annee
        FROM etudiant e
        JOIN inscription i ON e.id_etudiant = i.id_etudiant
        JOIN base b ON i.id_base = b.id_base
        JOIN parcours p ON i.id_parcours = p.id_parcours
        JOIN niveau n ON i.id_niveau = n.id_niveau
        JOIN annee_academique a ON i.id_annee = a.id_annee
        WHERE e.id_etudiant = ?
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_etudiant]);

    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($etudiant) {
        echo json_encode($etudiant);
    } else {
        echo json_encode(['error' => 'Étudiant non trouvé']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
}
