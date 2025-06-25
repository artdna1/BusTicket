<?php
require_once __DIR__ . '/../config/settings-configuration.php';
require_once __DIR__ . '/../classes/user-class.php';

$user = new USER();

if (!$user->isUserLoggedIn()) {
    $user->redirect('../auth/user-signin.php');
}

if (isset($_GET['id'])) {
    $stmt = $user->runQuery("UPDATE tickets SET status = 'cancelled' WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['userSession']]);
}

$user->redirect('my-tickets.php');
