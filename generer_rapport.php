<?php
session_start();
require_once 'config.php';

// Vérification de la session acteur
if (!isset($_SESSION['actor_id'])) {
    header('Location: index.php');
    exit();
}

$actor_id = $_SESSION['actor_id'];

// Récupération des informations de l'acteur et de ses métriques de campagne
try {
    $stmt = $pdo->prepare("SELECT a.*, c.* FROM actors a 
                           LEFT JOIN campaign_metrics c ON a.id = c.actor_id 
                           WHERE a.id = ?");
    $stmt->execute([$actor_id]);
    $data = $stmt->fetch();

    if (!$data) {
        die("Erreur : Données introuvables pour cet acteur.");
    }
} catch (Exception $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Rapport Officiel de Campagne (CCA)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f1f5f9; }
        .print-container { background: #ffffff; max-width: 800px; margin: 40px auto; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        @media print {
            body { background: #ffffff; }
            .no-print { display: none; }
            .print-container { margin: 0; box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Boutons d'action (Masqués à l'impression) -->
    <div class="no-print max-w-800px mx-auto mt-6 flex justify-between px-6">
        <a href="dashboard.php" class="bg-slate-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow">
            <i class="fa-solid fa-arrow-left mr-2">Retour au Dashboard</i>
        </a>
        <button onclick="window.print()" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Imprimer / Enregistrer en PDF
        </button>
    </div>

    <!-- Contenu du Rapport Officiel -->
    <div class="print-container space-y-6 border border-slate-200">
        
        <!-- En-tête Institutionnel -->
        <div class="flex justify-between items-start border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-xl font-extrabold text-emerald-900 tracking-tight">CAJOUMARKET - RÉPUBLIQUE DE CÔTE D'IVOIRE</h1>
                <p class="text-xs text-slate-500 uppercase mt-1">Plateforme Numérique de Suivi - Conseil du Coton et de l'Anacarde (CCA)</p>
            </div>
            <div class="text-right">
                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase">Document Officiel</span>
                <p class="text-xs text-slate-400 mt-2">Date : <?= date('d/m/Y') ?></p>
            </div>
        </div>

        <!-- Informations de l'Acteur -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">1. Identification de l'Acteur / Entreprise</h3>
            <div class="bg-slate-50 p-4 rounded-xl grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 block uppercase text-[10px]">Raison Sociale</span>
                    <strong class="text-slate-800 text-sm"><?= htmlspecialchars($data['company_name']) ?></strong>
                </div>
                <div>
                    <span class="text-slate-400 block uppercase text-[10px]">Type d'Acteur / Catégorie</span>
                    <strong class="text-slate-800"><?= htmlspecialchars(ucfirst($data['actor_type'])) ?> (<?= htmlspecialchars($data['agrement_category']) ?>)</strong>
                </div>
                <div>
                    <span class="text-slate-400 block uppercase text-[10px]">N° RCCM / Contribuable</span>
                    <span class="text-slate-700"><?= htmlspecialchars($data['rccm_number']) ?> / <?= htmlspecialchars($data['taxpayer_number']) ?></span>
                </div>
                <div>
                    <span class="text-slate-400 block uppercase text-[10px]">Siège Social</span>
                    <span class="text-slate-700"><?= htmlspecialchars($data['headquarters']) ?></span>
                </div>
            </div>
        </div>

        <!-- Métriques et Tonnages de Campagne -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">2. Déclarations de Tonnages & Quotas (Campagne en cours)</h3>
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 uppercase text-[10px]">
                        <th class="p-3 rounded-l-lg">Indicateur de Campagne</th>
                        <th class="p-3 text-right rounded-r-lg">Volume (Tonnes)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="p-3">Quantités exportées ou transformées (Précédente)</td>
                        <td class="p-3 text-right font-bold"><?= number_format($data['quantities_exported_or_processed_tonnes'] ?? 0, 2, ',', ' ') ?> T</td>
                    </tr>
                    <tr>
                        <td class="p-3">Quantités vendues localement (Précédente)</td>
                        <td class="p-3 text-right font-bold"><?= number_format($data['quantities_sold_locally_tonnes'] ?? 0, 2, ',', ' ') ?> T</td>
                    </tr>
                    <tr class="bg-emerald-50/50">
                        <td class="p-3 font-bold text-emerald-900">Prévisions de Campagne (Quotas officiels)</td>
                        <td class="p-3 text-right font-bold text-emerald-700"><?= number_format($data['forecast_quantities_tonnes'] ?? 0, 2, ',', ' ') ?> T</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Attestation et Signature -->
        <div class="pt-6 border-t border-slate-200 text-xs space-y-4">
            <div class="flex items-center gap-2">
                <input type="checkbox" checked disabled class="h-4 w-4 text-emerald-600 rounded">
                <span class="text-slate-700">L'acteur certifie l'exactitude des informations transmises et s'engage à respecter les prix planchers et les seuils d'humidité (max 10 %) fixés par le régulateur.</span>
            </div>
            
            <div class="grid grid-cols-2 pt-8">
                <div></div>
                <div class="text-center space-y-12">
                    <p class="font-bold text-slate-800 uppercase">Cachet & Signature de l'Entreprise</p>
                    <p class="text-[10px] text-slate-400">(Document généré et certifié par CajouMarket / SIGEMA)</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>