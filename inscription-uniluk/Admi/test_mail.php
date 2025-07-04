<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'votre.email@gmail.com';
    $mail->Password = 'votre_mot_de_passe';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('jackmugisa83@gmail.com', 'Test UNILUK');
    $mail->addAddress('jackmugisa83@gmail.com'); // même email pour test
    $mail->isHTML(true);
    $mail->Subject = 'Test de mail';
    $mail->Body    = 'Ceci est un test de mail depuis votre application UNILUK.';
    $mail->send();
    echo 'Message envoyé !';
} catch (Exception $e) {
    echo 'Erreur : ', $mail->ErrorInfo;
}
?>