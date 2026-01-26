<?php
include '../includes/header.php';


$pdo = getDB();
$errors = [];


$id = (int)($_GET['id'] ?? 0);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $errors[] = 'Invalid form submission.';
    }

    //collecting inputs
    $data = [
        'first_name'       => trim($_POST['first_name'] ?? ''),
        'last_name'        => trim($_POST['last_name'] ?? ''),
        'email'            => trim($_POST['email'] ?? ''),
        'phone'            => trim($_POST['phone'] ?? ''),
        'date_of_birth'    => $_POST['date_of_birth'] ?? '',
        'gender'           => $_POST['gender'] ?? '',
        'address'          => trim($_POST['address'] ?? ''),
        'medical_history'  => trim($_POST['medical_history'] ?? '')
    ];

    foreach (['first_name','last_name','email','phone','date_of_birth','gender'] as $field) {
        if (empty($data[$field])) {
            $errors[] = ucfirst(str_replace('_',' ', $field)) . ' is required.';
        }
    }

    if (!empty($data['email']) && !validateEmail($data['email'])) {
        $errors[] = 'Invalid email format.';
    }

    if (!empty($data['phone']) && !validatePhone($data['phone'])) {
        $errors[] = 'Invalid phone number format.';
    }

    //unique email checking
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM patients WHERE email = ? AND id != ?");
        $stmt->execute([$data['email'], $id]);
        if ($stmt->fetchColumn()) {
            $errors[] = 'Email already exists.';
        }
    }


    //updating if no error


    if (empty($errors)) {

        try {
            $stmt = $pdo->prepare("
                UPDATE patients SET first_name = ?, last_name = ?, email = ?, phone = ?,
                    date_of_birth = ?, gender = ?, address = ?, medical_history = ?
                WHERE id = ?");

            $stmt->execute([...array_values($data), $id]);

            setFlashMessage('success', 'Patient updated successfully!');
            redirect('patients.php');

        } 
        catch (PDOException $e) {

            $errors[] = 'Database error.';
        }
    }

} else {
    $_POST = $patient;

}

$csrf_token = generateCSRFToken();

?>

<div class="page-header">
    <h1><i class="fas fa-user-edit"></i> Edit Patient</h1>
</div>

<?php if ($errors): ?>
<div class="alert alert-error">
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= escape($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php endif; ?>


<form method="POST" class="form-card">
<input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

<?php
function field($name, $type = 'text') {
    echo "<input type=\"$type\" name=\"$name\" value=\"" . escape($_POST[$name] ?? '') . "\" required>";
}
?>

<div class="form-row">
    <div class="form-group">
        <label>First Name *</label><?php field('first_name'); ?>
    </div>
    <div class="form-group">
        <label>Last Name *</label><?php field('last_name'); ?>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label>Email *</label><?php field('email','email'); ?>
    </div>
    <div class="form-group">
        <label>Phone *</label><?php field('phone','tel'); ?>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label>Date of Birth *</label><?php field('date_of_birth','date'); ?>
    </div>
    <div class="form-group">
        <label>Gender *</label>
        <select name="gender" required>
            <option value="">Select</option>
            <?php foreach (['Male','Female','Other'] as $g): ?>
                <option value="<?= $g ?>" <?= ($_POST['gender'] ?? '') === $g ? 'selected' : '' ?>>
                    <?= $g ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label>Address</label>
    <textarea name="address"><?= escape($_POST['address'] ?? '') ?></textarea>
</div>

<div class="form-group">
    <label>Medical History</label>
    <textarea name="medical_history"><?= escape($_POST['medical_history'] ?? '') ?></textarea>
</div>

<div class="form-actions">
    <button class="btn btn-primary">Update Patient</button>
    <a href="patients.php" class="btn btn-secondary">Cancel</a>
</div>
</form>

<?php include '../includes/footer.php'; ?>
