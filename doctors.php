
<div class="page-header">
<h1><i class="fas fa-user-md"></i> All Doctors</h1>
<a href="doctor_add.php" class="btn btn-primary">
<i class="fas fa-plus"></i> Add New Doctor
</a>
</div>



]<div class="table-responsive">
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




    <a href="doctor_view.php?" class="btn-icon" title="View">
    <i class="fas fa-eye"></i>
    </a>

    <a href="doctor_edit.php?" class="btn-icon" title="Edit">
    <i class="fas fa-edit"></i>
    </a>

    <a href="doctor_delete.php?" class="btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this doctor?');">
    <i class="fas fa-trash"></i>
    </a>


    </td>
    </tr>

        </tbody>
    </table>
</div>

