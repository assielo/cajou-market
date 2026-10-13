<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['company_manager_name'] = $_POST['company_manager_name'] ?? '';
    $_SESSION['company_manager_date_naissance'] = $_POST['company_manager_date_naissance'] ?? '';
    $_SESSION['company_manager_lieu_naissance'] = $_POST['company_manager_lieu_naissance'] ?? '';
    $_SESSION['company_manager_function'] = $_POST['company_manager_function'] ?? '';
    $_SESSION['company_manager_identity_piece'] = $_POST['company_manager_identity_piece'] ?? '';
    $_SESSION['company_manager_n_cni'] = $_POST['company_manager_n_cni'] ?? '';
    $_SESSION['company_manager_city'] = $_POST['company_manager_city'] ?? '';
    $_SESSION['company_manager_mobile'] = $_POST['company_manager_mobile'] ?? '';
    $_SESSION['company_manager_email'] = $_POST['company_manager_email'] ?? '';

    header('Location: etape4.php');
    exit();
}