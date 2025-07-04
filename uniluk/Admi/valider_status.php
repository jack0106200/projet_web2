<?php
session_start(); // 🔴 INDISPENSABLE avant toute session

//require_once 'includes/auth_check.php';
require_once '../classes/Database.php';

// Inclusion PHPMailer
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifie que c'est bien un formulaire envoyé par POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: liste_status.php");
    exit;
}

// Vérifie si les champs sont présents
if (!isset($_POST['id_inscription'], $_POST['statut'])) {
    echo "⚠️ ID de l'étudiant ou statut non fourni.";
    exit;
}

$id = $_POST['id_inscription'];
$newStatut = $_POST['statut'];

$db = (new Database())->getConnection();

// Met à jour le statut
$update = $db->prepare("UPDATE inscription SET statut = ? WHERE id_inscription = ?");
if ($update->execute([$newStatut, $id])) {

    // Récupérer l’email de l’étudiant pour envoi
    $stmtMail = $db->prepare("
        SELECT e.email, e.nom, e.post_nom, e.prenom
        FROM inscription i
        JOIN etudiant e ON i.id_etudiant = e.id_etudiant
        WHERE i.id_inscription = ?
    ");
    $stmtMail->execute([$id]);
    $etudiant = $stmtMail->fetch(PDO::FETCH_ASSOC);

    if ($etudiant && !empty($etudiant['email'])) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ton.email@gmail.com';
            $mail->Password = 'ton_mot_de_passe';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('ton.email@gmail.com', 'Administration UNILUK');
            $mail->addAddress($etudiant['email'], $etudiant['nom']);
            $mail->isHTML(true);
            $mail->Subject = 'Notification de mise à jour de statut';
            $nomComplet = htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['post_nom'] . ' ' . $etudiant['prenom']);
            $mail->Body = "
                Bonjour <strong>{$nomComplet}</strong>,<br><br>
                Votre statut académique a été mis à jour à : <strong style='color: green;'>{$newStatut}</strong>.<br><br>
                Cordialement,<br>Administration UNILUK
            ";
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi email : " . $mail->ErrorInfo);
        }
    }

    // ✅ Redirection selon le nouveau statut (ex. admis → liste_status.php?statut=admis)
    header("Location: liste_status.php?statut=" . urlencode($newStatut));
    exit;
} else {
    echo "❌ Échec de mise à jour du statut.";
    exit;
}
session_start();
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
exit;