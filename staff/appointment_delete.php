<?php
include '../config/db.php';
include '../includes/functions.php';
require_once '../includes/session.php'; //




$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {

    setFlashMessage('error', 'Invalid appointment ID.');
    redirect('appointments.php');
}


$pdo = getDB();


try {
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
    
        setFlashMessage('success', 'Appointment deleted successfully!');
}


 catch (PDOException $e) {
    setFlashMessage('error', 'Error deleting appointment: ' . $e->getMessage());
}

redirect('appointments.php');
?>
