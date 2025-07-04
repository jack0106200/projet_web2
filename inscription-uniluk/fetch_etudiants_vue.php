<?php
require_once 'classes/Database.php'; // ← Change ce nom si ta classe s'appelle autrement

header('Content-Type: application/json');

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->query("
        SELECT id_etudiant,nom, post_nom, prenom
        FROM etudiant
        ORDER BY nom ASC
    ");

    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($etudiants);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
}
