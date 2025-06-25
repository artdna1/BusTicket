<?php
require_once __DIR__ . '/../../config/settings-configuration.php';
require_once __DIR__ . '/user-class.php';

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up | <?php echo PROJECT_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Create an Account</h3>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" name="fullname" id="fullname" class="form-control" required placeholder="Enter Your Full Name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="example@email.com">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="********">
                        </div>

                        <div class="mb-3">
                            <label for="confirm" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm" id="confirm" class="form-control" required placeholder="********">
                        </div>

                        <button type="submit" name="btn-signup" class="btn btn-primary w-100">Sign Up</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="user-signin.php">Already have an account? Login</a>
                    </div>

                    <div class="text-center mt-4">
                        <a href="../../index.php" class="btn btn-outline-secondary w-100">Back to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>