<?php
require_once '../classes/Database.php';
$db = (new Database())->getConnection();

$search = $_GET['search'] ?? '';

$stmt = $db->prepare("
    SELECT i.id_inscription, e.nom, e.post_nom, e.prenom,
           b.nom_base, p.nom_parcours, n.nom_niveau,
           a.annee, i.statut
    FROM inscription i
    JOIN etudiant e ON i.id_etudiant = e.id_etudiant
    JOIN base b ON i.id_base = b.id_base
    JOIN parcours p ON i.id_parcours = p.id_parcours
    JOIN niveau n ON i.id_niveau = n.id_niveau
    JOIN annee_academique a ON i.id_annee = a.id_annee
    WHERE e.nom LIKE ? OR e.post_nom LIKE ? OR e.prenom LIKE ? 
         ORDER BY e.nom ASC, e.post_nom ASC, e.prenom ASC
");
$term = "%$search%";
$stmt->execute([$term, $term, $term]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Résultat pour : <?= htmlspecialchars($search) ?></h2>

<ul>
    <?php foreach ($results as $etu): ?>
        <li>
            <?= $etu['nom'] . ' ' . $etu['post_nom'] . ' ' . $etu['prenom'] ?>
            (<?= $etu['statut'] ?> - <?= $etu['nom_parcours'] ?>)
        </li>
    <?php endforeach; ?>
</ul>
