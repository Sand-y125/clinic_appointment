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
        SET status = 'scheduled'
        WHERE id = ?
    ");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        setFlashMessage('success', 'Appointment approved successfully!');
    } else {
        setFlashMessage('error', 'Appointment not found or already approved.');
    }

} catch (PDOException $e) {
    setFlashMessage('error', 'Error approving appointment.');
}

redirect('appointments.php');
