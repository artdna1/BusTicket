<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Composer autoloader (PHPMailer and other packages)
require_once __DIR__ . '/vendor/autoload.php';

// Optional: Autoload your own classes (if not manually required)
spl_autoload_register(function ($className) {
    $classFile = __DIR__ . '/classes/' . strtolower($className) . '-class.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});
