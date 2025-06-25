<?php
// ==============================
// Global Configuration Settings
// ==============================

// Project branding
define('PROJECT_NAME', 'Bus Ticket Reservation System');
define('SITE_URL', 'http://localhost/BusTicket/'); // Update this as needed

// Timezone
date_default_timezone_set('Asia/Manila');

// ==============================
// SMTP Configuration (PHPMailer)
// ==============================
define('SMTP_HOST', 'smtp.gmail.com');        // Example: smtp.gmail.com
define('SMTP_PORT', 587);                     // Common: 587 (TLS) or 465 (SSL)
define('SMTP_USERNAME', 'artaziessamson@gmail.com'); // Your SMTP email
define('SMTP_PASSWORD', 'bwuh idvd lric hrzk');  // Your SMTP password or App Password
define('MAIL_FROM_EMAIL', 'artaziessamson@gmail.com'); // Sender email
define('MAIL_FROM_NAME', PROJECT_NAME);           // Sender name (uses project name)

// ==============================
// Google reCAPTCHA (Optional)
// ==============================
define('RECAPTCHA_SECRET_KEY', 'your-recaptcha-secret-key'); // If not using, you may leave blank or remove

// ==============================
// Security Settings
// ==============================
// (You may add CSRF token salt, encryption keys, etc.)
