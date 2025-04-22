<?php
require __DIR__.'/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();
require __DIR__.'/config/database.php';
require __DIR__.'/config/mailer.php';

header('Content-Type: application/json');

try {
    // Validate email
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email || strlen($email) > 191) {
        throw new Exception('Invalid email address');
    }

    // Store in database
    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO subscribers (email, ip_address) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $_SERVER['REMOTE_ADDR']);
    $stmt->execute();

    // Send notifications
    $mail = getMailer();
    
    // To admin
    $mail->addAddress($_ENV['ADMIN_EMAIL']);
    $mail->Subject = 'New Subscriber';
    $mail->Body = "New subscription from: $email";
    $mail->send();
    
    // To user (confirmation)
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = 'Subscription Confirmed';
    $mail->Body = "Thank you for subscribing to Agriwatt Hub!";
    $mail->send();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}