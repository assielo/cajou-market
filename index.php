<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Inscription (Étape 1)</title>
    <!-- Tailwind CSS pour un design responsive mobile-first -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center py-6 px-4 sm:px-6 lg:px-8">
        <!-- En-tête / Logo -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div class="inline-flex items-center justify-center bg-emerald-800 text-white p-3 rounded-full shadow-md mb-2">
                <i class="fa-solid fa-seedling text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">CajouMarket</h1>
            <p class="text-xs text-slate-600 mt-1 uppercase tracking-wider font-semibold">
                Plateforme Web & Mobile - Filière Anacarde CI
            </p>
        </div>

        <!-- Conteneur du Formulaire -->
        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
                
                <!-- En-tête de l'étape -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Étape 1 sur 5</span>
                        <span class="text-xs font-medium text-slate-400">20%</span>
                    </div>
                    <!-- Barre de progression -->
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 20%"></div>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mt-4">Sécurité & Quittance d'Agrément</h2>
                    <p class="text-xs text-slate-500">Sécurisez votre accès et joignez votre reçu officiel.</p>
                </div>

                <!-- Formulaire Étape 1 -->
                <form class="space-y-5" action="process_step1.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <input id="password" name="password" type="password" required placeholder="••••••••"
                                class="block w-full px-3 py-3 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-slate-400 hover:text-slate-600" id="togglePassword">
                                <i class="fa fa-eye text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div>
                        <label for="confirm_password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Confirmez le mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input id="confirm_password" name="confirm_password" type="password" required placeholder="••••••••"
                            class="block w-full px-3 py-3 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                    </div>

                    <!-- Reçu de paiement -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Reçu de paiement de l'agrément <span class="text-slate-400 font-normal">(PDF / Image)</span>
                        </label>
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-emerald-600 transition-colors bg-slate-50">
                            <div class="space-y-1 text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-emerald-600 mb-1"></i>
                                <div class="flex text-xs text-slate-600 justify-center">
                                    <label for="payment_receipt" class="relative cursor-pointer rounded-md font-semibold text-emerald-700 hover:text-emerald-500 focus-within:outline-none">
                                        <span>Téléverser le fichier</span>
                                        <input id="payment_receipt" name="payment_receipt" type="file" class="sr-only" accept=".pdf,.png,.jpg,.jpeg">
                                    </label>
                                </div>
                                <p class="text-[10px] text-slate-400">PDF, PNG, JPG jusqu'à 10 Mo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de navigation (Adaptés tactile mobile) -->
                    <div class="flex items-center justify-between pt-4 gap-3">
                        <button type="button" disabled class="w-1/3 bg-slate-100 text-slate-400 py-3 rounded-xl text-xs font-bold uppercase tracking-wider cursor-not-allowed">
                            Précédent
                        </button>
                        <button type="submit" class="w-2/3 bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-700/20 transition-all flex items-center justify-center gap-2">
                            <span>Suivant</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>

                </form>

                <!-- Lien connexion -->
                <div class="mt-6 text-center border-t border-slate-100 pt-4">
                    <a href="login.php" class="text-xs font-semibold text-emerald-700 hover:text-emerald-600">
                        Vous avez déjà un compte ? <span class="underline">Se connecter</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Script gestion visibilité mot de passe
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>