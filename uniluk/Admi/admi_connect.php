<?php
session_start();
require_once '../classes/Database.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nom_utilisateur'] ?? '';
    $password = $_POST['mot_de_passe'] ?? '';

    $db = (new Database())->getConnection();
    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE nom_utilisateur = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['mot_de_passe']) { // ⚠️ à sécuriser avec password_hash plus tard
        if (strtolower($user['role']) === 'admin') {
            $_SESSION['utilisateur'] = [
                'id' => $user['id_utilisateur'],
                'nom' => $user['nom_utilisateur'],
                'role' => $user['role']
            ];
            header("Location: liste_status.php"); // ✅ Redirection
            exit;
        } else {
            $erreur = "⛔ Accès refusé. Vous n’êtes pas administrateur.";
        }
    } else {
        $erreur = "❌ Nom d’utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Admin</title>
  <link rel="stylesheet" href="admin.css"> 
</head>
<body>
  <div class="container">
    <h2>Administrateur</h2>

    <?php if (!empty($erreur)) : ?>
      <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>Nom d'utilisateur :</label>
      <input type="text" name="nom_utilisateur" required>

      <label>Mot de passe :</label>
      <input type="password" name="mot_de_passe" required>

      <button type="submit">Se connecter</button>
    </form>
  </div>
</body>
</html>
