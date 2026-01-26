<?php

include '../includes/header.php';
require_once '../includes/session.php'; //



$pdo = getDB();

$errors  = [];


$patients = $pdo -> query (" SELECT id , CONCAT (first_name, ' ', last_name) AS name FROM patients ORDER BY last_name , first_name")-> fetchAll();


$doctors =    $pdo-> query("SELECT id, CONCAT(first_name, ' ', last_name) AS name, specialization FROM doctors ORDER BY last_name, first_name") -> fetchAll();


if ( $_SERVER['REQUEST_METHOD']  ==  'POST') {

    if ( !isset ($_POST ['csrf_token'] ) || !verifyCSRFToken($_POST['csrf_token'])) {

        $errors[] = 'Invalid form submission.';
    }
    

   
    $patient_id =  (int)     ($_POST ['patient_id'] ?? 0);
    $doctor_id =  (int) ($_POST ['doctor_id'] ?? 0);          //validating inputs
    $appointment_date  =    $_POST ['appointment_date'] ?? '';
    $appointment_time  =  $_POST ['appointment_time'] ?? '';
    $reason =  trim ($_POST ['reason'] ?? '');
    
    if  ( $patient_id  <=  0)  $errors[] =  'Please select a patient.';
    if ( $doctor_id <= 0) $errors[]  =  'Please select a doctor.';
    if ( empty ( $appointment_date )) {

        $errors[]  = 'Appointment date is required.';
    }
     elseif (!validateFutureDate($appointment_date)) {

        $errors[] = 'Appointment date must be today or in the future.';
    }

    if (empty($appointment_time)) $errors[] = 'Appointment time is required.';

    if (empty($reason)) $errors[] = 'Reason for visit is required.';
    


    if (empty($errors)) {

        if ( !isSlotAvailable($pdo, $doctor_id, $appointment_date, $appointment_time)) {
            $errors[] = 'This time slot is already booked. Please select another time.';
        }
    }

    
    if ( empty($errors)) {

        try {
            $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason) VALUES (?, ?, ?, ?, ?)");


            $stmt->execute([$patient_id,$doctor_id,$appointment_date,$appointment_time,$reason]);
            
            setFlashMessage('success', 'Appointment booked successfully!');

            redirect('appointments.php');

        } 
        catch (PDOException $e) {

            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

$csrf_token = generateCSRFToken();

?>




<div class="page-header">
<h1><i class="fas fa-calendar-plus"></i> Book New Appointment</h1>
</div>


<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <ul><?php foreach ($errors as $error): ?>
    <li><?php echo escape($error); ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>




<form  method="POST" action="" class="form-card" id="appointmentForm">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    
    <div class="form-row">
    <div class="form-group">
    <label for="patient_id">Patient <span class="required">*</span></label>
    <select id="patient_id" name="patient_id" required>
    <option value="">Select Patient</option>
    <?php foreach ($patients as $patient): ?>
    <option value="<?php echo $patient['id']; ?>" <?php echo (isset($_POST['patient_id']) && $_POST['patient_id'] == $patient['id']) ? 'selected' : ''; ?>>
    <?php echo escape($patient['name']); ?>
    </option>



        <?php endforeach; ?>




    </select>
        <small>Don't see the patient? <a href="patient_add.php" target="_blank">Add new patient</a></small>
    </div>
    <div class="form-group">
    <label for="doctor_id">Doctor <span class="required">*</span></label>
    <select id="doctor_id" name="doctor_id" required>
    <option value="">Select Doctor</option>

    <?php foreach ($doctors as $doctor): ?>
    <option value="<?php echo $doctor['id']; ?>" data-specialization="<?php echo escape($doctor['specialization']); ?>" 
    <?php echo (isset($_POST['doctor_id']) && $_POST['doctor_id'] == $doctor['id']) ? 'selected' : ''; ?>>
    <?php echo escape($doctor['name']); ?> - <?php echo escape($doctor['specialization']); ?>
    </option>



                <?php endforeach; ?>


            </select>
        </div>
    </div>



    
    <div class="form-row">

    <div class="form-group">
            <label for="appointment_date">Appointment Date <span class="required">*</span></label>
            <input type="date" id="appointment_date" name="appointment_date" 
                   min="<?php echo date('Y-m-d'); ?>" 
                   value="<?php echo isset($_POST['appointment_date']) ? escape($_POST['appointment_date']) : ''; ?>"required>
        </div>


        
        <div class="form-group">
            <label for="appointment_time">Appointment Time <span class="required">*</span></label>
            <select id="appointment_time" name="appointment_time" required>
    <option value="">Select time</option>
    <option value="09:00">09:00 AM</option>
    <option value="10:00">10:00 AM</option>
    <option value="11:00">11:00 AM</option>
    <option value="12:00">12:00 PM</option>
    <option value="14:00">02:00 PM</option>
    <option value="15:00">03:00 PM</option>
    <option value="16:00">04:00 PM</option>
</select>

            <small id="availability-message" class="availability-message"></small>
        </div>
    </div>
    

    <div class="form-group">
        <label for="reason">Reason for Visit <span class="required">*</span></label>
        <textarea id="reason" name="reason" rows="4" required placeholder="Please describe the reason for your appointment..."><?php echo isset($_POST['reason']) ? escape($_POST['reason']) : ''; ?></textarea>
    </div>
    
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Book Appointment
        </button>
        <a href="appointments.php" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
