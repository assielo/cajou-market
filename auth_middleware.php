<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour vérifier si l'utilisateur est connecté et possède le rôle requis
function checkAccess($requiredRole = null) {
    if (!isset($_SESSION['actor_id']) || !isset($_SESSION['role'])) {
        header('Location: index.php');
        exit();
    }

    if ($requiredRole !== null && $_SESSION['role'] !== $requiredRole) {
        // Redirection vers le dashboard par défaut si le rôle ne correspond pas
        header('Location: dashboard.php?error=unauthorized');
        exit();
    }
}

// Fonction utilitaire pour récupérer le libellé du rôle en français
function getRoleLabel($role) {
    switch ($role) {
        case 'admin_cca': return 'Administrateur CCA';
        case 'gestionnaire_stock': return 'Gestionnaire de Stock';
        case 'acheteur_b2b': return 'Acheteur / Exportateur B2B';
        default: return 'Acteur';
    }
}
?>