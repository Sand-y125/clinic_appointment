`<?php
include '../includes/header.php';
require_once '../includes/session.php'; //


$pdo = getDB();
$errors = [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ( $id <= 0) {
    setFlashMessage('error', 'Invalid appointment ID.');
    redirect('appointments.php');
}


$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->execute([$id]);

$appointment = $stmt->fetch();

if (  !$appointment) {

    setFlashMessage('error', 'Appointment not found.');
    redirect('appointments.php');
}


$patients =  $pdo->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM patients ORDER BY last_name, first_name")->fetchAll();



$doctors = $pdo->query( "SELECT id, CONCAT(first_name, ' ', last_name) AS name, specialization FROM doctors ORDER BY last_name, first_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $errors[] = 'Invalid form submission.';
    }

    
    $patient_id = (int)($_POST['patient_id'] ?? 0);
    $doctor_id = (int)($_POST['doctor_id'] ?? 0);
    $appointment_date = $_POST['appointment_date'] ?? '';      // Validating inputs

    $appointment_time = $_POST['appointment_time'] ?? '';
    $reason = trim($_POST['reason'] ?? '');
    


    if ($patient_id <= 0) $errors[] = 'Please select a patient.';
    if ($doctor_id <= 0) $errors[] = 'Please select a doctor.';
    if (empty($appointment_date)) {
        $errors[] = 'Appointment date is required.';
    } 
    elseif (!validateFutureDate($appointment_date)) {

        $errors[] = 'Appointment date must be today or in the future.';
    }


    if (empty($appointment_time)) $errors[] = 'Appointment time is required.';

    if (empty($reason)) $errors[] = 'Reason for visit is required.';
    

    if (empty($errors)) {

        if (!isSlotAvailable($pdo, $doctor_id, $appointment_date, $appointment_time, $id)) {
            $errors[] = 'This time slot is already booked. Please select another time.';
        }
    }
    

    if (empty($errors)) {

        try {
            $stmt = $pdo->prepare("UPDATE appointments SET patient_id = ?, doctor_id = ?, appointment_date = ?, appointment_time = ?, reason = ? WHERE id = ?");
            $stmt->execute([$patient_id,$doctor_id,$appointment_date,$appointment_time,$reason,$id]);
            

            setFlashMessage('success', 'Appointment updated successfully!');

            redirect('appointments.php');
        } 

catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }



} 

else {
    $_POST = $appointment;       //refilling form with existing data

}

$csrf_token = generateCSRFToken();

?>

<div class="page-header">
<h1><i class="fas fa-calendar-edit"></i> Edit Appointment</h1>
</div>


<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <ul><?php foreach ($errors as $error): ?>
    <li><?php echo escape($error); ?></li>
        <?php endforeach; ?>
    </ul>
</div>

            <?php endif; ?>

            

<form method="POST" action="" class="form-card" id="appointmentForm">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    
<div class="form-row">
<div class="form-group">
<label for="patient_id">Patient <span class="required">*</span></label>
<select id="patient_id" name="patient_id" required>
<option value="">Select Patient</option>
<?php foreach ($patients as $patient): ?>
<option value="<?php echo $patient['id']; ?>" <?php echo ($_POST['patient_id'] == $patient['id']) ? 'selected' : ''; ?>>
<?php echo escape($patient['name']); ?>
</option>
            <?php endforeach; ?>





</select>
    </div>
<div class="form-group">
<label for="doctor_id">Doctor <span class="required">*</span></label>
<select id="doctor_id" name="doctor_id" required>
<option value="">Select Doctor</option>
    <?php foreach ($doctors as $doctor): ?>
<option value="<?php echo $doctor['id']; ?>" data-specialization="<?php echo escape($doctor['specialization']); ?>" 
<?php echo ($_POST['doctor_id'] == $doctor['id']) ? 'selected' : ''; ?>>
<?php echo escape($doctor['name']); ?> - <?php echo escape($doctor['specialization']); ?>
</option>
<?php endforeach; ?>
</select>



    </div>
    </div>
    



    <div class="form-row">
    <div class="form-group">
    <label for="appointment_date">Appointment Date <span class="required">*</span></label>
    <input type="date" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo escape($_POST['appointment_date']); ?>" 
                   required>
        </div>





        
        <div class="form-group">
<label for="appointment_time">Appointment Time <span class="required">*</span></label>
<select id="appointment_time" name="appointment_time" required>
<option value="<?php echo escape($_POST['appointment_time']); ?>"><?php echo escape(formatTime($_POST['appointment_time'])); ?></option>
</select>
<small id="availability-message" class="availability-message"></small>
        </div>
    </div>
    
    <div class="form-group">
        <label for="reason">Reason for Visit <span class="required">*</span></label>
        <textarea id="reason" name="reason" rows="4" required><?php echo escape($_POST['reason']); ?></textarea>
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
