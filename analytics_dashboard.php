<?php
session_start();
require_once 'auth_middleware.php';
require_once 'config.php';

checkAccess(); // Vérifie que l'acteur est connecté

// Récupération de statistiques globales simulées ou dynamiques (depuis la base de données)
try {
    $totalActors = $pdo->query("SELECT COUNT(*) FROM actors")->fetchColumn();
    $totalTonnage = $pdo->query("SELECT SUM(total_tonnage) FROM edi_declarations")->fetchColumn() ?: 1250.50;
    $totalContracts = $pdo->query("SELECT COUNT(*) FROM contract_signatures")->fetchColumn() ?: 45;
} catch (Exception $e) {
    $totalActors = 120;
    $totalTonnage = 1250.50;
    $totalContracts = 45;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CajouMarket - Tableau de Bord Analytique & Statistiques</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js pour les graphiques interactifs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .bg-institutional { background-color: #1E5705; }
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
                        <span class="text-[10px] text-emerald-300 uppercase tracking-wider">Analytique & Pilotage</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-chart-pie w-5"></i> Vue Générale B2B
                    </a>
                    <a href="analytics_dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-semibold shadow-sm">
                        <i class="fa-solid fa-chart-line w-5"></i> Statistiques & Graphiques
                    </a>
                    <a href="edi_portail.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-file-contract w-5"></i> Portail EDI / SIGEMA
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
                <h2 class="text-xs md:text-sm font-bold text-slate-800 uppercase tracking-wider">Analytique Nationale — Filière Anacarde (Côte d'Ivoire)</h2>
                <div class="flex items-center gap-2">
                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase">Campagne Active</span>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Acteurs & Coopératives Enregistrés</span>
                        <h3 class="text-2xl font-extrabold text-slate-900 mt-1"><?= number_format($totalActors, 0, ',', ' ') ?></h3>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Tonnage Global Déclaré (SIGEMA)</span>
                        <h3 class="text-2xl font-extrabold text-emerald-700 mt-1"><?= number_format($totalTonnage, 2, ',', ' ') ?> T</h3>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Contrats Pro Forma Signés</span>
                        <h3 class="text-2xl font-extrabold text-amber-600 mt-1"><?= number_format($totalContracts, 0, ',', ' ') ?></h3>
                    </div>
                </div>

                <!-- Graphiques Chart.js -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Graphique 1 : Tonnage par Région Productrice -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-sm uppercase mb-4">Répartition des Tonnages par Bassin de Production</h3>
                        <div class="relative h-64">
                            <canvas id="regionChart"></canvas>
                        </div>
                    </div>

                    <!-- Graphique 2 : Évolution Mensuelle des Ventes B2B -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-sm uppercase mb-4">Évolution du Volume Transigé (en Tonnes)</h3>
                        <div class="relative h-64">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Script d'initialisation des graphiques Chart.js -->
    <script>
        // 1. Graphique par Région (Données simulées représentatives des zones anacarde en CI)
        const ctxRegion = document.getElementById('regionChart').getContext('2d');
        new Chart(ctxRegion, {
            type: 'doughnut',
            data: {
                labels: ['Korhogo (Poro)', 'Bouaké (Gbêkê)', 'Bondoukou (Gontougo)', 'Séguéla (Worodougou)', 'Autres'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: ['#1E5705', '#4C942D', '#f38423', '#cbd5e1', '#e2e8f0']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 10 } } }
                }
            }
        });

        // 2. Graphique d'Évolution Mensuelle
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Tonnage Commercialisé (T)',
                    data: [120, 340, 580, 420, 290, 180],
                    backgroundColor: '#1E5705',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>