<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Load Composer autoload (PHPMailer, etc.)
require_once __DIR__ . '/../vendor/autoload.php';


// Load your own class autoloader
spl_autoload_register(function ($className) {
    $classFile = __DIR__ . '/classes/' . strtolower($className) . '-class.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});
