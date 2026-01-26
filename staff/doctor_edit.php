<?php
include '../includes/header.php';


$pdo = getDB();
$errors = [];

//to get doctor ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    setFlashMessage('error', 'Invalid doctor ID.');
    redirect('doctors.php');
}



//to get doctor data
$stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->execute([$id]);
$doctor = $stmt->fetch();


if (!$doctor) {

    setFlashMessage('error', 'Doctor not found.');
    redirect('doctors.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $errors[] = 'Invalid form submission.';
    }
    
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $license_number = trim($_POST['license_number'] ?? '');
    $years_of_experience = (int)($_POST['years_of_experience'] ?? 0);
    $consultation_fee = floatval($_POST['consultation_fee'] ?? 0);
    $availability_days = isset($_POST['availability_days']) ? implode(',', $_POST['availability_days']) : '';
    

    if (empty($first_name)) $errors[] = 'First name is required.';

    if (empty($last_name)) $errors[] = 'Last name is required.';

    if (empty($email)) {
        $errors[] = 'Email is required.';

    } elseif (!validateEmail($email)) {
        $errors[] = 'Invalid email format.';

    }
    if (empty($phone)) {

        $errors[] = 'Phone number is required.';
    } elseif (!validatePhone($phone)) {
        $errors[] = 'Invalid phone number format.';
    }
    if (empty($specialization)) $errors[] = 'Specialization is required.';
    if (empty($license_number)) $errors[] = 'License number is required.';
    if ($years_of_experience < 0) $errors[] = 'Years of experience must be a positive number.';
    if ($consultation_fee <= 0) $errors[] = 'Consultation fee must be greater than 0.';
    
    //checking email already exists for another doctor or not 
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM doctors WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Email already exists.';
        }
    }
    
    //checking license number already exists or not
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM doctors WHERE license_number = ? AND id != ?");
        $stmt->execute([$license_number, $id]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'License number already exists.';
        }
    }
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE doctors 
                SET first_name = ?, last_name = ?, email = ?, phone = ?, 
                    specialization = ?, license_number = ?, years_of_experience = ?,
                    consultation_fee = ?, availability_days = ?
                WHERE id = ?
            ");
            $stmt->execute([$first_name,$last_name,$email,$phone,$specialization,$license_number,
                $years_of_experience,$consultation_fee,$availability_days,$id]);
            
            setFlashMessage('success', 'Doctor updated successfully!');

            redirect('doctors.php');

        } catch (PDOException $e) {

            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }

} else {

    
    $_POST = $doctor;  //prefilling form 
    $_POST['availability_days'] = explode(',', $doctor['availability_days']);
}

$csrf_token = generateCSRFToken();

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
?>

<div class="page-header">
    <h1><i class="fas fa-user-edit"></i> Edit Doctor</h1>
</div>



<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <ul>
    <?php foreach ($errors as $error): ?>
    <li><?php echo escape($error); ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>


<form method="POST" action="" class="form-card">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    
    <div class="form-row">
        <div class="form-group">
            <label for="first_name">First Name <span class="required">*</span></label>
            <input type="text" id="first_name" name="first_name" value="<?php echo escape($_POST['first_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name <span class="required">*</span></label>
            <input type="text" id="last_name" name="last_name" value="<?php echo escape($_POST['last_name']); ?>" required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo escape($_POST['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone <span class="required">*</span></label>
            <input type="tel" id="phone" name="phone" value="<?php echo escape($_POST['phone']); ?>" required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="specialization">Specialization <span class="required">*</span></label>
            <input type="text" id="specialization" name="specialization" value="<?php echo escape($_POST['specialization']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="license_number">License Number <span class="required">*</span></label>
            <input type="text" id="license_number" name="license_number" value="<?php echo escape($_POST['license_number']); ?>" required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="years_of_experience">Years of Experience <span class="required">*</span></label>
            <input type="number" id="years_of_experience" name="years_of_experience" min="0" value="<?php echo escape($_POST['years_of_experience']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="consultation_fee">Consultation Fee ($) <span class="required">*</span></label>
            <input type="number" id="consultation_fee" name="consultation_fee" min="0" step="0.01" value="<?php echo escape($_POST['consultation_fee']); ?>" required>
        </div>
    </div>
    
    <div class="form-group">
        <label>Available Days <span class="required">*</span></label>
        <div class="checkbox-group">
            <?php foreach ($days as $day): ?>
            <label class="checkbox-label">
                <input type="checkbox" name="availability_days[]" value="<?php echo $day; ?>" 
                    <?php echo (in_array($day, $_POST['availability_days'])) ? 'checked' : ''; ?>>
                <?php echo $day; ?>
            </label>
            <?php endforeach; ?>
        </div>
    </div>
    
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
