
<div class="page-header">
    <h1><i class="fas fa-user"></i> Patient Details</h1>
    <div>
        <a href="patient_edit.php" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="patients.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="detail-card">
    
    <div class="detail-grid">
        <div class="detail-item">
            <label><i class="fas fa-envelope"></i> Email:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-phone"></i> Phone:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-birthday-cake"></i> Date of Birth:</label>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-venus-mars"></i> Gender:</label>
        </div>
        
        <div class="detail-item full-width">
            <label><i class="fas fa-map-marker-alt"></i> Address:</label>
        </div>
        
        <div class="detail-item full-width">
            <label><i class="fas fa-notes-medical"></i> Medical History:</label>
        </div>
    </div>
</div>

<div class="appointments-section">
    <h2><i class="fas fa-calendar-alt"></i> Appointment History</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Doctor</th>
                <th>Specialization</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <p class="text-muted">No appointments found for this patient.</p>
</div>

<?php include '../includes/footer.php'; ?>
