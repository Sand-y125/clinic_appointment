<?php
include '../includes/header.php';


$pdo = getDB();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    setFlashMessage('error', 'Invalid patient ID.');
    redirect('patients.php');
}

$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->execute([$id]);
$patient = $stmt->fetch();

if (!$patient) {
    setFlashMessage('error', 'Patient not found.');
    redirect('patients.php');
}

?>

<div class="page-header">
    <h1><i class="fas fa-user"></i> Patient Details</h1>
    <div>
        <a href="patient_edit.php?id=<?php echo $patient['id']; ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="patients.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-header">
        <h2><?php echo escape($patient['first_name'] . ' ' . $patient['last_name']); ?></h2>
        <span class="badge badge-info"><?php echo escape($patient['gender']); ?></span>
    </div>
    
    <div class="detail-grid">
        <div class="detail-item">
            <label><i class="fas fa-envelope"></i> Email:</label>
            <span><?php echo escape($patient['email']); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-phone"></i> Phone:</label>
            <span><?php echo escape($patient['phone']); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-birthday-cake"></i> Date of Birth:</label>
            <span><?php echo escape(formatDate($patient['date_of_birth'])); ?></span>
        </div>
        
        <div class="detail-item">
            <label><i class="fas fa-venus-mars"></i> Gender:</label>
            <span><?php echo escape($patient['gender']); ?></span>
        </div>
        
        <div class="detail-item full-width">
            <label><i class="fas fa-map-marker-alt"></i> Address:</label>
            <span><?php echo escape($patient['address'] ?: 'N/A'); ?></span>
        </div>
        
        <div class="detail-item full-width">
            <label><i class="fas fa-notes-medical"></i> Medical History:</label>
            <span><?php echo escape($patient['medical_history'] ?: 'No medical history recorded'); ?></span>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
