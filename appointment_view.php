
include '../includes/header.php';



<div class="page-header">
    <h1><i class="fas fa-calendar-alt"></i> Appointment Details</h1>
    <div>
        <a href="appointment_edit.php" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="appointments.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="appointment-detail">
    <div class="detail-card">
        <div class="detail-header">
            <h2>Appointment </h2>
        
        </div>
        
        <div class="appointment-info">
            <div class="info-section">
                <h3><i class="fas fa-calendar"></i> Appointment Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Date:</label>
                    </div>
                    <div class="detail-item">
                        <label>Time:</label>
                    </div>
                    <div class="detail-item full-width">
                        <label>Reason for Visit:</label>
                    </div>
                </div>
            </div>
            
            <div class="info-section">
                <h3><i class="fas fa-user-injured"></i> Patient Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Name:</label>
                        <span>
                            <a href="patient_view.php">
                            </a>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Email:</label>
                    </div>
                    <div class="detail-item">
                        <label>Phone:</label>
                    </div>
                </div>
            </div>
            
            <div class="info-section">
                <h3><i class="fas fa-user-md"></i> Doctor Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Name:</label>
                        <span>
                            <a href="doctor_view.php">
                                
                            </a>
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Specialization:</label>
                    </div>
                    <div class="detail-item">
                        <label>Consultation Fee:</label>
                    </div>
                </div>
            </div>
            
            <div class="info-section">
                <h3><i class="fas fa-sticky-note"></i> Notes</h3>
            </div>
        </div>
    </div>
    
    <div class="status-update-card">
        <h3><i class="fas fa-edit"></i> Update Status</h3>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token">
            <input type="hidden" name="update_status" value="1">
            
            <div class="form-group">
                <label for="status">Status:</label>
            
            </div>
            
            <div class="form-group">
                <label for="notes">Notes:</label>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Status
            </button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
