<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste par statut</title>
    <link rel="stylesheet" href="admi.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="liste.css">
</head>
<body>
    <header class="navbar">
        <nav>
            <ul>
                <li><a href="interface.php" class="active">Accueil</a></li>
                <li><a href="https://www.google.com/search?q=uniluk">Institution</a></li>
                <li><a href="service.php">Service</a></li>
            </ul>
        </nav>
    </header>

    <h2>Étudiants - Statut : <?= strtoupper(htmlspecialchars($statut)) ?></h2>

    <form method="GET">
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
                    <form method="POST" action="liste_status.php">
                        <input type="hidden" name="id_inscription" value="<?= $etu['id_inscription'] ?>">
                        <select name="statut">
                            <option value="en attente" <?= $etu['statut'] === 'en attente' ? 'selected' : '' ?>>En attente</option>
                            <option value="admis" <?= $etu['statut'] === 'admis' ? 'selected' : '' ?>>Admis</option>
                            <option value="répété" <?= $etu['statut'] === 'répété' ? 'selected' : '' ?>>Répété</option>
                        </select>
                        <button type="submit" class="btn-blue">Valider</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="bottom-actions">
        <form method="GET" action="rechercher.php">
            <input type="text" name="search" placeholder="Rechercher un étudiant..." required>
            <button type="submit" class="btn-blue">Rechercher</button>
        </form>

        <form method="POST" action="supprimer_etudiant.php" onsubmit="return confirm('Voulez-vous vraiment supprimer ?');">
            <input type="text" name="id_inscription" placeholder="Entrer ID à supprimer" required>
            <button type="submit" class="btn-danger">Supprimer par ID</button>
        </form>
    </div>

    <?php if (isset($_GET['message'])): ?>
        <p style="color: <?= $_GET['message'] === 'suppression_ok' ? 'green' : 'red' ?>;">
            <?= $_GET['message'] === 'suppression_ok' ? 'Étudiant supprimé avec succès.' : 'Erreur lors de la suppression.' ?>
        </p>
    <?php endif; ?>
</body>
</html>
