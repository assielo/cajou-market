<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Tableau de Bord Officiel (Filière Anacarde CI)</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Polices Officielles (Poppins & Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-institutional { background-color: #1E5705; }
        .text-institutional { color: #1E5705; }
        .btn-official { background-color: #f38423; color: #ffffff; border-radius: 2px; transition: all 0.3s; }
        .btn-official:hover { background-color: #4C942D; }
    </style>
</head>
<body class="bg-slate-100 antialiased">

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
                        <span class="text-[10px] text-emerald-300 uppercase tracking-wider">Portail GUCE / CCA</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-semibold shadow-sm">
                        <i class="fa-solid fa-chart-pie w-5"></i> Tableau de bord
                    </a>
                    <a href="marketplace.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 hover:text-white text-xs font-medium transition-all">
                        <i class="fa-solid fa-store w-5"></i> Bourse B2B & Négoce
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 hover:text-white text-xs font-medium transition-all">
                        <i class="fa-solid fa-file-contract w-5"></i> Déclarations EDI / SIGEMA
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
            
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-10 shadow-sm">
                <div class="flex items-center gap-3">
                    <h2 class="text-xs md:text-sm font-bold text-slate-800 uppercase tracking-wider">Suivi des Cours Légaux & Conformité CCA</h2>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-full flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="text-[11px] font-bold text-amber-900">Campagne Anacarde Active</span>
                    </div>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                
                <!-- Grille des Prix Planchers Réglementés (Source Officielle CCA) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide flex items-center gap-2">
                            <i class="fa-solid fa-scale-balanced text-amber-600"></i>
                            Barème Officiel des Prix Planchers (Noix séchées et bien triées)
                        </h3>
                        <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-lg">Arrêté Ministériel</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">1. Bord Champ (Producteur)</span>
                            <h4 class="text-lg font-extrabold text-slate-900 mt-1">400 FCFA <span class="text-xs font-normal text-slate-500">/ kg</span></h4>
                            <p class="text-[10px] text-emerald-700 mt-2 font-medium"><i class="fa-solid fa-check"></i> Achat direct champ</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">2. Magasin Intérieur</span>
                            <h4 class="text-lg font-extrabold text-slate-900 mt-1">425 FCFA <span class="text-xs font-normal text-slate-500">/ kg</span></h4>
                            <p class="text-[10px] text-emerald-700 mt-2 font-medium"><i class="fa-solid fa-check"></i> Collecte régionale</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">3. Magasin Usine</span>
                            <h4 class="text-lg font-extrabold text-slate-900 mt-1">454 FCFA <span class="text-xs font-normal text-slate-500">/ kg</span></h4>
                            <p class="text-[10px] text-emerald-700 mt-2 font-medium"><i class="fa-solid fa-check"></i> Unités de transformation</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">4. Magasin Portuaire</span>
                            <h4 class="text-lg font-extrabold text-slate-900 mt-1">484 FCFA <span class="text-xs font-normal text-slate-500">/ kg</span></h4>
                            <p class="text-[10px] text-emerald-700 mt-2 font-medium"><i class="fa-solid fa-check"></i> Prêt pour exportation</p>
                        </div>
                    </div>

                    <!-- Note réglementaire humidité -->
                    <div class="mt-4 bg-red-50 border border-red-200 p-3 rounded-xl flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 mt-0.5"></i>
                        <p class="text-xs text-red-900 leading-relaxed">
                            <strong>Alerte Qualité Obligatoire :</strong> Les lots présentant un <strong>taux d'humidité supérieur à 10 %</strong> sont systématiquement refusés au déchargement par les services de contrôle. Veillez au respect du séchage sur aire aménagée.
                        </p>
                    </div>
                </div>

                <!-- Simulateur KOR & Contrôle Humidité Intégré -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-calculator text-institutional"></i>
                            Calculateur de Rendement KOR & Contrôle d'Humidité
                        </h3>
                        <p class="text-xs text-slate-500 mb-4">Vérifiez la conformité de vos lots avant soumission des déclarations SIGEMA.</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Poids Échantillon (g)</label>
                                <input type="number" id="sample" value="1000" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Poids Amandes (g)</label>
                                <input type="number" id="kernel" value="485" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Humidité (%)</label>
                                <input type="number" id="humidity" value="9.2" step="0.1" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-600 focus:outline-none">
                            </div>
                        </div>

                        <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100 flex justify-between items-center">
                            <div>
                                <span class="text-xs font-bold text-emerald-900 uppercase">Diagnostic :</span>
                                <p class="text-xs text-emerald-700 mt-0.5" id="result-text">KOR estimé : <strong>48.5 lbs</strong> — Lot Conforme aux normes d'exportation</p>
                            </div>
                            <button onclick="calculate()" class="btn-official px-4 py-2 text-xs font-bold shadow">Calculer</button>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide mb-3">Accès Rapides</h3>
                            <div class="space-y-2 text-xs">
                                <a href="marketplace.php" class="block p-3 bg-slate-50 hover:bg-slate-100 rounded-xl font-medium text-slate-700 transition-all flex items-center justify-between">
                                    <span>Accéder à la Bourse B2B</span>
                                    <i class="fa-solid fa-arrow-right text-institutional"></i>
                                </a>
                                <a href="#" class="block p-3 bg-slate-50 hover:bg-slate-100 rounded-xl font-medium text-slate-700 transition-all flex items-center justify-between">
                                    <span>Déclarations EDI / SIGEMA</span>
                                    <i class="fa-solid fa-arrow-right text-institutional"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <span class="text-[10px] text-slate-400 block text-center">Plateforme interopérable GUCE-CI / CCA</span>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <script>
        function calculate() {
            const sample = parseFloat(document.getElementById('sample').value);
            const kernel = parseFloat(document.getElementById('kernel').value);
            const humidity = parseFloat(document.getElementById('humidity').value);

            if(humidity > 10.0) {
                document.getElementById('result-text').innerHTML = `<strong class="text-red-600">REJETÉ :</strong> Taux d'humidité de ${humidity}% supérieur à la limite légale (10%) !`;
                return;
            }

            const kor = ((kernel / sample) * 100) * 2.20462 * 0.5;
            document.getElementById('result-text').innerHTML = `KOR estimé : <strong>${kor.toFixed(1)} lbs</strong> — Lot Conforme aux normes d'exportation`;
        }
    </script>
</body>
</html>