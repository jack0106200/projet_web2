<!DOCTYPE html><html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des inscriptions - Admin</title>
    <link rel="stylesheet" href="admi.css">
</head>
<body>
    <h2>Liste des Inscriptions</h2><!-- Formulaire de filtre par statut -->
<form method="GET" action="liste_status.php">
    <label for="statut">Filtrer par statut :</label>
    <select name="statut" id="statut" onchange="this.form.submit()">
        <option value="en attente">En attente</option>
        <option value="admis">Admis</option>
        <option value="répété">Répété</option>
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
    <tbody id="etudiant-body">
        <?php foreach (\$etudiants as \$etu): ?>
        <tr>
            <td><?= htmlspecialchars(\$etu['nom']) . ' ' . \$etu['post_nom'] . ' ' . \$etu['prenom'] ?></td>
            <td><?= \$etu['nom_base'] ?></td>
            <td><?= \$etu['nom_parcours'] ?></td>
            <td><?= \$etu['nom_niveau'] ?></td>
            <td><?= \$etu['annee'] ?></td>
            <td><strong><?= strtoupper(\$etu['statut']) ?></strong></td>
            <td>
                <form method="POST" action="valider_statut.php">
                    <input type="hidden" name="id_inscription" value="<?= \$etu['id_inscription'] ?>">
                    <select name="statut">
                        <option value="en attente" <?= \$etu['statut'] === 'en attente' ? 'selected' : '' ?>>En attente</option>
                        <option value="admis" <?= \$etu['statut'] === 'admis' ? 'selected' : '' ?>>Admis</option>
                        <option value="répété" <?= \$etu['statut'] === 'répété' ? 'selected' : '' ?>>Répété</option>
                    </select>
                    <button type="submit">Valider</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>