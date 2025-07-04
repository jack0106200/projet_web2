<?php
// auth_check.php : fichier à inclure pour sécuriser l'accès à une page admin
session_start();

// Délai d'expiration (ex : 30 minutes)
$session_timeout = 1800; // 1800 secondes = 30 minutes

// Vérifie la session
if (!isset($_SESSION['admin'])) {
    header("Location: admi_connect.php?error=unauthorized");
    exit;
}

// Expiration automatique de session
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    session_unset();     // vide toutes les variables de session
    session_destroy();   // détruit la session
    header("Location: admi_connect.php?error=timeout");
    exit;
}

// Mise à jour du timestamp de la dernière activité
$_SESSION['LAST_ACTIVITY'] = time();
