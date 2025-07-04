<?php
require_once 'classes/Database.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérifie que la méthode est POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Méthode non autorisée.']);
    exit;
}

// Vérifie que les IDs sont fournis
if (empty($_POST['id_etudiant']) || empty($_POST['id_inscription'])) {
    echo json_encode(['error' => 'ID manquant pour la mise à jour.']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Données du formulaire
    $id_etudiant    = $_POST['id_etudiant'];
    $id_inscription = $_POST['id_inscription'];
    $nom            = $_POST['nom'] ?? '';
    $post_nom       = $_POST['post_nom'] ?? '';
    $prenom         = $_POST['prenom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $sexe           = $_POST['sexe'] ?? '';
    $adresse        = $_POST['adresse'] ?? '';
    $email          = $_POST['email'] ?? '';
    $telephone      = $_POST['telephone'] ?? '';
    $nom_base       = $_POST['nom_base'] ?? '';
    $nom_parcours   = $_POST['nom_parcours'] ?? '';
    $nom_niveau     = $_POST['nom_niveau'] ?? '';
    $annee          = $_POST['annee'] ?? '';

    // ✅ Fonction pour récupérer l'ID à partir du nom
    function getIdFromTable($pdo, $table, $col, $value) {
        $id_column = ($table === 'annee_academique') ? 'id_annee' : "id_$table";
        $stmt = $pdo->prepare("SELECT $id_column FROM $table WHERE $col = ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetchColumn();
    }

    // 🔍 Conversion des noms en IDs
    $id_base     = getIdFromTable($pdo, 'base', 'nom_base', $nom_base);
    $id_parcours = getIdFromTable($pdo, 'parcours', 'nom_parcours', $nom_parcours);
    $id_niveau   = getIdFromTable($pdo, 'niveau', 'nom_niveau', $nom_niveau);
    $id_annee    = getIdFromTable($pdo, 'annee_academique', 'annee', $annee);

    // ✅ Mise à jour de la table `etudiant`
    $stmt = $pdo->prepare("
        UPDATE etudiant SET
            nom = ?, post_nom = ?, prenom = ?, date_naissance = ?, sexe = ?,
            adresse = ?, email = ?, telephone = ?
        WHERE id_etudiant = ?
    ");
    $stmt->execute([$nom, $post_nom, $prenom, $date_naissance, $sexe, $adresse, $email, $telephone, $id_etudiant]);

    // 📷 Traitement de la photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoData = file_get_contents($_FILES['photo']['tmp_name']);
        $stmtPhoto = $pdo->prepare("UPDATE etudiant SET photo = ? WHERE id_etudiant = ?");
        $stmtPhoto->execute([$photoData, $id_etudiant]);
    }

    // ✅ Mise à jour de la table `inscription`
    $stmt2 = $pdo->prepare("
        UPDATE inscription SET
            id_base = ?, id_parcours = ?, id_niveau = ?, id_annee = ?
        WHERE id_inscription = ?
    ");
    $stmt2->execute([$id_base, $id_parcours, $id_niveau, $id_annee, $id_inscription]);

    echo json_encode(['success' => '✅ Mise à jour réussie !']);
exit;
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur SQL : ' . $e->getMessage()]);
}