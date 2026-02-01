<?php
require_once __DIR__ . '/session.php';

$current = basename($_SERVER['PHP_SELF']);

if (!in_array($current, ['login.php'])) {
    require_once __DIR__ . '/auth.php';
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';

/* Base URL (adjust only this if project folder name changes) */
if (!defined('BASE_URL')) {
    define('BASE_URL', '/~np03cs4a240022/clinic_appointment');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Appointment System</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/staff/assest/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <i class="fas fa-clinic-medical"></i>
            <span>Clinic Appointment System</span>
        </div>

        <ul class="nav-menu">
            <li><a href="<?= BASE_URL ?>/staff/dashboard.php"><i class="fas fa-home"></i> Home</a></li>

            <li class="dropdown">
                <a href="#"><i class="fas fa-user-injured"></i> Patients <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= BASE_URL ?>/staff/patients.php">View All</a></li>
                    <li><a href="<?= BASE_URL ?>/staff/patient_add.php">Add New</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#"><i class="fas fa-user-md"></i> Doctors <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= BASE_URL ?>/staff/doctors.php">View All</a></li>
                    <li><a href="<?= BASE_URL ?>/staff/doctor_add.php">Add New</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#"><i class="fas fa-calendar-check"></i> Appointments <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= BASE_URL ?>/staff/appointments.php">View All</a></li>
                    <li><a href="<?= BASE_URL ?>/staff/appointment_add.php">Book New</a></li>
                </ul>
            </li>

            <li><a href="<?= BASE_URL ?>/staff/search.php"><i class="fas fa-search"></i> Search</a></li>
        </ul>
    </div>
</nav>

<main class="main-content">
    <div class="container">
        <?php
        $flash = getFlashMessage();
        if ($flash):
        ?>
        <div class="alert alert-<?= escape($flash['type']); ?>">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?= escape($flash['message']); ?>
        </div>
        <?php endif; ?>
