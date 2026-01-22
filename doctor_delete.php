
include '../includes/header.php';


<div class="page-header">
    <h1><i class="fas fa-user-edit"></i> Edit Doctor</h1>
</div>


<form method="POST" action="" class="form-card">
    <input type="hidden" name="csrf_token">
    
    <div class="form-row">
        <div class="form-group">
            <label for="first_name">First Name <span class="required">*</span></label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name <span class="required">*</span></label>
            <input type="text" id="last_name" name="last_name required">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone <span class="required">*</span></label>
            <input type="tel" id="phone" name="phone"  required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="specialization">Specialization <span class="required">*</span></label>
            <input type="text" id="specialization" name="specialization" required>
        </div>
        
        <div class="form-group">
            <label for="license_number">License Number <span class="required">*</span></label>
            <input type="text" id="license_number" name="license_number"required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="years_of_experience">Years of Experience <span class="required">*</span></label>
            <input type="number" id="years_of_experience" name="years_of_experience" min="0"required>
        </div>
        
        <div class="form-group">
            <label for="consultation_fee">Consultation Fee ($) <span class="required">*</span></label>
            
        </div>
    </div>
    
    <div class="form-group">
        <label>Available Days <span class="required">*</span></label>
        
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Doctor
        </button>
        <a href="doctors.php" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
