<?php
// start session ONCE
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDB();
$errors = [];

/* fetch doctors (PUBLIC – read only) */
$doctors = $pdo->query("
    SELECT id, CONCAT(first_name,' ',last_name,' (',specialization,')') AS name
    FROM doctors
    ORDER BY last_name, first_name
")->fetchAll();

/* handle form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid form submission.';
    }

    $first_name      = trim($_POST['first_name'] ?? '');
    $last_name       = trim($_POST['last_name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $phone           = trim($_POST['phone'] ?? '');
    $date_of_birth   = $_POST['date_of_birth'] ?? '';
    $gender          = $_POST['gender'] ?? '';
    $doctor_id       = (int)($_POST['doctor_id'] ?? 0);
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';
    $reason          = trim($_POST['reason'] ?? '');

    /* validation */
    if ($first_name === '') $errors[] = 'First name is required.';
    if ($last_name === '')  $errors[] = 'Last name is required.';
    if ($email === '' || !validateEmail($email)) $errors[] = 'Valid email is required.';
    if ($phone === '' || !validatePhone($phone)) $errors[] = 'Valid phone number is required.';
    if ($date_of_birth === '') $errors[] = 'Date of birth is required.';
    if ($gender === '') $errors[] = 'Gender is required.';
    if ($doctor_id <= 0) $errors[] = 'Please select a doctor.';
    if ($appointment_date === '') $errors[] = 'Appointment date is required.';
    if ($appointment_time === '') $errors[] = 'Appointment time is required.';

    if (empty($errors)) {

        /* check if patient exists */
        $stmt = $pdo->prepare("SELECT id FROM patients WHERE email = ?");
        $stmt->execute([$email]);
        $patient_id = $stmt->fetchColumn();

        if (!$patient_id) {
            $stmt = $pdo->prepare("
                INSERT INTO patients 
                (first_name, last_name, email, phone, date_of_birth, gender)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $first_name,
                $last_name,
                $email,
                $phone,
                $date_of_birth,
                $gender
            ]);
            $patient_id = $pdo->lastInsertId();
        }

        /* create appointment */
        $stmt = $pdo->prepare("
            INSERT INTO appointments
            (patient_id, doctor_id, appointment_date, appointment_time, reason, status)
            VALUES (?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([
            $patient_id,
            $doctor_id,
            $appointment_date,
            $appointment_time,
            $reason
        ]);

        setFlashMessage(
            'success',
            'Thank you! Your appointment request has been submitted. we will call you when your request get approved'
        );

        redirect('appointment_book.php');
    }
}

$csrf_token = generateCSRFToken();
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Book Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/clinic_appointment_dup/staff/assest/css/style.css">
    
</head>
<body>

<div class="container main-content">

    <?php if ($flash): ?>
        <div class="alert alert-<?= escape($flash['type']) ?>">
            <?= escape($flash['message']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= escape($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="page-header">
        <h1>Book an Appointment</h1>
    </div>

    <form method="post" class="form-card">
        <input type="hidden" name="csrf_token" value="<?= escape($csrf_token) ?>">

        <!-- Name -->
        <div class="form-row">
            <div class="form-group">
                <label>First Name <span class="required">*</span></label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name <span class="required">*</span></label>
                <input type="text" name="last_name" required>
            </div>
        </div>

        <!-- Contact -->
        <div class="form-row">
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Phone <span class="required">*</span></label>
                <input type="tel" name="phone" required>
            </div>
        </div>

        <!-- DOB + Gender -->
        <div class="form-row">
            <div class="form-group">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="date_of_birth" required>
            </div>

            <div class="form-group">
                <label>Gender <span class="required">*</span></label>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <!-- Doctor -->
        <div class="form-group">
            <label>Select Doctor <span class="required">*</span></label>
            <select name="doctor_id" required>
                <option value="">Select Doctor</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor['id'] ?>">
                        <?= escape($doctor['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Appointment Date + Time -->
        <div class="form-row">
            <div class="form-group">
                <label>Appointment Date <span class="required">*</span></label>
                <input type="date" name="appointment_date" min="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="form-group">
                <label>Appointment Time <span class="required">*</span></label>
                <select name="appointment_time" required>
                    <option value="">Select time</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:00">04:00 PM</option>
                </select>
            </div>
        </div>

        <!-- Reason -->
        <div class="form-group">
            <label>Reason (optional)</label>
            <textarea name="reason" rows="3"></textarea>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Book Appointment</button>
            <a href="/clinic_appointment/public/index.php" class="btn btn-secondary">Back</a>
        </div>
    </form>

</div>
</body>
</html>
