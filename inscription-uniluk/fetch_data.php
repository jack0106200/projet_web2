<?php
require_once 'classes/Database.php';
require_once 'classes/Base.php';
require_once 'classes/Parcours.php';
require_once 'classes/Niveau.php';
require_once 'classes/AnneeAcademique.php';

header('Content-Type: application/json');

if (!isset($_GET['action'])) {
    echo json_encode(['error' => 'Paramètre action manquant']);
    exit;
}

$database = new Database();
$db = $database->getConnection();

$action = $_GET['action'];

switch ($action) {

    case 'bases':
    $base = new Base($db);
    $bases = $base->getAll();
    echo json_encode($bases);
    break;

    case 'parcours':
    if (isset($_GET['id_niveau'])) {
        $parcours = new Parcours($db);
        $listeParcours = $parcours->getByNiveau($_GET['id_niveau']);
        echo json_encode($listeParcours);
    } else {
        $parcours = new Parcours($db);
        $listeParcours = $parcours->getAll();
        echo json_encode($listeParcours);
    }
    break;


   case 'niveaux':
    $niveau = new Niveau($db);
    $listeNiveaux = $niveau->getAll();
    echo json_encode($listeNiveaux);
    break;


   case 'annees':
    $annee = new AnneeAcademique($db);
    $listeAnnees = $annee->getAll();
    echo json_encode($listeAnnees);
    break;
   }
