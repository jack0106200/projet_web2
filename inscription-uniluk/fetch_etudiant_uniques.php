<?php
require_once 'Etudiant.php'; // Inclut la classe Database

header('Content-Type: application/json');

if (!isset($_GET['id_etudiant']) || empty($_GET['id_etudiant'])) {
    echo json_encode(['error' => 'ID étudiant manquant.']);
    exit;
}

$id_etudiant = intval($_GET['id_etudiant']);

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("
        SELECT *
        FROM vue_inscriptions_etudiant
        WHERE id_etudiant = ?
        ORDER BY date_inscription DESC
        LIMIT 1
    ");
    $stmt->execute([$id_etudiant]);

    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($etudiant) {
        echo json_encode($etudiant);
    } else {
        echo json_encode(['error' => 'Aucun étudiant trouvé.']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion ou de requête : ' . $e->getMessage()]);
}
