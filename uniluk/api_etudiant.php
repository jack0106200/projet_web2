<?php
header('Content-Type: application/json');
$pdo = new PDO("mysql:host=localhost;dbname=uniluk;charset=utf8", "root", "");

if (!isset($_GET['id_inscription'])) {
  echo json_encode(null);
  exit;
}

$id = $_GET['id_inscription'];
$stmt = $pdo->prepare("SELECT id_inscription, nom, post_nom, prenom, sexe, date_naissance, adresse, email, telephone, photo FROM vue_inscription_etudiant WHERE id_inscription = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($etudiant);
?>