<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

/**
 * Envoi d'un e-mail sécurisé avec traçabilité dans notification_logs
 */
function sendSecureEmail($toEmail, $recipientName, $subject, $htmlBody, $actorId = null) {
    global $pdo;
    $mail = new PHPMailer(true);
    $status = 'failed';

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.mailtrap.io'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'votre_username_smtp';
        $mail->Password   = 'votre_password_smtp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('no-reply@cajoumarket.ci', 'CajouMarket - Plateforme Anacarde CI');
        $mail->addAddress($toEmail, $recipientName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;

        if ($mail->send()) {
            $status = 'success';
        }
    } catch (Exception $e) {
        error_log("Erreur d'envoi d'e-mail à $toEmail : {$mail->ErrorInfo}");
    }

    // Enregistrement dans les logs MySQL si la connexion PDO est active
    if (isset($pdo)) {
        $stmt = $pdo->prepare("INSERT INTO notification_logs (actor_id, channel, recipient, subject_or_message, status) VALUES (?, 'email', ?, ?, ?)");
        $stmt->execute([$actorId, $toEmail, $subject, $status]);
    }

    return ($status === 'success');
}

/**
 * Envoi d'un SMS transactionnel avec traçabilité dans notification_logs
 */
function sendTransactionalSms($phoneNumber, $messageContent, $actorId = null) {
    global $pdo;
    $cleanPhone = preg_replace('/[^0-9+]/', '', $phoneNumber);
    
    // Simulation ou appel API SMS opérateur
    $status = 'success'; // Passé en success pour l'exemple local, géré par l'API en production
    
    // Enregistrement dans les logs MySQL
    if (isset($pdo)) {
        $stmt = $pdo->prepare("INSERT INTO notification_logs (actor_id, channel, recipient, subject_or_message, status) VALUES (?, 'sms', ?, ?, ?)");
        $stmt->execute([$actorId, $cleanPhone, $messageContent, $status]);
    }

    return true;
}
?>