<?php

// On utilise les classes de PHP Mailer (on les importe en quelque sorte)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Autoload permet de charger les classes ci-dessus
require 'vendor/autoload.php';
include "dotenv.php";

// Si on a bien, soumis des données en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["message"])) {

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

            $userEmail = $_POST["email"];
            $username = htmlspecialchars($_POST["username"]);
            $subject = htmlspecialchars($_POST["subject"]);
            $message = htmlspecialchars($_POST["message"]);

            // On crée une instance de PHPMailer 
            $mail = new PHPMailer(true);

            try {
                // Configuration serveur SMTP               
                $mail->isSMTP();                                    // ON précise ici qu'on va utiliser le protocole SMTP = Simlpe Mail Transfer Protocol
                $mail->Host       = 'smtp.gmail.com';               // On précise l'hote ici gmail
                $mail->Port       = 465;                            // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->SMTPAuth   = true;                           // Authentification pour le SMTP
                $mail->Username   = $email;                         // Email de destination (à ne pas mettre en clair)
                $mail->Password   = $appPassword;                   // MDP d'application gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    // Chiffrement TLS activé
            
                //Destinataires
                $mail->setFrom($email, $username);        // Infos du User à l'origine du mail
                $mail->addAddress($email, 'Romain Jalabert');        // Ajouter le destinataire
            
                //Content                           
                $mail->Subject = $subject; // Le sujet du mail  qui provient du contact form
                $mail->Body    = $message . "// Message de $username"; // Le corps du message qui provient aussi du contact form
            
                // Envoi du mail 
                $mail->send();

                // Redirection vers une page de succès 
                header("Location: contact-success.php");
            
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
            }

        }

    }

}



