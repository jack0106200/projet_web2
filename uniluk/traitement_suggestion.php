<?php
class SuggestionHandler {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function enregistrer($nom, $email, $sujet, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO suggestions (nom, email, sujet, message, date_soumission) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([
            htmlspecialchars($nom),
            htmlspecialchars($email),
            htmlspecialchars($sujet),
            htmlspecialchars($message)
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['sujet']) && !empty($_POST['message'])) {
        $handler = new SuggestionHandler('localhost', 'incription_uniluk', 'root', '');

        if ($handler->enregistrer($_POST['nom'], $_POST['email'], $_POST['sujet'], $_POST['message'])) {
            header("Location: comentaire.php?success=1");
            exit;
        } else {
            header("Location: comentaire.php?error=1");
            exit;
        }
    } else {
        header("Location: comentaire.php?error=1");
        exit;
    }
} else {
    header("Location: comentaire.php");
    exit;
}
?>