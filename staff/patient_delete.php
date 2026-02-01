<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    setFlashMessage('error', 'Invalid patient ID.');
    redirect('patients.php');
}

$pdo = getDB();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE patient_id = ?");
$stmt->execute([$id]);
$appointmentCount = $stmt->fetchColumn();

if ($appointmentCount > 0) {
    setFlashMessage(
        'error',
        'Cannot delete patient with existing appointments. Please delete appointments first.'
    );
    redirect('patients.php');
}

try {
    $stmt = $pdo->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->execute([$id]);

    setFlashMessage('success', 'Patient deleted successfully!');
} catch (PDOException $e) {
    setFlashMessage('error', 'Error deleting patient.');
}

redirect('patients.php');
