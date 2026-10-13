<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Recherche de l'acteur dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM actors WHERE email = ?");
        $stmt->execute([$email]);
        $actor = $stmt->fetch();

        if ($actor && password_verify($password, $actor['password_hash'])) {
            // Stockage des informations clés dans la session
            $_SESSION['actor_id'] = $actor['id'];
            $_SESSION['company_name'] = $actor['company_name'] ?? 'Entreprise';
            $_SESSION['role'] = $actor['role'] ?? 'acheteur_b2b'; // Récupération du rôle multi-niveau

            // Redirection intelligente selon le rôle de l'utilisateur
            if ($_SESSION['role'] === 'admin_cca') {
                header('Location: dashboard_admin.php');
            } elseif ($_SESSION['role'] === 'gestionnaire_stock') {
                header('Location: logistique_sigema.php');
            } else {
                header('Location: dashboard.php');
            }
            exit();
        } else {
            $error = "Identifiants incorrects ou compte introuvable.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Connexion Acteur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border border-slate-200">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center bg-emerald-800 text-white p-3 rounded-full shadow-md mb-2">
                <i class="fa-solid fa-seedling text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">CajouMarket</h1>
            <p class="text-xs text-slate-500 uppercase mt-1">Connexion Portail Acteur CCA / GUCE</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 bg-red-50 text-red-700 p-3 rounded-xl text-xs font-medium border border-red-200">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Adresse Email</label>
                <input type="emailname" name="email" required placeholder="nom@entreprise.ci" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mot de passe</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
            </div>
            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow">
                Se Connecter
            </button>
        </form>

        <div class="mt-6 text-center border-t border-slate-100 pt-4">
            <p class="text-xs text-slate-500">Nouvel acteur dans la filière ? <a href="etape2.php" class="text-emerald-700 font-bold hover:underline">S'inscrire (Demande d'agrément)</a></p>
        </div>
    </div>
</body>
</html>