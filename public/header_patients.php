<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', '/~np03cs4a240022/clinic_appointment');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/staff/assest/css/style.css">
</head>
<body>


<header class="navbar">
    <div class="container">
    <h2 class="nav-brand">
    <i class="fas fa-clinic-medical"></i>
    Sandy Medical Clinic
    </h2>

        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="appointment_book.php">Book Appointment</a></li>
        </ul>


    </div>
    
</header>

<main class="main-content">
    <div class="container">
