<?php
session_start();
require_once 'auth_middleware.php';
require_once 'config.php';

checkAccess(); // Vérifie que l'acteur est connecté

$actor_id = $_SESSION['actor_id'];
$message = '';
$error = '';

// Récupération des informations de l'entreprise connectée
$stmtActor = $pdo->prepare("SELECT * FROM actors WHERE id = ?");
$stmtActor->execute([$actor_id]);
$currentActor = $stmtActor->fetch();

// Simulation des données d'une transaction marketplace (À lier dynamiquement à votre panier/commandes)
$contractRef = 'PROFORMA-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
$tonnage = 25.00; // en tonnes
$unitPrice = 950; // FCFA / kg par exemple ou selon cours CCA
$totalAmount = $tonnage * 1000 * ($unitPrice / 1000); // Calcul global simplifié
$buyerCompany = $currentActor['company_name'] ?? 'Acheteur B2B';
$sellerCompany = 'COOPÉRATIVE ANACARDE PARTENAIRE CI';

// Traitement de la signature électronique
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sign_contract'])) {
    $rawHashData = $contractRef . $buyerCompany . $sellerCompany . $totalAmount . date('Y-m-d');
    $digitalHash = hash('sha256', $rawHashData); // Empreinte cryptographique immuable

    try {
        $stmtSave = $pdo->prepare("INSERT INTO contract_signatures (contract_reference, actor_id, buyer_company, seller_company, total_amount, tonnage, digital_hash, signature_status, signed_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'signe_electroniquement', NOW())");
        if ($stmtSave->execute([$contractRef, $actor_id, $buyerCompany, $sellerCompany, $totalAmount, $tonnage, $digitalHash])) {
            $message = "Contrat pro forma signé et scellé numériquement avec succès. Empreinte SHA-256 : " . $digitalHash;
        }
    } catch (Exception $e) {
        $error = "Erreur lors du scellement du contrat : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CajouMarket - Contrat Pro Forma & Signature Électronique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .contract-paper { background: #ffffff; max-width: 800px; margin: 30px auto; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        @media print {
            .no-print { display: none; }
            .contract-paper { margin: 0; box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Boutons d'action hors impression -->
    <div class="no-print max-w-[800px] mx-auto mt-6 flex justify-between px-4">
        <a href="dashboard.php" class="bg-slate-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow">
            <i class="fa-solid fa-arrow-left mr-2"></i> Retour au Tableau de bord
        </a>
        <button onclick="window.print()" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Imprimer / Archiver PDF
        </button>
    </div>

    <div class="contract-paper border border-slate-200 space-y-6">
        
        <?php if ($message): ?>
            <div class="no-print bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="no-print bg-red-50 text-red-800 p-4 rounded-xl border border-red-200 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- En-tête Institutionnel -->
        <div class="flex justify-between items-start border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-lg font-extrabold text-emerald-900">CAJOUMARKET B2B — CONTRAT PRO FORMA</h1>
                <p class="text-xs text-slate-500 uppercase mt-1">Plateforme Sécurisée de Transaction d'Anacarde (Côte d'Ivoire)</p>
            </div>
            <div class="text-right">
                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase">Réf : <?= htmlspecialchars($contractRef) ?></span>
                <p class="text-xs text-slate-400 mt-2">Date : <?= date('d/m/Y') ?></p>
            </div>
        </div>

        <!-- Parties engagées -->
        <div class="grid grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-xl">
            <div>
                <span class="text-slate-400 block uppercase text-[10px]">Vendeur / Fournisseur</span>
                <strong class="text-slate-800"><?= htmlspecialchars($sellerCompany) ?></strong>
            </div>
            <div>
                <span class="text-slate-400 block uppercase text-[10px]">Acheteur / Exportateur</span>
                <strong class="text-slate-800"><?= htmlspecialchars($buyerCompany) ?></strong>
            </div>
        </div>

        <!-- Détails de la Commande -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Détails de la Marchandise & Conditions Réglementaires</h3>
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 uppercase text-[10px]">
                        <th class="p-3 rounded-l-lg">Description du Produit</th>
                        <th class="p-3 text-center">Tonnage</th>
                        <th class="p-3 text-right">Montant Total estimé</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="p-3">
                            <strong>Matières Premières d'Anacarde (Brut)</strong>
                            <div class="text-[10px] text-slate-400">Conforme KOR min 48 | Humidité max 10% | Prix plancher CCA</div>
                        </td>
                        <td class="p-3 text-center font-bold"><?= number_format($tonnage, 2, ',', ' ') ?> T</td>
                        <td class="p-3 text-right font-bold text-emerald-800"><?= number_format($totalAmount, 0, ',', ' ') ?> FCFA</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Clauses de Sécurité & Conformité CCA -->
        <div class="text-[11px] text-slate-600 space-y-2 bg-emerald-50/40 p-4 rounded-xl border border-emerald-100">
            <p><strong>Clauses Réglementaires :</strong> Le présent contrat est régi par les dispositions en vigueur édictées par le Conseil du Coton et de l'Anacarde (CCA). Toute transaction validée électroniquement sur CajouMarket engage la responsabilité des parties et génère automatiquement une traçabilité SIGEMA.</p>
        </div>

        <!-- Section Signature Électronique et Scellement -->
        <div class="pt-6 border-t border-slate-200 text-xs space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-slate-800">Scellement Cryptographique (SHA-256)</p>
                    <p class="text-[10px] text-slate-400">Assure l'authentification et l'inviolabilité du document contractuel.</p>
                </div>
                
                <form method="POST" class="no-print">
                    <button type="submit" name="sign_contract" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow flex items-center gap-2">
                        <i class="fa-solid fa-signature"></i> Signer & Sceller Numériquement
                    </button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>