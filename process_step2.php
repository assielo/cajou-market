<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['num_agreement'] = $_POST['num_agreement'] ?? '';
    $_SESSION['actor_type'] = $_POST['actor_type'] ?? '';
    $_SESSION['agrement_category'] = $_POST['agrement_category'] ?? '';
    $_SESSION['company_name'] = $_POST['company_name'] ?? '';
    $_SESSION['rccm_number'] = $_POST['rccm_number'] ?? '';
    $_SESSION['taxpayer_number'] = $_POST['taxpayer_number'] ?? '';
    $_SESSION['headquarters'] = $_POST['headquarters'] ?? '';
    $_SESSION['secondary_locations'] = $_POST['secondary_locations'] ?? '';

    header('Location: etape3.php');
    exit();
}