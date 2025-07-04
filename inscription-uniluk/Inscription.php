<?php
require_once 'classes/Database.php';
require_once 'classes/Etudiant.php';
require_once 'classes/Inscription.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Sécurisation des données reçues
    $nom = htmlspecialchars(trim($_POST['nom']));
    $post_nom = htmlspecialchars(trim($_POST['post_nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $sexe = $_POST['sexe'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));

    $base_id = $_POST['base'];
    $parcours_id = $_POST['parcours'];
    $niveau_id = $_POST['niveau'];
    $annee_id = $_POST['annee'];

    $date_enregistrement = date("Y-m-d H:i:s");

    // Gestion de la photo
    $photo_nom = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_nom = uniqid("photo_", true) . '.' . $ext;
        $upload_dir = "Document_images/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        move_uploaded_file($photo_tmp, $upload_dir . $photo_nom);
    }

    // Insertion de l'étudiant
    $etudiant = new Etudiant($db);
    $etudiant->nom = $nom;
    $etudiant->post_nom = $post_nom;
    $etudiant->prenom = $prenom;
    $etudiant->sexe = $sexe;
    $etudiant->date_naissance = $date_naissance;
    $etudiant->adresse = $adresse;
    $etudiant->email = $email;
    $etudiant->telephone = $telephone;
    $etudiant->photo = $photo_nom;
    $etudiant->date_enregistrement = $date_enregistrement;

    $etudiant_id = $etudiant->insert();

    if ($etudiant_id) {
        // Insertion de l'inscription
        $inscription = new Inscription($db);
        $result = $inscription->insert($etudiant_id, $base_id, $parcours_id, $niveau_id, $annee_id);

        if ($result) {
            echo "<script>alert('✅ Inscription réussie !'); window.location.href = 'inscription.html';</script>";
        } else {
            echo "❌ Erreur lors de l'inscription.";
        }

    } else {
        echo "❌ Erreur lors de l'enregistrement de l'étudiant.";
    }

} else {
    echo "❌ Requête invalide.";
}
?>