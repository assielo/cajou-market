#!/bin/bash

# Configuration des variables
BACKUP_DIR="/var/www/html/cajou_market/backups"
WEB_DIR="/var/www/html/cajou_market"
DATE=$(date +"%Y-%m-%d_%H-%M-%S")

# Paramètres de la base de données MySQL
DB_NAME="cajou_market_db"
DB_USER="cajou_user"
DB_PASS="cajou_password"
DB_HOST="localhost"

# Création du dossier de sauvegarde s'il n'existe pas
mkdir -p "$BACKUP_DIR"

# 1. Sauvegarde de la base de données MySQL (avec compression gzip)
echo "Début de la sauvegarde de la base de données $DB_NAME..."
mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" | gzip > "$BACKUP_DIR/db_${DB_NAME}_$DATE.sql.gz"

# 2. Sauvegarde des dossiers de reçus et fichiers téléversés
echo "Début de la sauvegarde des dossiers de reçus (uploads)..."
if [ -d "$WEB_DIR/uploads" ]; then
    tar -czf "$BACKUP_DIR/uploads_$DATE.tar.gz" -C "$WEB_DIR" uploads
else
    echo "Dossier uploads introuvable, sauvegarde ignorée pour les fichiers."
fi

# 3. Nettoyage automatique : Suppression des sauvegardes de plus de 30 jours
echo "Nettoyage des anciennes sauvegardes (> 30 jours)..."
find "$BACKUP_DIR" -type f -mtime +30 -exec rm {} \;

echo "Sauvegarde CajouMarket terminée avec succès le $(date)."