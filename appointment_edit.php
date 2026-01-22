

<div class="page-header">
    <h1><i class="fas fa-calendar-edit"></i> Edit Appointment</h1>
</div>


<form method="POST" action="" class="form-card" id="appointmentForm">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    
<div class="form-row">
<div class="form-group">
<label for="patient_id">Patient <span class="required">*</span></label>
<select id="patient_id" name="patient_id" required>
<option value="">Select Patient</option>



</select>
    </div>
<div class="form-group">
<label for="doctor_id">Doctor <span class="required">*</span></label>
<select id="doctor_id" name="doctor_id" required>
<option value="">Select Doctor</option>
    
</select>



    </div>
    </div>
    



    <div class="form-row">
    <div class="form-group">
    <label for="appointment_date">Appointment Date <span class="required">*</span></label>
    <input type="date" id="appointment_date" name="appointment_date" 
                   required>
        </div>





        
        <div class="form-group">
<label for="appointment_time">Appointment Time <span class="required">*</span></label>
<select id="appointment_time" name="appointment_time" required>
</select>
<small id="availability-message" class="availability-message"></small>
        </div>
    </div>
    
    <div class="form-group">
        <label for="reason">Reason for Visit <span class="required">*</span></label>
        <textarea id="reason" name="reason" rows="4" required></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Appointment
        </button>
        <a href="appointments.php" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
