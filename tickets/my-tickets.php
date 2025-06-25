<?php
require_once __DIR__ . '/../config/settings-configuration.php';
require_once __DIR__ . '/../classes/user-class.php';

$user = new USER();

if (!$user->isUserLoggedIn()) {
    $user->redirect('../auth/user-signin.php');
}

$stmt = $user->runQuery("SELECT * FROM tickets WHERE user_id = ? ORDER BY travel_date DESC");
$stmt->execute([$_SESSION['userSession']]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3>My Booked Tickets</h3>
    <table class="table table-bordered bg-white mt-3">
        <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Seat</th>
                <th>Status</th>
                <th>Cancel</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket['route_from']) ?></td>
                <td><?= htmlspecialchars($ticket['route_to']) ?></td>
                <td><?= $ticket['travel_date'] ?></td>
                <td><?= $ticket['seat_number'] ?></td>
                <td><?= ucfirst($ticket['status']) ?></td>
                <td>
                    <?php if ($ticket['status'] == 'booked'): ?>
                        <a href="cancel-ticket.php?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-danger">Cancel</a>
                    <?php else: ?>
                        <span class="text-muted">N/A</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
