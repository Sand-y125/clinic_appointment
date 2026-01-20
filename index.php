

<div class="dashboard">
 <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    
<div class="stats-grid">
    <div class="stat-card stat-primary">
    <div class="stat-icon">
<i class="fas fa-user-injured"></i>
    </div>
        <div class="stat-details">
        <p>Total Patients</p>
        </div>
        </div>
        
<div class="stat-card stat-success">
<div class="stat-icon">
    <i class="fas fa-user-md"></i>
    </div>
    <div class="stat-details">
        <p>Total Doctors</p>
        </div>
        </div>

        
<div class="stat-card stat-info">
    <div class="stat-icon">
        <i class="fas fa-calendar-check"></i>

            </div>
 <div class="stat-details">
    <p>Scheduled Appointments</p>


    </div>

    </div>

        
<div class="stat-card stat-warning">
        <div class="stat-icon">
        <i class="fas fa-clock"></i>

    </div>
<div class="stat-details">
        <p>Today's Appointments</p>
    </div>

    </div>


    </div>
    
<div class="quick-actions">
    <h2><i class="fas fa-bolt"></i> Quick Actions</h2>

<div class="action-buttons">
<a href="patient_add.php" class="btn btn-primary">
    <i class="fas fa-user-plus"></i> Add New Patient

    </a>
            
<a href="doctor_add.php" class="btn btn-success">
    <i class="fas fa-user-md"></i> Add New Doctor
    </a>

<a href="appointment_add.php" class="btn btn-info">
    <i class="fas fa-calendar-plus"></i> Book Appointment
    </a>
    <a href="search.php" class="btn btn-warning">
    <i class="fas fa-search"></i> Search


    </a>
        </div>


    </div>
    
    
    </div>

<?php include '../includes/footer.php'; ?>
