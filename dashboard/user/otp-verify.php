<?php
require_once '../settings-configuration.php';
require_once '../dashboard/user/user-class.php';

$user = new USER();

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    if ($user->activateUser($email, $token)) {
        $success = "Account verified. You may now login.";
    } else {
        $error = "Invalid or expired verification link.";
    }
}
?>

<!-- Simple Verification Feedback -->
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
