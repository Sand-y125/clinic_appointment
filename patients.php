
<div class="page-header">
<h1><i class="fas fa-user-injured"></i> All Patients</h1>
<a href="patient_add.php" class="btn btn-primary">
<i class="fas fa-plus"></i> Add New Patient
</a>
</div>


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


    

<a href="patient_edit.php?" class="btn-icon" title="Edit">
    <i class="fas fa-edit"></i>
    </a>


    <a href="patient_delete.php?" class="btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this patient?');">
    <i class="fas fa-trash"></i>
    </a>


    </td>
    </tr>

    </tbody>
    </table>
</div>


<?php include '../includes/footer.php'; ?>
