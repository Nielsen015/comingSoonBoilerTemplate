<?php
require __DIR__.'/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();
require __DIR__.'/config/mailer.php';

$mail = getMailer();
$mail->addAddress($_ENV['ADMIN_EMAIL']);
$mail->Subject = 'Test Email';
$mail->Body = 'This is a test email from Agriwatt Hub';
$mail->send();

echo "Test email sent to ".$_ENV['ADMIN_EMAIL'];