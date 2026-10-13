<?php
require_once 'config.php';

$token = $_GET['token'] ?? '';
$message = '';
$success = false;

if (!empty($token)) {
    $stmt = $pdo->prepare("SELECT id FROM actors WHERE verification_token = ?");
    $stmt->execute([$token]);
    $actor = $stmt->fetch();

    if ($actor) {
        // Mise à jour du statut is_verified
        $update = $pdo->prepare("UPDATE actors SET is_verified = 1, verification_token = NULL WHERE id = ?");
        if ($update->execute([$actor['id']])) {
            $success = true;
            $message = "Votre compte a été activé avec succès ! Vous pouvez maintenant vous connecter.";
        } else {
            $message = "Erreur technique lors de l'activation du compte.";
        }
    } else {
        $message = "Jeton d'activation invalide ou expiré.";
    }
} else {
    $message = "Aucun jeton fourni.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CajouMarket - Validation du Compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center space-y-4">
        <div class="inline-flex p-3 rounded-full <?= $success ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">
            <i class="fa-solid <?= $success ? 'fa-check' : 'fa-xmark' ?> text-2xl"></i>
        </div>
        <h2 class="text-lg font-bold text-slate-800">Activation du Compte</h2>
        <p class="text-xs text-slate-600 leading-relaxed"><?= $message ?></p>
        <div class="pt-4">
            <a href="index.php" class="bg-emerald-700 text-white text-xs font-bold px-6 py-3 rounded-xl shadow uppercase tracking-wider inline-block">
                Aller à la Connexion
            </a>
        </div>
    </div>
</body>
</html>