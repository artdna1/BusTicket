<?php
session_start();

require_once '../../config/settings-configuration.php';
require_once 'user-class.php';

$user = new USER();

if ($user->isUserLoggedIn()) {
    $user->redirect('index.php');
}

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $loginResult = $user->login($email, $password);

    if ($loginResult === true) {
        $user->redirect('../../dashboard/user/index.php');
    } elseif ($loginResult === "not_verified") {
        $error = "Account not verified. Please check your email.";
    } else {
        $error = "Incorrect email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | <?php echo PROJECT_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Login to <?php echo PROJECT_NAME; ?></h3>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="Enter email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Enter password">
                        </div>

                        <button type="submit" name="btn-login" class="btn btn-primary w-100">Login</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="user-forgotpassword.php">Forgot password?</a><br>
                        <a href="user-signup.php">Don't have an account? Sign up</a>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="../../index.php" class="btn btn-outline-secondary w-100">Back to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>