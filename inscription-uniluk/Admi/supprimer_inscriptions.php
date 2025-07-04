<?php
require_once 'includes/auth_check.php';
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_inscription'])) {
    header("Location: liste_status.php");
    exit;
}

$id = $_POST['id_inscription'];

$db = (new Database())->getConnection();

// Suppression de l’inscription
$stmt = $db->prepare("DELETE FROM inscription WHERE id_inscription = ?");
if ($stmt->execute([$id])) {
    // (Optionnel) : message flash de confirmation
    header("Location: liste_status.php?message=suppression_ok");
} else {
    header("Location: liste_status.php?message=erreur_suppression");
}
exit;
