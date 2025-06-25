<?php
require_once '../settings-configuration.php';
require_once '../dashboard/user/user-class.php';
$user = new USER();

if (isset($_POST['btn-signup'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $token = bin2hex(random_bytes(16));
        if ($user->register($fullname, $email, $password, $token)) {
            $user->sendOTP($email, $token);
            $success = "Account created! Please check your email to verify.";
        } else {
            $error = "Registration failed. Email may already be registered.";
        }
    }
}
?>

<!-- HTML Signup Form -->
<form method="POST">
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>
    <button type="submit" name="btn-signup">Sign Up</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
