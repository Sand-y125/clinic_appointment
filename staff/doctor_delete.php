<?php
require_once '../includes/session.php'; 
include '../config/db.php';
include '../includes/functions.php';



$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {

    setFlashMessage('error', 'Invalid doctor ID.');
    redirect('doctors.php');
}


$pdo = getDB();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ?");
$stmt->execute([$id]);

$appointmentCount = $stmt->fetchColumn();

if ($appointmentCount > 0) {
    setFlashMessage('error', 'Cannot delete doctor with existing appointments. Please delete appointments first.');
    redirect('doctors.php');
}


try {

    $stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->execute([$id]);
    
    
    setFlashMessage('success', 'Doctor deleted successfully!');
}

 catch (PDOException $e) {
    
    setFlashMessage('error', 'Error deleting doctor: ' . $e->getMessage());
}

redirect('doctors.php');
?>
