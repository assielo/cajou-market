<?php
session_start();
require_once 'auth_middleware.php';
require_once 'config.php';

checkAccess(); // Vérifie que l'acteur est connecté

$actor_id = $_SESSION['actor_id'];
$message = '';
$error = '';

// Traitement de l'envoi d'une nouvelle déclaration EDI
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campaign_year = trim($_POST['campaign_year'] ?? '2026');
    $declaration_type = trim($_POST['declaration_type'] ?? 'declaration_mensuelle');
    $total_tonnage = floatval($_POST['total_tonnage'] ?? 0);
    $average_kor = floatval($_POST['average_kor'] ?? 48.0);
    $humidity_rate = floatval($_POST['humidity_rate'] ?? 9.0);

    if ($total_tonnage > 0 && $humidity_rate <= 10.0) {
        try {
            $sigema_ref = 'SIGEMA-CI-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));
            
            $stmt = $pdo->prepare("INSERT INTO edi_declarations (actor_id, campaign_year, declaration_type, total_tonnage, average_kor, humidity_rate, sigema_reference, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'transmis_cca')");
            if ($stmt->execute([$actor_id, $campaign_year, $declaration_type, $total_tonnage, $average_kor, $humidity_rate, $sigema_ref])) {
                $message = "Déclaration EDI transmise avec succès au système SIGEMA / GUCE-CI. Réf : $sigema_ref";
            }
        } catch (Exception $e) {
            $error = "Erreur technique lors de la transmission : " . $e->getMessage();
        }
    } else {
        $error = "Erreur de validation : Le tonnage doit être supérieur à 0 et le taux d'humidité ne doit pas dépasser le seuil réglementaire de 10%.";
    }
}

// Récupération de l'historique des déclarations de l'acteur
$stmtHistory = $pdo->prepare("SELECT * FROM edi_declarations WHERE actor_id = ? ORDER BY created_at DESC");
$stmtHistory->execute([$actor_id]);
$declarations = $stmtHistory->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CajouMarket - Portail EDI & Déclarations SIGEMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .bg-institutional { background-color: #1E5705; }
        .btn-official { background-color: #f38423; color: #ffffff; border-radius: 4px; transition: all 0.3s; }
        .btn-official:hover { background-color: #4C942D; }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex">
        
        <!-- Sidebar Navigation -->
        <aside class="hidden md:flex flex-col w-64 bg-institutional text-white p-5 justify-between shadow-xl">
            <div>
                <div class="flex items-center gap-3 mb-8 px-2 border-b border-emerald-800 pb-4">
                    <div class="bg-white/10 p-2.5 rounded-xl">
                        <i class="fa-solid fa-seedling text-xl text-amber-400"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-base tracking-wide">CajouMarket</h1>
                        <span class="text-[10px] text-emerald-300 uppercase tracking-wider">Portail EDI / SIGEMA</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-chart-pie w-5"></i> Tableau de bord
                    </a>
                    <a href="edi_portail.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-semibold shadow-sm">
                        <i class="fa-solid fa-file-contract w-5"></i> Déclarations EDI & SIGEMA
                    </a>
                    <a href="logistique_sigema.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-truck-ramp-box w-5"></i> Traçabilité Camions
                    </a>
                </nav>
            </div>

            <div class="border-t border-emerald-800 pt-4">
                <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-900/40 text-xs font-medium transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-10 shadow-sm">
                <h2 class="text-xs md:text-sm font-bold text-slate-800 uppercase tracking-wider">Module EDI — Échanges de Données avec le SIGEMA (CCA / GUCE-CI)</h2>
                <div class="flex items-center gap-2">
                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase">Passerelle Active</span>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                
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

                <!-- Formulaire de Saisie EDI -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Soumettre une Déclaration Officielle de Stock / Tonnage</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Conforme aux exigences de contrôle des flux d'anacarde en Côte d'Ivoire.</p>
                    </div>

                    <form method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Campagne</label>
                            <select name="campaign_year" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none">
                                <option value="2026">Campagne 2026</option>
                                <option value="2027">Campagne 2027</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Type de Déclaration</label>
                            <select name="declaration_type" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none">
                                <option value="declaration_mensuelle">Déclaration Mensuelle</option>
                                <option value="stock_initial">Stock Initial d'Usine</option>
                                <option value="intention_export">Intention d'Exportation</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Tonnage Global (Tonnes)</label>
                            <input type="number" step="0.01" name="total_tonnage" required placeholder="Ex: 50.5" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">KOR Moyen (lbs)</label>
                            <input type="number" step="0.1" name="average_kor" required placeholder="49.0" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Humidité (Max 10%)</label>
                            <input type="number" step="0.1" name="humidity_rate" required placeholder="9.0" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                        </div>
                        <div class="sm:col-span-2 lg:col-span-5 flex justify-end pt-2">
                            <button type="submit" class="btn-official px-6 py-2.5 text-xs font-bold shadow flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> Transmettre au SIGEMA & GUCE
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Historique des Déclarations -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Historique des Déclarations EDI Transmises</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                                    <th class="p-3">Référence SIGEMA</th>
                                    <th class="p-3">Type</th>
                                    <th class="p-3">Tonnage</th>
                                    <th class="p-3">KOR / Humidité</th>
                                    <th class="p-3">Statut Interopérabilité</th>
                                    <th class="p-3 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <?php if (empty($declarations)): ?>
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-slate-400 italic">Aucune déclaration EDI enregistrée pour l'instant.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($declarations as $dec): ?>
                                        <tr>
                                            <td class="p-3 font-mono font-bold text-institutional"><?= htmlspecialchars($dec['sigema_reference']) ?></td>
                                            <td class="p-3"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $dec['declaration_type']))) ?></td>
                                            <td class="p-3 font-bold"><?= number_format($dec['total_tonnage'], 2, ',', ' ') ?> T</td>
                                            <td class="p-3">KOR : <?= $dec['average_kor'] ?> | Humidité : <?= $dec['humidity_rate'] ?>%</td>
                                            <td class="p-3">
                                                <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                                    <?= strtoupper($dec['status']) ?>
                                                </span>
                                            </td>
                                            <td class="p-3 text-right text-slate-400"><?= $dec['created_at'] ?></td>
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