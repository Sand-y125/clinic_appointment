<?php
include '../includes/header.php';


$pdo = getDB();

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {

    setFlashMessage('error', 'Invalid appointment ID.');
    redirect('appointments.php');
}

$stmt = $pdo->prepare("SELECT a.id, a.patient_id, a.doctor_id,a.appointment_date, a.appointment_time,
                              a.reason,p.first_name AS patient_first, 
                              p.last_name AS patient_last,p.email AS patient_email, 
                              p.phone AS patient_phone,d.first_name AS doctor_first, 
                              d.last_name AS doctor_last,d.specialization, d.consultation_fee
                               FROM appointments a JOIN patients p ON a.patient_id = p.id
                                JOIN doctors d ON a.doctor_id = d.id WHERE a.id = ?");

$stmt->execute([$id]);
$appointment = $stmt->fetch();

if (!$appointment) {
    setFlashMessage('error', 'Appointment not found.');
    redirect('appointments.php');
}
?>

<div class="page-header">
<h1><i class="fas fa-calendar-alt"></i> Appointment Details</h1>
<div>
<a href="appointment_edit.php?id=<?php echo $appointment['id']; ?>" class="btn btn-primary">
<i class="fas fa-edit"></i> Edit
        </a>

    <a href="appointments.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Back to List
    </a>
    </div>
</div>

<div class="appointment-detail">
    <div class="detail-card">

        <div class="detail-header">
        <h2>Appointment #<?php echo escape($appointment['id']); ?></h2>
        </div>

        <div class="appointment-info">

            <div class="info-section">
            <h3><i class="fas fa-calendar"></i> Appointment Information</h3>
            <div class="detail-grid">
            <div class="detail-item">
            <label>Date:</label>
            <span><?php echo escape(formatDate($appointment['appointment_date'])); ?></span>
            </div>


            <div class="detail-item">
            <label>Time:</label>
            <span><?php echo escape(formatTime($appointment['appointment_time'])); ?></span>
            </div>

            <div class="detail-item full-width">
            <label>Reason for Visit:</label>
            <span><?php echo escape($appointment['reason']); ?></span>
            </div>
            </div>
            </div>


            <div class="info-section">
            <h3><i class="fas fa-user-injured"></i> Patient Information</h3>
            <div class="detail-grid">
            <div class="detail-item">
            <label>Name:</label>
            <span>
            <?php echo escape($appointment['patient_first'] . ' ' . $appointment['patient_last']); ?>
            </a>
            </span>
            </div>


        <div class="detail-item">
        <label>Email:</label>
            <span><?php echo escape($appointment['patient_email']); ?></span>
            </div>

            <div class="detail-item">
            <label>Phone:</label>
            <span><?php echo escape($appointment['patient_phone']); ?></span>
            </div>
            </div>
            </div>


            <div class="info-section">
                <h3><i class="fas fa-user-md"></i> Doctor Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Name:</label>
                        <span>
                                <?php echo escape($appointment['doctor_first'] . ' ' . $appointment['doctor_last']); ?>
                            </a>
                        </span>
                    </div>

                    <div class="detail-item">
                        <label>Specialization:</label>
                        <span><?php echo escape($appointment['specialization']); ?></span>
                    </div>

                    <div class="detail-item">
                        <label>Consultation Fee:</label>
                        <span>$<?php echo escape(number_format($appointment['consultation_fee'], 2)); ?></span>
                    </div>
                </div>
            </div>

            

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
