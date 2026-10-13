<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Inscription (Étape 3 : Représentant Légal)</title>
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
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Étape 3 sur 5</span>
                        <span class="text-xs font-medium text-slate-400">60%</span>
                    </div>
                    <!-- Barre de progression -->
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 60%"></div>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mt-4">Données Personnelles du Représentant Légal</h2>
                    <p class="text-xs text-slate-500">Identité, qualité et contacts du dirigeant habilité.</p>
                </div>

                <!-- Formulaire Étape 3 -->
                <form class="space-y-4" action="process_step3.php" method="POST">
                    
                    <!-- Nom & Prénom(s) -->
                    <div>
                        <label for="company_manager_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nom & Prénom(s) du Représentant <span class="text-red-500">*</span>
                        </label>
                        <input id="company_manager_name" name="company_manager_name" type="text" required placeholder="Ex: Kouassi Jean-Marc"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Date et Lieu de naissance -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="company_manager_date_naissance" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Date de Naissance <span class="text-red-500">*</span>
                            </label>
                            <input id="company_manager_date_naissance" name="company_manager_date_naissance" type="date" min="1950-01-01" max="2008-12-31" required
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                        <div>
                            <label for="company_manager_lieu_naissance" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Lieu de Naissance <span class="text-red-500">*</span>
                            </label>
                            <input id="company_manager_lieu_naissance" name="company_manager_lieu_naissance" type="text" required placeholder="Ex: Bouaké"
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                    </div>

                    <!-- Qualité / Fonction -->
                    <div>
                        <label for="company_manager_function" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Qualité / Mandat Social <span class="text-red-500">*</span>
                        </label>
                        <select id="company_manager_function" name="company_manager_function" required
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                            <option value="">Sélectionner la qualité...</option>
                            <option value="PCG">PCG (Président du Conseil de Gestion)</option>
                            <option value="PCA">PCA (Président du Conseil d'Administration)</option>
                            <option value="GERANT">GÉRANT</option>
                            <option value="DIRECTEUR GENERAL">DIRECTEUR GÉNÉRAL</option>
                            <option value="ADMINISTRATEUR GENERAL">ADMINISTRATEUR GÉNÉRAL</option>
                        </select>
                    </div>

                    <!-- Type de pièce d'identité et Numéro -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="company_manager_identity_piece" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Type de Pièce d'Identité <span class="text-red-500">*</span>
                            </label>
                            <select id="company_manager_identity_piece" name="company_manager_identity_piece" required
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                                <option value="">Sélectionner...</option>
                                <option value="Carte nationale d'identité">Carte Nationale d'Identité (CNI)</option>
                                <option value="Passeport">Passeport</option>
                                <option value="Attestation d'identité">Attestation d'identité</option>
                                <option value="Permis de conduire">Permis de conduire</option>
                                <option value="Carte de résident">Carte de résident</option>
                                <option value="Certificat de nationalité">Certificat de nationalité</option>
                                <option value="Extrait de naissance">Extrait de naissance</option>
                            </select>
                        </div>
                        <div>
                            <label for="company_manager_n_cni" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Numéro de la Pièce <span class="text-red-500">*</span>
                            </label>
                            <input id="company_manager_n_cni" name="company_manager_n_cni" type="text" required placeholder="Ex: C002849..."
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                    </div>

                    <!-- Résidence (Pays, Région, Département, S/P, Village) -->
                    <div>
                        <label for="company_manager_city" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Résidence (Pays, Région, Département, S/P, Village) <span class="text-red-500">*</span>
                        </label>
                        <input id="company_manager_city" name="company_manager_city" type="text" required placeholder="Ex: Côte d'Ivoire, Gbêkê, Bouaké, Bouaké, Belleville"
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Téléphone mobile et Email du représentant -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="company_manager_mobile" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Téléphone Mobile <span class="text-red-500">*</span>
                            </label>
                            <input id="company_manager_mobile" name="company_manager_mobile" type="tel" required placeholder="Ex: +225 0700000000"
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                        <div>
                            <label for="company_manager_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Adresse Email <span class="text-red-500">*</span>
                            </label>
                            <input id="company_manager_email" name="company_manager_email" type="email" required placeholder="dirigeant@entreprise.ci"
                                class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex items-center justify-between pt-4 gap-3">
                        <a href="etape2.php" class="w-1/3 bg-slate-200 hover:bg-slate-300 text-slate-700 text-center py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
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