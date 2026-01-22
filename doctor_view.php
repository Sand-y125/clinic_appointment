

<div class="page-header">
    <h1><i class="fas fa-user-md"></i> Doctor Details</h1>
    <div>
        <a href="doctor_edit.php" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="doctors.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-header">
        <span class="badge badge-success"></span>
    </div>
    
    <div class="detail-grid">
        <div class="detail-item">
            <label><i class="fas fa-envelope"></i> Email:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-phone"></i> Phone:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-id-card"></i> License Number:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-graduation-cap"></i> Experience:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-dollar-sign"></i> Consultation Fee:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-calendar"></i> Available Days:</label>
        </div>
    </div>
</div>

<div class="appointments-section">
    <h2><i class="fas fa-calendar-alt"></i> Appointment Schedule</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Patient</th>
                <th>Contact</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        
    </table>
    <p class="text-muted">No appointments scheduled for this doctor.</p>
</div>

<?php include '../includes/footer.php'; ?>
