<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécurité mot de passe
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        die("Erreur : Les mots de passe ne correspondent pas. <a href='index.php'>Retour</a>");
    }

    $_SESSION['password_hash'] = password_hash($password, PASSWORD_DEFAULT);

    // Gestion du fichier de reçu de paiement
    if (isset($_FILES['payment_receipt']) && $_FILES['payment_receipt']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
        
        $fileExtension = pathinfo($_FILES['payment_receipt']['name'], PATHINFO_EXTENSION);
        $fileName = 'recu_' . time() . '.' . $fileExtension;
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['payment_receipt']['tmp_name'], $filePath)) {
            $_SESSION['payment_receipt_url'] = $filePath;
        }
    }

    header('Location: etape2.php');
    exit();
}