<?php
session_start();
require_once 'config.php';
require_once 'notifications.php';

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: etape5.php');
    exit();
}

// Récupération des données de l'étape 5
$admin_sigema_name = trim($_POST['admin_sigema_name'] ?? '');
$admin_sigema_email = trim($_POST['admin_sigema_email'] ?? '');
$admin_sigema_mobile = trim($_POST['admin_sigema_mobile'] ?? '');

$admin_edi_name = trim($_POST['admin_edi_name'] ?? '');
$admin_edi_email = trim($_POST['admin_edi_email'] ?? '');
$admin_edi_mobile = trim($_POST['admin_edi_mobile'] ?? '');

$is_accurate_information = isset($_POST['is_accurate_information']) ? 1 : 0;

if (!$is_accurate_information) {
    die("Erreur : Vous devez cocher l'attestation sur l'honneur pour valider l'inscription.");
}

try {
    // Début de la transaction SQL pour garantir l'intégrité des 5 étapes
    $pdo->beginTransaction();

    // 1. Insertion des données principales de l'entreprise (Stockées en session lors des étapes précédentes)
    $company_name = $_SESSION['company_name'] ?? 'Entreprise Anacarde';
    $actor_type = $_SESSION['actor_type'] ?? 'exportateur';
    $agrement_category = $_SESSION['agrement_category'] ?? 'Standard';
    $rccm_number = $_SESSION['rccm_number'] ?? '';
    $taxpayer_number = $_SESSION['taxpayer_number'] ?? '';
    $headquarters = $_SESSION['headquarters'] ?? '';
    $main_email = $_SESSION['main_email'] ?? $admin_sigema_email;
    $main_password = $_SESSION['password'] ?? password_hash('PassCajou2026*', PASSWORD_DEFAULT); // Mot de passe sécurisé par défaut ou saisi à l'étape 1
    
    $verification_token = bin2hex(random_bytes(32));

    $sqlActor = "INSERT INTO actors (company_name, actor_type, agrement_category, rccm_number, taxpayer_number, headquarters, email, password_hash, verification_token, validation_status, role) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'en_attente', 'acheteur_b2b')";
    $stmtActor = $pdo->prepare($sqlActor);
    $stmtActor->execute([
        $company_name, $actor_type, $agrement_category, $rccm_number, $taxpayer_number, $headquarters, $main_email, $main_password, $verification_token
    ]);
    
    $actor_id = $pdo->lastInsertId();

    // 2. Insertion du représentant légal (Étape précédente en session)
    if (isset($_SESSION['manager_full_name'])) {
        $stmtManager = $pdo->prepare("INSERT INTO legal_representatives (actor_id, full_name, mobile, email) VALUES (?, ?, ?, ?)");
        $stmtManager->execute([
            $actor_id, 
            $_SESSION['manager_full_name'], 
            $_SESSION['manager_mobile'] ?? '', 
            $_SESSION['manager_email'] ?? ''
        ]);
    }

    // 3. Insertion des administrateurs applicatifs (SIGEMA & EDI - Étape 5 actuelle)
    $stmtAdmins = $pdo->prepare("INSERT INTO system_admins (actor_id, admin_type, full_name, email, mobile) VALUES (?, ?, ?, ?, ?)");
    $stmtAdmins->execute([$actor_id, 'sigema', $admin_sigema_name, $admin_sigema_email, $admin_sigema_mobile]);
    $stmtAdmins->execute([$actor_id, 'edi', $admin_edi_name, $admin_edi_email, $admin_edi_mobile]);

    // Validation définitive de la transaction
    $pdo->commit();

    // 4. Déclenchement des Notifications (Email de confirmation & SMS OTP)
    $otpCode = rand(100000, 999999);
    
    // Envoi de l'e-mail de validation avec le jeton
    $sujetEmail = "CajouMarket - Confirmation de votre demande d'agrément";
    $corpsHtml = "
        <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
            <h2 style='color: #1E5705;'>Bienvenue sur CajouMarket, $company_name</h2>
            <p>Votre dossier d'inscription en 5 étapes a bien été enregistré et transmis au <strong>Conseil du Coton et de l'Anacarde (CCA)</strong>.</p>
            <p>Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse email :</p>
            <p><a href='http://localhost/cajou_market/verify.php?token=$verification_token' style='background: #1E5705; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Activer mon compte</a></p>
        </div>
    ";
    sendSecureEmail($main_email, $company_name, $sujetEmail, $corpsHtml);

    // Envoi du SMS transactionnel au mobile de l'admin SIGEMA
    sendTransactionalSms($admin_sigema_mobile, "Votre code de confirmation CajouMarket est le : " . $otpCode);

    // Nettoyage de la session d'inscription
    session_unset();

    // Redirection vers une page de succès
    header('Location: inscription_succes.php');
    exit();

} catch (Exception $e) {
    // Annulation de la transaction en cas d'erreur
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Erreur critique lors de l'enregistrement de l'inscription : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Inscription (Étape 5 : Administrateurs Applicatifs & Engagement)</title>
    <!-- Tailwind CSS pour un design responsive mobile-first -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center py-6 px-4 sm:px-6 lg:px-8">
        <!-- En-tête / Logo -->
        <div class="sm:mx-auto sm:w-full sm:max-w-xl text-center mb-4">
            <div class="inline-flex items-center justify-center bg-emerald-800 text-white p-3 rounded-full shadow-md mb-2">
                <i class="fa-solid fa-seedling text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">CajouMarket</h1>
            <p class="text-xs text-slate-600 mt-1 uppercase tracking-wider font-semibold">
                Portail de Gestion des Opérations d’Anacarde (Côte d'Ivoire)
            </p>
        </div>

        <!-- Conteneur du Formulaire -->
        <div class="sm:mx-auto sm:w-full sm:max-w-xl">
            <div class="bg-white py-8 px-6 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
                
                <!-- En-tête de l'étape -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Étape 5 sur 5</span>
                        <span class="text-xs font-medium text-emerald-700">100%</span>
                    </div>
                    <!-- Barre de progression -->
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mt-4">Administrateurs Applicatifs & Engagement</h2>
                    <p class="text-xs text-slate-500">Désignation des référents techniques et attestation sur l'honneur.</p>
                </div>

                <!-- Formulaire Étape 5 -->
                <form class="space-y-6" action="process_step5.php" method="POST">
                    
                    <!-- Section Administrateur SIGEMA -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h3 class="text-xs font-bold text-emerald-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-user-gear text-emerald-700"></i>
                            Administrateur SIGEMA
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label for="admin_sigema_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Nom & Prénom(s) <span class="text-red-500">*</span>
                                </label>
                                <input id="admin_sigema_name" name="admin_sigema_name" type="text" required placeholder="Ex: Yao Konan Marc"
                                    class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="admin_sigema_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input id="admin_sigema_email" name="admin_sigema_email" type="email" required placeholder="sigema@entreprise.ci"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                                </div>
                                <div>
                                    <label for="admin_sigema_mobile" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                        Téléphone (Mobile) <span class="text-red-500">*</span>
                                    </label>
                                    <input id="admin_sigema_mobile" name="admin_sigema_mobile" type="tel" required placeholder="+225 0700000000"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Administrateur Portail EDI -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h3 class="text-xs font-bold text-emerald-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-laptop-code text-emerald-700"></i>
                            Administrateur Portail EDI
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label for="admin_edi_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Nom & Prénom(s) <span class="text-red-500">*</span>
                                </label>
                                <input id="admin_edi_name" name="admin_edi_name" type="text" required placeholder="Ex: Touré Fatou"
                                    class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="admin_edi_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input id="admin_edi_email" name="admin_edi_email" type="email" required placeholder="edi@entreprise.ci"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                                </div>
                                <div>
                                    <label for="admin_edi_mobile" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                        Téléphone (Mobile) <span class="text-red-500">*</span>
                                    </label>
                                    <input id="admin_edi_mobile" name="admin_edi_mobile" type="tel" required placeholder="+225 0500000000"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attestation sur l'honneur (Déclaration réglementaire CCA) -->
                    <div class="bg-amber-50/70 border border-amber-200 p-4 rounded-xl">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="is_accurate_information" name="is_accurate_information" value="1" required
                                class="mt-1 h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded">
                            <label for="is_accurate_information" class="text-xs text-slate-700 leading-relaxed cursor-pointer">
                                <strong>J’atteste que les informations fournies sont complètes et conformes à la vérité</strong>, en sachant qu’une fausse déclaration peut être une raison suffisante au rejet de ma candidature en tant qu’exportateur ou transformateur. Au demeurant, j’autorise le <strong>Conseil du Coton et de l’Anacarde</strong> à vérifier l’exactitude des renseignements fournis.
                            </label>
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex items-center justify-between pt-2 gap-3">
                        <a href="etape4.php" class="w-1/3 bg-slate-200 hover:bg-slate-300 text-slate-700 text-center py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                            Précédent
                        </a>
                        <button type="submit" class="w-2/3 bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-700/20 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check-double"></i>
                            <span>Finaliser l'Inscription</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>