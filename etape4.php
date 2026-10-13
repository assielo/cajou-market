<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Inscription (Étape 4 : Volumes de Campagne)</title>
    <!-- Tailwind CSS pour un design responsive mobile-first -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center py-6 px-4 sm:px-6 lg:px-8">
        <!-- En-tête / Logo -->
        <div class="sm:mx-auto sm:w-full sm:max-w-xl text-center mb-4">
            <div class="inline-flex items-center justify-center bg-emerald-800 text-white p-3 rounded-full shadow-md mb-2">
                <i class="fa-solid fa-seedling text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">CajouMarket</h1>
            <p class="text-xs text-slate-600 mt-1 uppercase tracking-wider font-semibold">
                Portail de Gestion des Opérations d’Anacarde (Côte d'Ivoire)
            </p>
        </div>

        <!-- Conteneur du Formulaire -->
        <div class="sm:mx-auto sm:w-full sm:max-w-xl">
            <div class="bg-white py-8 px-6 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
                
                <!-- En-tête de l'étape -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Étape 4 sur 5</span>
                        <span class="text-xs font-medium text-slate-400">80%</span>
                    </div>
                    <!-- Barre de progression -->
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 80%"></div>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mt-4">Informations sur la Commercialisation</h2>
                    <p class="text-xs text-slate-500">Déclaration des tonnages de la campagne précédente et prévisions.</p>
                </div>

                <!-- Formulaire Étape 4 -->
                <form class="space-y-4" action="process_step4.php" method="POST">
                    
                    <!-- Quantités exportées ou transformées (Campagne précédente) -->
                    <div>
                        <label for="quantities_exported" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Quantités exportées ou transformées de la campagne précédente (Tonnes) <span class="text-red-500">*</span>
                        </label>
                        <input id="quantities_exported" name="quantities_exported" type="number" step="0.01" min="0" required placeholder="Ex: 1500.50"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        <p class="text-[10px] text-slate-400 mt-1">Indiquez 0 si vous débutez cette activité.</p>
                    </div>

                    <!-- Quantités vendues localement (Campagne précédente) -->
                    <div>
                        <label for="quantities_sold" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Quantités vendues localement de la campagne précédente (Tonnes) <span class="text-red-500">*</span>
                        </label>
                        <input id="quantities_sold" name="quantities_sold" type="number" step="0.01" min="0" required placeholder="Ex: 250.00"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Quantités prévisionnelles (Campagne prochaine) -->
                    <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                        <label for="forecast_quantities" class="block text-xs font-bold text-emerald-900 uppercase mb-1">
                            Quantités prévisionnelles à exporter ou transformer pour la campagne prochaine (Tonnes) <span class="text-red-500">*</span>
                        </label>
                        <input id="forecast_quantities" name="forecast_quantities" type="number" step="0.01" min="0" required placeholder="Ex: 2000.00"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        <p class="text-[10px] text-emerald-700 mt-1 font-medium">
                            <i class="fa-solid fa-circle-info"></i> Ce champ est obligatoire pour le calcul de vos quotas réglementaires auprès du régulateur.
                        </p>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex items-center justify-between pt-4 gap-3">
                        <a href="etape3.php" class="w-1/3 bg-slate-200 hover:bg-slate-300 text-slate-700 text-center py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                            Précédent
                        </a>
                        <button type="submit" class="w-2/3 bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-700/20 transition-all flex items-center justify-center gap-2">
                            <span>Suivant</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>