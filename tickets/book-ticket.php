<?php
require_once __DIR__ . '/../config/settings-configuration.php';
require_once __DIR__ . '/../dashboard/user/user-class.php';

$user = new USER();

if (!$user->isUserLoggedIn()) {
    $user->redirect('../auth/user-signin.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['travel_date'];
    $seat = $_POST['seat'];

    $stmt = $user->runQuery("INSERT INTO tickets (user_id, route_from, route_to, travel_date, seat_number) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$_SESSION['userSession'], $from, $to, $date, $seat])) {
        $success = "Ticket successfully booked!";
    } else {
        $error = "Failed to book ticket. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="col-md-6 offset-md-3">
        <h3>Book a Ticket</h3>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>From</label>
                <input type="text" name="from" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>To</label>
                <input type="text" name="to" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Travel Date</label>
                <input type="date" name="travel_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Seat Number</label>
                <input type="text" name="seat" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Book Ticket</button>
        </form>
    </div>
</div>
</body>
</html>
