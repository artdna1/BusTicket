<?php
require_once __DIR__ . '/config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | <?php echo PROJECT_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1589381824093-f04f2b42b0cf') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
        }
        .hero-text {
            background: rgba(0, 0, 0, 0.5);
            padding: 60px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?php echo PROJECT_NAME; ?></a>
    <div class="d-flex">
      <a href="../dashboard/user/user-signin.php" class="btn btn-outline-light me-2">Login</a>
      <a href="../dashboard/user/user-class.php';" class="btn btn-light">Register</a>
    </div>
  </div>
</nav>

<section class="hero d-flex align-items-center">
    <div class="container text-center hero-text">
        <h1 class="display-4">Book Your Bus Ticket</h1>
        <p class="lead">Fast. Easy. Reliable.</p>
        <a href="tickets/book-ticket.php" class="btn btn-primary btn-lg">Start Booking</a>
    </div>
</section>

<section class="container my-5">
    <h2 class="text-center mb-4">Why Choose Us?</h2>
    <div class="row text-center">
        <div class="col-md-4">
            <h4>Affordable Fares</h4>
            <p>Get the best prices without compromising comfort.</p>
        </div>
        <div class="col-md-4">
            <h4>Verified Operators</h4>
            <p>Travel safely with trusted bus companies.</p>
        </div>
        <div class="col-md-4">
            <h4>Easy Booking</h4>
            <p>Book online in just a few clicks — anytime, anywhere.</p>
        </div>
    </div>
</section>

<footer class="text-center py-4 bg-dark text-white">
    &copy; <?php echo date('Y'); ?> <?php echo PROJECT_NAME; ?>. All rights reserved.
</footer>

</body>
</html>
