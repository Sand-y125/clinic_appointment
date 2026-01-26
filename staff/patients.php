<?php
include '../includes/header.php';


$pdo = getDB();

$stmt = $pdo->query("SELECT * FROM patients ORDER BY last_name, first_name");
$patients = $stmt->fetchAll();
?>

<div class="page-header">
<h1><i class="fas fa-user-injured"></i> All Patients</h1>
<a href="patient_add.php" class="btn btn-primary">
<i class="fas fa-plus"></i> Add New Patient
</a>
</div>


<?php if (count($patients) > 0): ?>
<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
    </thead>
<tbody>

<?php foreach ($patients as $patient): ?>
    <tr>
    <td><?php echo escape($patient['id']); ?></td>
        <td><?php echo escape($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
<td><?php echo escape($patient['email']); ?></td>
        <td><?php echo escape($patient['phone']); ?></td>

                <td><?php echo escape(formatDate($patient['date_of_birth'])); ?></td>
        <td><?php echo escape($patient['gender']); ?></td>
                <td class="actions">
        <a href="patient_view.php?id=<?php echo $patient['id']; ?>" class="btn-icon" title="View">
            <i class="fas fa-eye"></i>
    </a>

    

<a href="patient_edit.php?id=<?php echo $patient['id']; ?>" class="btn-icon" title="Edit">
    <i class="fas fa-edit"></i>
    </a>


    <a href="patient_delete.php?id=<?php echo $patient['id']; ?>" class="btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this patient?');">
    <i class="fas fa-trash"></i>
    </a>


    </td>
    </tr>

<?php endforeach; ?>
    </tbody>
    </table>
</div>

<?php else: ?>
<p class="text-muted">No patients found. <a href="patient_add.php">Add a new patient</a></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
