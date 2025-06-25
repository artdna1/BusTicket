<?php
session_start();
require_once __DIR__ . '/../../config/settings-configuration.php';
require_once __DIR__ . '/user-class.php';

$user = new USER();

if ($user->logout()) {
    $user->redirect('user-signin.php'); // Redirect to login page in the same folder
}
