<?php
include '../includes/header.php';


$pdo = getDB();

// Get doctor ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    setFlashMessage('error', 'Invalid doctor ID.');
    redirect('doctors.php');
}

// Get doctor data
$stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->execute([$id]);
$doctor = $stmt->fetch();

if (!$doctor) {
    setFlashMessage('error', 'Doctor not found.');
    redirect('doctors.php');
}


?>

<div class="page-header">
    <h1><i class="fas fa-user-md"></i> Doctor Details</h1>
    <div>
        <a href="doctor_edit.php?id=<?php echo $doctor['id']; ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="doctors.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-header">
        <h2><?php echo escape($doctor['first_name'] . ' ' . $doctor['last_name']); ?></h2>
        <span class="badge badge-success"><?php echo escape($doctor['specialization']); ?></span>
    </div>
    
    <div class="detail-grid">
        <div class="detail-item">
            <label><i class="fas fa-envelope"></i> Email:</label>
            <span><?php echo escape($doctor['email']); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-phone"></i> Phone:</label>
            <span><?php echo escape($doctor['phone']); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-id-card"></i> License Number:</label>
            <span><?php echo escape($doctor['license_number']); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-graduation-cap"></i> Experience:</label>
            <span><?php echo escape($doctor['years_of_experience']); ?> years</span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-dollar-sign"></i> Consultation Fee:</label>
            <span>$<?php echo escape(number_format($doctor['consultation_fee'], 2)); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-calendar"></i> Available Days:</label>
            <span><?php echo escape($doctor['availability_days']); ?></span>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
