<?php
require_once __DIR__ . '/session.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /clinic_appointment/staff/login.php');
    exit;
}
