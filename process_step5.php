<?php
session_start();

// Connexion à la base de données MySQL via PDO
$host = 'localhost';$dbname = 'cajou_market_db';
$username = 'root'; // Changez selon votre configuration$password = ''; // Changez selon votre configuration

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification de la soumission de l'étape 5
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Récupération des données de l'étape 5
        $admin_sigema_name =$_POST['admin_sigema_name'] ?? '';
        $admin_sigema_email =$_POST['admin_sigema_email'] ?? '';
        $admin_sigema_mobile =$_POST['admin_sigema_mobile'] ?? '';

        $admin_edi_name =$_POST['admin_edi_name'] ?? '';
        $admin_edi_email =$_POST['admin_edi_email'] ?? '';
        $admin_edi_mobile =$_POST['admin_edi_mobile'] ?? '';
        
        $is_accurate = isset($_POST['is_accurate_information']) ? 1 : 0;

        // Début de la transaction
        $pdo->beginTransaction();

        // 1. Insertion dans la table `actors`
        $stmtActor =$pdo->prepare("INSERT INTO actors (
            actor_type, agrement_category, num_agreement_previous_season, 
            company_name, rccm_number, taxpayer_number, headquarters, 
            secondary_locations, email, password_hash, mobile_1, 
            postal_code, payment_receipt_url, is_accurate_information
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Email temporaire stocké ou généré (on utilise l'email du représentant ou un email principal)
        $main_email =$_SESSION['company_manager_email'] ?? 'contact@cajoumarket.ci';

        $stmtActor->execute([$_SESSION['actor_type'] ?? 'acheteur',
            $_SESSION['agrement_category'] ?? 'societe_commerciale',$_SESSION['num_agreement'] ?? null,
            $_SESSION['company_name'] ?? '',$_SESSION['rccm_number'] ?? '',
            $_SESSION['taxpayer_number'] ?? '',$_SESSION['headquarters'] ?? '',
            $_SESSION['secondary_locations'] ?? '',$main_email,
            $_SESSION['password_hash'] ?? '',$_SESSION['company_manager_mobile'] ?? '',
            '01 BP ...', // Code postal par défaut ou dynamique
            $_SESSION['payment_receipt_url'] ?? null,
            $is_accurate
        ]);

        $actor_id =$pdo->lastInsertId();

        // 2. Insertion dans la table `legal_representatives`
        $stmtRep =$pdo->prepare("INSERT INTO legal_representatives (
            actor_id, full_name, birth_date, birth_place, quality_function, 
            identity_card_type, identity_card_number, residence_location, mobile, email
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmtRep->execute([
            $actor_id,$_SESSION['company_manager_name'] ?? '',
            $_SESSION['company_manager_date_naissance'] ?? '1970-01-01',$_SESSION['company_manager_lieu_naissance'] ?? '',
            $_SESSION['company_manager_function'] ?? '',$_SESSION['company_manager_identity_piece'] ?? '',
            $_SESSION['company_manager_n_cni'] ?? '',$_SESSION['company_manager_city'] ?? '',
            $_SESSION['company_manager_mobile'] ?? '',$_SESSION['company_manager_email'] ?? ''
        ]);

        // 3. Insertion dans la table `campaign_metrics`
        $stmtMetrics =$pdo->prepare("INSERT INTO campaign_metrics (
            actor_id, campaign_year, quantities_exported_or_processed_tonnes, 
            quantities_sold_locally_tonnes, forecast_quantities_tonnes
        ) VALUES (?, ?, ?, ?, ?)");

        $stmtMetrics->execute([$actor_id,
            date('Y'), // Année courante de campagne
            $_SESSION['quantities_exported'] ?? 0,
            $_SESSION['quantities_sold'] ?? 0,$_SESSION['forecast_quantities'] ?? 0
        ]);

        // 4. Insertion des Administrateurs Applicatifs (SIGEMA et EDI)
        $stmtAdmin =$pdo->prepare("INSERT INTO application_administrators (
            actor_id, admin_type, full_name, email, mobile
        ) VALUES (?, ?, ?, ?, ?)");

        // Administrateur SIGEMA
        $stmtAdmin->execute([$actor_id, 'SIGEMA',$admin_sigema_name, $admin_sigema_email,$admin_sigema_mobile]);

        // Administrateur EDI
        $stmtAdmin->execute([$actor_id, 'EDI',$admin_edi_name, $admin_edi_email,$admin_edi_mobile]);

        // Validation finale de la transaction
        $pdo->commit();

        // Nettoyage de la session
        session_unset();
        session_destroy();

        // Redirection vers une page de succès
        echo "<script>alert('Inscription enregistrée avec succès sur le portail CajouMarket !'); window.location.href='index.php';</script>";
        exit();

    }
} catch (Exception $e) {
    // En cas d'erreur, annulation de la transaction
    if ($pdo && $pdo->inTransaction()) {$pdo->rollBack();
    }
    die("Erreur technique lors de l'enregistrement en base de données : " . $e->getMessage());

    // (Dans process_step5.php, juste avant l'insertion dans la table actors)
$verification_token = bin2hex(random_bytes(32));
$otp_code = rand(100000, 999999);

// Modifier la requête d'insertion de la table actors pour inclure : 
// verification_token, is_verified (par défaut 0)

// Après le commit de la transaction :
require_once 'notifications.php';
sendConfirmationEmail($main_email, $_SESSION['company_manager_name'] ?? 'Acteur', $verification_token);
sendSmsNotification($_SESSION['company_manager_mobile'] ?? '', $otp_code);
}