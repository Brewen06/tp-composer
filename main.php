<?php

require 'vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Dotenv\Dotenv;


print("Premiers pas avec composer \n\n");

// create a log channel
$log = new Logger('Application SIO');
$log->pushHandler(new StreamHandler('log/info.log', Level::Warning));

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$log->info("Démarrage de l'envoi d'un mail");
$mail = new PHPMailer(true);

try {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMPTSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = $_ENV['SMTP_PORT'];

    $mail->setFrom($_ENV['SMTP_USERNAME'], 'Mailer');
    $mail->addAddress('brewen68@ik.me', 'Brewen Frotin');
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    $log->error( "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}
$log->info("Fin de l'envoie d'un mail");

// add records to the log
$log->warning('Foo');
$log->error('Bar');