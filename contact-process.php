<?php

// On utilise les classes de PHP Mailer (on les importe en quelque sorte)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Autoload permet de charger les classes ci-dessus
require 'vendor/autoload.php';

// On crée une instance de PHPMailer 
$mail = new PHPMailer(true);

try {
    // Configuration serveur SMTP               
    $mail->isSMTP();                                            // ON précise ici qu'on va utiliser le protocole SMTP = Simlpe Mail Transfer Protocol
    $mail->Host       = 'smtp.gmail.com';                       // On précise l'hote ici gmail
    $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPAuth   = true;                                   // Authentification pour le SMTP
    $mail->Username   = 'user@example.com';                     // Email de destination (à ne pas mettre en clair)
    $mail->Password   = 'secret';                               // MDP d'application gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Chiffrement TLS activé

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    echo 'Message has been sent';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}