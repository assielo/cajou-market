<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Inscription (Étape 2 : Données Professionnelles)</title>
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
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Étape 2 sur 5</span>
                        <span class="text-xs font-medium text-slate-400">40%</span>
                    </div>
                    <!-- Barre de progression -->
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 40%"></div>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mt-4">Données Professionnelles & Administratives</h2>
                    <p class="text-xs text-slate-500">Renseignez vos informations légales d'enregistrement en Côte d'Ivoire.</p>
                </div>

                <!-- Formulaire Étape 2 -->
                <form class="space-y-4" action="process_step2.php" method="POST">
                    
                    <!-- N° Agrément Campagne Précédente -->
                    <div>
                        <label for="num_agreement" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            N° Agrément de la campagne précédente 
                            <i class="fa fa-question-circle text-slate-400 ml-1" title="Réservé aux structures disposant déjà d'un agrément l'année dernière."></i>
                        </label>
                        <input id="num_agreement" name="num_agreement" type="text" placeholder="Ex: AGR-2025-XXXX"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Catégorie d'acteur (Rôle opérationnel) -->
                    <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                        <label class="block text-xs font-bold text-emerald-900 uppercase mb-2">
                            Type d'opération principale <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center space-x-2 text-sm text-slate-700 cursor-pointer bg-white p-2.5 rounded-lg border border-slate-200 hover:border-emerald-500">
                                <input type="radio" name="actor_type" value="exportateur" required class="text-emerald-600 focus:ring-emerald-500">
                                <span class="font-medium text-xs">Exportateur</span>
                            </label>
                            <label class="flex items-center space-x-2 text-sm text-slate-700 cursor-pointer bg-white p-2.5 rounded-lg border border-slate-200 hover:border-emerald-500">
                                <input type="radio" name="actor_type" value="acheteur" required class="text-emerald-600 focus:ring-emerald-500">
                                <span class="font-medium text-xs">Acheteur</span>
                            </label>
                        </div>
                        <p class="text-[10px] text-amber-700 mt-2">
                            <i class="fa-solid fa-triangle-exclamation"></i> <strong>NB :</strong> Si vous intervenez simultanément dans les deux (Achat et Export), veuillez créer un compte EDI distinct pour chaque opération.
                        </p>
                    </div>

                    <!-- Catégorie d'acteur (Structure juridique) -->
                    <div>
                        <label for="agrement_category" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Catégorie d'acteur <span class="text-red-500">*</span>
                        </label>
                        <select id="agrement_category" name="agrement_category" required
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                            <option value="">Sélectionner votre catégorie...</option>
                            <option value="personne_physique">PERSONNES PHYSIQUES</option>
                            <option value="cooperative_producteurs">SOCIÉTÉS COOPÉRATIVES - COOPÉRATIVES DE PRODUCTEURS</option>
                            <option value="societe_commerciale">SOCIÉTÉS COMMERCIALES</option>
                            <option value="transformateur">TRANSFORMATEURS</option>
                        </select>
                    </div>

                    <!-- Nom / Raison sociale -->
                    <div>
                        <label for="company_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nom / Raison Sociale <span class="text-red-500">*</span>
                        </label>
                        <input id="company_name" name="company_name" type="text" required placeholder="Ex: GROUPE MAYAS SARL"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Numéro RCCM et Compte Contribuable -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="rccm_number" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Numéro RCCM <span class="text-red-500">*</span>
                            </label>
                            <input id="rccm_number" name="rccm_number" type="text" required placeholder="CI-ABJ-..."
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                        <div>
                            <label for="taxpayer_number" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Numéro Compte Contribuable (CC) <span class="text-red-500">*</span>
                            </label>
                            <input id="taxpayer_number" name="taxpayer_number" type="text" required placeholder="Ex: 20XXXXX X"
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                    </div>

                    <!-- Siège social -->
                    <div>
                        <label for="headquarters" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Siège Social <span class="text-red-500">*</span>
                        </label>
                        <input id="headquarters" name="headquarters" type="text" required placeholder="Ex: Abidjan, Plateau, Avenue..."
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Établissements secondaires -->
                    <div>
                        <label for="secondary_locations" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Lieu(x) des Établissements Secondaires <span class="text-red-500">*</span>
                        </label>
                        <input id="secondary_locations" name="secondary_locations" type="text" required placeholder="Ex: Entrepôts à Bouaké, Korhogo, Bondoukou"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex items-center justify-between pt-4 gap-3">
                        <a href="index.php" class="w-1/3 bg-slate-200 hover:bg-slate-300 text-slate-700 text-center py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
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