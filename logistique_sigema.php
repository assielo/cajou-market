<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Logistique, Traçabilité & Bordereaux SIGEMA</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-institutional { background-color: #1E5705; }
        .btn-official { background-color: #f38423; color: #ffffff; border-radius: 4px; transition: all 0.3s; }
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
                        <span class="text-[10px] text-emerald-300 uppercase tracking-wider">Logistique & SIGEMA</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-chart-pie w-5"></i> Tableau de bord
                    </a>
                    <a href="marketplace.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-store w-5"></i> Bourse B2B
                    </a>
                    <a href="logistique_sigema.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-semibold shadow-sm">
                        <i class="fa-solid fa-truck-ramp-box w-5"></i> Logistique & Bordereaux
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
                <h2 class="text-xs md:text-sm font-bold text-slate-800 uppercase tracking-wider">Module Logistique, Traçabilité Camions & Bordereaux</h2>
                <div class="flex items-center gap-3">
                    <button onclick="openBordereauModal()" class="btn-official px-4 py-2 text-xs font-bold shadow flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice"></i> Générer un Bordereau de Pesée
                    </button>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                
                <!-- Section Alerte Période de Fin de Campagne & Liquidité -->
                <div class="bg-amber-50 border border-amber-200 p-5 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-amber-500 text-white p-3 rounded-xl mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation text-base"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-amber-900 text-sm">Alerte Gestion de Trésorerie (Fin de Campagne)</h4>
                            <p class="text-xs text-amber-800 mt-0.5 leading-relaxed">
                                Période de mai-juin : ralentissement de la liquidité sur le terrain. Optimisez vos enlèvements pour sécuriser vos stocks en magasin d'usine avant la baisse des flux[cite: 1].
                            </p>
                        </div>
                    </div>
                    <button onclick="alert('Simulation de financement de stock en cours de chargement...')" class="bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl whitespace-nowrap shadow transition-all">
                        Simuler un Trésor-Stock
                    </button>
                </div>

                <!-- Suivi des Expéditions en Temps Réel (Camions & Wagons) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide flex items-center gap-2">
                            <i class="fa-solid fa-truck-fast text-institutional"></i>
                            Suivi des Convois & Traçabilité vers les Magasins Portuaires
                        </h3>
                        <span class="text-[10px] bg-slate-100 text-slate-600 font-bold px-2.5 py-1 rounded-lg">Interopérable SIGEMA</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                                    <th class="p-3">N° Convoi / Immatriculation</th>
                                    <th class="p-3">Origine (Zone)</th>
                                    <th class="p-3">Destination</th>
                                    <th class="p-3">Tonnage Chargé</th>
                                    <th class="p-3">Statut SIGEMA</th>
                                    <th class="p-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <tr>
                                    <td class="p-3 font-bold">CI-4582-AB-01</td>
                                    <td class="p-3">Korhogo (Magasin Central)</td>
                                    <td class="p-3">Magasin Portuaire (Abidjan)</td>
                                    <td class="p-3 font-bold">35.4 Tonnes</td>
                                    <td class="p-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold text-[10px]">EN ROUTE / VALIDÉ</span></td>
                                    <td class="p-3 text-right"><button onclick="alert('Détails du convoi chargés')" class="text-emerald-700 hover:underline font-bold">Suivre</button></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-bold">CI-9910-ZZ-03</td>
                                    <td class="p-3">Bondoukou (Coopérative)</td>
                                    <td class="p-3">Magasin Usine (Bouaké)</td>
                                    <td class="p-3 font-bold">28.0 Tonnes</td>
                                    <td class="p-3"><span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded font-bold text-[10px]">DÉCHARGÉ & CONFORME</span></td>
                                    <td class="p-3 text-right"><button onclick="alert('Détails du convoi chargés')" class="text-emerald-700 hover:underline font-bold">Consulter</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Génération Bordereau de Pesée SIGEMA -->
    <div id="bordereauModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Bordereau de Pesée & Qualité Conforme</h3>
                <button onclick="closeBordereauModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form class="space-y-3" onsubmit="event.preventDefault(); closeBordereauModal(); alert('Bordereau de pesée généré et enregistré dans le registre numérique !');">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">N° du Camion / Véhicule</label>
                        <input type="text" required placeholder="Ex: CI-1234-AA" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Poids Brut (kg)</label>
                        <input type="number" required placeholder="35000" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Tare Sacs (kg)</label>
                        <input type="number" required placeholder="450" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">KOR mesuré</label>
                        <input type="number" step="0.1" required placeholder="49.0" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Humidité (%)</label>
                        <input type="number" step="0.1" required placeholder="9.0" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3">
                    <button type="button" onclick="closeBordereauModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Fermer</button>
                    <button type="submit" class="btn-official px-4 py-2 text-xs font-bold shadow">Éditer le Bordereau</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBordereauModal() { document.getElementById('bordereauModal').classList.remove('hidden'); }
        function closeBordereauModal() { document.getElementById('bordereauModal').classList.add('hidden'); }
    </script>
</body>
</html>