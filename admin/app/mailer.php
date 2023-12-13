<?php 
require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function Mailer($recipient,$subject,$body,$altbody){
    $mail = new PHPMailer(false);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                                      //Display output
        $mail->isSMTP(); 
        $mail->Host       = 'smtp.gmail.com';                                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                                   //Enable SMTP authentication
        // $mail->Username   = 'burgershot.service@gmail.com';                       //SMTP username
        // $mail->Password   = 'hmtnpxwhfrhvjbsy';                                           //SMTP password
        $mail->Username   = $_ENV['MAIL_USERNAME'];                       //SMTP username
        $mail->Password   = $_ENV['MAIL_PASSWORD'];                                           //SMTP password
        $mail->isSMTP();                                         //Enable implicit TLS encryption
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Recipients
        $mail->setFrom($_ENV['MAIL_FROM']);
        $mail->addAddress($recipient['email'], $recipient['name']);                         //Add a recipient & Name is optional
        $mail->addReplyTo($_ENV['MAIL_REPLY_TO'], 'Reply');
        $mail->AddEmbeddedImage($_ENV['MAIL_LOGO'], 'logo', 'attachment', 'base64', 'image/jpeg');
        // Content
        $mail->isHTML(true);                                                        //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altbody;

       return $mail->send();
       
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        die($e->getMessage());
    }
}
