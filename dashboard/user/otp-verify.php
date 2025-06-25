<?php
require_once __DIR__ . '/../../config/settings-configuration.php';
require_once 'user-class.php';

$user = new USER();

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    if ($user->activateUser($email, $token)) {
        $success = "Account verified. You may now proceed to login.";
    } else {
        $error = "Invalid or expired verification link.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification | <?php echo PROJECT_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .verify-container {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container verify-container">
        <div class="col-md-6 offset-md-3 text-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Email Verification</h3>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <a href="../../dashboard/user/user-signin.php" class="btn btn-primary mt-3">Go to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>