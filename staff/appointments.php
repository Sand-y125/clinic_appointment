<?php
include '../includes/header.php';

$pdo = getDB();

$filter_status = $_GET['status'] ?? 'all';
$filter_date   = $_GET['date'] ?? '';

$sql = "
SELECT 
    a.*, 
    CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
    CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
    d.specialization
FROM appointments a
JOIN patients p ON a.patient_id = p.id
JOIN doctors d ON a.doctor_id = d.id
WHERE 1=1
";

$params = [];

if ($filter_status !== 'all') {
    $sql .= " AND a.status = ?";
    $params[] = $filter_status;
}

if (!empty($filter_date)) {
    $sql .= " AND a.appointment_date = ?";
    $params[] = $filter_date;
}

$sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$appointments = $stmt->fetchAll();
?>

<div class="page-header">
    <h1><i class="fas fa-calendar-check"></i> All Appointments</h1>
    <a href="appointment_add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Book New Appointment
    </a>
</div>

<?php if (!empty($appointments)): ?>
<div class="table-responsive">
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Specialization</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($appointments as $apt): ?>
        <tr>
            <td><?= escape($apt['id']) ?></td>
            <td><?= escape(formatDate($apt['appointment_date'])) ?></td>
            <td><?= escape(formatTime($apt['appointment_time'])) ?></td>
            <td><?= escape($apt['patient_name']) ?></td>
            <td><?= escape($apt['doctor_name']) ?></td>
            <td><?= escape($apt['specialization']) ?></td>
            <td>
                <?= escape(substr($apt['reason'], 0, 40)) ?>
                <?= strlen($apt['reason']) > 40 ? '...' : '' ?>
            </td>

            <!-- STATUS -->
            <td>
                <?php if ($apt['status'] === 'pending'): ?>
                    <span class="badge badge-warning">Pending</span>
                <?php elseif ($apt['status'] === 'scheduled'): ?>
                    <span class="badge badge-success">Scheduled</span>
                <?php elseif ($apt['status'] === 'rejected'): ?>
                    <span class="badge badge-danger">Rejected</span>
                <?php else: ?>
                    <span class="badge"><?= ucfirst($apt['status']) ?></span>
                <?php endif; ?>
            </td>

            <!-- ACTIONS -->
            <td class="actions">
                <div class="action-buttons">

                    <a href="appointment_view.php?id=<?= $apt['id'] ?>" class="btn-icon" title="View">
                        <i class="fas fa-eye"></i>
                    </a>

                    <?php if ($apt['status'] === 'scheduled'): ?>
                        <a href="appointment_edit.php?id=<?= $apt['id'] ?>" class="btn-icon" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($apt['status'] === 'pending'): ?>
                        <a href="appointment_approve.php?id=<?= $apt['id'] ?>" class="btn-icon btn-success" title="Approve">
                            <i class="fas fa-check"></i>
                        </a>
                        <a href="appointment_reject.php?id=<?= $apt['id'] ?>" class="btn-icon btn-danger" title="Reject">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>

                    <a href="appointment_delete.php?id=<?= $apt['id'] ?>"
                       class="btn-icon btn-danger"
                       title="Delete"
                       onclick="return confirm('Delete this appointment?')">
                        <i class="fas fa-trash"></i>
                    </a>

                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php else: ?>
<p class="text-muted">
    No appointments found.
    <a href="appointment_add.php">Book a new appointment</a>
</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
