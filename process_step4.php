<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['quantities_exported'] = $_POST['quantities_exported'] ?? 0;
    $_SESSION['quantities_sold'] = $_POST['quantities_sold'] ?? 0;
    $_SESSION['forecast_quantities'] = $_POST['forecast_quantities'] ?? 0;

    header('Location: etape5.php');
    exit();
}