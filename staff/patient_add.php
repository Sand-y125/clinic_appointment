<?php
include '../includes/header.php';


$pdo = getDB();
$errors = [];

if ( $_SERVER['REQUEST_METHOD'] == 'POST') {


    if ( !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $errors [] =    'Invalid form submission.';
    }
    
    $first_name    = trim($_POST['first_name']  ?? '');
    $last_name =   trim($_POST['last_name'] ?? '');

    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $date_of_birth  = $_POST['date_of_birth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $medical_history = trim($_POST['medical_history'] ?? '');

    
    if (empty($first_name)) $errors[] = 'First name is required.';
    if (empty($last_name)) $errors[] = 'Last name is required.';
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } 
    elseif (!validateEmail($email)) {

        $errors[] = 'Invalid email format.';
    }

    if (empty($phone)) {
        $errors[] = 'Phone number is required.';
    } 
    elseif (!validatePhone($phone)) {
        $errors[] = 'Invalid phone number format.';
    }

    if (empty($date_of_birth)) $errors[] = 'Date of birth is required.';

    if (empty($gender)) $errors[] = 'Gender is required.';

    
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM patients WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Email already exists.';
        }
    }
    
   
    if (empty($errors)) {   //inserting patient if no errors

        try {
            $stmt = $pdo->prepare("INSERT INTO patients (first_name, last_name, email, phone, date_of_birth, gender, address, medical_history) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $first_name,
                $last_name,
                $email,
                $phone,
                $date_of_birth,
                $gender,
                $address,
                $medical_history
            ]);
            
            setFlashMessage('success', 'Patient added successfully!');
            redirect('patients.php');

        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}


$csrf_token = generateCSRFToken();
?>



<div class="page-header">
<h1><i class="fas fa-user-plus"></i> Add New Patient</h1>
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
<input type="text" id="first_name" name="first_name" value="<?php echo isset($_POST['first_name']) ? escape($_POST['first_name']) : ''; ?>" required>
</div>


        
    <div class="form-group">
    <label for="last_name">Last Name <span class="required">*</span></label>
        <input type="text" id="last_name" name="last_name" value="<?php echo isset($_POST['last_name']) ? escape($_POST['last_name']) : ''; ?>" required>
    </div>
    </div>


    
    <div class="form-row">
    <div class="form-group">
    <label for="email">Email <span class="required">*</span></label>
    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? escape($_POST['email']) : ''; ?>" required>
    </div>
        



        <div class="form-group">
        <label for="phone">Phone <span class="required">*</span></label>
    <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? escape($_POST['phone']) : ''; ?>" required>
    </div>
    </div>


    
    <div class="form-row">
    <div class="form-group">
    <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
<input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo isset($_POST['date_of_birth']) ? escape($_POST['date_of_birth']) : ''; ?>" required>
</div>


        
        <div class="form-group">
            <label for="gender">Gender <span class="required">*</span></label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
    </div>
    

    <div class="form-group">
    <label for="address">Address</label>
    <textarea id="address" name="address" rows="3"><?php echo isset($_POST['address']) ? escape($_POST['address']) : ''; ?></textarea>
    </div>


    
    <div class="form-group">
    <label for="medical_history">Medical History</label>
    <textarea id="medical_history" name="medical_history" rows="4" placeholder="Allergies, chronic conditions, medications, etc."><?php echo isset($_POST['medical_history']) ? escape($_POST['medical_history']) : ''; ?></textarea>
    </div>


    
    <div class="form-actions">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Save Patient
        </button>
        <a href="patients.php" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancel
        </a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
