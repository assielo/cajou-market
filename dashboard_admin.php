<?php
require_once 'auth_middleware.php';
require_once 'config.php';

// Sécurité : Seul l'administrateur CCA a accès à ce panneau
checkAccess('admin_cca');

$message = '';
$error = '';

// Traitement des actions de validation ou de rejet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['actor_id'])) {
    $actor_id = intval($_POST['actor_id']);
    $action = $_POST['action'];

    if (in_array($action, ['valide', 'rejete'])) {
        try {
            // 1. Mise à jour du statut dans la base de données
            $stmt = $pdo->prepare("UPDATE actors SET validation_status = ? WHERE id = ?");
            if ($stmt->execute([$action, $actor_id])) {
                
                // 2. Récupérer les informations de l'acteur (email, téléphone, nom) pour la notification
                $stmtActor = $pdo->prepare("SELECT a.company_name, a.email, l.mobile FROM actors a LEFT JOIN legal_representatives l ON a.id = l.actor_id WHERE a.id = ?");
                $stmtActor->execute([$actor_id]);
                $actorData = $stmtActor->fetch();

                if ($actorData) {
                    require_once 'notifications.php';
                    
                    if ($action === 'valide') {
                        // Envoi d'un e-mail de succès
                        $sujet = "CajouMarket - Validation de votre Agrément CCA";
                        $corpsHtml = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                            <h2 style='color: #1E5705;'>Félicitations, {$actorData['company_name']}</h2>
                            <p>Votre dossier d'agrément a été <strong>validé</strong> par le Conseil du Coton et de l'Anacarde.</p>
                            <p>Vous pouvez dès à présent vous connecter à la bourse B2B.</p>
                        </div>";
                        sendSecureEmail($actorData['email'], $actorData['company_name'], $sujet, $corpsHtml);

                        // Envoi d'un SMS de confirmation
                        if (!empty($actorData['mobile'])) {
                            sendTransactionalSms($actorData['mobile'], "Votre agrément CCA sur CajouMarket a ete valide avec succes !");
                        }
                    }
                }

                $statusLabel = ($action === 'valide') ? 'validé' : 'rejeté';
                $message = "Le dossier N° $actor_id a été $statusLabel avec succès et l'acteur a été notifié.";
            }
        } catch (Exception $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

// Récupération des statistiques globales
$countPending = $pdo->query("SELECT COUNT(*) FROM actors WHERE validation_status = 'en_attente'")->fetchColumn();
$countValidated = $pdo->query("SELECT COUNT(*) FROM actors WHERE validation_status = 'valide'")->fetchColumn();
$countRejected = $pdo->query("SELECT COUNT(*) FROM actors WHERE validation_status = 'rejete'")->fetchColumn();

// Récupération de la liste des dossiers d'acteurs avec leurs représentants légaux
$filter = $_GET['filter'] ?? 'en_attente';
$validFilters = ['en_attente', 'valide', 'rejete', 'tous'];
if (!in_array($filter, $validFilters)) { $filter = 'en_attente'; }

$sql = "SELECT a.*, l.full_name AS manager_name, l.mobile AS manager_mobile, l.email AS manager_email,
               cm.forecast_quantities_tonnes
        FROM actors a
        LEFT JOIN legal_representatives l ON a.id = l.actor_id
        LEFT JOIN campaign_metrics cm ON a.id = cm.actor_id";

if ($filter !== 'tous') {
    $sql .= " WHERE a.validation_status = " . $pdo->quote($filter);
}
$sql .= " ORDER BY a.created_at DESC";

$actors = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Supervision Réglementaire & Validation des Agréments CCA</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .bg-institutional { background-color: #1E5705; }
        .btn-official { background-color: #f38423; color: #ffffff; border-radius: 4px; transition: all 0.3s; }
        .btn-official:hover { background-color: #4C942D; }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex">
        
        <!-- Sidebar Administration CCA -->
        <aside class="hidden md:flex flex-col w-64 bg-institutional text-white p-5 justify-between shadow-xl">
            <div>
                <div class="flex items-center gap-3 mb-8 px-2 border-b border-emerald-800 pb-4">
                    <div class="bg-white/10 p-2.5 rounded-xl">
                        <i class="fa-solid fa-shield-halved text-xl text-amber-400"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-base tracking-wide">Admin CCA</h1>
                        <span class="text-[10px] text-emerald-300 uppercase tracking-wider">Conseil Coton Anacarde</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <a href="dashboard_admin.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-semibold shadow-sm">
                        <i class="fa-solid fa-file-signature w-5"></i> Agréments & Dossiers
                    </a>
                    <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-chart-pie w-5"></i> Vue Bourse B2B
                    </a>
                    <a href="logistique_sigema.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-truck-ramp-box w-5"></i> Traçabilité SIGEMA
                    </a>
                </nav>
            </div>

            <div class="border-t border-emerald-800 pt-4">
                <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-900/40 text-xs font-medium transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
                </a>
            </div>
        </aside>

        <!-- Contenu Principal -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-10 shadow-sm">
                <h2 class="text-xs md:text-sm font-bold text-slate-800 uppercase tracking-wider">Panneau de Contrôle Réglementaire — Validation des Agréments</h2>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-700">Administrateur Connecté</span>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                
                <!-- Messages de retour -->
                <?php if ($message): ?>
                    <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-xs font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="bg-red-50 text-red-800 p-4 rounded-xl border border-red-200 text-xs font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Cartes d'indicateurs clés -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="dashboard_admin.php?filter=en_attente" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-amber-400 transition-all">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">En Attente de Validation</span>
                                <h3 class="text-2xl font-extrabold text-amber-600 mt-1"><?= $countPending ?></h3>
                            </div>
                            <div class="bg-amber-50 text-amber-700 p-3 rounded-xl"><i class="fa-solid fa-clock text-lg"></i></div>
                        </div>
                    </a>

                    <a href="dashboard_admin.php?filter=valide" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Dossiers Validés</span>
                                <h3 class="text-2xl font-extrabold text-emerald-700 mt-1"><?= $countValidated ?></h3>
                            </div>
                            <div class="bg-emerald-50 text-emerald-700 p-3 rounded-xl"><i class="fa-solid fa-circle-check text-lg"></i></div>
                        </div>
                    </a>

                    <a href="dashboard_admin.php?filter=rejete" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-red-400 transition-all">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Dossiers Rejetés</span>
                                <h3 class="text-2xl font-extrabold text-red-600 mt-1"><?= $countRejected ?></h3>
                            </div>
                            <div class="bg-red-50 text-red-600 p-3 rounded-xl"><i class="fa-solid fa-circle-xmark text-lg"></i></div>
                        </div>
                    </a>
                </div>

                <!-- Filtres et Tableau des Demandes -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">
                            Demandes d'Agrément Récemment Soumises
                        </h3>
                        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl text-xs font-semibold">
                            <a href="dashboard_admin.php?filter=en_attente" class="px-3 py-1.5 rounded-lg <?= $filter === 'en_attente' ? 'bg-white shadow text-slate-900 font-bold' : 'text-slate-500' ?>">En Attente</a>
                            <a href="dashboard_admin.php?filter=valide" class="px-3 py-1.5 rounded-lg <?= $filter === 'valide' ? 'bg-white shadow text-slate-900 font-bold' : 'text-slate-500' ?>">Validés</a>
                            <a href="dashboard_admin.php?filter=rejete" class="px-3 py-1.5 rounded-lg <?= $filter === 'rejete' ? 'bg-white shadow text-slate-900 font-bold' : 'text-slate-500' ?>">Rejetés</a>
                            <a href="dashboard_admin.php?filter=tous" class="px-3 py-1.5 rounded-lg <?= $filter === 'tous' ? 'bg-white shadow text-slate-900 font-bold' : 'text-slate-500' ?>">Tous</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                                    <th class="p-3">ID / Entreprise</th>
                                    <th class="p-3">Type & Catégorie</th>
                                    <th class="p-3">N° RCCM / Contribuable</th>
                                    <th class="p-3">Représentant Légal</th>
                                    <th class="p-3">Prévision Quota</th>
                                    <th class="p-3">Statut</th>
                                    <th class="p-3 text-right">Actions de Validation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <?php if (empty($actors)): ?>
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-400 italic">
                                            Aucun dossier ne correspond au filtre sélectionné.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($actors as $actor): ?>
                                        <tr class="hover:bg-slate-50/80 transition-all">
                                            <td class="p-3 font-bold">
                                                <div class="text-slate-900"><?= htmlspecialchars($actor['company_name']) ?></div>
                                                <span class="text-[10px] text-slate-400 font-normal">Réf: #<?= $actor['id'] ?> — <?= htmlspecialchars($actor['headquarters']) ?></span>
                                            </td>
                                            <td class="p-3">
                                                <span class="font-semibold text-slate-800"><?= htmlspecialchars(ucfirst($actor['actor_type'])) ?></span>
                                                <span class="block text-[10px] text-slate-400"><?= htmlspecialchars($actor['agrement_category']) ?></span>
                                            </td>
                                            <td class="p-3 font-mono text-[11px]">
                                                <div>RCCM: <?= htmlspecialchars($actor['rccm_number'] ?: 'N/A') ?></div>
                                                <div class="text-slate-400">CC: <?= htmlspecialchars($actor['taxpayer_number'] ?: 'N/A') ?></div>
                                            </td>
                                            <td class="p-3">
                                                <div class="font-semibold"><?= htmlspecialchars($actor['manager_name'] ?: 'Non renseigné') ?></div>
                                                <div class="text-[10px] text-slate-400"><?= htmlspecialchars($actor['manager_mobile'] ?: $actor['email']) ?></div>
                                            </td>
                                            <td class="p-3 font-bold text-emerald-800">
                                                <?= number_format($actor['forecast_quantities_tonnes'] ?? 0, 0, ',', ' ') ?> T
                                            </td>
                                            <td class="p-3">
                                                <?php if ($actor['validation_status'] === 'valide'): ?>
                                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-[10px] font-bold inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-check"></i> Validé
                                                    </span>
                                                <?php elseif ($actor['validation_status'] === 'rejete'): ?>
                                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-[10px] font-bold inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-xmark"></i> Rejeté
                                                    </span>
                                                <?php else: ?>
                                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-[10px] font-bold inline-flex items-center gap-1 animate-pulse">
                                                        <i class="fa-solid fa-clock"></i> En Attente
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="p-3 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- Voir le reçu si disponible -->
                                                    <?php if (!empty($actor['payment_receipt_url'])): ?>
                                                        <a href="<?= htmlspecialchars($actor['payment_receipt_url']) ?>" target="_blank" title="Voir le reçu de paiement" class="bg-slate-100 text-slate-600 hover:bg-slate-200 p-2 rounded-lg text-xs font-bold transition-all">
                                                            <i class="fa-solid fa-receipt"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- Formulaire d'action -->
                                                    <form method="POST" class="inline-flex gap-1" onsubmit="return confirm('Confirmez-vous cette décision sur le dossier d\'agrément ?');">
                                                        <input type="hidden" name="actor_id" value="<?= $actor['id'] ?>">
                                                        
                                                        <?php if ($actor['validation_status'] !== 'valide'): ?>
                                                            <button type="submit" name="action" value="valide" class="bg-emerald-700 hover:bg-emerald-800 text-white px-3 py-1.5 rounded-lg text-[11px] font-bold shadow transition-all">
                                                                Valider
                                                            </button>
                                                        <?php endif; ?>

                                                        <?php if ($actor['validation_status'] !== 'rejete'): ?>
                                                            <button type="submit" name="action" value="rejete" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-[11px] font-bold shadow transition-all">
                                                                Rejeter
                                                            </button>
                                                        <?php endif; ?>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>