
<?php
require_once __DIR__ . '/session.php';

$current = basename($_SERVER['PHP_SELF']);

if (!in_array($current, ['login.php', 'dashboard.php', 'appointment_book.php'])) {
    require_once __DIR__ . '/auth.php';
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Appointment System></title>
    <link rel="stylesheet" href="/clinic_appointment/staff/assest/css/style.css">
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

    <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
    <li class="dropdown">
    <a href="#"><i class="fas fa-user-injured"></i> Patients <i class="fas fa-chevron-down"></i></a>
    <ul class="dropdown-menu">

    <li><a href="patients.php">View All</a></li>
    <li><a href="patient_add.php">Add New</a></li>
    </ul>
    </li>


    <li class="dropdown">
    <a href="#"><i class="fas fa-user-md"></i> Doctors <i class="fas fa-chevron-down"></i></a>
    <ul class="dropdown-menu">
        <li><a href="doctors.php">View All</a></li>
        <li><a href="doctor_add.php">Add New</a></li>
        </ul>
    </li>

        <li class="dropdown">
        <a href="#"><i class="fas fa-calendar-check"></i> Appointments <i class="fas fa-chevron-down"></i></a>
        <ul class="dropdown-menu">
        <li><a href="appointments.php">View All</a></li>
        <li><a href="appointment_add.php">Book New</a></li>
        </ul>


        </li>
        <li><a href="search.php"><i class="fas fa-search"></i> Search</a></li>
        </ul>
        </div>

        

    </nav>
    


   <main class="main-content">
        <div class="container">
            <?php
            $flash = getFlashMessage();     //  To Display flash messages
            if ($flash):
            ?>
            <div class="alert alert-<?php echo escape($flash['type']); ?>">
                <i class="fas fa-<?php echo $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo escape($flash['message']); ?>
            </div>
            <?php endif; ?>
