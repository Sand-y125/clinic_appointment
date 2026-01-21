

<div class="page-header">
<h1><i class="fas fa-calendar-check"></i> All Appointments</h1>
<a href="appointment_add.php" class="btn btn-primary">
<i class="fas fa-plus"></i> Book New Appointment
</a>
</div>


<div class="filter-section">
<form method="GET" action="" class="filter-form">
    <div class="filter-group">
    <label for="status">Status:</label>
    <select name="status" id="status" onchange="this.form.submit()">
    <option value="all">All</option>
    <option value="scheduled">Scheduled</option>
    <option value="completed">Completed</option>
    </select>
    </div>
        
        <div class="filter-group">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="">
        </div>
        
    <a href="appointments.php" class="btn btn-secondary">Clear Filters</a>
    </form>
</div>


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
            


    <td class="actions">
    <a href="appointment_view.php?" class="btn-icon" title="View">
    <i class="fas fa-eye"></i>
    </a>



    <a href="appointment_edit.php?" class="btn-icon" title="Edit">
    <i class="fas fa-edit"></i>
    </a>
    </a>


    <a href="appointment_delete.php?" class="btn-icon btn-danger" title="Delete" >
    <i class="fas fa-trash"></i>
    </a>
    </td>
    </tr>



    </tbody>
    </table>
</div>




<?php include '../includes/footer.php'; ?>
