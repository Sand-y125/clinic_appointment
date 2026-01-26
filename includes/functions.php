<?php



//creating reusable functions
 

function escape ($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}




function validateEmail ($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);  //to validate email
}


function validatePhone ($phone) {
    return preg_match('/^[0-9\-\+\(\)\s]{10,20}$/', $phone);  //to validate phone number
}


function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  //generating csrf token
    }
    return $_SESSION['csrf_token'];
}



function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirect($page) {
    header("Location: $page");
    exit();
}


function setFlashMessage($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}


function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        
        $type = $_SESSION['flash_type'];
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);
        return ['type' => $type, 'message' => $message];
    }
    return null;
}


function formatDate($date) {
    return date('F j, Y', strtotime($date));
}


function formatTime($time) {
    return date('g:i A', strtotime($time));
}


function isSlotAvailable($pdo, $doctor_id, $appointment_date, $appointment_time, $exclude_id = null) {
    $sql = "SELECT COUNT(*) FROM appointments 
            WHERE doctor_id = ? 
            AND appointment_date = ? 
            AND appointment_time = ? 
            AND status != 'cancelled'";
    
    $params = [$doctor_id, $appointment_date, $appointment_time];
    
    if ($exclude_id) {
        $sql .= " AND id != ?";
        $params[] = $exclude_id;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchColumn() == 0;
}


function getAvailableSlots($pdo, $doctor_id, $date) {
    // Define working hours (9 AM to 5 PM, 30-minute slots)
    $slots = [];
    $start = strtotime('09:00');
    $end = strtotime('17:00');
    $interval = 30 * 60; // 30 minutes
    
    for ($time = $start; $time < $end; $time += $interval) {
        $timeStr = date('H:i:s', $time);
        if (isSlotAvailable($pdo, $doctor_id, $date, $timeStr)) {
            $slots[] = $timeStr;
        }
    }
    
    return $slots;
}


function validateFutureDate($date) {
    $inputDate = strtotime($date);
    $today = strtotime(date('Y-m-d'));
    return $inputDate >= $today;
}
?>
