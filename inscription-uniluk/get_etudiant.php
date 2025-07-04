<?php
require_once 'classes/Database.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID manquant']);
    exit;
}

$id = intval($_GET['id']);
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT * FROM vue_inscription_etudiant WHERE id_inscription = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($etudiant) {
    echo json_encode($etudiant);
} else {
    echo json_encode(['error' => 'Aucun étudiant trouvé']);
}
