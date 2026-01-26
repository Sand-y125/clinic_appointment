<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/session.php'; //


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    setFlashMessage('error', 'Invalid appointment ID.');
    redirect('appointments.php');
}

$pdo = getDB();

try {
    $stmt = $pdo->prepare("
        UPDATE appointments
        SET status = 'rejected'
        WHERE id = ?
    ");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        setFlashMessage('success', 'Appointment rejected successfully!');
    } else {
        setFlashMessage('error', 'Appointment not found or already rejected.');
    }

} catch (PDOException $e) {
    setFlashMessage('error', 'Error rejecting appointment.');
}

redirect('appointments.php');
