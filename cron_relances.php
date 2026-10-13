<?php
require_once 'config.php';
require_once 'notifications.php';

// Recherche des acteurs inscrits depuis plus de 48h et toujours en attente
$stmt = $pdo->query("SELECT a.id, a.company_name, a.email, l.mobile 
                     FROM actors a 
                     LEFT JOIN legal_representatives l ON a.id = l.actor_id 
                     WHERE a.validation_status = 'en_attente' 
                     AND a.created_at <= NOW() - INTERVAL 2 DAY");
$pendingActors = $stmt->fetchAll();

$countRelances = 0;

foreach ($pendingActors as $actor) {
    if (!empty($actor['email'])) {
        $sujet = "CajouMarket - Rappel concernant votre dossier d'agrément";
        $corps = "<p>Bonjour <strong>{$actor['company_name']}</strong>,</p>
                  <p>Votre dossier de demande d'agrément est toujours en cours d'examen par le Conseil du Coton et de l'Anacarde.</p>
                  <p>Nous vous invitons à patienter ou à compléter vos pièces justificatives si requis.</p>";
        
        sendSecureEmail($actor['email'], $actor['company_name'], $sujet, $corps, $actor['id']);
        $countRelances++;
    }
}

echo "Script de relance exécuté : " . $countRelances . " notification(s) de rappel envoyée(s).";
?>