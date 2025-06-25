<?php
require_once '../settings-configuration.php';
require_once '../dashboard/user/user-class.php';
$user = new USER();

if ($user->logout()) {
    $user->redirect('../dashboard/user/user-signin.php');
}
?>
