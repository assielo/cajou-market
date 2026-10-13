<?php
session_start();
require_once 'auth_middleware.php';
require_once 'config.php';

checkAccess(); // Vérifie que l'acteur est connecté

$actor_id = $_SESSION['actor_id'];

// Récupération des logs de notification de l'acteur connecté
$stmt = $pdo->prepare("SELECT * FROM notification_logs WHERE actor_id = ? ORDER BY created_at DESC LIMIT 20");
$stmt->execute([$actor_id]);
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CajouMarket - Historique des Notifications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-xl border border-slate-200 space-y-6">
        <div class="flex justify-between items-center border-b border-slate-100 pb-4">
            <div>
                <h1 class="text-lg font-bold text-slate-900">Historique des Notifications</h1>
                <p class="text-xs text-slate-500">Consultez la trace des e-mails et SMS transmis par la plateforme.</p>
            </div>
            <a href="dashboard.php" class="bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2 rounded-xl">Retour au Tableau de bord</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px]">
                        <th class="p-3">Canal</th>
                        <th class="p-3">Destinataire</th>
                        <th class="p-3">Objet / Message</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400 italic">Aucune notification enregistrée pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="p-3 font-bold">
                                    <?php if ($log['channel'] === 'email'): ?>
                                        <span class="text-blue-600"><i class="fa-solid fa-envelope mr-1"></i> E-mail</span>
                                    <?php else: ?>
                                        <span class="text-emerald-600"><i class="fa-solid fa-sms mr-1"></i> SMS</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 font-mono text-[11px]"><?= htmlspecialchars($log['recipient']) ?></td>
                                <td class="p-3 max-w-xs truncate"><?= htmlspecialchars($log['subject_or_message']) ?></td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $log['status'] === 'success' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= strtoupper($log['status']) ?>
                                    </span>
                                </td>
                                <td class="p-3 text-right text-slate-400"><?= $log['created_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>