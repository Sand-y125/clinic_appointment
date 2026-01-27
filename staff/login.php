<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';

$csrfToken = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request. Please try again.';
    } else {

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if ($username === '' || $password === '') {
            $error = 'Both fields are required.';
        } else {

            $stmt = $pdo->prepare(
                "SELECT id, password FROM users WHERE username = :username"
            );
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {

                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];

                header('Location: /clinic_appointment/staff/dashboard.php');
                exit;

            } else {
                $error = 'Invalid username or password.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <link rel="stylesheet" href="/clinic_appointment/staff/assest/css/style.css">
</head>
<body>

<div class="form-card">
    <h2>Staff Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-error">
            <?= escape($error) ?>
        </div>
    <?php endif; ?>

    <div class="main-content">
  <div class="container">
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= escape($csrfToken) ?>">

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">


    <label>Password</label>
    <input type="password" name="password" required
        style="
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            height: 3rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;">
        </div>


        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </div>

        <div class="form-group mt-3">
            <a href="/clinic_appointment/public/index.php" class="btn btn-outline">
                <i class="fas fa-home"></i> Back to Homepage
            </a>
        </div>
    </form>
  </div>
</div>


</body>
</html>
