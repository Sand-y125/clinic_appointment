<?php
include '../includes/header.php';


$pdo = getDB();


function searchAppointments(PDO $pdo, string $keyword): array

{
    $sql = "SELECT a.*, CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
            CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
            d.specialization FROM appointments a JOIN patients p ON a.patient_id = p.id
        JOIN doctors d ON a.doctor_id = d.id
        WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ?
            OR CONCAT(d.first_name, ' ', d.last_name) LIKE ?
            OR d.specialization LIKE ?
            OR a.appointment_date LIKE ?
            OR a.appointment_time LIKE ?
            OR a.reason LIKE ? ORDER BY a.appointment_date DESC, a.appointment_time DESC ";

    $search = "%{$keyword}%";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$search,$search,$search,$search,$search,$search]);

    return $stmt->fetchAll();
}


function searchPatients(PDO $pdo, string $keyword): array
{

    $stmt = $pdo->prepare("SELECT * FROM patients WHERE first_name LIKE ? 
            OR last_name LIKE ? 
            OR email LIKE ?
            OR gender = ? ORDER BY last_name, first_name ");

    $like = "%{$keyword}%";

    $stmt->execute([$like, $like, $like, $keyword]);

    return $stmt->fetchAll();
}



function searchDoctors(PDO $pdo, string $keyword): array
{

    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE first_name LIKE ? 
            OR last_name LIKE ? 
            OR specialization LIKE ?
            OR email LIKE? ORDER BY last_name, first_name");

    $search = "%{$keyword}%";

    $stmt->execute([$search, $search, $search, $search]);

    return $stmt->fetchAll();
}




$results = [];
$search_type = $_GET['search_type'] ?? '';
$keyword = trim($_GET['keyword'] ?? '');

if (!empty($keyword)) {

    if ($search_type === 'appointments') {

        $results = searchAppointments($pdo, $keyword);

    }
     elseif ($search_type === 'patients') {

        $results = searchPatients($pdo, $keyword);

    } 
    elseif ($search_type === 'doctors') {

        $results = searchDoctors($pdo, $keyword);
    }
}



$all_doctors = $pdo->query("SELECT id, CONCAT(first_name,' ',last_name) AS name 
    FROM doctors ORDER BY last_name")->fetchAll();


$all_patients = $pdo->query("SELECT id, CONCAT(first_name,' ',last_name) AS name 

    FROM patients ORDER BY last_name")->fetchAll();
?>



<div class="page-header">
    <h1><i class="fas fa-search"></i> Advanced Search</h1>
</div>

<div class="search-container">
<form method="GET" class="search-form">
<input type="hidden" name="search" value="1">

<div class="form-group">
    
    <label>Search In</label>
    <select id="search_type" name="search_type" onchange="toggleSearchFields()">
        <option value="appointments" <?php if($search_type==='appointments') echo 'selected'; ?>>Appointments</option>
        <option value="patients" <?php if($search_type==='patients') echo 'selected'; ?>>Patients</option>
        <option value="doctors" <?php if($search_type==='doctors') echo 'selected'; ?>>Doctors</option>
    </select>
</div>

<div class="form-group">
    <label>Keyword</label>
    <input type="text" name="keyword" value="<?php echo escape($keyword); ?>">
</div>

<div id="appointment-filters" style="display:none"></div>

<button class="btn btn-primary">Search</button>

</form>
</div>


<?php if (isset($_GET['search'])): ?>

<h2>Results (<?php echo count($results); ?>)</h2>

<?php if (count($results) > 0): ?>
<table class="data-table">
<thead>
<tr>
<?php if ($search_type === 'appointments'): ?>
    <th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th>
<?php elseif ($search_type === 'patients'): ?>
    <th>Name</th><th>Email</th><th>Phone</th>
<?php else: ?>
    <th>Name</th><th>Specialization</th><th>Email</th>
<?php endif; ?>
</tr>
</thead>

<tbody>
<?php foreach ($results as $row): ?>
<tr>
<?php if ($search_type === 'appointments'): ?>
    <td><?php echo formatDate($row['appointment_date']); ?></td>
    <td><?php echo formatTime($row['appointment_time']); ?></td>
    <td><?php echo escape($row['patient_name']); ?></td>
    <td><?php echo escape($row['doctor_name']); ?></td>

<?php elseif ($search_type === 'patients'): ?>
    <td><?php echo escape($row['first_name'].' '.$row['last_name']); ?></td>
    <td><?php echo escape($row['email']); ?></td>
    <td><?php echo escape($row['phone']); ?></td>

<?php else: ?>
    <td><?php echo escape($row['first_name'].' '.$row['last_name']); ?></td>
    <td><?php echo escape($row['specialization']); ?></td>
    <td><?php echo escape($row['email']); ?></td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php else: ?>
<p>No results found.</p>
<?php endif; ?>
<?php endif; ?>

<script>
function toggleSearchFields() {
    const type = document.getElementById('search_type').value;
    document.getElementById('appointment-filters').style.display =
        (type === 'appointments') ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleSearchFields);
</script>

<?php include '../includes/footer.php'; ?>
