

<div class="page-header">
    <h1><i class="fas fa-user-edit"></i> Edit Patient</h1>
</div>


<form method="POST" action="" class="form-card">
    <input type="hidden" name="csrf_token">
    
    <div class="form-row">
        <div class="form-group">
            <label for="first_name">First Name <span class="required">*</span></label>
            <input type="text" id="first_name" name="first_name"  required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name <span class="required">*</span></label>
            <input type="text" id="last_name" name="last_name"  required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone <span class="required">*</span></label>
            <input type="tel" id="phone" name="phone" required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
        </div>
        
        
    </div>
    
    <div class="form-group">
        <label for="address">Address</label>
    </div>
    
    <div class="form-group">
        <label for="medical_history">Medical History</label>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Patient
        </button>
        <a href="patients.php" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
