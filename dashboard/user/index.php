<?php
session_start();
require_once __DIR__ . '/../../config/settings-configuration.php';
require_once __DIR__ . '/../../database/dbconnection.php';

// Redirect if not logged in
if (!isset($_SESSION['userSession'])) {
    header("Location: ../../auth/user-signin.php");
    exit();
}

// Connect to database
$database = new Database();
$conn = $database->dbConnection();

// Get user info
$stmt = $conn->prepare("SELECT fullname, email, status, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['userSession']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard | <?php echo PROJECT_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { overflow-x: hidden; }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-white text-center mb-4"><?php echo PROJECT_NAME; ?></h4>
            <a href="index.php">🏠 Dashboard</a>
            <a href="../../tickets/book-ticket.php">🚌 Book Ticket</a>
            <a href="../../tickets/my-tickets.php">📄 My Tickets</a>
            <a href="../../auth/user-signout.php">🚪 Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 content">
            <nav class="navbar navbar-light bg-light mb-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Welcome, <?php echo htmlspecialchars($userData['fullname']); ?></span>
                </div>
            </nav>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?php echo $userData['status'] ? 'success' : 'secondary'; ?>">
                            <?php echo $userData['status'] ? 'Verified' : 'Unverified'; ?>
                        </span>
                    </p>
                    <p><strong>Account Created:</strong> <?php echo $userData['created_at']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
