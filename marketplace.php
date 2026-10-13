<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CajouMarket - Bourse B2B & Négoce d'Anacarde (PWIC / CCA)</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .bg-institutional { background-color: #1E5705; }
        .text-institutional { color: #1E5705; }
        .btn-official { border-style: solid; color: #ffffff; border-color: #f38423; background-color: #f38423; border-radius: 4px; font-size: 0.85rem; transition: all 0.3s; }
        .btn-official:hover { color: #ffffff; border-color: #4C942D; background-color: #4C942D; }
        .service_1_single { background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.3s; }
        .service_1_single:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex">
        
        <!-- Sidebar Navigation (Institutionnelle) -->
        <aside class="hidden md:flex flex-col w-64 bg-institutional text-white p-5 justify-between shadow-xl">
            <div>
                <div class="flex items-center gap-3 mb-8 px-2 border-b border-emerald-800 pb-4">
                    <div class="bg-white/10 p-2.5 rounded-xl">
                        <i class="fa-solid fa-seedling text-xl text-amber-400"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-base tracking-wide">CajouMarket</h1>
                        <span class="text-[10px] text-emerald-300 uppercase tracking-wider">Portail PWIC / CCA</span>
                    </div>
                </div>

                <nav class="space-y-1.5">
                    <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-chart-pie w-5"></i> Tableau de bord
                    </a>
                    <a href="marketplace.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-semibold shadow-sm">
                        <i class="fa-solid fa-store w-5"></i> Bourse B2B & Produits
                    </a>
                    <a href="logistique_sigema.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-emerald-200 hover:bg-emerald-800 text-xs font-medium transition-all">
                        <i class="fa-solid fa-truck-ramp-box w-5"></i> Logistique & Sigema
                    </a>
                </nav>
            </div>

            <div class="border-t border-emerald-800 pt-4">
                <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-900/40 text-xs font-medium transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <!-- Top Navbar -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-10 shadow-sm">
                <h2 class="text-xs md:text-sm font-bold text-slate-800 uppercase tracking-wider">Bourse B2B - Catalogue Officiel et Mise en Relation</h2>
                <div class="flex items-center gap-3">
                    <button onclick="openCartModal()" class="relative bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> 
                        <span>Sélection (<span id="cart-count">0</span>)</span>
                    </button>
                    <button onclick="openModal()" class="btn-official px-4 py-2 text-xs font-bold shadow flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Publier une Offre
                    </button>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                
                <!-- Barre de Recherche et Filtres par Taxonomie -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Filtrer par Produit</label>
                        <select id="filter-type" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none">
                            <option value="">Tous les produits</option>
                            <option value="entiere">Amande de cajou entière</option>
                            <option value="brisee">Amande de cajou brisée</option>
                            <option value="beurre">Beurre de cajou</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Zone de Production</label>
                        <select id="filter-zone" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none">
                            <option value="">Toutes les zones (PND)</option>
                            <option value="Bouaké">Bouaké (Gbêkê)</option>
                            <option value="Korhogo">Korhogo (Poro)</option>
                            <option value="Bondoukou">Bondoukou (Gontougo)</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button onclick="applyFilters()" class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 rounded-xl transition-all shadow">
                            <i class="fa-solid fa-filter mr-1"></i> Appliquer les filtres
                        </button>
                    </div>
                </div>

                <!-- Grille des Produits (Inspirée du code source avec images locales) -->
                <section class="service_one">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="offers-grid">
                        
                        <!-- Produit 1 : Amande de cajou entière -->
                        <div class="service_1_single offer-card flex flex-col justify-between p-4" data-type="entiere" data-zone="Bouaké">
                            <div>
                                <div class="relative h-48 rounded-lg overflow-hidden bg-slate-100 mb-4">
                                    <img src="assets/images/products/amende-entiere.jpg" alt="Amande de cajou entière" class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 bg-institutional text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                                        WW320 - Premium
                                    </span>
                                </div>
                                <div class="content space-y-2">
                                    <h3 class="font-bold text-slate-900 text-base">Amande de cajou entière[cite: 1]</h3>
                                    <p class="text-xs text-slate-500">Amandes blanches calibrées, séchées et conditionnées sous vide pour l'exportation ou la transformation locale.</p>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="text-emerald-700 font-extrabold text-sm">3,500 FCFA <span class="text-[10px] text-slate-400">/ kg</span></span>
                                        <span class="text-xs text-slate-600 font-bold">Stock : 15 Tonnes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-4">
                                <button onclick="openChatModal('Usine MAYAS - Bouaké', 'Amande entière')" class="text-xs text-institutional font-bold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-comments"></i> Négocier
                                </button>
                                <button onclick="addToSelection('Amande de cajou entière (15T)', 3500)" class="btn-official px-3 py-1.5 shadow flex items-center gap-1">
                                    <i class="fa-solid fa-cart-plus"></i> Sélectionner
                                </button>
                            </div>
                        </div>

                        <!-- Produit 2 : Amande de cajou brisée -->
                        <div class="service_1_single offer-card flex flex-col justify-between p-4" data-type="brisee" data-zone="Korhogo">
                            <div>
                                <div class="relative h-48 rounded-lg overflow-hidden bg-slate-100 mb-4">
                                    <img src="assets/images/products/brises.jpg" alt="Amande de cajou brisée" class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 bg-amber-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                                        First Splits
                                    </span>
                                </div>
                                <div class="content space-y-2">
                                    <h3 class="font-bold text-slate-900 text-base">Amande de cajou brisée[cite: 1]</h3>
                                    <p class="text-xs text-slate-500">Morceaux d'amandes de premier choix, idéaux pour les industries agroalimentaires et la confiserie.</p>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="text-emerald-700 font-extrabold text-sm">2,800 FCFA <span class="text-[10px] text-slate-400">/ kg</span></span>
                                        <span class="text-xs text-slate-600 font-bold">Stock : 8 Tonnes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-4">
                                <button onclick="openChatModal('Coopérative CAPKOR - Korhogo', 'Amande brisée')" class="text-xs text-institutional font-bold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-comments"></i> Négocier
                                </button>
                                <button onclick="addToSelection('Amande de cajou brisée (8T)', 2800)" class="btn-official px-3 py-1.5 shadow flex items-center gap-1">
                                    <i class="fa-solid fa-cart-plus"></i> Sélectionner
                                </button>
                            </div>
                        </div>

                        <!-- Produit 3 : Beurre de cajou -->
                        <div class="service_1_single offer-card flex flex-col justify-between p-4" data-type="beurre" data-zone="Bondoukou">
                            <div>
                                <div class="relative h-48 rounded-lg overflow-hidden bg-slate-100 mb-4">
                                    <img src="assets/images/products/beurre-de-cajou.jpg" alt="Beurre de cajou" class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 bg-amber-800 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                                        100% Pur Naturel
                                    </span>
                                </div>
                                <div class="content space-y-2">
                                    <h3 class="font-bold text-slate-900 text-base">Beurre de cajou[cite: 1]</h3>
                                    <p class="text-xs text-slate-500">Pâte onctueuse obtenue à partir d'amandes torréfiées de qualité supérieure, sans additifs chimiques.</p>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="text-emerald-700 font-extrabold text-sm">4,200 FCFA <span class="text-[10px] text-slate-400">/ kg</span></span>
                                        <span class="text-xs text-slate-600 font-bold">Stock : 2.5 Tonnes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-4">
                                <button onclick="openChatModal('Unité Transformation Bondoukou', 'Beurre de cajou')" class="text-xs text-institutional font-bold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-comments"></i> Négocier
                                </button>
                                <button onclick="addToSelection('Beurre de cajou (2.5T)', 4200)" class="btn-official px-3 py-1.5 shadow flex items-center gap-1">
                                    <i class="fa-solid fa-cart-plus"></i> Sélectionner
                                </button>
                            </div>
                        </div>

                    </div>
                </section>

            </div>
        </main>
    </div>

    <!-- Modal Publication d'Offre -->
    <div id="offerModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Publier une Offre de Produit Transformé</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form class="space-y-3" onsubmit="event.preventDefault(); closeModal(); alert('Offre publiée avec succès sur la plateforme B2B !');">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Type de Produit</label>
                        <select required class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none">
                            <option value="entiere">Amande de cajou entière</option>
                            <option value="brisee">Amande de cajou brisée</option>
                            <option value="beurre">Beurre de cajou</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Zone de Production</label>
                        <select required class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none">
                            <option value="Bouaké">Bouaké</option>
                            <option value="Korhogo">Korhogo</option>
                            <option value="Bondoukou">Bondoukou</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Prix (FCFA/kg)</label>
                        <input type="number" required placeholder="3500" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Stock (Tonnes)</label>
                        <input type="number" required placeholder="10" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Image du Produit</label>
                    <input type="file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-institutional">
                </div>
                <div class="flex justify-end gap-2 pt-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Annuler</button>
                    <button type="submit" class="btn-official px-4 py-2 text-xs font-bold shadow">Valider la Publication</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Négociation / Messagerie B2B -->
    <div id="chatModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-comments text-institutional"></i>
                    Négociation : <span id="chat-vendor" class="text-institutional">Vendeur</span>
                </h3>
                <button onclick="closeChatModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl h-40 overflow-y-auto text-xs space-y-2">
                <div class="bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm">
                    <span class="text-[10px] text-slate-400 font-bold block">Canal Sécurisé B2B</span>
                    <p class="text-slate-700 mt-0.5">Discutez directement des conditions d'enlèvement et des volumes pour le produit : <strong id="chat-product">Produit</strong>.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <input type="text" placeholder="Proposition de prix ou message..." class="flex-1 px-3 py-2 border border-slate-300 rounded-xl text-xs focus:outline-none">
                <button onclick="alert('Message de négociation transmis au vendeur !')" class="btn-official px-4 py-2 text-xs font-bold shadow">Envoyer</button>
            </div>
        </div>
    </div>

    <!-- Modal Panier / Pro Forma -->
    <div id="cartModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Sélection & Contrat Pro Forma</h3>
                <button onclick="closeCartModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div id="cart-items" class="space-y-2 max-h-48 overflow-y-auto text-xs text-slate-600">
                <p class="text-slate-400 italic">Aucun produit sélectionné.</p>
            </div>
            <div class="border-t border-slate-100 pt-3 flex justify-between items-center font-bold text-slate-900 text-sm">
                <span>Total :</span>
                <span id="cart-total">0 Article(s)</span>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeCartModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Fermer</button>
                <button onclick="alert('Pro Forma généré avec succès pour vos déclarations !')" class="btn-official px-4 py-2 text-xs font-bold shadow">Générer le Pro Forma</button>
            </div>
        </div>
    </div>

    <script>
        let selectedLots = [];

        function openModal() { document.getElementById('offerModal').classList.remove('hidden'); }
        function closeModal() { document.getElementById('offerModal').classList.add('hidden'); }
        
        function openChatModal(vendorName, productName) {
            document.getElementById('chat-vendor').innerText = vendorName;
            document.getElementById('chat-product').innerText = productName;
            document.getElementById('chatModal').classList.remove('hidden');
        }
        function closeChatModal() { document.getElementById('chatModal').classList.add('hidden'); }

        function openCartModal() { document.getElementById('cartModal').classList.remove('hidden'); renderCart(); }
        function closeCartModal() { document.getElementById('cartModal').classList.add('hidden'); }

        function addToSelection(title, price) {
            selectedLots.push({title, price});
            document.getElementById('cart-count').innerText = selectedLots.length;
            alert(title + " ajouté à votre sélection.");
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            if(selectedLots.length === 0) {
                container.innerHTML = '<p class="text-slate-400 italic">Aucun produit sélectionné.</p>';
                document.getElementById('cart-total').innerText = '0 Article(s)';
                return;
            }
            let html = '';
            selectedLots.forEach((lot) => {
                html += `<div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl">
                    <span><strong>${lot.title}</strong></span>
                    <span class="text-emerald-700 font-bold">${lot.price} FCFA/kg</span>
                </div>`;
            });
            container.innerHTML = html;
            document.getElementById('cart-total').innerText = selectedLots.length + ' Article(s)';
        }

        function applyFilters() {
            const type = document.getElementById('filter-type').value;
            const zone = document.getElementById('filter-zone').value;

            document.querySelectorAll('.offer-card').forEach(card => {
                const cardType = card.getAttribute('data-type');
                const cardZone = card.getAttribute('data-zone');

                let match = true;
                if(type && cardType !== type) match = false;
                if(zone && cardZone !== zone) match = false;

                card.style.display = match ? 'flex' : 'none';
            });
        }
    </script>
</body>
</html>