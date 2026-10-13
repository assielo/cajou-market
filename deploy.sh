#!/bin/bash
set -e

echo "🚀 Début du déploiement de CajouMarket..."

# 1. Mise en mode maintenance
touch /var/www/html/cajou_market/.maintenance

# 2. Récupération de la dernière version Git
git pull origin main

# 3. Installation des dépendances Composer sans dépendances de dev
composer install --no-dev --optimize-autoloader

# 4. Exécution des migrations BDD (si nécessaire)
php scripts/migrate.php

# 5. Optimisation des permissions de fichiers
chmod -R 775 uploads/ backups/
chown -R www-data:www-data /var/www/html/cajou_market

# 6. Fin du mode maintenance
rm -f /var/www/html/cajou_market/.maintenance

echo "✅ Déploiement CajouMarket terminé avec succès !"