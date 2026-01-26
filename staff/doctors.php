<?php
include '../includes/header.php';


$pdo = getDB();

$stmt = $pdo->query("SELECT * FROM doctors ORDER BY last_name, first_name");
$doctors = $stmt->fetchAll();
?>

<div class="page-header">
<h1><i class="fas fa-user-md"></i> All Doctors</h1>
<a href="doctor_add.php" class="btn btn-primary">
<i class="fas fa-plus"></i> Add New Doctor
</a>
</div>



<?php if (count($doctors) > 0): ?>
<div class="table-responsive">
<table class="data-table">
    <thead>
        <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Experience</th>
                <th>Fee</th>
                <th>Actions</th>
            </tr>
        </thead>


        <tbody>
            <?php foreach ($doctors as $doctor): ?>
<tr>
    <td><?php echo escape($doctor['id']); ?></td>
    <td><?php echo escape($doctor['first_name'] . ' ' . $doctor['last_name']); ?></td>
    <td><span class="badge badge-info"><?php echo escape($doctor['specialization']); ?></span></td>
    <td><?php echo escape($doctor['email']); ?></td>
    <td><?php echo escape($doctor['phone']); ?></td>
<td><?php echo escape($doctor['years_of_experience']); ?> years</td>
        <td>$<?php echo escape(number_format($doctor['consultation_fee'], 2)); ?></td>
            <td class="actions">



    <a href="doctor_view.php?id=<?php echo $doctor['id']; ?>" class="btn-icon" title="View">
    <i class="fas fa-eye"></i>
    </a>

    <a href="doctor_edit.php?id=<?php echo $doctor['id']; ?>" class="btn-icon" title="Edit">
    <i class="fas fa-edit"></i>
    </a>

    <a href="doctor_delete.php?id=<?php echo $doctor['id']; ?>" class="btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this doctor?');">
    <i class="fas fa-trash"></i>
    </a>


    </td>
    </tr>
<?php endforeach; ?>

        </tbody>
    </table>
</div>

<?php else: ?>
<p class="text-muted">No doctors found. <a href="doctor_add.php">Add a new doctor</a></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
