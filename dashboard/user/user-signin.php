<?php
require_once '../settings-configuration.php';
require_once '../dashboard/user/user-class.php';

$user = new USER();

if ($user->isUserLoggedIn()) {
    $user->redirect('../dashboard/user/');
}

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $loginResult = $user->login($email, $password);

    if ($loginResult === true) {
        $user->redirect('../dashboard/user/');
    } elseif ($loginResult === "not_verified") {
        $error = "Account not verified. Please check your email.";
    } else {
        $error = "Incorrect email or password.";
    }
}
?>

<!-- HTML Login Form -->
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="btn-login">Login</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
