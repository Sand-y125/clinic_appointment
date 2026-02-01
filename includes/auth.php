<?php
require_once __DIR__ . '/session.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', '/~np03cs4a240022/clinic_appointment');
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/staff/login.php');
    exit;
}
