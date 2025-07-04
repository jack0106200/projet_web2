<?php
require_once '../classes/Database.php';

// Inclusion de PHPMailer
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = (new Database())->getConnection();

$statut = $_GET['statut'] ?? 'en attente';

$stmt = $db->prepare("
    SELECT i.id_inscription, e.nom, e.post_nom, e.prenom, e.email,
           b.nom_base, p.nom_parcours, n.nom_niveau,
           a.annee, i.statut
    FROM inscription i
    JOIN etudiant e ON i.id_etudiant = e.id_etudiant
    JOIN base b ON i.id_base = b.id_base
    JOIN parcours p ON i.id_parcours = p.id_parcours
    JOIN niveau n ON i.id_niveau = n.id_niveau
    JOIN annee_academique a ON i.id_annee = a.id_annee
    WHERE i.statut = ?
    ORDER BY i.date_inscription DESC
");
$stmt->execute([$statut]);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_inscription'], $_POST['statut'])) {
    $id = $_POST['id_inscription'];
    $newStatut = $_POST['statut'];

    // Mettre à jour le statut
    $update = $db->prepare("UPDATE inscription SET statut = ? WHERE id_inscription = ?");
    if ($update->execute([$newStatut, $id])) {
        // Récupérer l'email de l'étudiant concerné
        $stmtMail = $db->prepare("SELECT e.email, e.nom FROM inscription i JOIN etudiant e ON i.id_etudiant = e.id_etudiant WHERE i.id_inscription = ?");
        $stmtMail->execute([$id]);
        $etudiant = $stmtMail->fetch(PDO::FETCH_ASSOC);

        if ($etudiant && !empty($etudiant['email'])) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'votre.email@gmail.com'; // Remplacez par votre email
                $mail->Password = 'votre_mot_de_passe';    // Remplacez par votre mot de passe
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('votre.email@gmail.com', 'Administration UNILUK');
                $mail->addAddress($etudiant['email'], $etudiant['nom']);
                $mail->isHTML(true);
                $mail->Subject = 'Mise à jour de votre statut académique';
                $mail->Body = "Bonjour <strong>{$etudiant['nom']}</strong>,<br><br>Votre statut a été mis à jour : <strong>{$newStatut}</strong>.<br><br>Cordialement, <br>UNILUK";
                $mail->send();
            } catch (Exception $e) {
                // Vous pouvez logger ou afficher l'erreur ici si nécessaire
            }
        }
    }
    header("Location: liste_statut.php?statut=" . urlencode($newStatut));
    exit;
}
?>
<!DOCTYPE html><html>
<head>
    <meta charset="UTF-8">
    <title>Liste par statut</title>
    <link rel="stylesheet" href="admi.css">
    <link rel="stylesheet" href="nav.css">
    
    <style>
        .bottom-actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .bottom-actions button {
            padding: 8px 16px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .bottom-actions input[type="text"] {
            padding: 7px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<!-- Barre de navigation horizontale -->
<!-- Barre de navigation horizontale alignée à droite -->
<header style="background-color: #2c3e50; padding: 10px 20px;">
    <nav style="display: flex; justify-content: flex-end;">
        <ul style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0;">
            <li><a href="../interface.php" class="active" style="color: white; text-decoration: none; font-weight: bold;">Accueil</a></li>
            <li><a href="https://www.google.com/search?q=uniluk" style="color: white; text-decoration: none; font-weight: bold;">Institution</a></li>
            <li><a href="service.php" style="color: white; text-decoration: none; font-weight: bold;">Service</a></li>
        </ul>
    </nav>
</header>

<body>
<h2>Étudiants - Statut : <?= strtoupper(htmlspecialchars($statut)) ?></h2>
<form method="GET" style="margin-bottom: 15px;">
    <label>Filtrer par statut :</label>
    <select name="statut" onchange="this.form.submit()">
        <option value="en attente" <?= $statut === 'en attente' ? 'selected' : '' ?>>En attente</option>
        <option value="admis" <?= $statut === 'admis' ? 'selected' : '' ?>>Admis</option>
        <option value="répété" <?= $statut === 'répété' ? 'selected' : '' ?>>Répété</option>
    </select>
</form>

<table class="styled-table">
    <thead>
        <tr>
            <th>Nom complet</th>
            <th>Institution</th>
            <th>Parcours</th>
            <th>Niveau</th>
            <th>Année</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>
   <tbody>
<?php foreach ($etudiants as $etu): ?>
    <tr>
        <td><?= htmlspecialchars($etu['nom']) . ' ' . $etu['post_nom'] . ' ' . $etu['prenom'] ?></td>
        <td><?= htmlspecialchars($etu['nom_base']) ?></td>
        <td><?= htmlspecialchars($etu['nom_parcours']) ?></td>
        <td><?= htmlspecialchars($etu['nom_niveau']) ?></td>
        <td><?= htmlspecialchars($etu['annee']) ?></td>
        <td><strong><?= strtoupper($etu['statut']) ?></strong></td>
        <td>
            <form method="POST" action="valider_status.php">
    <input type="hidden" name="id_inscription" value="<?= $etu['id_inscription'] ?>">
    <select name="statut">
        <option value="en attente" <?= $etu['statut'] === 'en attente' ? 'selected' : '' ?>>En attente</option>
        <option value="admis" <?= $etu['statut'] === 'admis' ? 'selected' : '' ?>>Admis</option>
        <option value="répété" <?= $etu['statut'] === 'répété' ? 'selected' : '' ?>>Répété</option>
    </select>
    <button type="submit" style="background-color: blue;">Valider</button>
</form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="bottom-actions" style="margin-top: 30px; display: flex; gap: 20px; align-items: center;">
    <!-- Formulaire de recherche -->
    <form method="GET" action="rechercher.php" style="display: flex; align-items: center; gap: 10px;">
        <input type="text" name="search" placeholder="Rechercher un étudiant..." require style="padding: 7px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 8px 16px; background-color: blue; color: white; border: none; border-radius: 5px;">Rechercher</button>
    </form>

    <!-- Formulaire de suppression par ID -->
    <form method="POST" action="supprimer_etudiant.php" onsubmit="return confirm('Voulez-vous vraiment supprimer l’inscription avec cet ID ?');" style="display: flex; align-items: center; gap: 10px;">
        <input type="text" name="id_inscription" placeholder="Entrer ID à supprimer" required style="padding: 7px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 8px 16px; background-color: darkred; color: white; border: none; border-radius: 5px;">Supprimer par ID</button>
    </form>
</div>
</body>
<?php if (isset($_GET['message'])): ?>
    <p style="color: <?= $_GET['message'] === 'suppression_ok' ? 'green' : 'red' ?>;">
        <?= $_GET['message'] === 'suppression_ok' ? 'Étudiant supprimé avec succès.' : 'Erreur lors de la suppression.' ?>
    </p>
<?php endif; ?>
</html>